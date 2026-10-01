<?php

namespace App\Controllers;

use App\Models\DispositivoModel;
use App\Models\UsuarioDispositivoModel;

class TachosController extends BaseController
{
    private const SERVER_URL = 'http://192.168.1.150:8000';
    private const SIMULACION_URL = 'http://192.168.1.150:8080';

    /*
    |--------------------------------------------------------------------------
    | USUARIO
    |--------------------------------------------------------------------------
    */

    private function requireUser(): ?int
    {
        $usuarioId = session()->get('id');

        if (!$usuarioId) {
            return null;
        }

        return (int) $usuarioId;
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESO A UN ECO-TACHO
    |--------------------------------------------------------------------------
    */

    private function acceso(int $dispositivoId, int $usuarioId): ?object
    {
        $db = \Config\Database::connect();

        return $db->table('usuario_dispositivo')
            ->where('usuario_id', $usuarioId)
            ->where('dispositivo_id', $dispositivoId)
            ->get()
            ->getFirstRow();
    }

    /*
    |--------------------------------------------------------------------------
    | OBTENER ROL REAL
    |--------------------------------------------------------------------------
    */

    private function obtenerRol(int $dispositivoId, int $usuarioId, ?object $acceso = null): string
    {
        if (!$acceso) {
            $acceso = $this->acceso($dispositivoId, $usuarioId);
        }

        if (!$acceso) {
            return '';
        }

        if (!empty($acceso->rol)) {
            return strtolower((string) $acceso->rol);
        }

        $db = \Config\Database::connect();

        $tacho = $db->table('dispositivos')
            ->where('id', $dispositivoId)
            ->get()
            ->getFirstRow();

        if ($tacho && (int) $tacho->propietario_id === $usuarioId) {
            return 'propietario';
        }

        return 'lector';
    }

    /*
    |--------------------------------------------------------------------------
    | ¿PUEDE GESTIONAR?
    |--------------------------------------------------------------------------
    */

    private function puedeGestionar(int $dispositivoId, int $usuarioId): bool
    {
        $rol = $this->obtenerRol($dispositivoId, $usuarioId);

        return in_array(
            $rol,
            ['propietario', 'administrador'],
            true
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ¿ES PROPIETARIO?
    |--------------------------------------------------------------------------
    */

    private function esPropietario(int $dispositivoId, int $usuarioId): bool
    {
        return $this->obtenerRol($dispositivoId, $usuarioId) === 'propietario';
    }

    /*
    |--------------------------------------------------------------------------
    | HABILITAR DISPOSITIVO EN FASTAPI
    |--------------------------------------------------------------------------
    */

    private function habilitarDispositivo(string $codigo): bool
    {
        try {
            $client = \Config\Services::curlrequest([
                'timeout' => 5,
                'http_errors' => false
            ]);

            $response = $client->post(
                self::SERVER_URL . '/habilitar-dispositivo',
                [
                    'json' => [
                        'codigo' => $codigo
                    ]
                ]
            );

            return $response->getStatusCode() >= 200
                && $response->getStatusCode() < 300;

        } catch (\Throwable $e) {
            log_message(
                'error',
                'Error habilitando dispositivo: ' . $e->getMessage()
            );

            return false;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | LISTA DE ECO-TACHOS
    |--------------------------------------------------------------------------
    */

    public function mistachos()
    {
        $usuarioId = $this->requireUser();

        if (!$usuarioId) {
            return redirect()
                ->to('/usuario/login')
                ->with('error', 'Debes iniciar sesión primero.');
        }

        $db = \Config\Database::connect();

        $tachos = $db->table('usuario_dispositivo ud')
            ->select('d.*, ud.rol')
            ->join(
                'dispositivos d',
                'd.id = ud.dispositivo_id'
            )
            ->where('ud.usuario_id', $usuarioId)
            ->orderBy('d.id', 'ASC')
            ->get()
            ->getResult();

        foreach ($tachos as $tacho) {

            if (
                empty($tacho->rol)
                && isset($tacho->propietario_id)
                && (int) $tacho->propietario_id === $usuarioId
            ) {
                $tacho->rol = 'propietario';
            }

            if (empty($tacho->rol)) {
                $tacho->rol = 'lector';
            }

            $tacho->rol = strtolower($tacho->rol);
        }

        return view(
            'tachos/mistachos',
            [
                'tachos' => $tachos,
                'simulacionUrl' => self::SIMULACION_URL
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | REGISTRAR ECO-TACHO
    |--------------------------------------------------------------------------
    */

    public function registrar()
    {
        $usuarioId = $this->requireUser();

        if (!$usuarioId) {
            return redirect()
                ->to('/usuario/login')
                ->with('error', 'Debes iniciar sesión primero.');
        }

        return view('tachos/registrar');
    }

    /*
    |--------------------------------------------------------------------------
    | GUARDAR ECO-TACHO
    |--------------------------------------------------------------------------
    */

    public function guardar()
    {
        $usuarioId = $this->requireUser();

        if (!$usuarioId) {
            return redirect()
                ->to('/usuario/login')
                ->with('error', 'Debes iniciar sesión primero.');
        }

        $nombre = trim((string) $this->request->getPost('nombre'));
        $tipo = trim((string) $this->request->getPost('tipo'));
        $ubicacion = trim((string) $this->request->getPost('ubicacion'));
        $codigo = trim((string) $this->request->getPost('codigo_activacion'));

        $tiposPermitidos = [
            'residencial',
            'institucional',
            'empresarial',
            'municipal'
        ];

        if ($nombre === '') {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Debes ingresar un nombre para el Eco-Tacho.');
        }

        if (!in_array($tipo, $tiposPermitidos, true)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'El tipo de Eco-Tacho no es válido.');
        }

        if ($codigo === '') {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Debes ingresar el código de activación.');
        }

        $db = \Config\Database::connect();

        $tacho = $db->table('dispositivos')
            ->where('codigo_activacion', $codigo)
            ->get()
            ->getFirstRow();

        if (!$tacho) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'No se encontró un Eco-Tacho con ese código.');
        }

        if (
            !empty($tacho->propietario_id)
            && (int) $tacho->propietario_id !== $usuarioId
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Este Eco-Tacho ya tiene un propietario.'
                );
        }

        $db->transStart();

        $db->table('dispositivos')
            ->where('id', $tacho->id)
            ->update([
                'nombre' => $nombre,
                'tipo' => $tipo,
                'ubicacion' => $ubicacion,
                'propietario_id' => $usuarioId
            ]);

        $relacion = $db->table('usuario_dispositivo')
            ->where('usuario_id', $usuarioId)
            ->where('dispositivo_id', $tacho->id)
            ->get()
            ->getFirstRow();

        if ($relacion) {

            $db->table('usuario_dispositivo')
                ->where('id', $relacion->id)
                ->update([
                    'rol' => 'propietario'
                ]);

        } else {

            $db->table('usuario_dispositivo')
                ->insert([
                    'usuario_id' => $usuarioId,
                    'dispositivo_id' => $tacho->id,
                    'rol' => 'propietario'
                ]);
        }

        $db->transComplete();

        if (!$db->transStatus()) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'No se pudo registrar el Eco-Tacho.'
                );
        }

        $habilitado = $this->habilitarDispositivo($codigo);

        $db->table('dispositivos')
            ->where('id', $tacho->id)
            ->update([
                'habilitado' => $habilitado ? 1 : 0
            ]);

        session()->set('dispositivo_actual', (int) $tacho->id);

        if (!$habilitado) {
            return redirect()
                ->to('/mis-tachos')
                ->with(
                    'warning',
                    'El Eco-Tacho fue registrado, pero no se pudo habilitar el dispositivo en el servidor.'
                );
        }

        return redirect()
            ->to('/mis-tachos')
            ->with(
                'success',
                'Eco-Tacho registrado y habilitado correctamente.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | SELECCIONAR ECO-TACHO
    |--------------------------------------------------------------------------
    */

    public function seleccionar($id)
    {
        $usuarioId = $this->requireUser();

        if (!$usuarioId) {
            return redirect()
                ->to('/usuario/login')
                ->with('error', 'Debes iniciar sesión primero.');
        }

        $id = (int) $id;

        if (!$this->acceso($id, $usuarioId)) {
            return redirect()
                ->to('/mis-tachos')
                ->with(
                    'error',
                    'No tenés acceso a este Eco-Tacho.'
                );
        }

        session()->set('dispositivo_actual', $id);

        return redirect()->to('/usuario/principal');
    }

    /*
    |--------------------------------------------------------------------------
    | UNIRSE A ECO-TACHO
    |--------------------------------------------------------------------------
    */

    public function unirse()
    {
        $usuarioId = $this->requireUser();

        if (!$usuarioId) {
            return redirect()
                ->to('/usuario/login')
                ->with('error', 'Debes iniciar sesión primero.');
        }

        return view('tachos/unirse');
    }

    /*
    |--------------------------------------------------------------------------
    | PROCESAR UNIÓN
    |--------------------------------------------------------------------------
    */

    public function procesarUnion()
    {
        $usuarioId = $this->requireUser();

        if (!$usuarioId) {
            return redirect()
                ->to('/usuario/login')
                ->with('error', 'Debes iniciar sesión primero.');
        }

        $codigo = trim(
            (string) $this->request->getPost('codigo_activacion')
        );

        if ($codigo === '') {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Debes ingresar el código de activación.'
                );
        }

        $db = \Config\Database::connect();

        $tacho = $db->table('dispositivos')
            ->where('codigo_activacion', $codigo)
            ->get()
            ->getFirstRow();

        if (!$tacho) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'No se encontró un Eco-Tacho con ese código.'
                );
        }

        $existente = $db->table('usuario_dispositivo')
            ->where('usuario_id', $usuarioId)
            ->where('dispositivo_id', $tacho->id)
            ->get()
            ->getFirstRow();

        if ($existente) {
            return redirect()
                ->to('/mis-tachos')
                ->with(
                    'error',
                    'Ya tenés este Eco-Tacho agregado.'
                );
        }

        $rol = 'lector';

        if (
            !empty($tacho->propietario_id)
            && (int) $tacho->propietario_id === $usuarioId
        ) {
            $rol = 'propietario';
        }

        $db->table('usuario_dispositivo')
            ->insert([
                'usuario_id' => $usuarioId,
                'dispositivo_id' => $tacho->id,
                'rol' => $rol
            ]);

        session()->set(
            'dispositivo_actual',
            (int) $tacho->id
        );

        return redirect()
            ->to('/mis-tachos')
            ->with(
                'success',
                'Te uniste al Eco-Tacho correctamente.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | BUSCAR TACHO POR CÓDIGO
    |--------------------------------------------------------------------------
    */

    public function buscarPorCodigo()
    {
        $usuarioId = $this->requireUser();

        if (!$usuarioId) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON([
                    'success' => false,
                    'message' => 'Debes iniciar sesión.'
                ]);
        }

        $codigo = trim(
            (string) $this->request->getPost('codigo_activacion')
        );

        if ($codigo === '') {
            return $this->response
                ->setJSON([
                    'success' => false,
                    'message' => 'Debes ingresar un código.'
                ]);
        }

        $db = \Config\Database::connect();

        $tacho = $db->table('dispositivos')
            ->where('codigo_activacion', $codigo)
            ->get()
            ->getFirstRow();

        if (!$tacho) {
            return $this->response
                ->setJSON([
                    'success' => false,
                    'message' => 'No se encontró el Eco-Tacho.'
                ]);
        }

        return $this->response
            ->setJSON([
                'success' => true,
                'tacho' => $tacho
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | ASIGNAR PROPIETARIO
    |--------------------------------------------------------------------------
    */

    public function asignarPropietario()
    {
        $usuarioId = $this->requireUser();

        if (!$usuarioId) {
            return redirect()
                ->to('/usuario/login')
                ->with('error', 'Debes iniciar sesión primero.');
        }

        $codigo = trim(
            (string) $this->request->getPost('codigo_activacion')
        );

        if ($codigo === '') {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Debes ingresar el código de activación.'
                );
        }

        $db = \Config\Database::connect();

        $tacho = $db->table('dispositivos')
            ->where('codigo_activacion', $codigo)
            ->get()
            ->getFirstRow();

        if (!$tacho) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'No se encontró el Eco-Tacho.'
                );
        }

        if (
            !empty($tacho->propietario_id)
            && (int) $tacho->propietario_id !== $usuarioId
        ) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Este Eco-Tacho ya tiene propietario.'
                );
        }

        $db->transStart();

        $db->table('dispositivos')
            ->where('id', $tacho->id)
            ->update([
                'propietario_id' => $usuarioId
            ]);

        $relacion = $db->table('usuario_dispositivo')
            ->where('usuario_id', $usuarioId)
            ->where('dispositivo_id', $tacho->id)
            ->get()
            ->getFirstRow();

        if ($relacion) {

            $db->table('usuario_dispositivo')
                ->where('id', $relacion->id)
                ->update([
                    'rol' => 'propietario'
                ]);

        } else {

            $db->table('usuario_dispositivo')
                ->insert([
                    'usuario_id' => $usuarioId,
                    'dispositivo_id' => $tacho->id,
                    'rol' => 'propietario'
                ]);
        }

        $db->transComplete();

        if (!$db->transStatus()) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'No se pudo asignar el propietario.'
                );
        }

        $habilitado = $this->habilitarDispositivo($codigo);

        $db->table('dispositivos')
            ->where('id', $tacho->id)
            ->update([
                'habilitado' => $habilitado ? 1 : 0
            ]);

        return redirect()
            ->to('/mis-tachos')
            ->with(
                $habilitado ? 'success' : 'warning',
                $habilitado
                    ? 'Eco-Tacho habilitado correctamente.'
                    : 'El Eco-Tacho fue asignado, pero no se pudo habilitar en el servidor.'
            );
    }

/**
 * --------------------------------------------------------------------------
 * ELIMINAR ECO-TACHO DE LA LISTA
 * --------------------------------------------------------------------------
 
 */
public function eliminar($id)
{
    $usuarioId = $this->requireUser();

    if (!$usuarioId) {
        return $this->response
            ->setStatusCode(401)
            ->setJSON([
                'success' => false,
                'message' => 'Debes iniciar sesión.'
            ]);
    }

    $id = (int) $id;

    // ------------------------------------------------------------
    // Verificar que el usuario tenga relación con el Eco-Tacho
    // ------------------------------------------------------------

    $acceso = $this->acceso($id, $usuarioId);

    if (!$acceso) {
        return $this->response
            ->setStatusCode(403)
            ->setJSON([
                'success' => false,
                'message' => 'No tenés acceso a este Eco-Tacho.'
            ]);
    }

    $db = \Config\Database::connect();

    // ------------------------------------------------------------
    // Verificar que el Eco-Tacho exista
    // ------------------------------------------------------------

    $tacho = $db->table('dispositivos')
        ->where('id', $id)
        ->get()
        ->getFirstRow();

    if (!$tacho) {
        return $this->response
            ->setStatusCode(404)
            ->setJSON([
                'success' => false,
                'message' => 'Eco-Tacho no encontrado.'
            ]);
    }

    // ------------------------------------------------------------
    // Obtener el rol real del usuario
    // ------------------------------------------------------------

    $rol = $this->obtenerRol(
        $id,
        $usuarioId,
        $acceso
    );

    // ------------------------------------------------------------
    // ELIMINAR SOLAMENTE LA RELACIÓN
    // ------------------------------------------------------------
    //
    // NO hacemos:
    //
    // propietario_id = NULL
    //
    // NO hacemos:
    //
    // habilitado = 0
    //
    // NO llamamos a:
    //
    // /deshabilitar-dispositivo
    //
    // El Eco-Tacho permanece funcionando.
    //

    $db->transStart();

    $db->table('usuario_dispositivo')
        ->where('usuario_id', $usuarioId)
        ->where('dispositivo_id', $id)
        ->delete();

    $db->transComplete();

    // ------------------------------------------------------------
    // Verificar transacción
    // ------------------------------------------------------------

    if (!$db->transStatus()) {
        return $this->response
            ->setStatusCode(500)
            ->setJSON([
                'success' => false,
                'message' => 'No se pudo eliminar el Eco-Tacho.'
            ]);
    }

    // ------------------------------------------------------------
    // Si era el dispositivo seleccionado actualmente,
    // quitarlo de la sesión.
    // ------------------------------------------------------------

    if (
        (int) session()->get('dispositivo_actual') === $id
    ) {
        session()->remove('dispositivo_actual');
    }

    // ------------------------------------------------------------
    // RESPUESTA
    // ------------------------------------------------------------

    return $this->response
        ->setJSON([
            'success' => true,
            'message' => 'Eco-Tacho eliminado de tu lista correctamente.'
        ]);
}

    /*
    |--------------------------------------------------------------------------
    | PÁGINA DE GESTIÓN
    |--------------------------------------------------------------------------
    |
    | Propietario y administrador.
    |
    */

    public function gestionar($id)
    {
        $usuarioId = $this->requireUser();

        if (!$usuarioId) {
            return redirect()
                ->to('/usuario/login')
                ->with('error', 'Debes iniciar sesión primero.');
        }

        $id = (int) $id;

        $acceso = $this->acceso($id, $usuarioId);

        if (!$acceso) {
            return redirect()
                ->to('/mis-tachos')
                ->with(
                    'error',
                    'No tenés acceso a este Eco-Tacho.'
                );
        }

        $rol = $this->obtenerRol(
            $id,
            $usuarioId,
            $acceso
        );

        if (!in_array(
            $rol,
            ['propietario', 'administrador'],
            true
        )) {
            return redirect()
                ->to('/mis-tachos')
                ->with(
                    'error',
                    'No tenés permiso para gestionar este Eco-Tacho.'
                );
        }

        $db = \Config\Database::connect();

        $tacho = $db->table('dispositivos')
            ->where('id', $id)
            ->get()
            ->getFirstRow();

        if (!$tacho) {
            return redirect()
                ->to('/mis-tachos')
                ->with(
                    'error',
                    'Eco-Tacho no encontrado.'
                );
        }

        session()->set(
            'dispositivo_actual',
            $id
        );

        return view(
            'tachos/gestionar',
            [
                'tacho' => $tacho,
                'rol' => $rol
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CONTROL MANUAL DE APERTURA / CIERRE
    |--------------------------------------------------------------------------
    */

    public function control()
    {
        $usuarioId = $this->requireUser();

        if (!$usuarioId) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON([
                    'success' => false,
                    'message' => 'Debes iniciar sesión.'
                ]);
        }

        $dispositivoId = (int) $this->request->getPost('dispositivo_id');
        $accion = strtolower(
            trim((string) $this->request->getPost('accion'))
        );
        $categoria = strtolower(
            trim((string) $this->request->getPost('categoria'))
        );

        if ($dispositivoId <= 0) {
            return $this->respuestaControl(
                false,
                'Eco-Tacho inválido.',
                $dispositivoId
            );
        }

        if (!$this->puedeGestionar(
            $dispositivoId,
            $usuarioId
        )) {
            return $this->respuestaControl(
                false,
                'No tenés permiso para controlar este Eco-Tacho.',
                $dispositivoId
            );
        }

        if (!in_array(
            $accion,
            ['abrir', 'cerrar'],
            true
        )) {
            return $this->respuestaControl(
                false,
                'Acción no válida.',
                $dispositivoId
            );
        }

        $categoriasPermitidas = [
            'plastico_vidrio',
            'plastico',
            'vidrio',
            'organico',
            'papel'
        ];

        if (!in_array(
            $categoria,
            $categoriasPermitidas,
            true
        )) {
            return $this->respuestaControl(
                false,
                'Categoría no válida.',
                $dispositivoId
            );
        }

        if (
            $categoria === 'plastico'
            || $categoria === 'vidrio'
        ) {
            $categoria = 'plastico_vidrio';
        }

        $db = \Config\Database::connect();

        $tacho = $db->table('dispositivos')
            ->where('id', $dispositivoId)
            ->get()
            ->getFirstRow();

        if (!$tacho) {
            return $this->respuestaControl(
                false,
                'Eco-Tacho no encontrado.',
                $dispositivoId
            );
        }

        if (empty($tacho->codigo_activacion)) {
            return $this->respuestaControl(
                false,
                'El Eco-Tacho no tiene código de activación.',
                $dispositivoId
            );
        }

        if (empty($tacho->habilitado)) {
            return $this->respuestaControl(
                false,
                'El Eco-Tacho no está habilitado.',
                $dispositivoId
            );
        }

        try {

            $client = \Config\Services::curlrequest([
                'timeout' => 5,
                'http_errors' => false
            ]);

            $response = $client->post(
                self::SERVER_URL . '/control-tacho',
                [
                    'json' => [
                        'codigo' => $tacho->codigo_activacion,
                        'accion' => $accion,
                        'categoria' => $categoria
                    ]
                ]
            );

            $status = $response->getStatusCode();

            $body = json_decode(
                (string) $response->getBody(),
                true
            );

            if ($status >= 200 && $status < 300) {

                return $this->respuestaControl(
                    true,
                    $accion === 'abrir'
                        ? 'Se envió la orden para abrir el tacho.'
                        : 'Se envió la orden para cerrar el tacho.',
                    $dispositivoId
                );
            }

            $mensaje = $body['detail']
                ?? $body['message']
                ?? 'El servidor no aceptó la orden.';

            return $this->respuestaControl(
                false,
                $mensaje,
                $dispositivoId
            );

        } catch (\Throwable $e) {

            log_message(
                'error',
                'Error en control manual: ' . $e->getMessage()
            );

            return $this->respuestaControl(
                false,
                'No se pudo conectar con el servidor.',
                $dispositivoId
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | RESPUESTA DEL CONTROL
    |--------------------------------------------------------------------------
    */

    private function respuestaControl(
        bool $success,
        string $message,
        int $dispositivoId
    ) {
        if ($this->request->isAJAX()) {
            return $this->response
                ->setJSON([
                    'success' => $success,
                    'message' => $message
                ]);
        }

        return redirect()
            ->to('/gestionar-tacho/' . $dispositivoId)
            ->with(
                $success ? 'success' : 'error',
                $message
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ESTADO DEL TACHO
    |--------------------------------------------------------------------------
    */

    public function estado()
    {
        $usuarioId = $this->requireUser();

        if (!$usuarioId) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON([
                    'success' => false,
                    'message' => 'Debes iniciar sesión.'
                ]);
        }

        $dispositivoId = (int) $this->request->getGet(
            'dispositivo_id'
        );

        if ($dispositivoId <= 0) {
            $dispositivoId = (int) session()->get(
                'dispositivo_actual'
            );
        }

        if ($dispositivoId <= 0) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'success' => false,
                    'message' => 'No hay Eco-Tacho seleccionado.'
                ]);
        }

        if (!$this->acceso(
            $dispositivoId,
            $usuarioId
        )) {
            return $this->response
                ->setStatusCode(403)
                ->setJSON([
                    'success' => false,
                    'message' => 'No tenés acceso a este Eco-Tacho.'
                ]);
        }

        $db = \Config\Database::connect();

        $tacho = $db->table('dispositivos')
            ->select('alerta_papel, distancia_papel')
            ->where('id', $dispositivoId)
            ->get()
            ->getFirstRow();

        if (!$tacho) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'success' => false,
                    'message' => 'Eco-Tacho no encontrado.'
                ]);
        }

        return $this->response
            ->setJSON([
                'success' => true,
                'alerta' => (int) ($tacho->alerta_papel ?? 0),
                'distancia' => $tacho->distancia_papel !== null
                    ? (float) $tacho->distancia_papel
                    : null
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CAMBIAR BOLSA
    |--------------------------------------------------------------------------
    */

    public function cambiarBolsa()
    {
        $usuarioId = $this->requireUser();

        if (!$usuarioId) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON([
                    'success' => false,
                    'message' => 'Debes iniciar sesión.'
                ]);
        }

        $dispositivoId = (int) $this->request->getPost(
            'dispositivo_id'
        );

        if ($dispositivoId <= 0) {
            $dispositivoId = (int) session()->get(
                'dispositivo_actual'
            );
        }

        if ($dispositivoId <= 0) {
            return $this->respuestaBolsa(
                false,
                'No hay Eco-Tacho seleccionado.',
                $dispositivoId
            );
        }

        if (!$this->puedeGestionar(
            $dispositivoId,
            $usuarioId
        )) {
            return $this->respuestaBolsa(
                false,
                'No tenés permiso para confirmar el cambio de bolsa.',
                $dispositivoId
            );
        }

        $db = \Config\Database::connect();

        $tacho = $db->table('dispositivos')
            ->where('id', $dispositivoId)
            ->get()
            ->getFirstRow();

        if (!$tacho) {
            return $this->respuestaBolsa(
                false,
                'Eco-Tacho no encontrado.',
                $dispositivoId
            );
        }

        /*
         * Primero se limpia el aviso en la base local.
         */

        $db->table('dispositivos')
            ->where('id', $dispositivoId)
            ->update([
                'alerta_papel' => 0,
                'distancia_papel' => null
            ]);

        /*
         * También se informa al servidor.
         */

        if (!empty($tacho->codigo_activacion)) {

            try {

                $client = \Config\Services::curlrequest([
                    'timeout' => 5,
                    'http_errors' => false
                ]);

                $client->get(
                    self::SERVER_URL
                    . '/limpiar-alerta-llenado'
                    . '?codigo='
                    . urlencode($tacho->codigo_activacion)
                );

            } catch (\Throwable $e) {

                log_message(
                    'error',
                    'Error limpiando alerta de llenado: '
                    . $e->getMessage()
                );
            }
        }

        return $this->respuestaBolsa(
            true,
            'Se confirmó el cambio de bolsa correctamente.',
            $dispositivoId
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RESPUESTA CAMBIO DE BOLSA
    |--------------------------------------------------------------------------
    */

    private function respuestaBolsa(
        bool $success,
        string $message,
        int $dispositivoId
    ) {
        if ($this->request->isAJAX()) {
            return $this->response
                ->setJSON([
                    'success' => $success,
                    'message' => $message
                ]);
        }

        return redirect()
            ->to('/gestionar-tacho/' . $dispositivoId)
            ->with(
                $success ? 'success' : 'error',
                $message
            );
    }

    /*
    |--------------------------------------------------------------------------
    | USUARIOS DEL ECO-TACHO
    |--------------------------------------------------------------------------
    |
    | SOLO PROPIETARIO.
    |
    */

    public function usuarios($id)
    {
        $usuarioId = $this->requireUser();

        if (!$usuarioId) {
            return redirect()
                ->to('/usuario/login')
                ->with('error', 'Debes iniciar sesión primero.');
        }

        $id = (int) $id;

        if (!$this->esPropietario(
            $id,
            $usuarioId
        )) {
            return redirect()
                ->to('/mis-tachos')
                ->with(
                    'error',
                    'Solamente el propietario puede administrar los usuarios.'
                );
        }

        $db = \Config\Database::connect();

        $tacho = $db->table('dispositivos')
            ->where('id', $id)
            ->get()
            ->getFirstRow();

        if (!$tacho) {
            return redirect()
                ->to('/mis-tachos')
                ->with(
                    'error',
                    'Eco-Tacho no encontrado.'
                );
        }

        $usuarios = $db->table('usuario_dispositivo ud')
            ->select(
                'ud.id AS relacion_id,
                 ud.usuario_id,
                 ud.rol,
                 u.nombre,
                 u.apellido,
                 u.email'
            )
            ->join(
                'usuario u',
                'u.id = ud.usuario_id',
                'left'
            )
            ->where(
                'ud.dispositivo_id',
                $id
            )
            ->orderBy(
                'ud.id',
                'ASC'
            )
            ->get()
            ->getResult();

        return view(
            'tachos/usuarios',
            [
                'tacho' => $tacho,
                'usuarios' => $usuarios
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CAMBIAR ROL
    |--------------------------------------------------------------------------
    |
    | SOLO PROPIETARIO.
    |
    | lector -> administrador
    | administrador -> lector
    |
    */

    public function cambiarRol()
    {
        $usuarioId = $this->requireUser();

        if (!$usuarioId) {
            return redirect()
                ->to('/usuario/login')
                ->with(
                    'error',
                    'Debes iniciar sesión primero.'
                );
        }

        $dispositivoId = (int) $this->request->getPost(
            'dispositivo_id'
        );

        $usuarioObjetivo = (int) $this->request->getPost(
            'usuario_id'
        );

        $nuevoRol = strtolower(
            trim((string) $this->request->getPost('rol'))
        );

        if ($dispositivoId <= 0 || $usuarioObjetivo <= 0) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Datos inválidos.'
                );
        }

        if (!$this->esPropietario(
            $dispositivoId,
            $usuarioId
        )) {
            return redirect()
                ->to('/mis-tachos')
                ->with(
                    'error',
                    'Solamente el propietario puede administrar los usuarios.'
                );
        }

        if (!in_array(
            $nuevoRol,
            ['administrador', 'lector'],
            true
        )) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Rol no válido.'
                );
        }

        if ($usuarioObjetivo === $usuarioId) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'No podés modificar el rol del propietario.'
                );
        }

        $db = \Config\Database::connect();

        $relacion = $db->table('usuario_dispositivo')
            ->where(
                'usuario_id',
                $usuarioObjetivo
            )
            ->where(
                'dispositivo_id',
                $dispositivoId
            )
            ->get()
            ->getFirstRow();

        if (!$relacion) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Ese usuario no pertenece al Eco-Tacho.'
                );
        }

        if (
            strtolower((string) $relacion->rol)
            === 'propietario'
        ) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'No se puede modificar al propietario desde esta sección.'
                );
        }

        $db->table('usuario_dispositivo')
            ->where('id', $relacion->id)
            ->update([
                'rol' => $nuevoRol
            ]);

        return redirect()
            ->to('/usuarios-tacho/' . $dispositivoId)
            ->with(
                'success',
                $nuevoRol === 'administrador'
                    ? 'El usuario ahora es administrador.'
                    : 'El usuario volvió a tener rol de lector.'
            );
    }
}
<?php

namespace App\Controllers;

use App\Models\DispositivoModel;
use App\Models\UsuarioDispositivoModel;

class TachosController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | URL DEL SERVIDOR FASTAPI
    |--------------------------------------------------------------------------
    |
    | Si server.py está ejecutándose en la misma PC que CodeIgniter,
    | también podrías usar:
    |
    | http://127.0.0.1:8000
    |
    | Pero dejamos la IP que ya estás utilizando en tu proyecto.
    |
    */

    private const SERVER_URL = 'http://192.168.1.150:8000';

private const SIMULACION_URL = 'http://192.168.1.150:8080';
    // ============================================================
    // USUARIO ACTUAL
    // ============================================================

    private function requireUser(): ?int
    {
        $id = session()->get('id');

        return $id ? (int) $id : null;
    }


    // ============================================================
    // VERIFICAR ACCESO
    // ============================================================

    private function acceso(int $dispositivoId, int $usuarioId): ?object
    {
        $db = \Config\Database::connect();

        return $db->table('usuario_dispositivo')
            ->where('usuario_id', $usuarioId)
            ->where('dispositivo_id', $dispositivoId)
            ->get()
            ->getFirstRow();
    }


    // ============================================================
    // HABILITAR DISPOSITIVO EN FASTAPI
    // ============================================================

    private function habilitarDispositivo(string $codigo): bool
    {
        $codigo = strtoupper(trim($codigo));

        if ($codigo === '') {
            return false;
        }

        try {

            $client = \Config\Services::curlrequest([
                'timeout' => 10,
                'connect_timeout' => 5,
                'http_errors' => false
            ]);

            $respuesta = $client->post(
                self::SERVER_URL . '/habilitar-dispositivo',
                [
                    'headers' => [
                        'Content-Type' => 'application/json'
                    ],
                    'json' => [
                        'codigo' => $codigo
                    ]
                ]
            );

            $status = $respuesta->getStatusCode();

            $body = (string) $respuesta->getBody();

            log_message(
                'info',
                'Habilitar dispositivo. Código: ' . $codigo .
                ' | HTTP: ' . $status .
                ' | Respuesta: ' . $body
            );

            if ($status < 200 || $status >= 300) {
                return false;
            }

            $data = json_decode($body, true);

            if (!is_array($data)) {
                return false;
            }

            return (
                isset($data['status']) &&
                $data['status'] === 'ok' &&
                isset($data['habilitado']) &&
                $data['habilitado'] === true
            );

        } catch (\Throwable $e) {

            log_message(
                'error',
                'Error habilitando dispositivo: ' . $e->getMessage()
            );

            return false;
        }
    }


    // ============================================================
    // MIS TACHOS
    // ============================================================

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
                $tacho->rol === null ||
                $tacho->rol === ''
            ) {

                $tacho->rol =
                    ((int) $tacho->propietario_id === $usuarioId)
                    ? 'propietario'
                    : 'lector';
            }
        }

return view(
    'tachos/mistachos',
    [
        'tachos' => $tachos,
        'simulacionUrl' => self::SIMULACION_URL
    ]
);
    }


    // ============================================================
    // GUARDAR / REGISTRAR TACHO
    // ============================================================

    public function guardar()
    {
        $usuarioId = $this->requireUser();

        if (!$usuarioId) {
            return redirect()
                ->to('/usuario/login')
                ->with('error', 'Debes iniciar sesión primero.');
        }

        $nombre = trim(
            (string) $this->request->getPost('nombre')
        );

        $tipo = trim(
            (string) $this->request->getPost('tipo')
        );

        $ubicacion = trim(
            (string) $this->request->getPost('ubicacion')
        );

        $codigo = strtoupper(
            trim(
                (string) $this->request->getPost('codigo')
            )
        );


        // ========================================================
        // VALIDACIONES
        // ========================================================

        if (
            $nombre === '' ||
            !in_array(
                $tipo,
                [
                    'residencial',
                    'institucional',
                    'empresarial',
                    'municipal'
                ],
                true
            )
        ) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Datos inválidos.');
        }


        if ($codigo === '') {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Debés ingresar el código de activación del Eco-Tacho.'
                );
        }


        $db = \Config\Database::connect();


        // ========================================================
        // BUSCAR DISPOSITIVO
        // ========================================================

        $dispositivo = $db->table('dispositivos')
            ->where(
                'codigo_activacion',
                $codigo
            )
            ->get()
            ->getFirstRow();


        if (!$dispositivo) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'El código no existe. Primero configurá el Eco-Tacho con la ESP32.'
                );
        }


        // ========================================================
        // VERIFICAR PROPIETARIO
        // ========================================================

        if ($dispositivo->propietario_id !== null) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Este Eco-Tacho ya tiene propietario.'
                );
        }


        // ========================================================
        // REGISTRAR PROPIETARIO
        // ========================================================

        $db->transStart();

        $db->table('dispositivos')
            ->where('id', $dispositivo->id)
            ->update(
                [
                    'nombre' =>
                        $nombre,

                    'tipo' =>
                        $tipo,

                    'ubicacion' =>
                        $ubicacion !== ''
                            ? $ubicacion
                            : null,

                    'propietario_id' =>
                        $usuarioId
                ]
            );


        $db->table('usuario_dispositivo')
            ->insert(
                [
                    'usuario_id' =>
                        $usuarioId,

                    'dispositivo_id' =>
                        $dispositivo->id,

                    'rol' =>
                        'propietario'
                ]
            );


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


        // ========================================================
        // HABILITAR DISPOSITIVO
        // ========================================================

        $habilitado = $this->habilitarDispositivo(
            $codigo
        );


        if (!$habilitado) {

            // Si FastAPI no respondió correctamente,
            // dejamos el dispositivo deshabilitado.

            $db->table('dispositivos')
                ->where('id', $dispositivo->id)
                ->update(
                    [
                        'habilitado' => 0
                    ]
                );

            return redirect()
                ->to('/mis-tachos')
                ->with(
                    'error',
                    'El Eco-Tacho fue registrado, pero no se pudo habilitar. Verificá que server.py esté ejecutándose.'
                );
        }


        // ========================================================
        // TODO CORRECTO
        // ========================================================

        session()->set(
            'dispositivo_actual',
            (int) $dispositivo->id
        );


        return redirect()
            ->to('/mis-tachos')
            ->with(
                'mensaje',
                'Eco-Tacho registrado y habilitado correctamente. La ESP32 ya puede activar la cámara, sensores y servos.'
            );
    }


    // ============================================================
    // SELECCIONAR
    // ============================================================

    public function seleccionar($id)
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

        $id = (int) $id;

        if (
            !$id ||
            !$this->acceso($id, $usuarioId)
        ) {

            return redirect()
                ->to('/mis-tachos')
                ->with(
                    'error',
                    'No tenés acceso a este Eco-Tacho.'
                );
        }

        session()->set(
            'dispositivo_actual',
            $id
        );

        return redirect()
            ->to('/usuario/principal');
    }


    // ============================================================
    // UNIRSE
    // ============================================================

    public function unirse()
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

        return view('tachos/unirse');
    }


    // ============================================================
    // PROCESAR UNION
    // ============================================================

    public function procesarUnion()
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

        $codigo = strtoupper(
            trim(
                (string) $this->request->getPost('codigo')
            )
        );


        if ($codigo === '') {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Ingresá un código.'
                );
        }


        $db = \Config\Database::connect();

        $dispositivo = $db->table('dispositivos')
            ->where(
                'codigo_activacion',
                $codigo
            )
            ->get()
            ->getFirstRow();


        if (!$dispositivo) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Código inválido.'
                );
        }


        $existe = $this->acceso(
            (int) $dispositivo->id,
            $usuarioId
        );


        if ($existe) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Ya estás vinculado a este Eco-Tacho.'
                );
        }


        $db->table('usuario_dispositivo')
            ->insert(
                [
                    'usuario_id' =>
                        $usuarioId,

                    'dispositivo_id' =>
                        $dispositivo->id,

                    'rol' =>
                        (
                            (int) $dispositivo->propietario_id ===
                            $usuarioId
                        )
                        ? 'propietario'
                        : 'lector'
                ]
            );


        return redirect()
            ->to('/mis-tachos')
            ->with(
                'mensaje',
                'Ahora podés ver las estadísticas de este Eco-Tacho.'
            );
    }


    // ============================================================
    // MOSTRAR REGISTRO
    // ============================================================

    public function registrar()
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

        return view('tachos/registrar');
    }


    // ============================================================
    // BUSCAR POR CÓDIGO
    // ============================================================

    public function buscarPorCodigo()
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

        $codigo = strtoupper(
            trim(
                (string) $this->request->getPost('codigo')
            )
        );


        if ($codigo === '') {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Ingresá un código.'
                );
        }


        $db = \Config\Database::connect();

        $dispositivo = $db->table('dispositivos')
            ->where(
                'codigo_activacion',
                $codigo
            )
            ->where(
                'propietario_id IS NULL',
                null,
                false
            )
            ->get()
            ->getFirstRow();


        if (!$dispositivo) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Código inválido o este tacho ya tiene propietario.'
                );
        }


        return view(
            'tachos/registrar',
            [
                'dispositivo' =>
                    $dispositivo
            ]
        );
    }


    // ============================================================
    // ASIGNAR PROPIETARIO
    // ============================================================

    public function asignarPropietario()
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


        $dispositivoId = (int)
            $this->request->getPost(
                'dispositivo_id'
            );

        $tipo = trim(
            (string) $this->request->getPost(
                'tipo'
            )
        );

        $ubicacion = trim(
            (string) $this->request->getPost(
                'ubicacion'
            )
        );


        if (
            !in_array(
                $tipo,
                [
                    'residencial',
                    'institucional',
                    'empresarial',
                    'municipal'
                ],
                true
            )
        ) {

            return redirect()
                ->to('/mis-tachos')
                ->with(
                    'error',
                    'Tipo de Eco-Tacho inválido.'
                );
        }


        $db = \Config\Database::connect();


        // ========================================================
        // BUSCAR DISPOSITIVO
        // ========================================================

        $dispositivo = $db->table('dispositivos')
            ->where(
                'id',
                $dispositivoId
            )
            ->where(
                'propietario_id IS NULL',
                null,
                false
            )
            ->get()
            ->getFirstRow();


        if (!$dispositivo) {

            return redirect()
                ->to('/mis-tachos')
                ->with(
                    'error',
                    'Este tacho ya fue registrado por otro usuario.'
                );
        }


        // ========================================================
        // OBTENER CÓDIGO
        // ========================================================

        $codigo = strtoupper(
            trim(
                (string) $dispositivo->codigo_activacion
            )
        );


        // ========================================================
        // ASIGNAR PROPIETARIO
        // ========================================================

        $db->transStart();

        $db->table('dispositivos')
            ->where(
                'id',
                $dispositivoId
            )
            ->update(
                [
                    'propietario_id' =>
                        $usuarioId,

                    'tipo' =>
                        $tipo,

                    'ubicacion' =>
                        $ubicacion !== ''
                            ? $ubicacion
                            : null
                ]
            );


        $db->table('usuario_dispositivo')
            ->insert(
                [
                    'usuario_id' =>
                        $usuarioId,

                    'dispositivo_id' =>
                        $dispositivoId,

                    'rol' =>
                        'propietario'
                ]
            );


        $db->transComplete();


        if (!$db->transStatus()) {

            return redirect()
                ->to('/mis-tachos')
                ->with(
                    'error',
                    'No se pudo asignar el propietario.'
                );
        }


        // ========================================================
        // HABILITAR EN FASTAPI
        // ========================================================

        $habilitado = $this->habilitarDispositivo(
            $codigo
        );


        if (!$habilitado) {

            $db->table('dispositivos')
                ->where(
                    'id',
                    $dispositivoId
                )
                ->update(
                    [
                        'habilitado' => 0
                    ]
                );

            return redirect()
                ->to('/mis-tachos')
                ->with(
                    'error',
                    'El Eco-Tacho fue registrado, pero no se pudo habilitar. Verificá que server.py esté ejecutándose.'
                );
        }


        // ========================================================
        // GUARDAR COMO DISPOSITIVO ACTUAL
        // ========================================================

        session()->set(
            'dispositivo_actual',
            $dispositivoId
        );


        return redirect()
            ->to('/mis-tachos')
            ->with(
                'mensaje',
                'Eco-Tacho registrado y habilitado correctamente. La ESP32 ya puede activar la cámara, sensores y servos.'
            );
    }


    // ============================================================
    // ELIMINAR
    // ============================================================

    public function eliminar($id)
    {
        $usuarioId = $this->requireUser();

        if (!$usuarioId) {

            return $this->response
                ->setStatusCode(401)
                ->setJSON(
                    [
                        'success' => false,
                        'message' => 'No autenticado'
                    ]
                );
        }


        $id = (int) $id;

        $db = \Config\Database::connect();

        $relacion = $this->acceso(
            $id,
            $usuarioId
        );


        if (!$relacion) {

            return $this->response
                ->setStatusCode(403)
                ->setJSON(
                    [
                        'success' => false,
                        'message' =>
                            'No tenés acceso a este tacho'
                    ]
                );
        }


        $db->transStart();


        if (
            $relacion->rol ===
            'propietario'
        ) {

            /*
             * Al quitar al propietario,
             * también deshabilitamos el dispositivo.
             */

            $db->table('dispositivos')
                ->where(
                    'id',
                    $id
                )
                ->update(
                    [
                        'propietario_id' => null,
                        'habilitado' => 0
                    ]
                );
        }


        $db->table('usuario_dispositivo')
            ->where(
                'usuario_id',
                $usuarioId
            )
            ->where(
                'dispositivo_id',
                $id
            )
            ->delete();


        $db->transComplete();


        if (
            (int) session()->get(
                'dispositivo_actual'
            ) === $id
        ) {

            session()->remove(
                'dispositivo_actual'
            );
        }


        if (!$db->transStatus()) {

            return $this->response
                ->setStatusCode(500)
                ->setJSON(
                    [
                        'success' => false,
                        'message' =>
                            'No se pudo eliminar el acceso'
                    ]
                );
        }


        // ========================================================
        // DESHABILITAR EN FASTAPI
        // ========================================================

        $dispositivoEliminado = $db->table('dispositivos')
            ->where('id', $id)
            ->get()
            ->getFirstRow();

        /*
         * Si todavía existe el dispositivo y tenemos código,
         * avisamos al servidor.
         */

        if ($dispositivoEliminado) {

            $codigo = strtoupper(
                trim(
                    (string)
                    $dispositivoEliminado->codigo_activacion
                )
            );

            if ($codigo !== '') {

                try {

                    $client = \Config\Services::curlrequest(
                        [
                            'timeout' => 5,
                            'connect_timeout' => 3,
                            'http_errors' => false
                        ]
                    );

                    $client->post(
                        self::SERVER_URL .
                        '/deshabilitar-dispositivo',
                        [
                            'headers' => [
                                'Content-Type' =>
                                    'application/json'
                            ],
                            'json' => [
                                'codigo' =>
                                    $codigo
                            ]
                        ]
                    );

                } catch (\Throwable $e) {

                    log_message(
                        'error',
                        'Error deshabilitando dispositivo: ' .
                        $e->getMessage()
                    );
                }
            }
        }


        return $this->response
            ->setJSON(
                [
                    'success' => true,
                    'message' =>
                        'Acceso al tacho eliminado'
                ]
            );
    }
}
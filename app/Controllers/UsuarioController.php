<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\EstadisticaModel;
use App\Models\ClasificacionModel;
use App\Models\DispositivoModel;

class UsuarioController extends BaseController
{
    private function usuarioId(): ?int
    {
        $id = session()->get('id');
        return $id ? (int) $id : null;
    }

    private function verificarSesion()
    {
        if (!session()->has('usuario')) {
            return redirect()->to('/usuario/login');
        }
        return null;
    }

    private function tieneAccesoDispositivo(int $dispositivoId, ?int $usuarioId = null): bool
    {
        $usuarioId ??= $this->usuarioId();
        if (!$usuarioId) {
            return false;
        }

        $db = \Config\Database::connect();
        return (bool) $db->table('usuario_dispositivo')
            ->where('usuario_id', $usuarioId)
            ->where('dispositivo_id', $dispositivoId)
            ->get()
            ->getFirstRow();
    }

    public function inicio()
    {
        return view('inicio');
    }

    public function registro()
    {
        return view('registro');
    }

    public function registrar()
    {
        $rules = [
            'nombre' => 'required',
            'apellido' => 'required',
            'dni' => 'required|numeric',
            'email' => 'required|valid_email',
            'confirmEmail' => 'required|valid_email',
            'contraseña' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Por favor completá correctamente todos los campos.');
        }

        $usuarioModel = new UsuarioModel();
        $dni = trim((string) $this->request->getPost('dni'));
        $email = strtolower(trim((string) $this->request->getPost('email')));
        $confirmEmail = strtolower(trim((string) $this->request->getPost('confirmEmail')));

        if ($email !== $confirmEmail) {
            return redirect()->back()->withInput()->with('error', 'Los emails no coinciden.');
        }

        if ($usuarioModel->where('dni', $dni)->first()) {
            return redirect()->back()->withInput()->with('error', 'El DNI ya está registrado.');
        }

        if ($usuarioModel->where('email', $email)->first()) {
            return redirect()->back()->withInput()->with('error', 'El email ya está registrado.');
        }

        $datos = [
            'nombre' => trim((string) $this->request->getPost('nombre')),
            'apellido' => trim((string) $this->request->getPost('apellido')),
            'dni' => $dni,
            'email' => $email,
            'contraseña' => password_hash((string) $this->request->getPost('contraseña'), PASSWORD_DEFAULT),
            'rol' => 'usuario'
        ];

        if (!$usuarioModel->insert($datos)) {
            return redirect()->back()->withInput()->with('error', 'No se pudo registrar el usuario.');
        }

        $emailService = \Config\Services::email();
        $emailService->setFrom('ecoscam2026@gmail.com', 'EcoS-cam');
        $emailService->setTo($email);
        $emailService->setSubject('Registro exitoso en EcoS-cam');
        $emailService->setMessage("Hola {$datos['nombre']} {$datos['apellido']},<br><br>Tu registro en <b>EcoS-cam</b> se completó correctamente.<br>Ya podés iniciar sesión.");

        if (!$emailService->send()) {
            log_message('error', $emailService->printDebugger(['headers']));
        }

        return redirect()->to('/usuario/login')
            ->with('success', 'Registro exitoso. Te enviamos un correo de confirmación.');
    }

    public function login()
    {
        return view('login');
    }

    public function iniciarSesion()
    {
        $rules = [
            'email' => 'required|valid_email',
            'contraseña' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Completá correctamente los campos.');
        }

        $usuarioModel = new UsuarioModel();
        $email = strtolower(trim((string) $this->request->getPost('email')));
        $contraseña = (string) $this->request->getPost('contraseña');
        $usuario = $usuarioModel->where('email', $email)->first();

        if (!$usuario || !password_verify($contraseña, $usuario['contraseña'])) {
            return redirect()->back()->withInput()->with('error', 'Credenciales incorrectas.');
        }

        session()->regenerate(true);
        session()->set([
            'usuario' => $usuario,
            'id' => $usuario['id'],
            'nombre' => $usuario['nombre'],
            'apellido' => $usuario['apellido']
        ]);

        $db = \Config\Database::connect();
        $primerDispositivo = $db->table('usuario_dispositivo')
            ->select('dispositivo_id')
            ->where('usuario_id', $usuario['id'])
            ->orderBy('id', 'ASC')
            ->get()
            ->getFirstRow();

        if ($primerDispositivo) {
            session()->set('dispositivo_actual', (int) $primerDispositivo->dispositivo_id);
        } else {
            session()->remove('dispositivo_actual');
        }

        return redirect()->to('/usuario/principal');
    }

    public function principal()
    {
        if ($redirect = $this->verificarSesion()) {
            return $redirect;
        }

        $usuario = session()->get('usuario');
        $usuarioId = (int) $usuario['id'];
        $clasificacionModel = new ClasificacionModel();
        $estadisticaModel = new EstadisticaModel();
        $dispositivoModel = new DispositivoModel();
        $db = \Config\Database::connect();

        $tachos = $db->table('usuario_dispositivo ud')
            ->select('d.id,d.nombre,d.ubicacion,d.tipo,d.codigo_activacion,d.habilitado,ud.rol')
            ->join('dispositivos d', 'd.id = ud.dispositivo_id')
            ->where('ud.usuario_id', $usuarioId)
            ->orderBy('d.id', 'ASC')
            ->get()
            ->getResultArray();

        $dispositivoId = session()->get('dispositivo_actual');
        $dispositivoId = $dispositivoId ? (int) $dispositivoId : null;

        if (!$tachos) {
            session()->remove('dispositivo_actual');
            $dispositivoId = null;
        } else {
            $ids = array_map(static fn($t) => (int) $t['id'], $tachos);
            if (!$dispositivoId || !in_array($dispositivoId, $ids, true)) {
                $dispositivoId = $ids[0];
                session()->set('dispositivo_actual', $dispositivoId);
            }
        }

        $tachoSeleccionado = $dispositivoId ? $dispositivoModel->find($dispositivoId) : null;

        $alertaTacho = null;
        if ($dispositivoId) {
            $alertaTacho = $db->table('dispositivos')
                ->select('id,nombre,alerta_papel,distancia_papel')
                ->where('id', $dispositivoId)
                ->get()
                ->getFirstRow('array');
        }

        if (!$dispositivoId || !$tachoSeleccionado) {
            return view('principal', [
                'usuario' => $usuario,
                'residuosHoy' => 0,
                'impactoAmbiental' => 0,
                'nivelEco' => 'Sin datos',
                'labels' => json_encode([]),
                'datos' => json_encode([]),
                'tachoSeleccionado' => null,
                'tachos' => $tachos,
                'alertaTacho' => $alertaTacho
            ]);
        }

        $residuos = $estadisticaModel->residuosPorTipo($dispositivoId);
        $labels = [];
        $datos = [];
        foreach ($residuos as $r) {
            $labels[] = ucfirst($r['residuo']);
            $datos[] = (int) $r['cantidad'];
        }

        return view('principal', [
            'usuario' => $usuario,
            'residuosHoy' => $clasificacionModel->obtenerResiduosHoy($dispositivoId),
            'impactoAmbiental' => $clasificacionModel->obtenerImpactoAmbiental($dispositivoId),
            'nivelEco' => $clasificacionModel->obtenerNivelEcologico($dispositivoId),
            'labels' => json_encode($labels, JSON_UNESCAPED_UNICODE),
            'datos' => json_encode($datos),
            'tachoSeleccionado' => $tachoSeleccionado,
            'tachos' => $tachos,
            'alertaTacho' => $alertaTacho
        ]);
    }

    public function seleccionarDispositivo()
    {
        if ($redirect = $this->verificarSesion()) {
            return $redirect;
        }

        $db = \Config\Database::connect();
        $dispositivos = $db->table('usuario_dispositivo ud')
            ->select('d.id,d.nombre,d.tipo,d.ubicacion,d.codigo_activacion,d.habilitado,ud.rol')
            ->join('dispositivos d', 'd.id = ud.dispositivo_id')
            ->where('ud.usuario_id', $this->usuarioId())
            ->orderBy('d.id', 'ASC')
            ->get()
            ->getResultArray();

        return $this->response->setJSON([
            'success' => !empty($dispositivos),
            'dispositivos' => $dispositivos
        ]);
    }

    public function cambiarDispositivo()
    {
        if ($redirect = $this->verificarSesion()) {
            return $redirect;
        }

        $dispositivoId = (int) $this->request->getPost('dispositivo_id');
        if (!$dispositivoId || !$this->tieneAccesoDispositivo($dispositivoId)) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'No tenés acceso a este Eco-Tacho.'
            ]);
        }

        session()->set('dispositivo_actual', $dispositivoId);
        return $this->response->setJSON(['success' => true]);
    }

    public function cerrarSesion()
    {
        session()->destroy();
        return redirect()->to('/usuario/login');
    }

    public function perfil()
    {
        if ($redirect = $this->verificarSesion()) return $redirect;
        return view('perfil', ['usuario' => session()->get('usuario')]);
    }

    public function cliente()
    {
        if ($redirect = $this->verificarSesion()) return $redirect;
        return view('cliente');
    }

    public function servicios()
    {
        if ($redirect = $this->verificarSesion()) return $redirect;
        return view('servicios');
    }

    public function politica_privacidad()
    {
        if ($redirect = $this->verificarSesion()) return $redirect;
        return view('politica_privacidad');
    }

    public function cambiarPass()
    {
        if ($redirect = $this->verificarSesion()) return $redirect;
        return view('cambiar_pass');
    }

    public function actualizarPass()
    {
        if ($redirect = $this->verificarSesion()) return $redirect;

        $rules = [
            'actual' => 'required',
            'nueva' => 'required|min_length[6]',
            'confirmar' => 'required|matches[nueva]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' ', array_values($this->validator->getErrors())));
        }

        $usuarioModel = new UsuarioModel();
        $sesUsuario = session()->get('usuario');
        $usuario = $usuarioModel->find($sesUsuario['id']);
        $actual = (string) $this->request->getPost('actual');
        $nueva = (string) $this->request->getPost('nueva');

        if (!$usuario || !password_verify($actual, $usuario['contraseña'])) {
            return redirect()->back()->withInput()->with('error', 'La contraseña actual no coincide.');
        }

        if (password_verify($nueva, $usuario['contraseña'])) {
            return redirect()->back()->withInput()->with('error', 'La nueva contraseña debe ser distinta a la actual.');
        }

        $usuarioModel->update($usuario['id'], ['contraseña' => password_hash($nueva, PASSWORD_DEFAULT)]);
        session()->set('usuario', $usuarioModel->find($usuario['id']));
        return redirect()->to('/usuario/perfil')->with('success', 'Contraseña actualizada con éxito.');
    }

    public function estadistica()
    {
        if ($redirect = $this->verificarSesion()) return $redirect;

        $dispositivoId = (int) session()->get('dispositivo_actual');
        if (!$dispositivoId || !$this->tieneAccesoDispositivo($dispositivoId)) {
            return redirect()->to('/mis-tachos');
        }

        return redirect()->to('/estadisticas-tacho/' . $dispositivoId);
    }

    public function logro()
    {
        if ($redirect = $this->verificarSesion()) return $redirect;

        $dispositivoId = (int) session()->get('dispositivo_actual');
        $model = new ClasificacionModel();
        $data = [
            'usuario' => session()->get('usuario'),
            'residuosHoy' => $dispositivoId ? $model->obtenerResiduosHoy($dispositivoId) : 0,
            'impactoAmbiental' => $dispositivoId ? $model->obtenerImpactoAmbiental($dispositivoId) : 0,
            'nivelEco' => $dispositivoId ? $model->obtenerNivelEcologico($dispositivoId) : 'Sin datos'
        ];
        return view('logro', $data);
    }

    public function mostrar()
    {
        if ($redirect = $this->verificarSesion()) return $redirect;
        $usuarioModel = new UsuarioModel();
        return view('mostrar', ['usuarios' => $usuarioModel->findAll()]);
    }
}

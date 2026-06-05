<?php
namespace App\Controllers;
use App\Models\UsuarioModel;
use App\Models\EstadisticaModel;
use App\Models\ClasificacionModel;
class UsuarioController extends BaseController {

  public function inicio() {
    return view('inicio');
  }

  public function registro() {
    return view('registro');
  }


  public function   registrar() {
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
    $dniIngresado = $this->request->getPost('dni');
    $emailIngresado = $this->request->getPost('email');
    $confirmEmail = $this->request->getPost('confirmEmail');

    // Validación de coincidencia 
    if (strtolower(trim($emailIngresado)) !== strtolower(trim($confirmEmail))) {
        return redirect()->back()->withInput()->with('error', 'Los gmails no coinciden');
    }

    if ($usuarioModel->where('dni', $dniIngresado)->first()) {
        return redirect()->back()->withInput()->with('error', 'El DNI ya está registrado.');
    }

    if ($usuarioModel->where('email', $emailIngresado)->first()) {
        return redirect()->back()->withInput()->with('error', 'El email ya está registrado.');
    }

    $emailNormalizado = strtolower(trim($emailIngresado));
    $rol = 'cliente';



               $datos = [
               'nombre' => $this->request->getPost('nombre'),
                'apellido' => $this->request->getPost('apellido'),
               'dni' => $dniIngresado,
               'email' => $emailNormalizado,
                'contraseña' => password_hash($this->request->getPost('contraseña'), PASSWORD_DEFAULT),
                 'rol' => $rol
         ];
           $usuarioModel->insert($datos);



    // Enviar correo de confirmación
    $emailService = \Config\Services::email();
    $emailService->setFrom('ecoscam2026@gmail.com', 'EcoS-cam');
    $emailService->setTo($emailNormalizado);
    $emailService->setSubject('Registro exitoso en Eco-Scam');
    $emailService->setMessage("
        Hola {$datos['nombre']} {$datos['apellido']},<br><br>
        Tu registro en <b>Eco-Scam</b> se ha completado correctamente.<br>
        Ya podés iniciar sesión en la plataforma.<br><br>
        ¡Bienvenido!
    ");

    if (!$emailService->send()) {
        log_message('error', $emailService->printDebugger(['headers']));
    }

    // Mensaje en la página
    return redirect()->to('/usuario/login')
                     ->with('success', 'Registro exitoso. Te enviamos un correo de confirmación.');
}

  public function login() {
    return view('login');
  }

  public function iniciarSesion() {
    $rules = [
      'email' => 'required|valid_email',
      'contraseña' => 'required'
    ];

    if (!$this->validate($rules)) {
      return redirect()->back()->withInput()->with('error', 'Completá correctamente los campos.');
    }

    $usuarioModel = new UsuarioModel();
    $email = strtolower(trim($this->request->getPost('email')));
    $contraseña = $this->request->getPost('contraseña');
    $usuario = $usuarioModel->where('email', $email)->first();

    if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {
        session()->set([
            'usuario' => $usuario,
            'id' => $usuario['id']
        ]);

      if ($usuario['rol'] === 'cliente') {
          session()->set([
              'id_cliente' => $usuario['id'],
              'nombre'    => $usuario['nombre'],
              'apellido'  => $usuario['apellido'],
          ]);
      }

      return redirect()->to('/usuario/principal');
  } else {
      return redirect()->back()->withInput()->with('error', 'Credenciales incorrectas.');
  }
}

public function principal()
{
    if (!session()->has('usuario')) {
        return redirect()->to('/usuario/login');
    }

    $usuario = session()->get('usuario');

    $clasificacionModel = new ClasificacionModel();
    $estadisticaModel = new EstadisticaModel();

    // Datos para gráfico
    $dispositivo_id =
    session()->get('dispositivo_actual');

if(!$dispositivo_id)
{
    return redirect()->to('/mis-tachos');
}

$residuos =
    $estadisticaModel->residuosPorTipo(
        $dispositivo_id
    );

    $labels = [];
    $datos = [];

    foreach ($residuos as $r) {
        $labels[] = ucfirst($r['residuo']);
        $datos[] = $r['cantidad'];
    }

    $data = [
        'usuario' => $usuario,
        'residuosHoy' => $clasificacionModel->obtenerResiduosHoy(),
        'impactoAmbiental' => $clasificacionModel->obtenerImpactoAmbiental(),
        'nivelEco' => $clasificacionModel->obtenerNivelEcologico(),

        // gráfico
        'labels' => json_encode($labels),
        'datos' => json_encode($datos)
    ];

    return view('principal', $data);
}
  public function cerrarSesion() {
    session()->destroy();
    return redirect()->to('/usuario/login');
  }

  public function perfil() {
    if (! session()->has('usuario')) {
        return redirect()->to('/usuario/login');
    }

    $data['usuario'] = session()->get('usuario');
    return view('/perfil', $data);
  }

  public function cliente() {
    if (! session()->has('usuario')) {
        return redirect()->to('/usuario/login');
    }

    return view('cliente'); 
  }

  public function servicios() {
    if (! session()->has('usuario')) {
        return redirect()->to('/usuario/login');
    }

    return view('servicios'); 
  }

  public function politica_privacidad() {
    if (! session()->has('usuario')) {
        return redirect()->to('/usuario/login');
    }

    return view('politica_privacidad_view');
  }

  // Mostrar formulario para cambiar contraseña (usuario logueado)
  public function cambiarPass()
  {
      if (! session()->has('usuario')) {
          return redirect()->to('/usuario/login');
      }

      return view('cambiar_pass');
  }

  // Actualización de contraseña
  public function actualizarPass()
  {
      if (! session()->has('usuario')) {
          return redirect()->to('/usuario/login');
      }

      $rules = [
          'actual'    => 'required',
          'nueva'     => 'required|min_length[6]',
          'confirmar' => 'required|matches[nueva]'
      ];

      if (!$this->validate($rules)) {
          $errors = $this->validator->getErrors();
          $msg = implode(' ', array_values($errors));
          return redirect()->back()->withInput()->with('error', $msg);
      }

      $usuarioModel = new UsuarioModel();
      $sesUsuario = session()->get('usuario');
      $usuario = $usuarioModel->find($sesUsuario['id']);

      $actual = $this->request->getPost('actual');
      $nueva  = $this->request->getPost('nueva');

      // Verificar contraseña actual
      if (! password_verify($actual, $usuario['contraseña'])) {
          return redirect()->back()->withInput()->with('error', 'La contraseña actual no coincide.');
      }

      // No repetir la misma contraseña 
      if (password_verify($nueva, $usuario['contraseña'])) {
          return redirect()->back()->withInput()->with('error', 'La nueva contraseña debe ser distinta a la actual.');
      }

      // Actualizar en la BD
      $usuarioModel->update($usuario['id'], [
          'contraseña' => password_hash($nueva, PASSWORD_DEFAULT)
      ]);

      // Refrescar datos en sesión 
      $usuarioActualizado = $usuarioModel->find($usuario['id']);
      session()->set('usuario', $usuarioActualizado);

      return redirect()->to('/usuario/perfil')->with('success', 'Contraseña actualizada con éxito.');
  }
    // Estadisticas
public function estadistica()
{

    if (!session()->has('usuario')) {
        return redirect()->to('/usuario/login');
    }

    $model = new EstadisticaModel();

    $dispositivo_id =
    session()->get('dispositivo_actual');

if(!$dispositivo_id)
{
    return redirect()->to('/mis-tachos');
}

$residuos =
    $model->residuosPorTipo(
        $dispositivo_id
    );

    $labels = [];
    $datos = [];

    foreach ($residuos as $r) {
        $labels[] = ucfirst($r['residuo']);
        $datos[] = $r['cantidad'];
    }

    $data = [
        'usuario'  => session()->get('usuario'),
        'total'    => $model->totalClasificaciones($dispositivo_id),
        'promedio' => $model->promedioConfianza($dispositivo_id),
        'hoy'      => $model->clasificacionesHoy($dispositivo_id),
        'ultimos'  => $model->ultimosRegistros($dispositivo_id),
        'labels'   => json_encode($labels),
        'datos'    => json_encode($datos)
    ];

    return view('estadistica', $data);
}

public function logro()
{
    if (!session()->has('usuario')) {
        return redirect()->to('/usuario/login');
    }

    $usuario = session()->get('usuario');

    $clasificacionModel = new ClasificacionModel();

    $data = [
        'usuario' => $usuario,
        'residuosHoy' => $clasificacionModel->obtenerResiduosHoy(),
        'impactoAmbiental' => $clasificacionModel->obtenerImpactoAmbiental(),
        'nivelEco' => $clasificacionModel->obtenerNivelEcologico()
    ];

    return view('logro', $data);
}

}
?>

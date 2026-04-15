<?php
namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\PasswordResetModel;
use CodeIgniter\Controller;

class ContraseñaController extends BaseController

{ public function enviarRecuperacion()
    {
        $email = strtolower(trim($this->request->getPost('email')));
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->where('email', $email)->first();
    
        if (!$usuario) {
            return redirect()->back()->with('error', 'Ese correo no está registrado.');
        }
    
        $token = bin2hex(random_bytes(32));
        $resetModel = new \App\Models\PasswordResetModel();
        $resetModel->insert(['email' => $email, 'token' => $token]);
    
        $link = site_url("usuario/restablecer/$token");
    
        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setSubject('Recuperación de contraseña');
        $emailService->setMessage("Hacé clic en el siguiente enlace para restablecer tu contraseña: $link");
        $emailService->send();
    
        return redirect()->to('usuario/login')->with('mensaje', 'Te enviamos un enlace a tu correo.');
    }
    public function restablecer($token)
{
    $resetModel = new \App\Models\PasswordResetModel();
    $registro = $resetModel->where('token', $token)->first();

    if (!$registro) {
        return redirect()->to('usuario/login')->with('error', 'Token inválido o expirado.');
    }

    return view('formRestablecer', ['token' => $token]);
}
public function guardarNuevaContrasena()
{
    $token = $this->request->getPost('token');
    $nueva = $this->request->getPost('contraseña');

    $resetModel = new \App\Models\PasswordResetModel();
    $registro = $resetModel->where('token', $token)->first();

    if (!$registro) {
        return redirect()->to('/login')->with('error', 'Token inválido.');
    }

    $usuarioModel = new UsuarioModel();
    $usuarioModel->where('email', $registro['email'])
                 ->set(['contraseña' => password_hash($nueva, PASSWORD_DEFAULT)])
                 ->update();

    $resetModel->where('token', $token)->delete();

    return redirect()->to('usuario/login')->with('mensaje', 'Contraseña actualizada correctamente.');
}

public function recuperar()
{
    return view('recuperarcontraseña');
}

public function login()
{
    return view('login');
}

public function probarCorreo()
{
    $emailService = \Config\Services::email();
    $emailService->setTo('TU_CORREO@gmail.com');
    $emailService->setSubject('Prueba desde CodeIgniter');
    $emailService->setMessage('Este es un mensaje de prueba desde tu proyecto Optiglass.');

    if ($emailService->send()) {
        echo '✅ Correo enviado correctamente';
    } else {
        echo '❌ Error al enviar el correo:<br>';
        print_r($emailService->printDebugger(['headers']));
    }
}

}    
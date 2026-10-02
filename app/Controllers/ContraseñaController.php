<?php
namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\PasswordResetModel;
use CodeIgniter\Controller;

class ContraseñaController extends BaseController
{ 
    public function recuperar()
    {
        return view('recuperarcontraseña');
    }

    public function enviarRecuperacion()
    {
        $email = strtolower(trim((string)$this->request->getPost('email')));
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->where('email', $email)->first();
    
        if (!$usuario) {
            return redirect()->back()->with('error', 'Ese correo no está registrado.');
        }
    
        $token = bin2hex(random_bytes(32));
        $resetModel = new PasswordResetModel();
        
        // Opcional: Borrar tokens viejos de este correo para no saturar la tabla
        $resetModel->where('email', $email)->delete();
        
        $resetModel->insert(['email' => $email, 'token' => $token]);
    
        $link = site_url("usuario/restablecer/$token");
    
        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setSubject('Recuperación de contraseña | EcoScam');
        $emailService->setMessage("Hacé clic en el siguiente enlace para restablecer tu contraseña: $link");
        
        if($emailService->send()){
            return redirect()->to('usuario/login')->with('mensaje', 'Te enviamos un enlace a tu correo.');
        } else {
            log_message('error', $emailService->printDebugger(['headers']));
            return redirect()->back()->with('error', 'No se pudo enviar el correo electrónico.');
        }
    }

    public function restablecer($token)
    {
        $resetModel = new PasswordResetModel();
        $registro = $resetModel->where('token', $token)->first();

        if (!$registro) {
            return redirect()->to('usuario/login')->with('error', 'Token inválido o expirado.');
        }

        // Corregido al nombre exacto de tu archivo vista
        return view('fromrestablecer', ['token' => $token]);
    }

    public function guardarNuevaContrasena()
    {
        $token = $this->request->getPost('token');
        $nueva = (string)$this->request->getPost('contraseña');

        $resetModel = new PasswordResetModel();
        $registro = $resetModel->where('token', $token)->first();

        if (!$registro) {
            return redirect()->to('usuario/login')->with('error', 'Token inválido.');
        }

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->where('email', $registro['email'])->first();

        if ($usuario) {
            // Actualización corregida usando el ID del usuario
            $usuarioModel->update($usuario['id'], [
                'contraseña' => password_hash($nueva, PASSWORD_DEFAULT)
            ]);
            
            // Eliminamos el token usado
            $resetModel->where('token', $token)->delete();
            return redirect()->to('usuario/login')->with('mensaje', 'Contraseña actualizada correctamente.');
        }

        return redirect()->to('usuario/login')->with('error', 'No se pudo encontrar el usuario asociado.');
    }

    public function login()
    {
        return view('login');
    }

public function probarCorreo()
{
    $config = config('Email');

    echo '<pre>';

    echo "========== CONFIGURACIÓN LEÍDA POR CODEIGNITER ==========\n\n";

    echo "SMTP HOST: " . $config->SMTPHost . "\n";
    echo "SMTP USER: " . $config->SMTPUser . "\n";
    echo "SMTP PORT: " . $config->SMTPPort . "\n";
    echo "SMTP CRYPTO: " . $config->SMTPCrypto . "\n";

    echo "SMTP PASS LENGTH: " . strlen($config->SMTPPass) . "\n";

    echo "\n==========================================================\n";

    $emailService = \Config\Services::email();

    $emailService->setTo('ecoscam2026@gmail.com');
    $emailService->setSubject('Prueba EcoScam');
    $emailService->setMessage('Prueba de correo desde EcoScam.');

    if ($emailService->send()) {

        echo "\n✅ CORREO ENVIADO CORRECTAMENTE";

    } else {

        echo "\n❌ ERROR AL ENVIAR\n\n";
        echo $emailService->printDebugger(['headers']);
    }

    echo '</pre>';
}
}

<?php

namespace App\Controllers;

class PrincipalController extends BaseController
{
    public function index()
    {
        // Verifica si el usuario está logueado
        if (!session()->has('usuario')) {
            return redirect()->to('/usuario/inicio');
        }

        //  pasa datos del usuario a la vista si querés mostrar su nombre, por ejemplo
        $usuario = session()->get('usuario');

        return view('dashboard', ['usuario' => $usuario]);
    }
}

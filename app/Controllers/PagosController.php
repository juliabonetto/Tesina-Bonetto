<?php

namespace App\Controllers;

class PagosController extends BaseController
{
    public function checkout()
    {
        $data = [
            'producto' => 'EcoScam Premium',
            'precio' => 5000
        ];
    
        return view('pagos/checkout', $data);
    }

    public function exito()
    {
        return view('pagos/exito');
    }

    public function error()
    {
        return view('pagos/error');
    }

    public function pendiente()
    {
        return view('pagos/pendiente');
    }
}
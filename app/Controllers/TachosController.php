<?php

namespace App\Controllers;

use App\Models\DispositivoModel;
use App\Models\UsuarioDispositivoModel;

class TachosController extends BaseController
{
    public function mistachos()
    {
        $usuario_id = session()->get('id');

        $db = \Config\Database::connect();

        $tachos = $db->table('usuario_dispositivo ud')
            ->select('d.*')
            ->join('dispositivos d', 'd.id = ud.dispositivo_id')
            ->where('ud.usuario_id', $usuario_id)
            ->get()
            ->getResult();

        return view('tachos/mistachos', [
            'tachos' => $tachos
        ]);
    }

    public function registrar()
    {
        return view('tachos/registrar');
    }

    public function guardar()
    {
        $dispositivoModel = new DispositivoModel();

        $id = $dispositivoModel->insert([
            'nombre' => $this->request->getPost('nombre'),
            'tipo' => $this->request->getPost('tipo'),
            'ubicacion' => $this->request->getPost('ubicacion'),
            'codigo_activacion' => $this->request->getPost('codigo')
        ]);

        $usuarioDispositivo = new UsuarioDispositivoModel();

        $usuarioDispositivo->insert([
            'usuario_id' => session()->get('id'),
            'dispositivo_id' => $id,
            'rol' => 'propietario'
        ]);

        return redirect()->to('/mis-tachos');
    }

    public function seleccionar($id)
    {
        session()->set('dispositivo_actual', $id);
    
        return redirect()->to('/usuario/principal');
    }

    public function unirse()
    {
        return view('tachos/unirse');
    } 
    public function procesarUnion()
{
    $db = \Config\Database::connect();

    $codigo =
        $this->request->getPost('codigo');

    $dispositivo =
        $db->table('dispositivos')
        ->where(
            'codigo_activacion',
            $codigo
        )
        ->get()
        ->getRow();

    if(!$dispositivo)
    {
        return redirect()
            ->back()
            ->with(
                'error',
                'Código inválido'
            );
    }

    $db->table('usuario_dispositivo')
        ->insert([

            'usuario_id' =>
            session()->get('id'),

            'dispositivo_id' =>
                $dispositivo->id,

            'rol' =>
                'lector'

        ]);

    return redirect()
        ->to('/mis-tachos');
}
}
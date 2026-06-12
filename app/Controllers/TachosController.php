<?php

namespace App\Controllers;

use App\Models\DispositivoModel;
use App\Models\UsuarioDispositivoModel;

class TachosController extends BaseController
{
    // ========== VERIFICACIÓN DE SESIÓN (MÉTODO AUXILIAR) ==========
    private function verificarSesion()
    {
        $usuario_id = session()->get('id');
        if (!$usuario_id) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión primero.');
        }
        return $usuario_id;
    }

    // ========== MIS TACHOS ==========
    public function mistachos()
    {
        $usuario_id = session()->get('id');
        if (!$usuario_id) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión primero.');
        }
        
        $db = \Config\Database::connect();

        $tachos = $db->table('usuario_dispositivo ud')
            ->select('d.*, ud.rol')
            ->join('dispositivos d', 'd.id = ud.dispositivo_id')
            ->where('ud.usuario_id', $usuario_id)
            ->get()
            ->getResult();

        return view('tachos/mistachos', ['tachos' => $tachos]);
    }

    // ========== GUARDAR (CREAR NUEVO TACHO MANUAL) ==========
    public function guardar()
    {
        $usuario_id = session()->get('id');
        if (!$usuario_id) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión primero.');
        }

        $dispositivoModel = new DispositivoModel();

        $id = $dispositivoModel->insert([
            'nombre' => $this->request->getPost('nombre'),
            'tipo' => $this->request->getPost('tipo'),
            'ubicacion' => $this->request->getPost('ubicacion'),
            'codigo_activacion' => $this->request->getPost('codigo')
        ]);

        $usuarioDispositivo = new UsuarioDispositivoModel();

        $usuarioDispositivo->insert([
            'usuario_id' => $usuario_id,
            'dispositivo_id' => $id,
            'rol' => 'propietario'
        ]);

        return redirect()->to('/mis-tachos');
    }

    // ========== SELECCIONAR TACHO ==========
    public function seleccionar($id)
    {
        $usuario_id = session()->get('id');
        if (!$usuario_id) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión primero.');
        }
        
        session()->set('dispositivo_actual', $id);
        return redirect()->to('/usuario/principal');
    }

    // ========== UNIRSE A TACHO EXISTENTE ==========
    public function unirse()
    {
        $usuario_id = session()->get('id');
        if (!$usuario_id) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión primero.');
        }
        
        return view('tachos/unirse');
    }
    
    // ========== PROCESAR UNIÓN A TACHO ==========
    public function procesarUnion()
    {
        $usuario_id = session()->get('id');
        if (!$usuario_id) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión primero.');
        }
        
        $codigo = $this->request->getPost('codigo');
        $db = \Config\Database::connect();

        $dispositivo = $db->table('dispositivos')
            ->where('codigo_activacion', $codigo)
            ->get()
            ->getRow();

        if (!$dispositivo) {
            return redirect()->back()->with('error', 'Código inválido.');
        }

        // Verificar si el usuario ya tiene relación con este dispositivo
        $existe = $db->table('usuario_dispositivo')
            ->where('usuario_id', $usuario_id)
            ->where('dispositivo_id', $dispositivo->id)
            ->get()
            ->getRow();

        if ($existe) {
            return redirect()->back()->with('error', 'Ya estás vinculado a este Eco-Tacho.');
        }

        $db->table('usuario_dispositivo')->insert([
            'usuario_id' => $usuario_id,
            'dispositivo_id' => $dispositivo->id,
            'rol' => 'lector'
        ]);

        return redirect()->to('/mis-tachos')->with('mensaje', 'Ahora puedes ver las estadísticas de este Eco-Tacho.');
    }

    // ========== REGISTRAR (PRIMER PASO - FORMULARIO) ==========
    public function registrar()
    {
        $usuario_id = session()->get('id');
        if (!$usuario_id) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión primero.');
        }
        
        return view('tachos/registrar');
    }

    // ========== BUSCAR POR CÓDIGO (PRIMER PASO - VERIFICACIÓN) ==========
    public function buscarPorCodigo()
    {
        $usuario_id = session()->get('id');
        if (!$usuario_id) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión primero.');
        }
        
        $codigo = $this->request->getPost('codigo');
        $db = \Config\Database::connect();
        
        $dispositivo = $db->table('dispositivos')
            ->where('codigo_activacion', $codigo)
            ->where('propietario_id', null)  // solo si aún no tiene dueño
            ->get()
            ->getRow();

        if (!$dispositivo) {
            return redirect()->back()->with('error', 'Código inválido o este tacho ya tiene propietario.');
        }

        // Mostrar formulario con datos del dispositivo
        return view('tachos/registrar', ['dispositivo' => $dispositivo]);
    }

    // ========== ASIGNAR PROPIETARIO (SEGUNDO PASO) ==========
    public function asignarPropietario()
    {
        // 🔥 VERIFICAR SESIÓN (lo más importante)
        $usuario_id = session()->get('id');
        if (!$usuario_id) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión primero.');
        }
        
        $dispositivo_id = $this->request->getPost('dispositivo_id');
        $tipo = $this->request->getPost('tipo');
        $ubicacion = $this->request->getPost('ubicacion');

        $db = \Config\Database::connect();

        // Verificar que el dispositivo existe y no tiene dueño
        $dispositivo = $db->table('dispositivos')
            ->where('id', $dispositivo_id)
            ->where('propietario_id', null)
            ->get()
            ->getRow();

        if (!$dispositivo) {
            return redirect()->to('/mis-tachos')->with('error', 'Este tacho ya fue registrado por otro usuario.');
        }

        // Actualizar dispositivo con propietario, tipo y ubicación
        $db->table('dispositivos')->update(
            [
                'propietario_id' => $usuario_id,
                'tipo' => $tipo,
                'ubicacion' => $ubicacion
            ],
            ['id' => $dispositivo_id]
        );

        // Crear relación propietario en usuario_dispositivo
        $db->table('usuario_dispositivo')->insert([
            'usuario_id' => $usuario_id,
            'dispositivo_id' => $dispositivo_id,
            'rol' => 'propietario'
        ]);

        return redirect()->to('/mis-tachos')->with('mensaje', 'Eco-Tacho registrado exitosamente.');
    }
}
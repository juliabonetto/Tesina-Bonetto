<?php

namespace App\Controllers;

use App\Models\EstadisticaModel;

class EstadisticaController extends BaseController
{
    public function show($id)
    {
        $usuarioId = session()->get('id');
        if (!$usuarioId) {
            return redirect()->to('/usuario/login')->with('error', 'Debes iniciar sesión primero.');
        }

        $id = (int) $id;
        $db = \Config\Database::connect();
        $acceso = $db->table('usuario_dispositivo')
            ->where('usuario_id', (int) $usuarioId)
            ->where('dispositivo_id', $id)
            ->get()
            ->getFirstRow();

        if (!$acceso) {
            return redirect()->to('/mis-tachos')->with('error', 'No tenés acceso a este Eco-Tacho.');
        }

        session()->set('dispositivo_actual', $id);

        $tacho = $db->table('dispositivos')
            ->where('id', $id)
            ->get()
            ->getFirstRow();

        if (!$tacho) {
            return redirect()->to('/mis-tachos')->with('error', 'Eco-Tacho no encontrado.');
        }

        $model = new EstadisticaModel();
        $residuos = $model->residuosPorTipo($id);
        $labels = array_map(static fn($r) => ucfirst($r['residuo']), $residuos);
        $datos = array_map(static fn($r) => (int) $r['cantidad'], $residuos);

        return view('estadistica', [
            'tacho' => $tacho,
            'total' => $model->totalClasificaciones($id),
            'hoy' => $model->clasificacionesHoy($id),
            'promedio' => $model->promedioConfianza($id),
            'ultimos' => $model->ultimosRegistros($id),
            'labels' => json_encode($labels, JSON_UNESCAPED_UNICODE),
            'datos' => json_encode($datos)
        ]);
    }
}

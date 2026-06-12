<?php

namespace App\Controllers;

use App\Models\EstadisticaModel;

class EstadisticaController extends BaseController
{
 
    public function show($id)
    {
        $model = new EstadisticaModel();


        // Verificar que el usuario tenga acceso a este dispositivo
        $db = \Config\Database::connect();
        $existe = $db->table('usuario_dispositivo')
            ->where('usuario_id', session()->get('id'))
            ->where('dispositivo_id', $id)
            ->get()
            ->getRow();


        if (!$existe) {
            return redirect()->to('/mis-tachos')->with('error', 'No tienes acceso a este Eco-Tacho.');
        }


        // Obtener datos del tacho (nombre, tipo, etc.)
        $tacho = $db->table('dispositivos')->where('id', $id)->get()->getRow();


        // Calcular estadísticas
        $residuos = $model->residuosPorTipo($id);
        $labels = array_column($residuos, 'residuo');
        $datos = array_column($residuos, 'cantidad');
        $total = $model->totalClasificaciones($id);
        $promedio = $model->promedioConfianza($id);
        $hoy = $model->clasificacionesHoy($id);
        $ultimos = $model->ultimosRegistros($id);


        return view('estadistica', [
            'tacho' => $tacho,
            'total' => $total,
            'hoy' => $hoy,
            'promedio' => $promedio,
            'ultimos' => $ultimos,
            'labels' => json_encode($labels),
            'datos' => json_encode($datos)
        ]);
    }
}
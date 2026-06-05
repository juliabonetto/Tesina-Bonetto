<?php

namespace App\Controllers;

use App\Models\EstadisticaModel;

class EstadisticaController extends BaseController
{
    public function index()
    {
        $model = new EstadisticaModel();

        $dispositivo_id = session()->get('dispositivo_actual');

        if (!$dispositivo_id)
        {
            return redirect()->to('/mis-tachos');
        }

        $residuos = $model->residuosPorTipo($dispositivo_id);

        $labels = [];
        $datos = [];

        foreach ($residuos as $r)
        {
            $labels[] = $r['residuo'];
            $datos[] = $r['cantidad'];
        }

        $data = [

            'total' =>
                $model->totalClasificaciones(
                    $dispositivo_id
                ),

            'promedio' =>
                $model->promedioConfianza(
                    $dispositivo_id
                ),

            'hoy' =>
                $model->clasificacionesHoy(
                    $dispositivo_id
                ),

            'ultimos' =>
                $model->ultimosRegistros(
                    $dispositivo_id
                ),

            'labels' => json_encode($labels),

            'datos' => json_encode($datos)

        ];

        return view('estadistica', $data);
    }
}
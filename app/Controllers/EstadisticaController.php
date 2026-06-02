<?php

namespace App\Controllers;

use App\Models\EstadisticaModel;

class EstadisticaController extends BaseController
{
    public function index()
    {
        $model = new EstadisticaModel();

        $residuos = $model->residuosPorTipo();

        $labels = [];
        $datos = [];

        foreach($residuos as $r){
            $labels[] = $r['residuo'];
            $datos[] = $r['cantidad'];
        }

        $data = [
            'total' => $model->totalClasificaciones(),
            'promedio' => $model->promedioConfianza(),
            'hoy' => $model->clasificacionesHoy(),
            'ultimos' => $model->ultimosRegistros(),
            'labels' => json_encode($labels),
            'datos' => json_encode($datos)
        ];

        return view('estadistica', $data);
    }
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class ClasificacionModel extends Model
{
    protected $table = 'clasificaciones';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'fecha_hora',
        'residuo',
        'confianza',
        'clasificacion',
        'imagen'
    ];


    public function obtenerCO2Hoy()
    {
        $datos = $this->select('residuo, COUNT(*) as cantidad')
                      ->where('DATE(fecha_hora)', date('Y-m-d'))
                      ->groupBy('residuo')
                      ->findAll();

        $equivalencias = [
            'papel' => 0.15,
            'plastico' => 0.25,
            'vidrio' => 0.20,
            'organico' => 0.10
        ];

        $co2 = 0;

        foreach ($datos as $fila) {

            $tipo = strtolower($fila['residuo']);

            if (isset($equivalencias[$tipo])) {
                $co2 += $fila['cantidad'] * $equivalencias[$tipo];
            }
        }

        return round($co2, 2);
    }
     public function obtenerResiduosHoy()
    {
        return $this->where('DATE(fecha_hora)', date('Y-m-d'))
                    ->countAllResults();
    }

    public function obtenerImpactoAmbiental()
    {
        $residuosHoy = $this->obtenerResiduosHoy();

        return min(100, $residuosHoy * 2);
    }

    public function obtenerNivelEcologico()
    {
        $total = $this->countAll();

        if ($total >= 1000) return 'Eco Maestro';
        if ($total >= 500) return 'Eco Experto';
        if ($total >= 300) return 'Eco Avanzado';
        if ($total >= 150) return 'Eco Comprometido';
        if ($total >= 50) return 'Eco Aprendiz';

        return 'Eco Principiante';
    }
}
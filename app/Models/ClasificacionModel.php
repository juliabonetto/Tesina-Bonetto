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
        'imagen',
        'dispositivo_id'   // ← asegurate de que exista esta columna
    ];

    // 🔹 Residuos de hoy para un dispositivo específico
    public function obtenerResiduosHoy($dispositivo_id)
    {
        return $this->where('dispositivo_id', $dispositivo_id)
                    ->where('DATE(fecha_hora)', date('Y-m-d'))
                    ->countAllResults();
    }

    // 🔹 Impacto ambiental (basado en residuos de hoy)
    public function obtenerImpactoAmbiental($dispositivo_id)
    {
        $residuosHoy = $this->obtenerResiduosHoy($dispositivo_id);
        return min(100, $residuosHoy * 2);
    }

    // 🔹 Nivel ecológico (basado en el total de residuos del dispositivo)
    public function obtenerNivelEcologico($dispositivo_id)
    {
        $total = $this->where('dispositivo_id', $dispositivo_id)->countAllResults();

        if ($total >= 1000) return 'Eco Maestro';
        if ($total >= 500)  return 'Eco Experto';
        if ($total >= 300)  return 'Eco Avanzado';
        if ($total >= 10)   return 'Eco Comprometido';
        if ($total >= 5)    return 'Eco Aprendiz';
        return 'Eco Principiante';
    }

    // 🔹 (Opcional) CO₂ de hoy para un dispositivo
    public function obtenerCO2Hoy($dispositivo_id)
    {
        $datos = $this->select('residuo, COUNT(*) as cantidad')
                      ->where('dispositivo_id', $dispositivo_id)
                      ->where('DATE(fecha_hora)', date('Y-m-d'))
                      ->groupBy('residuo')
                      ->findAll();

        $equivalencias = [
            'papel'    => 0.15,
            'plastico' => 0.25,
            'vidrio'   => 0.20,
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
}
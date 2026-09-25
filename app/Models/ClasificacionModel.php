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
        'dispositivo_id',
        'categoria_final',
        'seleccion_manual'
    ];
    protected $returnType = 'array';

    public function obtenerResiduosHoy(int $dispositivoId): int
    {
        return (int) $this->where('dispositivo_id', $dispositivoId)
            ->where('DATE(fecha_hora)', date('Y-m-d'))
            ->countAllResults();
    }

    public function obtenerImpactoAmbiental(int $dispositivoId): int
    {
        return min(100, $this->obtenerResiduosHoy($dispositivoId) * 2);
    }

    public function obtenerNivelEcologico(int $dispositivoId): string
    {
        $total = (int) $this->where('dispositivo_id', $dispositivoId)->countAllResults();

        if ($total >= 1000) return 'Eco Maestro';
        if ($total >= 500) return 'Eco Experto';
        if ($total >= 300) return 'Eco Avanzado';
        if ($total >= 10) return 'Eco Comprometido';
        if ($total >= 5) return 'Eco Aprendiz';
        return 'Eco Principiante';
    }

    public function obtenerCO2Hoy(int $dispositivoId): float
    {
        $datos = $this->select('residuo, COUNT(*) as cantidad')
            ->where('dispositivo_id', $dispositivoId)
            ->where('DATE(fecha_hora)', date('Y-m-d'))
            ->groupBy('residuo')
            ->findAll();

        $equivalencias = [
            'papel' => 0.15,
            'plastico' => 0.25,
            'vidrio' => 0.20,
            'organico' => 0.10
        ];

        $co2 = 0.0;
        foreach ($datos as $fila) {
            $tipo = strtolower(trim($fila['residuo']));
            if (isset($equivalencias[$tipo])) {
                $co2 += (int) $fila['cantidad'] * $equivalencias[$tipo];
            }
        }

        return round($co2, 2);
    }
}

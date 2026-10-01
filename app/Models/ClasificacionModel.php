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


    // ============================================================
    // RESIDUOS RECICLADOS HOY
    // ============================================================
public function obtenerResiduosHoy(int $dispositivoId): int
{
    $hoy = date('Y-m-d');

    $registros = $this->db->table('clasificaciones')
        ->select('id, dispositivo_id, fecha_hora, residuo, clasificacion, categoria_final')
        ->where('dispositivo_id', $dispositivoId)
        ->orderBy('id', 'DESC')
        ->limit(10)
        ->get()
        ->getResultArray();

    log_message(
        'error',
        'ECOSCAM DEBUG - dispositivo_id=' . $dispositivoId .
        ' | FECHA PHP=' . $hoy .
        ' | ULTIMOS REGISTROS=' . json_encode($registros, JSON_UNESCAPED_UNICODE)
    );

    $cantidad = (int) $this->db->table('clasificaciones')
        ->where('dispositivo_id', $dispositivoId)
        ->where('fecha_hora >=', $hoy . ' 00:00:00')
        ->where('fecha_hora <=', $hoy . ' 23:59:59')
        ->countAllResults();

    return $cantidad;
}

    // ============================================================
    // IMPACTO AMBIENTAL
    // ============================================================
    public function obtenerImpactoAmbiental(int $dispositivoId): int
    {
        return min(
            100,
            $this->obtenerResiduosHoy($dispositivoId) * 2
        );
    }


    // ============================================================
    // NIVEL ECOLÓGICO
    // ============================================================
    public function obtenerNivelEcologico(int $dispositivoId): string
    {
        // IMPORTANTE:
        // Se cuentan solamente las clasificaciones pertenecientes
        // al Eco-Tacho seleccionado.
        $total = (int) $this->where('dispositivo_id', $dispositivoId)
            ->countAllResults();

        if ($total >= 1000) return 'Eco Maestro';
        if ($total >= 500)  return 'Eco Experto';
        if ($total >= 300)  return 'Eco Avanzado';
        if ($total >= 10)   return 'Eco Comprometido';
        if ($total >= 5)    return 'Eco Aprendiz';

        return 'Eco Principiante';
    }



}
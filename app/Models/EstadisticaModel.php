<?php

namespace App\Models;

use CodeIgniter\Model;

class EstadisticaModel extends Model 
{
    protected $table = 'clasificaciones';
    protected $primaryKey = 'id';

    public function totalClasificaciones($dispositivo_id)
    {
        return $this
            ->where(
                'dispositivo_id',
                $dispositivo_id
            )
            ->countAllResults();
    }

    public function residuosPorTipo($dispositivo_id)
    {
        return $this->db->query("
            SELECT residuo, COUNT(*) cantidad
            FROM clasificaciones
            WHERE dispositivo_id = ?
            GROUP BY residuo
        ", [$dispositivo_id])->getResultArray();
    }

public function promedioConfianza($dispositivo_id)
{
    return $this->db->query("
        SELECT AVG(confianza) promedio
        FROM clasificaciones
        WHERE dispositivo_id = ?
    ", [$dispositivo_id])->getRowArray();
}

public function clasificacionesHoy($dispositivo_id)
{
    return $this->db->query("
        SELECT COUNT(*) cantidad
        FROM clasificaciones
        WHERE DATE(fecha_hora)=CURDATE()
        AND dispositivo_id = ?
    ", [$dispositivo_id])->getRowArray();
}

public function ultimosRegistros($dispositivo_id)
{
    return $this->db->query("
        SELECT *
        FROM clasificaciones
        WHERE dispositivo_id = ?
        ORDER BY fecha_hora DESC
        LIMIT 20
    ", [$dispositivo_id])->getResultArray();
}
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class EstadisticaModel extends Model
{
    protected $table = 'clasificaciones';
    protected $primaryKey = 'id';

    public function totalClasificaciones()
    {
        return $this->countAll();
    }

    public function residuosPorTipo()
    {
        return $this->db->query("
            SELECT residuo, COUNT(*) cantidad
            FROM clasificaciones
            GROUP BY residuo
        ")->getResultArray();
    }

    public function promedioConfianza()
    {
        return $this->db->query("
            SELECT AVG(confianza) promedio
            FROM clasificaciones
        ")->getRowArray();
    }

    public function clasificacionesHoy()
    {
        return $this->db->query("
            SELECT COUNT(*) cantidad
            FROM clasificaciones
            WHERE DATE(fecha_hora)=CURDATE()
        ")->getRowArray();
    }

    public function ultimosRegistros()
    {
        return $this->db->query("
            SELECT *
            FROM clasificaciones
            ORDER BY fecha_hora DESC
            LIMIT 20
        ")->getResultArray();
    }
}
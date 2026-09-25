<?php

namespace App\Models;

use CodeIgniter\Model;

class EstadisticaModel extends Model
{
    protected $table = 'clasificaciones';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    public function totalClasificaciones(int $dispositivoId): int
    {
        return (int) $this->where('dispositivo_id', $dispositivoId)->countAllResults();
    }

    public function residuosPorTipo(int $dispositivoId): array
    {
        return $this->db->query(
            "SELECT residuo, COUNT(*) AS cantidad
             FROM clasificaciones
             WHERE dispositivo_id = ?
             GROUP BY residuo
             ORDER BY cantidad DESC",
            [$dispositivoId]
        )->getResultArray();
    }

    public function promedioConfianza(int $dispositivoId): array
    {
        $row = $this->db->query(
            "SELECT COALESCE(AVG(confianza), 0) AS promedio
             FROM clasificaciones
             WHERE dispositivo_id = ?",
            [$dispositivoId]
        )->getRowArray();

        return $row ?: ['promedio' => 0];
    }

    public function clasificacionesHoy(int $dispositivoId): array
    {
        $row = $this->db->query(
            "SELECT COUNT(*) AS cantidad
             FROM clasificaciones
             WHERE DATE(fecha_hora) = CURDATE()
               AND dispositivo_id = ?",
            [$dispositivoId]
        )->getRowArray();

        return $row ?: ['cantidad' => 0];
    }

    public function ultimosRegistros(int $dispositivoId): array
    {
        return $this->db->query(
            "SELECT id, fecha_hora, residuo, confianza, clasificacion,
                    categoria_final, seleccion_manual, imagen, dispositivo_id
             FROM clasificaciones
             WHERE dispositivo_id = ?
             ORDER BY fecha_hora DESC, id DESC
             LIMIT 20",
            [$dispositivoId]
        )->getResultArray();
    }
}

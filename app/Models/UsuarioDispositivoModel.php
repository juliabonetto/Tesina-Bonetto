<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioDispositivoModel extends Model
{
    protected $table = 'usuario_dispositivo';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'usuario_id',
        'dispositivo_id',
        'rol'
    ];
}
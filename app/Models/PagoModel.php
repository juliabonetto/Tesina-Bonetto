<?php

namespace App\Models;

use CodeIgniter\Model;

class PagoModel extends Model
{
    protected $table = 'pagos';

    protected $allowedFields = [
        'usuario_id',
        'plan_id',
        'preference_id',
        'payment_id',
        'estado',
        'monto'
    ];
}
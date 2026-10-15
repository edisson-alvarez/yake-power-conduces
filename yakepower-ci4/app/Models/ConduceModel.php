<?php

namespace App\Models;

use CodeIgniter\Model;

class ConduceModel extends Model
{
    protected $table = 'conduces';
    protected $primaryKey = 'id_conduce';

    protected $allowedFields = [
        'numero_conduce',
        'fecha',
        'id_cliente',
        'id_usuario',
        'observaciones',
        'creado_en'
    ];

    protected $returnType = 'array';
}
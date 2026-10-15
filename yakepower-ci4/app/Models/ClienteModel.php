<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'id_cliente';

    protected $allowedFields = [
        'nombre',
        'rnc_cedula',
        'direccion',
        'atencion',
        'telefono',
        'creado_en'
    ];

    protected $returnType = 'array';
}
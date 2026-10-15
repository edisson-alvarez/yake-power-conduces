<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';

    protected $allowedFields = [
        'nombre',
        'usuario',
        'correo',
        'password',
        'creado_en'
    ];

    protected $returnType = 'array';
}
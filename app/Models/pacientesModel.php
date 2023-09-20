<?php

namespace App\Models;

use CodeIgniter\Model;

class PacientesModel extends Model
{
    protected $table      = 'pacientes';
    protected $primaryKey = 'id_paciente';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['nombres', 'apellidos','cedula','fecha_nac','direccion','telefono','email','password'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'fecha_registro';
    protected $updatedField  = '';
    protected $deletedField  = '';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function obtenerUsuario($data){
        $Usuario = $this->db->table('pacientes');
        $Usuario->where($data);
        return $Usuario->get()->getResultArray();
    }
}
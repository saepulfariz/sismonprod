<?php

namespace App\Models;

use CodeIgniter\Model;

class PcsModel extends Model
{
    protected $table            = 'pcs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

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

    protected $pcs;
    protected $db;
    public function __construct()
    {
        $this->pcs = db_connect('pcs');
        $this->db = db_connect('default');
    }

    public function getMaterial()
    {
        $builder = $this->pcs->table('MD_MATERIALS');
        $builder->select('MAT_CODE');
        $builder->where('SFC_CODE', 'AL');
        $builder->where('MAT_OUT_MNG IS NULL');
        return $builder->get()->getResultArray();
    }

    public function findMaterial($mat_code)
    {
        $builder = $this->pcs->table('MD_MATERIALS');
        $builder->select('MAT_CODE, MAT_DESC, MAT_SAP_CODE');
        $builder->where('MAT_CODE', $mat_code);
        $builder->where('SFC_CODE', 'AL');
        $builder->where('MAT_OUT_MNG IS NULL');
        return $builder->get()->getRowArray();
    }
}

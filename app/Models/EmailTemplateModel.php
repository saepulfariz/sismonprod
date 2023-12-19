<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\BaseModel;

class EmailTemplateModel extends BaseModel
{
  protected $table            = 'email_templates';
  protected $primaryKey       = 'id';
  protected $useAutoIncrement = true;
  protected $returnType       = 'array';
  protected $useSoftDeletes   = false;
  protected $protectFields    = true;
  protected $allowedFields    = [
    'name',
    'code',
    'subject',
    'body',
  ];

  // Dates
  protected $useTimestamps = true;
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
  protected $beforeInsert   = ['beforeInsert'];
  protected $afterInsert    = [];
  protected $beforeUpdate   = ['beforeUpdate'];
  protected $afterUpdate    = [];
  protected $beforeFind     = [];
  protected $afterFind      = [];
  protected $beforeDelete   = ['beforeDelete'];
  protected $afterDelete    = [];
}

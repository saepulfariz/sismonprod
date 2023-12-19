<?php

namespace App\Models;

use App\Models\BaseModel;

class UserModel extends BaseModel
{
    // protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'username',
        'email',
        'password',
        'phone',
        'image',
        'address',
        'last_login',
        'role_id',
        'is_active',
        'email_verified_at',
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

    public function addTokenReset($token, $email)
    {
        $builder = $this->db->table('password_reset_tokens');
        $data = [
            'token' => $token,
            'email' => $email,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        return $builder->insert($data);
    }

    public function findTokenReset($token, $created_at = false)
    {
        $builder = $this->db->table('password_reset_tokens');
        $builder->where('token', $token);
        return $builder->get()->getRowArray();
    }
}

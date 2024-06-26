<?php

namespace App\Models;

use App\Models\BaseModel;

class PermissionModel extends BaseModel
{
    protected $table      = 'permissions';
    protected $primaryKey = 'id';
    protected $returnType     = 'array';
    protected $allowedFields = ['title', 'code'];
}

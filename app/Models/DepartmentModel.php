<?php

namespace App\Models;

use App\Models\BaseModel;

class DepartmentModel extends BaseModel
{
    protected $table      = 'departments';
    protected $primaryKey = 'id';
    protected $returnType     = 'array';
    protected $allowedFields = ['name'];
}

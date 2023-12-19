<?php

namespace App\Models;

use App\Models\BaseModel;

class SectionModel extends BaseModel
{
    protected $table      = 'sections';
    protected $primaryKey = 'id';
    protected $returnType     = 'array';
    protected $allowedFields = ['name', 'dept_id'];
}

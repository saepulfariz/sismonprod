<?php

namespace App\Models;

use App\Models\BaseModel;

class SettingModel extends BaseModel
{
	protected $table      = 'settings';
	protected $primaryKey = 'id';
	protected $returnType     = 'array';
	protected $allowedFields = ['key', 'value', 'created_at'];

	public function updateByKey($key, $value)
	{
		$builder = $this->db->table($this->table);
		$builder->like('key', $key);
		$builder->set('value', $value);
		$builder->set('updated_at', date('Y-m-d H:i:s'));
		return $builder->update();
	}
}

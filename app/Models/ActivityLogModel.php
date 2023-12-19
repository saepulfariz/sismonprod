<?php

namespace App\Models;

use App\Models\BaseModel;

class ActivityLogModel extends BaseModel
{
	protected $table      = 'activity_logs';
	protected $primaryKey = 'id';
	protected $useAutoIncrement = true;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		'title',
		'user_id',
		'ip_address',
	];

	// Dates
	protected $useTimestamps = true;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';


	public function add($message, $user_id = 0, $ip_address = false)
	{
		if (setting('activity_record') == '1') {
			$log_id = (is_logged()) ? logged('id') : 1;
			$message = ($log_id == 1) ? $message . '1' : $message;
			$user_id = ($user_id == 0) ? $log_id : $user_id;
			$this->save([
				'title' => $message,
				'user_id' => $user_id,
				'ip_address' => !empty($ip_address) ? $ip_address : ip_address()
			]);
		}
		return true;
	}
}

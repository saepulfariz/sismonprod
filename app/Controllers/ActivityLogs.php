<?php

namespace App\Controllers;

use App\Controllers\AdminBaseController;

class ActivityLogs extends AdminBaseController
{

  public $title = 'Activity Logs';
  public $menu = 'activity_log';
  public $link = 'activitylogs';
  private $view = 'admin/activity_logs';

  public function __construct()
  {
    $this->model = new \App\Models\ActivityLogModel();
  }

  public function index()
  {

    $this->permissionCheck('activity_log_list');

    $ip = ($ip = $this->request->getVar('ip')) ? urldecode($ip) : '';
    $user_id = ($user_id = $this->request->getVar('user_id')) ? urldecode($user_id) : '';

    $result = $this->model->orderBy('id', 'DESC');

    if ($ip != '') {
      $result->like('ip_address', $ip);
    }

    if ($user_id != '') {
      $result->where('user_id', $user_id);
    }

    $data = [
      'data' => $result->findAll(),
      'users' => (new \App\Models\UserModel)->findAll(),
      'user_id' => $user_id,
      'ip' => $ip,
    ];
    return view($this->view . '/list', $data);
  }

  public function show($id)
  {

    $this->permissionCheck('activity_log_view');

    $result = $this->model->join('users', 'users.id = activity_logs.user_id')->find($id);
    if (!$result) {
      setAlert('warning', 'Warning', 'NOT VALID');
      return redirect()->to($this->link);
    };

    $data = [
      'data' => $result,

    ];

    return view($this->view . '/view', $data);
  }
}

<?php

namespace App\Controllers;

use App\Controllers\AdminBaseController;

class Dashboard extends AdminBaseController
{
    public $title = 'Dashboard';

    public function index()
    {
        $this->permissionCheck('dashboard');

        return view('admin/dashboard/index');
    }
}

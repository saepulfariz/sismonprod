<?php

namespace App\Controllers;

use App\Controllers\AdminBaseController;

class Errors extends BaseController
{

    public function index()
    {
        if (setting('activity_error') == '1') {
            $request = \Config\Services::request();
            model('App\Models\ActivityLogModel')->add("Not Found Url : " . base_url($request->uri->getPath()) . " By user #");
        }
        $data = [
            'title' => '404 Not Found',
            'back' => urlBack()
        ];
        return view('admin/template/404', $data);
    }
    public function denied()
    {
        // return view('errors/html/error_403.php');
        if (setting('activity_forbidden') == '1') {
            model('App\Models\ActivityLogModel')->add("Forbidden Url : " . urlBack() . " By user #" . logged('id'));
        }

        $data = [
            'title' => '403 Forbidden',
            'back' => base_url('dashboard')
        ];
        return view('admin/template/403', $data);
    }
}

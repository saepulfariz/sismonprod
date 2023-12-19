<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Controllers\AdminBaseController;

class Departments extends AdminBaseController
{

    public $title = 'Departments';
    public $menu = 'departments';
    public $link = 'departments';
    private $view = 'admin/departments';
    private $dir = '';

    public function __construct()
    {
        $this->model = new \App\Models\DepartmentModel();
        $this->pcs = new \App\Models\PcsModel();
    }

    public function index()
    {

        $this->permissionCheck('departments_list');

        $data = [
            'data' => $this->model->orderBy('id', 'DESC')->findAll()
        ];
        return view($this->view . '/list', $data);
    }

    public function show($id)
    {
        return redirect()->to($this->link);
    }

    public function new()
    {

        $this->permissionCheck('departments_add');

        return view($this->view . '/add');
    }



    public function create()
    {
        $this->permissionCheck('departments_add');

        $rules = [
            'name' => 'required',
        ];

        $input = $this->request->getVar();

        if (!$this->validateData($input, $rules)) {
            return redirect()->back()->withInput();
        }

        $data = [
            'name' => htmlspecialchars($this->request->getVar('name')),
        ];


        $res = $this->model->save($data);
        if ($res) {
            setAlert('success', 'Add success');
        } else {
            setAlert('warning', 'Add failed');
        }
        $id = $this->model->orderBy('id', 'DESC')->first()['id'];

        model('App\Models\ActivityLogModel')->add(ucfirst($this->title) . " #$id Created by User: #" . logged('id'));

        return redirect()->to($this->link);
    }

    public function edit($id)
    {

        $this->permissionCheck('departments_edit');

        $result = $this->model->find($id);
        if (!$result) {
            setAlert('warning', 'Warning', 'NOT VALID');
            return redirect()->to($this->link);
        }

        $data = [
            'data' => $result,
        ];

        return view($this->view . '/edit', $data);
    }



    public function update($id)
    {

        $this->permissionCheck('departments_edit');

        $result = $this->model->find($id);
        if (!$result) {
            setAlert('warning', 'Warning', 'NOT VALID');
            return redirect()->to($this->link);
        }

        $rules = [
            'name' => 'required',
        ];

        $input = $this->request->getVar();


        if (!$this->validateData($input, $rules)) {
            return redirect()->back()->withInput();
        }

        $data = [
            'name' => htmlspecialchars($this->request->getVar('name')),
        ];

        $res = $this->model->update($id, $data);
        if ($res) {
            setAlert('success', 'Update success');
        } else {
            setAlert('warning', 'Update failed');
        }

        model('App\Models\ActivityLogModel')->add(ucfirst($this->title) . " #$id Updated by User: #" . logged('id'));

        return redirect()->to($this->link);
    }


    public function delete($id)
    {

        $this->permissionCheck('departments_delete');

        $result = $this->model->find($id);
        if (!$result) {
            setAlert('warning', 'Warning', 'NOT VALID');
            return redirect()->to($this->link);
        }

        $this->model->delete($id);

        setAlert('success', 'Delete success');

        model('App\Models\ActivityLogModel')->add(ucfirst($this->title) . " #$id Deleted by User: #" . logged('id'));

        return redirect()->to($this->link);
    }
}

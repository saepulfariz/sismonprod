<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Controllers\AdminBaseController;

class Sections extends AdminBaseController
{

    public $title = 'Sections';
    public $menu = 'sections';
    public $link = 'sections';
    private $view = 'admin/sections';
    private $modeldept;

    public function __construct()
    {
        $this->model = new \App\Models\SectionModel();
        $this->modeldept = new \App\Models\DepartmentModel();
    }

    public function index()
    {

        $this->permissionCheck('sections_list');

        $data = [
            'data' => $this->model->select('sections.*, departments.name as department')->join('departments', 'departments.id  = sections.dept_id')->orderBy('id', 'DESC')->findAll()
        ];
        return view($this->view . '/list', $data);
    }

    public function show($id)
    {
        return redirect()->to($this->link);
    }

    public function new()
    {

        $this->permissionCheck('sections_add');
        $data['departments'] = $this->modeldept->findAll();

        return view($this->view . '/add', $data);
    }



    public function create()
    {
        $this->permissionCheck('sections_add');

        $rules = [
            'name' => 'required',
            'dept_id' => 'required',
        ];

        $input = $this->request->getVar();

        if (!$this->validateData($input, $rules)) {
            return redirect()->back()->withInput();
        }

        $data = [
            'name' => htmlspecialchars($this->request->getVar('name')),
            'dept_id' => htmlspecialchars($this->request->getVar('dept_id')),
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

        $this->permissionCheck('sections_edit');

        $result = $this->model->find($id);
        if (!$result) {
            setAlert('warning', 'Warning', 'NOT VALID');
            return redirect()->to($this->link);
        }

        $data = [
            'data' => $result,
            'departments' => $this->modeldept->findAll()
        ];

        return view($this->view . '/edit', $data);
    }



    public function update($id)
    {

        $this->permissionCheck('sections_edit');

        $result = $this->model->find($id);
        if (!$result) {
            setAlert('warning', 'Warning', 'NOT VALID');
            return redirect()->to($this->link);
        }

        $rules = [
            'name' => 'required',
            'dept_id' => 'required',
        ];

        $input = $this->request->getVar();


        if (!$this->validateData($input, $rules)) {
            return redirect()->back()->withInput();
        }

        $data = [
            'name' => htmlspecialchars($this->request->getVar('name')),
            'dept_id' => htmlspecialchars($this->request->getVar('dept_id')),
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

        $this->permissionCheck('sections_delete');

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

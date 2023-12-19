<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Controllers\AdminBaseController;

class Users extends AdminBaseController
{

    public $title = 'Users Management';
    public $menu = 'users';
    public $link = 'users';
    private $view = 'admin/users';
    private $dir = '';

    public function __construct()
    {
        $this->model = new \App\Models\UserModel();
        $this->dir = dirUploadUser();
    }

    public function index()
    {

        $this->permissionCheck('users_list');

        $data = [
            'data' => $this->model->select('users.id, image, name, email, last_login, is_active, roles.title')->join('roles', 'roles.id = users.role_id')->findAll()
        ];
        return view($this->view . '/list', $data);
    }

    public function show($id)
    {

        $this->permissionCheck('users_view');

        $result = $this->model->join('roles', 'roles.id = users.role_id')->find($id);
        if (!$result) {
            setAlert('warning', 'Warning', 'NOT VALID');
            return redirect()->to($this->link);
        }

        $data = [
            'data' => $result,
            'activity' => (new \App\Models\ActivityLogModel)->where('user_id', $id)->orderBy('id', 'DESC')->findAll()
        ];

        return view($this->view . '/view', $data);
    }

    public function new()
    {

        $this->permissionCheck('users_add');
        $data = [
            'roles' => model('\App\Models\RoleModel')->findAll()
        ];

        return view($this->view . '/add', $data);
    }



    public function create()
    {
        $this->permissionCheck('users_add');

        $rules = [
            'name' => 'required',
            'password' => 'required|min_length[8]',
            'confirm_password' => 'required|min_length[8]|matches[password]',
            // 'phone' => 'required',
            // 'address' => 'required',
            'role_id' => 'required',
            'is_active' => 'required',
            'email' => 'required|is_unique[users.email]|valid_email',
            'username' => 'required|is_unique[users.username]',
        ];

        $input = $this->request->getVar();

        $dataBerkas = $this->request->getFile('image');


        if ($dataBerkas->getError() != 4) {
            $rules['image'] = 'uploaded[image]'
                . '|is_image[image]'
                . '|mime_in[image,image/jpg,image/jpeg,image/gif,image/png,image/webp]';
        }

        if (!$this->validateData($input, $rules)) {
            return redirect()->back()->withInput();
        }

        $data = [
            'name' => htmlspecialchars($this->request->getVar('name')),
            'password' => passwordHash($this->request->getVar('password')),
            'phone' => htmlspecialchars($this->request->getVar('phone')),
            'role_id' => htmlspecialchars($this->request->getVar('role_id')),
            'address' => htmlspecialchars($this->request->getVar('address')),
            'is_active' => htmlspecialchars($this->request->getVar('is_active')),
            'email' => htmlspecialchars($this->request->getVar('email')),
            'username' => htmlspecialchars($this->request->getVar('username')),
        ];

        if ($dataBerkas->getError() != 4) {

            // $fileName = $dataBerkas->getName();
            $fileName = $dataBerkas->getRandomName();

            $dataBerkas->move($this->dir, $fileName);

            $data['image'] = $fileName;
        }

        $res = $this->model->save($data);
        if ($res) {
            setAlert('success', 'Add success');
        } else {
            setAlert('warning', 'Add failed');
        }
        $id = $this->model->orderBy('id', 'DESC')->first()['id'];

        model('App\Models\ActivityLogModel')->add(ucfirst($this->menu) . " #$id Created by User: #" . logged('id'));

        return redirect()->to($this->link);
    }

    public function edit($id)
    {

        $this->permissionCheck('users_edit');

        $result = $this->model->find($id);
        if (!$result) {
            setAlert('warning', 'Warning', 'NOT VALID');
            return redirect()->to($this->link);
        }

        $data = [
            'data' => $result,
            'roles' => model('\App\Models\RoleModel')->findAll()
        ];

        return view($this->view . '/edit', $data);
    }



    public function update($id)
    {

        $this->permissionCheck('users_edit');

        $result = $this->model->find($id);
        if (!$result) {
            setAlert('warning', 'Warning', 'NOT VALID');
            return redirect()->to($this->link);
        }

        $rules = [
            'name' => 'required',
            'role_id' => 'required',
            'is_active' => 'required',
            'email' => 'required',
            'username' => 'required',
        ];


        $input = $this->request->getVar();

        if ($result['email'] != $input['email']) {
            $rules['email'] = 'required|is_unique[users.email]|valid_email';
        }

        if ($result['username'] != $input['username']) {
            $rules['username'] = 'required|is_unique[users.username]';
        }

        if ($input['password'] != '') {
            $rules['password'] = 'required|min_length[8]';
            $rules['confirm_password'] = 'required|min_length[8]|matches[password]';
        }

        $dataBerkas = $this->request->getFile('image');


        if ($dataBerkas->getError() != 4) {
            $rules['image'] = 'uploaded[image]'
                . '|is_image[image]'
                . '|mime_in[image,image/jpg,image/jpeg,image/gif,image/png,image/webp]';
        }

        if (!$this->validateData($input, $rules)) {
            return redirect()->back()->withInput();
        }

        $data = [
            'name' => htmlspecialchars($this->request->getVar('name')),
            'phone' => htmlspecialchars($this->request->getVar('phone')),
            'role_id' => htmlspecialchars($this->request->getVar('role_id')),
            'address' => htmlspecialchars($this->request->getVar('address')),
            'is_active' => htmlspecialchars($this->request->getVar('is_active')),
            'email' => htmlspecialchars($this->request->getVar('email')),
            'username' => htmlspecialchars($this->request->getVar('username')),
        ];



        if ($input['password'] != '') {
            $data['password'] = passwordHash($input['password']);
        }

        if ($dataBerkas->getError() != 4) {

            // $fileName = $dataBerkas->getName();
            $fileName = $dataBerkas->getRandomName();

            if ($result['image'] != 'default.jpg') {
                @unlink($this->dir . '/' . $result['image']);
            }

            $dataBerkas->move($this->dir, $fileName);

            $data['image'] = $fileName;
        }

        $res = $this->model->update($id, $data);
        if ($res) {
            setAlert('success', 'Update success');
        } else {
            setAlert('warning', 'Update failed');
        }

        model('App\Models\ActivityLogModel')->add(ucfirst($this->menu) . " #$id Updated by User: #" . logged('id'));

        return redirect()->to($this->link);
    }

    public function change_status($id)
    {
        $this->permissionCheck('users_edit');

        $result = $this->model->find($id);
        if (!$result) {
            setAlert('warning', 'Warning', 'NOT VALID');
            return redirect()->to($this->link);
        }

        $this->model->update($id, ['is_active' => $this->request->getVar('status') == 'true' ? 1 : 0]);
        echo 'done';
    }

    public function delete($id)
    {

        $this->permissionCheck('users_delete');

        $result = $this->model->find($id);
        if (!$result) {
            setAlert('warning', 'Warning', 'NOT VALID');
            return redirect()->to($this->link);
        }

        if ($result['image'] != 'default.jpg') {
            @unlink($this->dir . '/' . $result['image']);
        }

        $this->model->delete($id);

        setAlert('success', 'Delete success');

        model('App\Models\ActivityLogModel')->add(ucfirst($this->menu) . " #$id Deleted by User: #" . logged('id'));

        return redirect()->to($this->link);
    }
}

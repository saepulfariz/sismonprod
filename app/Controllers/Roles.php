<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Controllers\AdminBaseController;

class Roles extends AdminBaseController
{

	public $title = 'Roles Management';
	public $menu = 'roles';
	public $link = 'roles';
	private $view = 'admin/roles';

	public function __construct()
	{
		$this->model = new \App\Models\RoleModel();
	}

	public function index()
	{

		$this->permissionCheck('roles_list');

		$data = [
			'data' => $this->model->findAll()
		];
		return view($this->view . '/list', $data);
	}

	public function new()
	{

		$this->permissionCheck('roles_add');

		return view($this->view . '/add');
	}

	public function show()
	{
		return redirect()->to($this->link);
	}

	public function create()
	{
		$this->permissionCheck('roles_add');

		$rules = [
			'title' => 'required',
		];

		$input = $this->request->getVar();

		if (!$this->validateData($input, $rules)) {
			return redirect()->back()->withInput();
		}



		$data = [
			'title' => htmlspecialchars($this->request->getVar('title')),
		];

		$res = $this->model->save($data);
		if ($res) {
			setAlert('success', 'Add success');
		} else {
			setAlert('warning', 'Add failed');
		}
		$id = $this->model->orderBy('id', 'DESC')->first()['id'];

		$data = [];
		foreach ($this->request->getVar('permission') as $permission) {
			array_push($data, [
				'role_id' => $id,
				'permission_id' => $permission,
			]);
		}

		model('App\Models\RolePermissionModel')->insertBatch($data);

		model('App\Models\ActivityLogModel')->add(ucfirst($this->menu) . " #$id Created by User: #" . logged('id'));

		return redirect()->to($this->link);
	}

	public function edit($id)
	{

		$this->permissionCheck('roles_edit');

		$result = $this->model->find($id);
		if (!$result) {
			setAlert('warning', 'Warning', 'NOT VALID');
			return redirect()->to($this->link);
		}

		$permissions = (new \App\Models\RolePermissionModel)->where([
			'role_id' => $id
		])->findAll();

		$_permissions = array_map(function ($data) {
			return $data['permission_id'];
		}, $permissions);

		$data = [
			'data' => $result,
			'role_permissions' => $_permissions
		];

		return view($this->view . '/edit', $data);
	}



	public function update($id)
	{

		$this->permissionCheck('roles_edit');

		$res = $this->checkId($id);

		$rules = [
			'title' => 'required',
		];


		$input = $this->request->getVar();


		if (!$this->validateData($input, $rules)) {
			return redirect()->back()->withInput();
		}

		$data = [
			'title' => htmlspecialchars($this->request->getVar('title')),
		];

		$res = $this->model->update($id, $data);
		if ($res) {
			setAlert('success', 'Update success');
		} else {
			setAlert('warning', 'Update failed');
		}

		// Data which will be added
		$Data = [];
		foreach ($this->request->getVar('permission') as $permission) {
			if (!empty((new \App\Models\RolePermissionModel)->where(['role_id' => $id, 'permission_id' => $permission])->first())) {
			} else {
				array_push($Data, [
					'role_id' => $id,
					'permission_id' => $permission,
				]);
			}
		}

		if (!empty($Data)) (new \App\Models\RolePermissionModel)->insertBatch($Data);

		$all_permissions = (new \App\Models\RolePermissionModel)->where([
			'role_id' =>  $id
		])->findAll();

		if (!empty($all_permissions)) {
			// Permissions which will be deleted
			foreach ($all_permissions as $data) {

				if (!in_array($data['permission_id'], $this->request->getVar('permission'))) {
					(new \App\Models\RolePermissionModel)->delete($data['id']);
				}
			}
		}

		model('App\Models\ActivityLogModel')->add(ucfirst($this->menu) . " #$id Updated by User: #" . logged('id'));

		return redirect()->to($this->link);
	}

	public function delete($id)
	{

		$this->permissionCheck('roles_delete');

		$result = $this->model->find($id);
		if (!$result) {
			setAlert('warning', 'Warning', 'NOT VALID');
			return redirect()->to($this->link);
		}

		(new \App\Models\RolePermissionModel)->where([
			'role_id' =>  $id
		])->delete();

		$this->model->delete($id);

		setAlert('success', 'Delete success');

		model('App\Models\ActivityLogModel')->add(ucfirst($this->menu) . " #$id Deleted by User: #" . logged('id'));

		return redirect()->to($this->link);
	}
}

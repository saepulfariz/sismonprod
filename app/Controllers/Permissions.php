<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Controllers\AdminBaseController;

class Permissions extends AdminBaseController
{

	public $title = 'Permissions Management';
	public $menu = 'permissions';
	public $link = 'permissions';
	private $view = 'admin/permissions';

	public function __construct()
	{
		$this->model = new \App\Models\PermissionModel();
	}

	public function index()
	{

		$this->permissionCheck('permissions_list');

		$data = [
			'data' => $this->model->findAll()
		];
		return view($this->view . '/list', $data);
	}

	public function new()
	{

		$this->permissionCheck('permissions_add');

		return view($this->view . '/add');
	}

	public function create()
	{
		$this->permissionCheck('permissions_add');

		$rules = [
			'title' => 'required',
			'code' => 'required|is_unique[permissions.code]',
		];

		$input = $this->request->getVar();

		if (!$this->validateData($input, $rules)) {
			return redirect()->back()->withInput();
		}

		$data = [
			'title' => htmlspecialchars($this->request->getVar('title')),
			'code' => htmlspecialchars($this->request->getVar('code')),
		];

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

		$this->permissionCheck('permissions_edit');

		$result = $this->model->find($id);
		if (!$result) {
			setAlert('warning', 'Warning', 'NOT VALID');
			return redirect()->to($this->link);
		}

		$data = [
			'data' => $result
		];

		return view($this->view . '/edit', $data);
	}



	public function update($id)
	{

		$this->permissionCheck('permissions_edit');

		$result = $this->model->find($id);
		if (!$result) {
			setAlert('warning', 'Warning', 'NOT VALID');
			return redirect()->to($this->link);
		};

		$rules = [
			'title' => 'required',
			'code' => 'required',
		];


		$input = $this->request->getVar();

		if ($result['code'] != $input['code']) {
			$rules['code'] = 'required|is_unique[permissions.code]';
		}

		if (!$this->validateData($input, $rules)) {
			return redirect()->back()->withInput();
		}

		$data = [
			'title' => htmlspecialchars($this->request->getVar('title')),
			'code' => htmlspecialchars($this->request->getVar('code')),
		];

		$res = $this->model->update($id, $data);
		if ($res) {
			setAlert('success', 'Update success');
		} else {
			setAlert('warning', 'Update failed');
		}

		model('App\Models\ActivityLogModel')->add(ucfirst($this->menu) . " #$id Updated by User: #" . logged('id'));

		return redirect()->to($this->link);
	}

	public function delete($id)
	{

		$this->permissionCheck('permissions_delete');

		$result = $this->model->find($id);
		if (!$result) {
			setAlert('warning', 'Warning', 'NOT VALID');
			return redirect()->to($this->link);
		}

		$this->model->delete($id);

		setAlert('success', 'Delete success');

		model('App\Models\ActivityLogModel')->add(ucfirst($this->menu) . " #$id Deleted by User: #" . logged('id'));

		return redirect()->to($this->link);
	}
}

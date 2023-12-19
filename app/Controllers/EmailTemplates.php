<?php

namespace App\Controllers;

use App\Controllers\AdminBaseController;
use CodeIgniter\RESTful\ResourceController;

class EmailTemplates extends AdminBaseController
{
  /**
   * Return an array of resource objects, themselves in array format
   *
   * @return mixed
   */

  public $model;
  public $modelEmailTemplateVariable;
  public $link = 'settings/email_templates';
  public $view = 'admin/email_templates';
  public $title = 'Email Templates';
  public $menu = 'settings';
  public $tab = 'email_templates';

  public function __construct()
  {
    $this->model = new \App\Models\EmailTemplateModel();
    $this->modelEmailTemplateVariable = new \App\Models\EmailTemplateVariableModel();
  }

  public function index()
  {
    $this->permissionCheck('email_templates_list');

    $data = [
      'tab' => $this->tab,
      'data' => $this->model->findAll()
    ];

    $this->updatePageData(['submenu' => 'email_templates']);

    return view($this->view . '/list', $data);
  }

  /**
   * Return the properties of a resource object
   *
   * @return mixed
   */
  public function show($id = null)
  {
    $this->permissionCheck('email_templates_list');

    return json_encode($this->model->find($id));
  }

  /**
   * Return a new resource object, with default properties
   *
   * @return mixed
   */
  public function new()
  {
    $this->permissionCheck('email_templates_add');

    $data = [
      'tab' => $this->tab,
    ];

    $this->updatePageData(['submenu' => 'email_templates']);

    return view($this->view . '/add', $data);
  }

  /**
   * Create a new resource object, from "posted" parameters
   *
   * @return mixed
   */
  public function create()
  {
    $this->permissionCheck('email_templates_add');

    $rules = [
      'name' => 'required',
      'code' => 'required|is_unique[email_templates.code]',
      'subject' => 'required',
      'body' => 'required',
    ];


    $input = $this->request->getVar();

    if (!$this->validateData($input, $rules)) {
      return redirect()->back()->withInput();
    }

    $data = [
      'name' => htmlspecialchars($this->request->getVar('name')),
      'code' => htmlspecialchars($this->request->getVar('code')),
      'subject' => htmlspecialchars($this->request->getVar('subject')),
      'body' => $this->request->getVar('body'),
    ];


    $res = $this->model->save($data);
    if ($res) {
      setAlert('success', 'Success', 'Add Success');
    } else {
      setAlert('warning', 'Warning', 'Add Failed');
    }

    return redirect()->to($this->link);
  }

  /**
   * Return the editable properties of a resource object
   *
   * @return mixed
   */
  public function edit($id = null)
  {
    $this->permissionCheck('email_templates_edit');

    $result = $this->model->find($id);
    if (!$result) {
      setAlert('warning', 'Warning', 'NOT VALID');
      return redirect()->to($this->link);
    }

    $data = [
      'tab' => $this->tab,
      'data' => $result,
      'variables' => $this->modelEmailTemplateVariable->where('template_id', $id)->findAll()
    ];

    $this->updatePageData(['submenu' => 'email_templates']);

    return view($this->view . '/edit', $data);
  }

  /**
   * Add or update a model resource, from "posted" properties
   *
   * @return mixed
   */
  public function update($id = null)
  {
    $this->permissionCheck('email_templates_edit');

    $result = $this->model->find($id);
    if (!$result) {
      setAlert('warning', 'Warning', 'NOT VALID');
      return redirect()->to($this->link);
    }

    $rules = [
      'name' => 'required',
      'code' => 'required',
      'subject' => 'required',
      'body' => 'required',
    ];

    $input = $this->request->getVar();

    if ($input['code'] != $result['code']) {
      $rules['code'] = 'required|is_unique[email_templates.code]';
    }

    if (!$this->validateData($input, $rules)) {
      return redirect()->back()->withInput();
    }

    $data = [
      'name' => htmlspecialchars($this->request->getVar('name')),
      'code' => htmlspecialchars($this->request->getVar('code')),
      'subject' => htmlspecialchars($this->request->getVar('subject')),
      'body' => $this->request->getVar('body'),
    ];


    $res = $this->model->update($id, $data);
    if ($res) {
      setAlert('success', 'Success', 'Edit Success');
    } else {
      setAlert('warning', 'Warning', 'Edit Failed');
    }

    return redirect()->to($this->link);
  }

  /**
   * Delete the designated resource object from the model
   *
   * @return mixed
   */
  public function delete($id = null)
  {
    $this->permissionCheck('email_templates_delete');

    $result = $this->model->find($id);
    if (!$result) {
      setAlert('warning', 'Warning', 'NOT VALID');
      return redirect()->to($this->link);
    }

    $res = $this->model->delete($id);
    if ($res) {
      setAlert('success', 'Success', 'Delete Success');
    } else {
      setAlert('warning', 'Warning', 'Delete Failed');
    }

    return redirect()->to($this->link);
  }
}

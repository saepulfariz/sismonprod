<?php

namespace App\Controllers;

use App\Controllers\AdminBaseController;
use CodeIgniter\RESTful\ResourceController;

class EmailTemplateSend extends AdminBaseController
{
  /**
   * Return an array of resource objects, themselves in array format
   *
   * @return mixed
   */

  public $model;
  public $modelEmailTemplate;
  public $link = 'settings/email_templates/send';
  public $view = 'admin/email_template_send';
  public $title = 'Email Template Send';
  public $redirect = 'settings/email_templates';
  public $key_parent = 'template_id';
  public $type = [
    'TO',
    'CC',
    'BCC',
    'REPLY',
  ];
  public $menu = 'settings';
  public $tab = 'email_templates';

  public function __construct()
  {
    $this->model = new \App\Models\EmailTemplateSendModel();
    $this->modelEmailTemplate = new \App\Models\EmailTemplateModel();
  }

  public function index($id = false)
  {
    $this->permissionCheck('email_template_send_list');

    $result = $this->modelEmailTemplate->find($id);
    if (!$result) {
      setAlert('warning', 'Warning', 'NOT VALID');
      return redirect()->to($this->redirect);
    }

    $data = [
      'title' => $this->title,
      'link' => $this->link,
      'tab' => $this->tab,
      'id' => $id,
      'data' => $this->model->select('email_template_send.*, email_templates.name as template_name')->join('email_templates', 'email_templates.id = email_template_send.template_id')->where($this->key_parent, $id)->findAll()
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
    return redirect()->to($this->link);
  }

  /**
   * Return a new resource object, with default properties
   *
   * @return mixed
   */
  public function new($id = false)
  {
    $this->permissionCheck('email_template_send_add');

    $result = $this->modelEmailTemplate->find($id);
    if (!$result) {
      setAlert('warning', 'Warning', 'NOT VALID');
      return redirect()->to($this->redirect);
    }

    $data = [
      'title' => $this->title,
      'link' => $this->link,
      'tab' => $this->tab,
      'type' => $this->type,
      'id' => $id,
    ];

    $this->updatePageData(['submenu' => 'email_templates']);

    return view($this->view . '/add', $data);
  }

  /**
   * Create a new resource object, from "posted" parameters
   *
   * @return mixed
   */
  public function create($id = false)
  {
    $this->permissionCheck('email_template_send_add');

    $result = $this->modelEmailTemplate->find($id);
    if (!$result) {
      setAlert('warning', 'Warning', 'NOT VALID');
      return redirect()->to($this->redirect);
    }

    $rules = [
      'name' => 'required',
      'type' => 'required',
      'email' => 'required|valid_email',
    ];


    $input = $this->request->getVar();

    if (!$this->validateData($input, $rules)) {
      return redirect()->back()->withInput();
    }

    $data = [
      'name' => htmlspecialchars($this->request->getVar('name')),
      'type' => htmlspecialchars($this->request->getVar('type')),
      'email' => htmlspecialchars($this->request->getVar('email')),
      'template_id' => $id
    ];


    $res = $this->model->save($data);
    if ($res) {
      setAlert('success', 'Success', 'Add Success');
    } else {
      setAlert('warning', 'Warning', 'Add Failed');
    }

    return redirect()->to($this->link . '/' . $id);
  }

  /**
   * Return the editable properties of a resource object
   *
   * @return mixed
   */
  public function edit($id = null)
  {
    $this->permissionCheck('email_template_send_edit');

    $result = $this->model->find($id);
    if (!$result) {
      setAlert('warning', 'Warning', 'NOT VALID');
      return redirect()->to($this->link);
    }

    $data = [
      'title' => $this->title,
      'link' => $this->link,
      'tab' => $this->tab,
      'type' => $this->type,
      'id' => $result[$this->key_parent],
      'data' => $result,
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
    $this->permissionCheck('email_template_send_edit');

    $result = $this->model->find($id);
    if (!$result) {
      setAlert('warning', 'Warning', 'NOT VALID');
      return redirect()->to($this->link);
    }

    $rules = [
      'name' => 'required',
      'type' => 'required',
      'email' => 'required|valid_email',
    ];

    $input = $this->request->getVar();

    if (!$this->validateData($input, $rules)) {
      return redirect()->back()->withInput();
    }

    $data = [
      'name' => htmlspecialchars($this->request->getVar('name')),
      'type' => htmlspecialchars($this->request->getVar('type')),
      'email' => htmlspecialchars($this->request->getVar('email')),
    ];


    $res = $this->model->update($id, $data);
    if ($res) {
      setAlert('success', 'Success', 'Edit Success');
    } else {
      setAlert('warning', 'Warning', 'Edit Failed');
    }

    return redirect()->to($this->link . '/' . $result[$this->key_parent]);
  }

  /**
   * Delete the designated resource object from the model
   *
   * @return mixed
   */
  public function delete($id = null)
  {
    $this->permissionCheck('email_template_send_delete');

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

    return redirect()->to($this->link . '/' . $result[$this->key_parent]);
  }

  public function active($id = null, $active = null)
  {
    if ($id == null || $active == null) {
      setAlert('warning', 'Warning', 'NOT VALID');
      return redirect()->to($this->link);
    }

    $result = $this->model->find($id);
    if (!$result) {
      setAlert('warning', 'Warning', 'NOT VALID');
      return redirect()->to($this->link);
    }

    $data = [
      'is_send' => $active
    ];

    $res = $this->model->update($id, $data);
    if ($res) {
      $title = ($active == 0) ? 'Non ' : '';
      setAlert('success', 'Success', $title . 'Active Success');
    } else {
      setAlert('warning', 'Warning', 'Active Failed');
    }
    return redirect()->to($this->link . '/' . $result[$this->key_parent]);
  }
}

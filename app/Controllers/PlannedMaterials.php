<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Controllers\AdminBaseController;

class PlannedMaterials extends AdminBaseController
{

    public $title = 'Planned Materials';
    public $menu = 'planned_materials';
    public $link = 'planned_materials';
    private $view = 'admin/planned_materials';
    private $dir = '';
    private $pcs;

    public function __construct()
    {
        $this->model = new \App\Models\PlannedMaterialModel();
        $this->pcs = new \App\Models\PcsModel();
    }

    public function index()
    {

        $this->permissionCheck('planned_materials_list');

        $data = [
            // 'data' => $this->model->orderBy('id', 'DESC')->findAll()
        ];
        return view($this->view . '/list', $data);
    }

    public function ajax_table()
    {
        $this->permissionCheck('planned_materials_list');
        $data = [
            'data' => $this->model->orderBy('id', 'DESC')->findAll()
        ];
        return json_encode($data);
    }

    public function show($id)
    {
        return redirect()->to($this->link);
    }

    public function ajaxIpCode()
    {
        $mat_code = $this->request->getVar('mat_code');
        $data = $this->pcs->findMaterial($mat_code);
        if ($data != null) {
            $data['error'] = false;
        } else {
            $data['error'] = true;
            $data['message'] = 'Not Found';
        }
        return json_encode($data);
    }

    public function new()
    {

        $this->permissionCheck('planned_materials_add');
        $data = [
            'materials' => $this->pcs->getMaterial()
        ];

        return view($this->view . '/add', $data);
    }



    public function create()
    {
        $this->permissionCheck('planned_materials_add');

        $rules = [
            'ip_code' => 'required|is_unique[planned_materials.ip_code]',
            'mat_sap_code' => 'required',
            'mat_desc' => 'required',
            'target_shift' => 'required',
            'target_hour' => 'required',
            'target_minute' => 'required',
        ];

        $input = $this->request->getVar();

        if (!$this->validateData($input, $rules)) {
            return redirect()->back()->withInput();
        }

        $data = [
            'ip_code' => htmlspecialchars($this->request->getVar('ip_code')),
            'mat_sap_code' => htmlspecialchars($this->request->getVar('mat_sap_code')),
            'mat_desc' => htmlspecialchars($this->request->getVar('mat_desc')),
            'target_shift' => htmlspecialchars($this->request->getVar('target_shift')),
            'target_hour' => htmlspecialchars($this->request->getVar('target_hour')),
            'target_minute' => htmlspecialchars($this->request->getVar('target_minute')),
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

        $this->permissionCheck('planned_materials_edit');

        $result = $this->model->find($id);
        if (!$result) {
            setAlert('warning', 'Warning', 'NOT VALID');
            return redirect()->to($this->link);
        }

        $data = [
            'data' => $result,
            'materials' => $this->pcs->getMaterial()
        ];

        return view($this->view . '/edit', $data);
    }



    public function update($id)
    {

        $this->permissionCheck('planned_materials_edit');

        $result = $this->model->find($id);
        if (!$result) {
            setAlert('warning', 'Warning', 'NOT VALID');
            return redirect()->to($this->link);
        }

        $rules = [
            'ip_code' => 'required',
            'mat_sap_code' => 'required',
            'mat_desc' => 'required',
            'target_shift' => 'required',
            'target_hour' => 'required',
            'target_minute' => 'required',
        ];

        $input = $this->request->getVar();


        if ($result['ip_code'] != $input['ip_code']) {
            $rules['ip_code'] = 'required|is_unique[planned.ip_code]';
        }


        if (!$this->validateData($input, $rules)) {
            return redirect()->back()->withInput();
        }

        $data = [
            'ip_code' => htmlspecialchars($this->request->getVar('ip_code')),
            'mat_sap_code' => htmlspecialchars($this->request->getVar('mat_sap_code')),
            'mat_desc' => htmlspecialchars($this->request->getVar('mat_desc')),
            'target_shift' => htmlspecialchars($this->request->getVar('target_shift')),
            'target_hour' => htmlspecialchars($this->request->getVar('target_hour')),
            'target_minute' => htmlspecialchars($this->request->getVar('target_minute')),
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

        $this->permissionCheck('planned_materials_delete');

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

    public function import()
    {
        $this->permissionCheck('planned_materials_import');

        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
            $arr_file = explode('.', $_FILES['upload_file']['name']);
            $extension = end($arr_file);
            if ('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }

            $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            $result = 0;
            $gagal = 0;
            $update = 0;
            // di mulai dari 1 karena ada headernya
            for ($i = 1; $i < count($sheetData); $i++) {

                $dataInsert = [
                    'ip_code' => $sheetData[$i][2],
                    'mat_sap_code' => $sheetData[$i][1],
                    'mat_desc' => $sheetData[$i][3],
                    'target_shift' => $sheetData[$i][4],
                    'target_hour' => $sheetData[$i][5],
                    'target_minute' => $sheetData[$i][6],
                ];

                if ($dataInsert['ip_code'] != null) {
                    $resIp = $this->model->where('ip_code', $sheetData[$i][2])->first();

                    if ($resIp) {
                        // jika udah ada maka kita update

                        if (($resIp['target_shift'] == $dataInsert['target_shift']) && ($resIp['target_hour'] == $dataInsert['target_hour']) && ($resIp['target_minute'] == $dataInsert['target_minute'])) {
                            // jika data nya masih yang sama
                            $gagal++;
                        } else {
                            // jika beda maka kita update
                            if ($this->model->update($resIp['id'], $dataInsert)) {
                                model('App\Models\ActivityLogModel')->add(ucfirst($this->title) . " #" . $resIp['id'] . " Updated by User: #" . logged('id'));
                                $update++;
                            } else {
                                $gagal++;
                            }
                        }
                    } else {
                        // jika gak ada yang sama maka kita bikin yang baru
                        $res = $this->model->save($dataInsert);

                        $id = $this->model->orderBy('id', 'DESC')->first()['id'];
                        model('App\Models\ActivityLogModel')->add(ucfirst($this->title) . " #$id Created by User: #" . logged('id'));

                        if ($res) {
                            $result++;
                        } else {
                            $gagal++;
                        }
                    }
                }
            }
            setAlert('success', 'Success', "Rows $result success add database,  Update : $update, Gagal : $gagal");

            return redirect()->to($this->link);
        }
    }
}

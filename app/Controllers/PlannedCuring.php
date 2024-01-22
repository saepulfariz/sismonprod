<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Controllers\AdminBaseController;

class PlannedCuring extends AdminBaseController
{

    public $title = 'Planned Curing';
    public $menu = 'planned_curing';
    public $link = 'planned_curing';
    private $view = 'admin/planned_curing';
    private $dir = '';
    private $mch_type = [
        'BTUM',
        'STUM',
        'SBTU',
        'MRU1',
    ];

    private $brand = [
        'PIRELLI',
        'ASPIRA',
        'METZELER'
    ];

    private $status = [
        'PROD',
        'NS',
        'OUT',
    ];

    public function __construct()
    {
        $this->model = new \App\Models\PlannedCuringModel();

        $brand = $this->model->select('brand')->groupBy('brand')->findAll();
        if (count($this->brand) != count($brand)) {
            $br = [];
            foreach ($brand as $d) {
                $br[] = $d['brand'];
            }
            $this->brand = $br;
        }

        $mch_type = $this->model->select('mch_type')->groupBy('mch_type')->findAll();
        if (count($this->mch_type) != count($mch_type)) {
            $br = [];
            foreach ($mch_type as $d) {
                $br[] = $d['mch_type'];
            }
            $this->mch_type = $br;
        }
    }

    public function index()
    {

        $this->permissionCheck('planned_curing_list');

        $data = [
            // 'data' => $this->model->orderBy('id', 'DESC')->findAll()
        ];
        return view($this->view . '/list', $data);
    }

    public function ajax_table()
    {
        $this->permissionCheck('planned_curing_list');
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
        $ip_seven = $this->request->getVar('ip_seven');
        $result = $this->model->where('ip_seven', ($ip_seven))->orderBy('id', 'DESC')->first();
        if ($result != null) {
            $data['error'] = false;
            $data['data'] = $result;
        } else {
            $data['error'] = true;
            $data['message'] = 'Not Found';
        }
        return json_encode($data);
    }

    public function new()
    {

        $this->permissionCheck('planned_curing_add');
        $data = [
            'ip_seven' => $this->model->select('ip_seven')->groupBy('ip_seven')->findAll(),
            'mch_type' => $this->mch_type,
            'brand' => $this->brand,
            'status' => $this->status,
        ];

        return view($this->view . '/add', $data);
    }



    public function create()
    {
        $this->permissionCheck('planned_curing_add');

        $rules = [
            'ip_code' => 'required',
            'ip_seven' => 'required',
            'cost_center' => 'required',
            'brand' => 'required',
            'mch_type' => 'required',
            'rim' => 'required',
            'p_date' => 'required',
            'status' => 'required',
            'qty' => 'required',
        ];

        $input = $this->request->getVar();

        if (!$this->validateData($input, $rules)) {
            return redirect()->back()->withInput();
        }

        $date = htmlspecialchars($this->request->getVar('p_date'));
        $status  = htmlspecialchars($this->request->getVar('status'));
        $qty  = htmlspecialchars($this->request->getVar('qty'));

        $data = [
            'ip_code' => htmlspecialchars($this->request->getVar('ip_code')),
            'ip_seven' => htmlspecialchars($this->request->getVar('ip_seven')),
            'cost_center' => htmlspecialchars($this->request->getVar('cost_center')),
            'brand' => htmlspecialchars($this->request->getVar('brand')),
            'mch_type' => htmlspecialchars($this->request->getVar('mch_type')),
            'rim' => htmlspecialchars($this->request->getVar('rim')),
            'p_date' => $date,
            'status' => $status,
            'qty' => ($status != 'PROD') ? 0 : $qty,
            'week' => floor((intval(date('d', strtotime($date))) - 1) / 7) + 1
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

        $this->permissionCheck('planned_curing_edit');

        $result = $this->model->find($id);
        if (!$result) {
            setAlert('warning', 'Warning', 'NOT VALID');
            return redirect()->to($this->link);
        }

        $data = [
            'data' => $result,
            'ip_seven' => $this->model->select('ip_seven')->groupBy('ip_seven')->findAll(),
            'mch_type' => $this->mch_type,
            'brand' => $this->brand,
            'status' => $this->status,
        ];

        return view($this->view . '/edit', $data);
    }



    public function update($id)
    {

        $this->permissionCheck('planned_curing_edit');

        $result = $this->model->find($id);
        if (!$result) {
            setAlert('warning', 'Warning', 'NOT VALID');
            return redirect()->to($this->link);
        }

        $rules = [
            'ip_code' => 'required',
            'ip_seven' => 'required',
            'cost_center' => 'required',
            'brand' => 'required',
            'mch_type' => 'required',
            'rim' => 'required',
            'p_date' => 'required',
            'status' => 'required',
            'qty' => 'required',
        ];

        $input = $this->request->getVar();

        if (!$this->validateData($input, $rules)) {
            return redirect()->back()->withInput();
        }

        $date = htmlspecialchars($this->request->getVar('p_date'));
        $status  = htmlspecialchars($this->request->getVar('status'));
        $qty  = htmlspecialchars($this->request->getVar('qty'));

        $data = [
            'ip_code' => htmlspecialchars($this->request->getVar('ip_code')),
            'ip_seven' => htmlspecialchars($this->request->getVar('ip_seven')),
            'cost_center' => htmlspecialchars($this->request->getVar('cost_center')),
            'brand' => htmlspecialchars($this->request->getVar('brand')),
            'mch_type' => htmlspecialchars($this->request->getVar('mch_type')),
            'rim' => htmlspecialchars($this->request->getVar('rim')),
            'p_date' => $date,
            'status' => $status,
            'qty' => ($status != 'PROD') ? 0 : $qty,
            'week' => floor((intval(date('d', strtotime($date))) - 1) / 7) + 1
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

        $this->permissionCheck('planned_curing_delete');

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
        $this->permissionCheck('planned_curing_import');

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

            if (!isset($sheetData[2][2]) || !isset($sheetData[2][3]) || !isset($sheetData[2][4]) || !isset($sheetData[2][5]) || !isset($sheetData[2][6]) || !isset($sheetData[2][7]) || !isset($sheetData[2][8])) {
                setAlert('warning', 'Warning', 'Please Input Date Column, Example 19 May');

                return redirect()->to($this->link);
            }


            // di mulai dari 1 karena ada headernya
            $day1 = date('Y-m-d', strtotime($sheetData[2][2]));
            $day2 = date('Y-m-d', strtotime($sheetData[2][3]));
            $day3 = date('Y-m-d', strtotime($sheetData[2][4]));
            $day4 = date('Y-m-d', strtotime($sheetData[2][5]));
            $day5 = date('Y-m-d', strtotime($sheetData[2][6]));
            $day6 = date('Y-m-d', strtotime($sheetData[2][7]));
            $day7 = date('Y-m-d', strtotime($sheetData[2][8]));
            $data_date[] = $day1;
            $data_date[] = $day2;
            $data_date[] = $day3;
            $data_date[] = $day4;
            $data_date[] = $day5;
            $data_date[] = $day6;
            $data_date[] = $day7;


            $startKolom = 3; // di mulai dari 
            $countColumn = 0;
            $countRow = 1;

            // jika ada material baru di di excel
            $countNew = 0;

            // jika udah di planned tapi di upload ulang buat update
            $countUpdate = 0;

            // jika planned baru ke posisi new tb_planned
            $countPlanned = 0;

            for ($i = $startKolom; $i < count($sheetData); $i++) {

                $ip_seven = $sheetData[$i][1];
                $d7 = $sheetData[$i][8];

                // yang ip_total malah masuk di jeda jika nemu tidak sama dengan TOTAL
                if (($ip_seven != null) && ($ip_seven != 'TOTAL')) {
                    // jika udah tidak ada null di bawah maka stop baca nya
                    $result = $this->model->where('ip_seven', $ip_seven)->first();

                    $coloumnBrand = 10;
                    $coloumnRIM = 11;
                    $coloumnMchType = 12;

                    if ($sheetData[$i][$coloumnMchType] == null || $sheetData[$i][$coloumnRIM] == null || $sheetData[$i][$coloumnBrand] == null) {
                        setAlert('warning', 'Warning', 'Please Input RIM/MACHINE/BRAND TYPE empty column');

                        return redirect()->to($this->link);
                    }

                    if (strlen($sheetData[$i][$coloumnMchType]) <= 3) {
                        setAlert('warning', 'Warning', 'Please Input Machine Type BTUM SBTU STUM MRU1');

                        return redirect()->to($this->link);
                    }



                    if (!$result) {
                        // jika tidak ada maka bikin baru material nya dan table planned nya
                        $startQtyDate = 2;

                        // start kolom QTY day 1
                        $countColumn = 1;

                        $data = [
                            'ip_seven' => $ip_seven,
                            'ip_code' => substr($ip_seven, 0, 5),
                            'cost_center' => substr($ip_seven, 5, 2),
                            'brand' => ($sheetData[$i][$coloumnBrand] != null) ? $sheetData[$i][$coloumnBrand] : '',
                            'mch_type' => ($sheetData[$i][$coloumnMchType] != null) ? $sheetData[$i][$coloumnMchType] : '',
                            'rim' => ($sheetData[$i][$coloumnRIM] != null) ? $sheetData[$i][$coloumnRIM] : '',
                        ];


                        foreach ($data_date as $d) {
                            if (($ip_seven != null) && ($ip_seven != 'TOTAL')) {
                                $date = htmlspecialchars($d, true);
                                $qty = htmlspecialchars($sheetData[$i][$startQtyDate], true);


                                $dataPlanned = $data;
                                $dataPlanned['p_date'] = $date;
                                $dataPlanned['qty'] = (is_numeric($qty) == 1) ? $qty : 0;
                                $dataPlanned['status'] = (is_numeric($qty) != 1) ? $qty : 'PROD';
                                $dataPlanned['week'] = floor((intval(date('d', strtotime($date))) - 1) / 7) + 1;

                                $this->model->save($dataPlanned);
                            }
                            $startQtyDate++;
                        }
                        $countNew++;
                    } else {

                        // insert data ke update

                        $startQtyDate = 2;

                        // start kolom QTY day 1
                        $countColumn = 1;
                        foreach ($data_date as $d) {
                            $date = htmlspecialchars($d, true);
                            $qty = htmlspecialchars($sheetData[$i][$startQtyDate], true);
                            $data = [
                                'ip_seven' => $result['ip_seven'],
                                'ip_code' => $result['ip_code'],
                                'cost_center' => $result['cost_center'],
                                // 'brand' => $result['brand'],
                                // 'mch_type' => $result['mch_type'],
                                // 'rim' => $result['rim'],
                                'brand' => ($sheetData[$i][$coloumnBrand] != null) ? $sheetData[$i][$coloumnBrand] : $result['brand'],
                                'mch_type' => ($sheetData[$i][$coloumnMchType] != null) ? $sheetData[$i][$coloumnMchType] : $result['mch_type'],
                                'rim' => ($sheetData[$i][$coloumnRIM] != null) ? $sheetData[$i][$coloumnRIM] : $result['rim'],
                                'p_date' => $date,
                                'qty' => (is_numeric($qty) == 1) ? $qty : 0,
                                'status' => (is_numeric($qty) != 1) ? $qty : 'PROD',
                                'week' => floor((intval(date('d', strtotime($date))) - 1) / 7) + 1
                            ];
                            $startQtyDate++;
                            $countColumn++;

                            $getCurrentPlanning = $this->model->where('p_date', $d)->where('ip_seven', $result['ip_seven'])->first();

                            if ($getCurrentPlanning) {
                                // $getCurrentPlanning['p_date'] == $d 
                                if (($getCurrentPlanning['qty'] != $data['qty']) || ($getCurrentPlanning['status'] != $data['status']) || ($getCurrentPlanning['rim'] != $data['rim']) || ($getCurrentPlanning['brand'] != $data['brand']) || ($getCurrentPlanning['mch_type'] != $data['mch_type'])) {
                                    // || ($getCurrentPlanning['mch_type'] != $data['mch_type'])


                                    // jika tidak sama qty atau status maka kita update
                                    // udah di cek di sql nya 
                                    // jika tanggal yang dulu sama dengan tanggal yang mau di upload maka kita update
                                    $res = $this->model->update($getCurrentPlanning['id'], $data);


                                    $countUpdate++;
                                } else {
                                    // this
                                }
                            } else {
                                // maka kita insert
                                $res = $this->model->save($data);
                                $countPlanned++;
                            }
                        }


                        $countRow++;
                    }
                }
            }

            $file = $this->request->getFile('upload_file');
            $fileName = '';
            $name_original = $file->getName();
            if ($file->getError() != 4) {
                $fileName = date('ymdhis') . '_curing_' . $name_original;
                $file->move('public/uploads/curing', $fileName);
            }
            $notif = "Success Import, New Material : " . $countNew . " | Updated Planning :  " . $countUpdate;
            setAlert('success', 'Success', $notif);

            return redirect()->to($this->link);
        }
    }
}

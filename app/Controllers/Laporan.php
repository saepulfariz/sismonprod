<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Controllers\AdminBaseController;

class Laporan extends AdminBaseController
{

    public $title = 'laporan';
    public $menu = 'laporan';
    public $link = 'laporan';
    private $view = 'admin/laporan';
    private $dir = '';
    private $pcs;

    public function __construct()
    {
        $this->model = new \App\Models\PlannedMaterialModel();
        $this->pcs = new \App\Models\PcsModel();
    }

    public function index()
    {
        $this->permissionCheck('chart_building');

        $this->updatePageData([
            'title' => 'Chart Building',
            'submenu' => 'chart_building',
        ]);

        return view($this->view . '/chart_building');
    }


    public function frame_building($mt_code = 'BTUM')
    {
        $mt_code = strtoupper($mt_code);
        $mt_code = ($mt_code == 'ALL') ? null : $mt_code;
        $this->permissionCheck('chart_building');

        $this->updatePageData([
            'title' => 'Chart Building',
            'submenu' => 'chart_building',
        ]);

        $data = [
            'chart' => $this->pcs->getChartAjax($mt_code),
            'mch' => $mt_code
        ];
        return view($this->view . '/frame_building', $data);
    }

    function ajaxChartBuilding()
    {
        $mch = $this->request->getVar('mch');
        return json_encode($this->pcs->getChartAjax($mch));
    }

    function table_building($mt_code = 'BTUM')
    {
        $mt_code = strtoupper($mt_code);
        $mt_code = ($mt_code == 'ALL') ? null : $mt_code;
        $this->permissionCheck('table_building');

        $this->updatePageData([
            'title' => 'Table Building',
            'submenu' => 'table_building',
        ]);

        $data = [
            'chart' => $this->pcs->getChartHours($mt_code)
        ];
        return view($this->view . '/table_building', $data);
    }


    public function chart_curing($bulan = null, $tahun = null)
    {
        $bulan = ($bulan == null) ? date('m') : $bulan;
        $tahun = ($tahun == null) ? date('Y') : $tahun;
        $curing = $this->pcs->getDataCuring($bulan, $tahun);
        if (count($curing) == 0) {
            setAlert('warning', 'warning', "Bulan $bulan - $tahun gak ada plan");
            return redirect()->back();
        }
        $sbtu_act = 0;
        $sbtu_plan = 0;
        $mru1_act = 0;
        $mru1_plan = 0;
        $btum_act = 0;
        $btum_plan = 0;
        $stum_act = 0;
        $stum_plan = 0;
        foreach ($curing['SBTU'] as $key => $value) {
            $sbtu_act += $value['ACT'];
            $sbtu_plan += $value['PLAN'];
        }
        foreach ($curing['MRU1'] as $key => $value) {
            $mru1_act += $value['ACT'];
            $mru1_plan += $value['PLAN'];
        }
        foreach ($curing['BTUM'] as $key => $value) {
            $btum_act += $value['ACT'];
            $btum_plan += $value['PLAN'];
        }
        foreach ($curing['STUM'] as $key => $value) {
            $stum_act += $value['ACT'];
            $stum_plan += $value['PLAN'];
        }
        $data = [
            'title' => 'Dashboard Curing',
            'curing' => $curing,
            'id_bulan' => $bulan,
            'tahun' => $tahun,
            'link' => 'dashboard/curing',
            'sbtu' => [
                'act' => $sbtu_act,
                'plan' => $sbtu_plan,
            ],
            'mru1' => [
                'act' => $mru1_act,
                'plan' => $mru1_plan,
            ],
            'btum' => [
                'act' => $btum_act,
                'plan' => $btum_plan,
            ],
            'stum' => [
                'act' => $stum_act,
                'plan' => $stum_plan,
            ],
            'limit' => 10
        ];

        $this->permissionCheck('chart_curing');

        $this->updatePageData([
            'title' => 'Chart curing',
            'submenu' => 'chart_curing',
        ]);

        return view($this->view . '/chart_curing', $data);
    }


    function ajaxCuringMachine()
    {
        $mch = $this->request->getVar('mch');
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $bulan = ($bulan == null) ? date('m') : $bulan;
        $tahun = ($tahun == null) ? date('Y') : $tahun;
        $data = $this->pcs->getDataCuring($bulan, $tahun);
        $data = $data[$mch];
        $data = [
            'data' => $data
        ];
        return json_encode($data);
    }

    function ajaxCuringIp()
    {
        $ip = $this->request->getVar('ip');
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $bulan = ($bulan == null) ? date('m') : $bulan;
        $tahun = ($tahun == null) ? date('Y') : $tahun;
        $data = $this->pcs->getDataCuringDetail($ip, $bulan, $tahun);
        $data = [
            'data' => $data
        ];
        return json_encode($data);
    }
}

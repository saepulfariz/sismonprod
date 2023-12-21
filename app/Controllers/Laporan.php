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
}

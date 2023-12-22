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
    private $modelinbound;

    public function __construct()
    {
        $this->model = new \App\Models\PlannedMaterialModel();
        $this->modelinbound = new \App\Models\PlannedInboundModel();
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

    private function dataWeekly()
    {
        $bulan = ($this->request->getVar('bulan')) ? $this->request->getVar('bulan') : intval(date('m'));
        $tahun = ($this->request->getVar('tahun')) ? $this->request->getVar('tahun') : intval(date('Y'));

        $week1 = idate('W', strtotime($tahun . '-' . $bulan . '-' . '01'));
        $week2 = idate('W', strtotime($tahun . '-' . $bulan . '-' . (1 + 7)));
        $week3 = idate('W', strtotime($tahun . '-' . $bulan . '-' . (1 + (7 * 2))));
        $week4 = idate('W', strtotime($tahun . '-' . $bulan . '-' . (1 + (7 * 3))));
        $week5 = idate('W', strtotime($tahun . '-' . $bulan . '-' . (1 + (7 * 4))));


        $data = [
            'title' => 'Report',
            'tahun' => $tahun,
            // 'rim_list' => $this->pcs->getRimList($tahun, $bulan, 0),
            'total_week1' => $this->pcs->getReport($tahun, $bulan, $week1),
            'total_week2' => $this->pcs->getReport($tahun, $bulan, $week2),
            'total_week3' => $this->pcs->getReport($tahun, $bulan, $week3),
            'total_week4' => $this->pcs->getReport($tahun, $bulan, $week4),
            'total_week5' => $this->pcs->getReport($tahun, $bulan, $week5),

            'plan_total_week1' => $this->modelinbound->getReport($tahun, $bulan, $week1),
            'plan_total_week2' => $this->modelinbound->getReport($tahun, $bulan, $week2),
            'plan_total_week3' => $this->modelinbound->getReport($tahun, $bulan, $week3),
            'plan_total_week4' => $this->modelinbound->getReport($tahun, $bulan, $week4),
            'plan_total_week5' => $this->modelinbound->getReport($tahun, $bulan, $week5),


            'total_act' => $this->pcs->getReport($tahun, $bulan, 0, null, null, null, null, null, 'week'),
            'plan_total_act' => $this->modelinbound->getReport($tahun, $bulan, 0, null, null, null, null, null, 'week'),

            'pirelli_week1' => $this->pcs->getReport($tahun, $bulan, $week1, 'PIRELLi'),
            'pirelli_week2' => $this->pcs->getReport($tahun, $bulan, $week2, 'PIRELLi'),
            'pirelli_week3' => $this->pcs->getReport($tahun, $bulan, $week3, 'PIRELLi'),
            'pirelli_week4' => $this->pcs->getReport($tahun, $bulan, $week4, 'PIRELLi'),
            'pirelli_week5' => $this->pcs->getReport($tahun, $bulan, $week5, 'PIRELLi'),

            'plan_pirelli_week1' => $this->modelinbound->getReport($tahun, $bulan, $week1, 'PIRELLi'),
            'plan_pirelli_week2' => $this->modelinbound->getReport($tahun, $bulan, $week2, 'PIRELLi'),
            'plan_pirelli_week3' => $this->modelinbound->getReport($tahun, $bulan, $week3, 'PIRELLi'),
            'plan_pirelli_week4' => $this->modelinbound->getReport($tahun, $bulan, $week4, 'PIRELLi'),
            'plan_pirelli_week5' => $this->modelinbound->getReport($tahun, $bulan, $week5, 'PIRELLi'),

            'plan_pirelli_act' => $this->modelinbound->getReport($tahun, $bulan, 0, 'PIRELLi',  null, null, null, null, 'week'),

            'pirelli_act' => $this->pcs->getReport($tahun, $bulan, 0, 'PIRELLi',  null, null, null, null, 'week'),
            'aspira_week1' => $this->pcs->getReport($tahun, $bulan, $week1, 'aspira'),
            'aspira_week2' => $this->pcs->getReport($tahun, $bulan, $week2, 'aspira'),
            'aspira_week3' => $this->pcs->getReport($tahun, $bulan, $week3, 'aspira'),
            'aspira_week4' => $this->pcs->getReport($tahun, $bulan, $week4, 'aspira'),
            'aspira_week5' => $this->pcs->getReport($tahun, $bulan, $week5, 'aspira'),
            'aspira_act' => $this->pcs->getReport($tahun, $bulan, 0, 'aspira',  null, null, null, null, 'week'),

            'plan_aspira_week1' => $this->modelinbound->getReport($tahun, $bulan, $week1, 'aspira'),
            'plan_aspira_week2' => $this->modelinbound->getReport($tahun, $bulan, $week2, 'aspira'),
            'plan_aspira_week3' => $this->modelinbound->getReport($tahun, $bulan, $week3, 'aspira'),
            'plan_aspira_week4' => $this->modelinbound->getReport($tahun, $bulan, $week4, 'aspira'),
            'plan_aspira_week5' => $this->modelinbound->getReport($tahun, $bulan, $week5, 'aspira'),
            'plan_aspira_act' => $this->modelinbound->getReport($tahun, $bulan, 0, 'aspira',  null, null, null, null, 'week'),

            'plan_oe_week1' => $this->modelinbound->getReport($tahun, $bulan, $week1, null, null, '10'),
            'plan_oe_week2' => $this->modelinbound->getReport($tahun, $bulan, $week2, null, null, '10'),
            'plan_oe_week3' => $this->modelinbound->getReport($tahun, $bulan, $week3, null, null, '10'),
            'plan_oe_week4' => $this->modelinbound->getReport($tahun, $bulan, $week4, null, null, '10'),
            'plan_oe_week5' => $this->modelinbound->getReport($tahun, $bulan, $week5, null, null, '10'),
            'plan_oe_act' => $this->modelinbound->getReport($tahun, $bulan, 0, null, null, '10', null, null, 'week'),

            'oe_week1' => $this->pcs->getReport($tahun, $bulan, $week1, null, null, '10'),
            'oe_week2' => $this->pcs->getReport($tahun, $bulan, $week2, null, null, '10'),
            'oe_week3' => $this->pcs->getReport($tahun, $bulan, $week3, null, null, '10'),
            'oe_week4' => $this->pcs->getReport($tahun, $bulan, $week4, null, null, '10'),
            'oe_week5' => $this->pcs->getReport($tahun, $bulan, $week5, null, null, '10'),
            'oe_act' => $this->pcs->getReport($tahun, $bulan, 0, null, null, '10', null, null, 'week'),


            'plan_rem_week1' => $this->modelinbound->getReport($tahun, $bulan, $week1, null, null, '00'),
            'plan_rem_week2' => $this->modelinbound->getReport($tahun, $bulan, $week2, null, null, '00'),
            'plan_rem_week3' => $this->modelinbound->getReport($tahun, $bulan, $week3, null, null, '00'),
            'plan_rem_week4' => $this->modelinbound->getReport($tahun, $bulan, $week4, null, null, '00'),
            'plan_rem_week5' => $this->modelinbound->getReport($tahun, $bulan, $week5, null, null, '00'),
            'plan_rem_act' => $this->modelinbound->getReport($tahun, $bulan, 0, null, null, '00', null, null, 'week'),

            'rem_week1' => $this->pcs->getReport($tahun, $bulan, $week1, null, null, '00'),
            'rem_week2' => $this->pcs->getReport($tahun, $bulan, $week2, null, null, '00'),
            'rem_week3' => $this->pcs->getReport($tahun, $bulan, $week3, null, null, '00'),
            'rem_week4' => $this->pcs->getReport($tahun, $bulan, $week4, null, null, '00'),
            'rem_week5' => $this->pcs->getReport($tahun, $bulan, $week5, null, null, '00'),
            'rem_act' => $this->pcs->getReport($tahun, $bulan, 0, null, null, '00', null, null, 'week'),

            'plan_btu_week1' => $this->modelinbound->getReport($tahun, $bulan, $week1, null, null, null, 'BTU'),
            'plan_btu_week2' => $this->modelinbound->getReport($tahun, $bulan, $week2, null, null, null, 'BTU'),
            'plan_btu_week3' => $this->modelinbound->getReport($tahun, $bulan, $week3, null, null, null, 'BTU'),
            'plan_btu_week4' => $this->modelinbound->getReport($tahun, $bulan, $week4, null, null, null, 'BTU'),
            'plan_btu_week5' => $this->modelinbound->getReport($tahun, $bulan, $week5, null, null, null, 'BTU'),
            'plan_btu_act' => $this->modelinbound->getReport($tahun, $bulan, 0, null, null, null, 'BTU', null, 'week'),

            'btu_week1' => $this->pcs->getReport($tahun, $bulan, $week1, null, null, null, 'BTU'),
            'btu_week2' => $this->pcs->getReport($tahun, $bulan, $week2, null, null, null, 'BTU'),
            'btu_week3' => $this->pcs->getReport($tahun, $bulan, $week3, null, null, null, 'BTU'),
            'btu_week4' => $this->pcs->getReport($tahun, $bulan, $week4, null, null, null, 'BTU'),
            'btu_week5' => $this->pcs->getReport($tahun, $bulan, $week5, null, null, null, 'BTU'),
            'btu_act' => $this->pcs->getReport($tahun, $bulan, 0, null, null, null, 'BTU', null, 'week'),


            'plan_stu_week1' => $this->modelinbound->getReport($tahun, $bulan, $week1, null, null, null, 'stu'),
            'plan_stu_week2' => $this->modelinbound->getReport($tahun, $bulan, $week2, null, null, null, 'stu'),
            'plan_stu_week3' => $this->modelinbound->getReport($tahun, $bulan, $week3, null, null, null, 'stu'),
            'plan_stu_week4' => $this->modelinbound->getReport($tahun, $bulan, $week4, null, null, null, 'stu'),
            'plan_stu_week5' => $this->modelinbound->getReport($tahun, $bulan, $week5, null, null, null, 'stu'),
            'plan_stu_act' => $this->modelinbound->getReport($tahun, $bulan, 0, null, null, null, 'stu', null, 'week'),

            'stu_week1' => $this->pcs->getReport($tahun, $bulan, $week1, null, null, null, 'stu'),
            'stu_week2' => $this->pcs->getReport($tahun, $bulan, $week2, null, null, null, 'stu'),
            'stu_week3' => $this->pcs->getReport($tahun, $bulan, $week3, null, null, null, 'stu'),
            'stu_week4' => $this->pcs->getReport($tahun, $bulan, $week4, null, null, null, 'stu'),
            'stu_week5' => $this->pcs->getReport($tahun, $bulan, $week5, null, null, null, 'stu'),
            'stu_act' => $this->pcs->getReport($tahun, $bulan, 0, null, null, null, 'stu', null, 'week'),


            'plan_mru_week1' => $this->modelinbound->getReport($tahun, $bulan, $week1, null, null, null, 'mru'),
            'plan_mru_week2' => $this->modelinbound->getReport($tahun, $bulan, $week2, null, null, null, 'mru'),
            'plan_mru_week3' => $this->modelinbound->getReport($tahun, $bulan, $week3, null, null, null, 'mru'),
            'plan_mru_week4' => $this->modelinbound->getReport($tahun, $bulan, $week4, null, null, null, 'mru'),
            'plan_mru_week5' => $this->modelinbound->getReport($tahun, $bulan, $week5, null, null, null, 'mru'),
            'plan_mru_act' => $this->modelinbound->getReport($tahun, $bulan, 0, null, null, null, 'mru', null, 'week'),

            'mru_week1' => $this->pcs->getReport($tahun, $bulan, $week1, null, null, null, 'mru'),
            'mru_week2' => $this->pcs->getReport($tahun, $bulan, $week2, null, null, null, 'mru'),
            'mru_week3' => $this->pcs->getReport($tahun, $bulan, $week3, null, null, null, 'mru'),
            'mru_week4' => $this->pcs->getReport($tahun, $bulan, $week4, null, null, null, 'mru'),
            'mru_week5' => $this->pcs->getReport($tahun, $bulan, $week5, null, null, null, 'mru'),
            'mru_act' => $this->pcs->getReport($tahun, $bulan, 0, null, null, null, 'mru', null, 'week'),

            'id_bulan' => $bulan,
            'bulan' => date('F', strtotime(date('Y-' . $bulan . '-d')))
        ];

        return $data;
    }

    public function inbound()
    {
        $this->permissionCheck('inbound_list');

        $this->updatePageData([
            'title' => 'Laporan Inbound',
            'submenu' => 'inbound_list',
        ]);

        $data = $this->dataWeekly();

        return view($this->view . '/inbound_list', $data);
    }

    public function inboundAjax()
    {
        $this->permissionCheck('inbound_list');

        $data  = $this->dataWeekly();

        return view($this->view . '/inbound_list_ajax', $data);
    }
}

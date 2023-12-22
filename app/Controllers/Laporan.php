<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Controllers\AdminBaseController;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporan extends AdminBaseController
{

    public $title = 'laporan';
    public $menu = 'laporan';
    public $link = 'laporan';
    private $view = 'admin/laporan';
    private $dir = '';
    private $modelpcs;
    private $modelinbound;

    public function __construct()
    {
        $this->model = new \App\Models\PlannedMaterialModel();
        $this->modelinbound = new \App\Models\PlannedInboundModel();
        $this->modelpcs = new \App\Models\PcsModel();
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
            'chart' => $this->modelpcs->getChartAjax($mt_code),
            'mch' => $mt_code
        ];
        return view($this->view . '/frame_building', $data);
    }

    function ajaxChartBuilding()
    {
        $mch = $this->request->getVar('mch');
        return json_encode($this->modelpcs->getChartAjax($mch));
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
            'chart' => $this->modelpcs->getChartHours($mt_code)
        ];
        return view($this->view . '/table_building', $data);
    }


    public function chart_curing($bulan = null, $tahun = null)
    {
        $bulan = ($bulan == null) ? date('m') : $bulan;
        $tahun = ($tahun == null) ? date('Y') : $tahun;
        $curing = $this->modelpcs->getDataCuring($bulan, $tahun);
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
        $data = $this->modelpcs->getDataCuring($bulan, $tahun);
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
        $data = $this->modelpcs->getDataCuringDetail($ip, $bulan, $tahun);
        $data = [
            'data' => $data
        ];
        return json_encode($data);
    }

    private function inboundWeekly()
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
            // 'rim_list' => $this->modelpcs->getRimList($tahun, $bulan, 0),
            'total_week1' => $this->modelpcs->getDataInbound($tahun, $bulan, $week1),
            'total_week2' => $this->modelpcs->getDataInbound($tahun, $bulan, $week2),
            'total_week3' => $this->modelpcs->getDataInbound($tahun, $bulan, $week3),
            'total_week4' => $this->modelpcs->getDataInbound($tahun, $bulan, $week4),
            'total_week5' => $this->modelpcs->getDataInbound($tahun, $bulan, $week5),

            'plan_total_week1' => $this->modelinbound->getDataInbound($tahun, $bulan, $week1),
            'plan_total_week2' => $this->modelinbound->getDataInbound($tahun, $bulan, $week2),
            'plan_total_week3' => $this->modelinbound->getDataInbound($tahun, $bulan, $week3),
            'plan_total_week4' => $this->modelinbound->getDataInbound($tahun, $bulan, $week4),
            'plan_total_week5' => $this->modelinbound->getDataInbound($tahun, $bulan, $week5),


            'total_act' => $this->modelpcs->getDataInbound($tahun, $bulan, 0, null, null, null, null, null, 'week'),
            'plan_total_act' => $this->modelinbound->getDataInbound($tahun, $bulan, 0, null, null, null, null, null, 'week'),

            'pirelli_week1' => $this->modelpcs->getDataInbound($tahun, $bulan, $week1, 'PIRELLi'),
            'pirelli_week2' => $this->modelpcs->getDataInbound($tahun, $bulan, $week2, 'PIRELLi'),
            'pirelli_week3' => $this->modelpcs->getDataInbound($tahun, $bulan, $week3, 'PIRELLi'),
            'pirelli_week4' => $this->modelpcs->getDataInbound($tahun, $bulan, $week4, 'PIRELLi'),
            'pirelli_week5' => $this->modelpcs->getDataInbound($tahun, $bulan, $week5, 'PIRELLi'),

            'plan_pirelli_week1' => $this->modelinbound->getDataInbound($tahun, $bulan, $week1, 'PIRELLi'),
            'plan_pirelli_week2' => $this->modelinbound->getDataInbound($tahun, $bulan, $week2, 'PIRELLi'),
            'plan_pirelli_week3' => $this->modelinbound->getDataInbound($tahun, $bulan, $week3, 'PIRELLi'),
            'plan_pirelli_week4' => $this->modelinbound->getDataInbound($tahun, $bulan, $week4, 'PIRELLi'),
            'plan_pirelli_week5' => $this->modelinbound->getDataInbound($tahun, $bulan, $week5, 'PIRELLi'),

            'plan_pirelli_act' => $this->modelinbound->getDataInbound($tahun, $bulan, 0, 'PIRELLi',  null, null, null, null, 'week'),

            'pirelli_act' => $this->modelpcs->getDataInbound($tahun, $bulan, 0, 'PIRELLi',  null, null, null, null, 'week'),
            'aspira_week1' => $this->modelpcs->getDataInbound($tahun, $bulan, $week1, 'aspira'),
            'aspira_week2' => $this->modelpcs->getDataInbound($tahun, $bulan, $week2, 'aspira'),
            'aspira_week3' => $this->modelpcs->getDataInbound($tahun, $bulan, $week3, 'aspira'),
            'aspira_week4' => $this->modelpcs->getDataInbound($tahun, $bulan, $week4, 'aspira'),
            'aspira_week5' => $this->modelpcs->getDataInbound($tahun, $bulan, $week5, 'aspira'),
            'aspira_act' => $this->modelpcs->getDataInbound($tahun, $bulan, 0, 'aspira',  null, null, null, null, 'week'),

            'plan_aspira_week1' => $this->modelinbound->getDataInbound($tahun, $bulan, $week1, 'aspira'),
            'plan_aspira_week2' => $this->modelinbound->getDataInbound($tahun, $bulan, $week2, 'aspira'),
            'plan_aspira_week3' => $this->modelinbound->getDataInbound($tahun, $bulan, $week3, 'aspira'),
            'plan_aspira_week4' => $this->modelinbound->getDataInbound($tahun, $bulan, $week4, 'aspira'),
            'plan_aspira_week5' => $this->modelinbound->getDataInbound($tahun, $bulan, $week5, 'aspira'),
            'plan_aspira_act' => $this->modelinbound->getDataInbound($tahun, $bulan, 0, 'aspira',  null, null, null, null, 'week'),

            'plan_oe_week1' => $this->modelinbound->getDataInbound($tahun, $bulan, $week1, null, null, '10'),
            'plan_oe_week2' => $this->modelinbound->getDataInbound($tahun, $bulan, $week2, null, null, '10'),
            'plan_oe_week3' => $this->modelinbound->getDataInbound($tahun, $bulan, $week3, null, null, '10'),
            'plan_oe_week4' => $this->modelinbound->getDataInbound($tahun, $bulan, $week4, null, null, '10'),
            'plan_oe_week5' => $this->modelinbound->getDataInbound($tahun, $bulan, $week5, null, null, '10'),
            'plan_oe_act' => $this->modelinbound->getDataInbound($tahun, $bulan, 0, null, null, '10', null, null, 'week'),

            'oe_week1' => $this->modelpcs->getDataInbound($tahun, $bulan, $week1, null, null, '10'),
            'oe_week2' => $this->modelpcs->getDataInbound($tahun, $bulan, $week2, null, null, '10'),
            'oe_week3' => $this->modelpcs->getDataInbound($tahun, $bulan, $week3, null, null, '10'),
            'oe_week4' => $this->modelpcs->getDataInbound($tahun, $bulan, $week4, null, null, '10'),
            'oe_week5' => $this->modelpcs->getDataInbound($tahun, $bulan, $week5, null, null, '10'),
            'oe_act' => $this->modelpcs->getDataInbound($tahun, $bulan, 0, null, null, '10', null, null, 'week'),


            'plan_rem_week1' => $this->modelinbound->getDataInbound($tahun, $bulan, $week1, null, null, '00'),
            'plan_rem_week2' => $this->modelinbound->getDataInbound($tahun, $bulan, $week2, null, null, '00'),
            'plan_rem_week3' => $this->modelinbound->getDataInbound($tahun, $bulan, $week3, null, null, '00'),
            'plan_rem_week4' => $this->modelinbound->getDataInbound($tahun, $bulan, $week4, null, null, '00'),
            'plan_rem_week5' => $this->modelinbound->getDataInbound($tahun, $bulan, $week5, null, null, '00'),
            'plan_rem_act' => $this->modelinbound->getDataInbound($tahun, $bulan, 0, null, null, '00', null, null, 'week'),

            'rem_week1' => $this->modelpcs->getDataInbound($tahun, $bulan, $week1, null, null, '00'),
            'rem_week2' => $this->modelpcs->getDataInbound($tahun, $bulan, $week2, null, null, '00'),
            'rem_week3' => $this->modelpcs->getDataInbound($tahun, $bulan, $week3, null, null, '00'),
            'rem_week4' => $this->modelpcs->getDataInbound($tahun, $bulan, $week4, null, null, '00'),
            'rem_week5' => $this->modelpcs->getDataInbound($tahun, $bulan, $week5, null, null, '00'),
            'rem_act' => $this->modelpcs->getDataInbound($tahun, $bulan, 0, null, null, '00', null, null, 'week'),

            'plan_btu_week1' => $this->modelinbound->getDataInbound($tahun, $bulan, $week1, null, null, null, 'BTU'),
            'plan_btu_week2' => $this->modelinbound->getDataInbound($tahun, $bulan, $week2, null, null, null, 'BTU'),
            'plan_btu_week3' => $this->modelinbound->getDataInbound($tahun, $bulan, $week3, null, null, null, 'BTU'),
            'plan_btu_week4' => $this->modelinbound->getDataInbound($tahun, $bulan, $week4, null, null, null, 'BTU'),
            'plan_btu_week5' => $this->modelinbound->getDataInbound($tahun, $bulan, $week5, null, null, null, 'BTU'),
            'plan_btu_act' => $this->modelinbound->getDataInbound($tahun, $bulan, 0, null, null, null, 'BTU', null, 'week'),

            'btu_week1' => $this->modelpcs->getDataInbound($tahun, $bulan, $week1, null, null, null, 'BTU'),
            'btu_week2' => $this->modelpcs->getDataInbound($tahun, $bulan, $week2, null, null, null, 'BTU'),
            'btu_week3' => $this->modelpcs->getDataInbound($tahun, $bulan, $week3, null, null, null, 'BTU'),
            'btu_week4' => $this->modelpcs->getDataInbound($tahun, $bulan, $week4, null, null, null, 'BTU'),
            'btu_week5' => $this->modelpcs->getDataInbound($tahun, $bulan, $week5, null, null, null, 'BTU'),
            'btu_act' => $this->modelpcs->getDataInbound($tahun, $bulan, 0, null, null, null, 'BTU', null, 'week'),


            'plan_stu_week1' => $this->modelinbound->getDataInbound($tahun, $bulan, $week1, null, null, null, 'stu'),
            'plan_stu_week2' => $this->modelinbound->getDataInbound($tahun, $bulan, $week2, null, null, null, 'stu'),
            'plan_stu_week3' => $this->modelinbound->getDataInbound($tahun, $bulan, $week3, null, null, null, 'stu'),
            'plan_stu_week4' => $this->modelinbound->getDataInbound($tahun, $bulan, $week4, null, null, null, 'stu'),
            'plan_stu_week5' => $this->modelinbound->getDataInbound($tahun, $bulan, $week5, null, null, null, 'stu'),
            'plan_stu_act' => $this->modelinbound->getDataInbound($tahun, $bulan, 0, null, null, null, 'stu', null, 'week'),

            'stu_week1' => $this->modelpcs->getDataInbound($tahun, $bulan, $week1, null, null, null, 'stu'),
            'stu_week2' => $this->modelpcs->getDataInbound($tahun, $bulan, $week2, null, null, null, 'stu'),
            'stu_week3' => $this->modelpcs->getDataInbound($tahun, $bulan, $week3, null, null, null, 'stu'),
            'stu_week4' => $this->modelpcs->getDataInbound($tahun, $bulan, $week4, null, null, null, 'stu'),
            'stu_week5' => $this->modelpcs->getDataInbound($tahun, $bulan, $week5, null, null, null, 'stu'),
            'stu_act' => $this->modelpcs->getDataInbound($tahun, $bulan, 0, null, null, null, 'stu', null, 'week'),


            'plan_mru_week1' => $this->modelinbound->getDataInbound($tahun, $bulan, $week1, null, null, null, 'mru'),
            'plan_mru_week2' => $this->modelinbound->getDataInbound($tahun, $bulan, $week2, null, null, null, 'mru'),
            'plan_mru_week3' => $this->modelinbound->getDataInbound($tahun, $bulan, $week3, null, null, null, 'mru'),
            'plan_mru_week4' => $this->modelinbound->getDataInbound($tahun, $bulan, $week4, null, null, null, 'mru'),
            'plan_mru_week5' => $this->modelinbound->getDataInbound($tahun, $bulan, $week5, null, null, null, 'mru'),
            'plan_mru_act' => $this->modelinbound->getDataInbound($tahun, $bulan, 0, null, null, null, 'mru', null, 'week'),

            'mru_week1' => $this->modelpcs->getDataInbound($tahun, $bulan, $week1, null, null, null, 'mru'),
            'mru_week2' => $this->modelpcs->getDataInbound($tahun, $bulan, $week2, null, null, null, 'mru'),
            'mru_week3' => $this->modelpcs->getDataInbound($tahun, $bulan, $week3, null, null, null, 'mru'),
            'mru_week4' => $this->modelpcs->getDataInbound($tahun, $bulan, $week4, null, null, null, 'mru'),
            'mru_week5' => $this->modelpcs->getDataInbound($tahun, $bulan, $week5, null, null, null, 'mru'),
            'mru_act' => $this->modelpcs->getDataInbound($tahun, $bulan, 0, null, null, null, 'mru', null, 'week'),

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

        $data = $this->inboundWeekly();

        return view($this->view . '/inbound_list', $data);
    }

    public function ajaxInbound()
    {
        $this->permissionCheck('inbound_list');

        $data  = $this->inboundWeekly();

        return view($this->view . '/inbound_list_ajax', $data);
    }

    public function exportInbound()
    {
        $this->permissionCheck('inbound_list_export');

        $bulan = ($this->request->getVar('bulan')) ? $this->request->getVar('bulan') : intval(date('m'));
        $tahun = ($this->request->getVar('tahun')) ? $this->request->getVar('tahun') : intval(date('Y'));

        $week1 = idate('W', strtotime($tahun . '-' . $bulan . '-' . '01'));
        $week2 = idate('W', strtotime($tahun . '-' . $bulan . '-' . (1 + 7)));
        $week3 = idate('W', strtotime($tahun . '-' . $bulan . '-' . (1 + (7 * 2))));
        $week4 = idate('W', strtotime($tahun . '-' . $bulan . '-' . (1 + (7 * 3))));
        $week5 = idate('W', strtotime($tahun . '-' . $bulan . '-' . (1 + (7 * 4))));


        $data  = $this->inboundWeekly();

        // phpoffice/phpspreadsheet
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle("ALL " . $data['bulan'] . ' ' . $tahun);

        $rowLabel = 1;

        // $sheet->setCellValue('A2', 'Handover:');
        // $sheet->setCellValue('B2', '');

        // $sheet->setCellValue('D2', 'Export:');
        // $sheet->setCellValue('E2', date('Y-m-d H:i:s'));

        $lineFreeze = 2;

        // $sheet->freezePane('A' . $lineFreeze);
        // // Freeze second line:
        // $sheet->freezePane('E' . $lineFreeze);

        // set bold
        $sheet->getStyle('A' . $rowLabel . ':N' . $rowLabel . '')->getFont()->setBold(true);

        // set wrap text
        $sheet->getStyle('A' . $rowLabel . ':N' . $rowLabel . '')->getAlignment()->setWrapText(true);

        //  biar gak dempet karena autosize

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->mergeCells("A1:B2");
        $spreadsheet->getActiveSheet()->mergeCells("C1:H1");

        $sheet->setCellValue('A' . $rowLabel, 'SUBANG');
        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('C' . $rowLabel, $data['bulan'] . ' ' . $tahun);
        $spreadsheet->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal('center');
        $rowWeek = $rowLabel + 1;
        $week_first = idate('W', strtotime($tahun . '-' . $data['id_bulan'] . '-' . '01'));
        $week_first = ($week_first > 51) ? 1 : $week_first + 1;
        $sheet->setCellValue('C' . $rowWeek, 'W1 (W' . $week_first . ')');
        $sheet->setCellValue('D' . $rowWeek, 'W2 (W' . ($week_first + 1) . ')');
        $sheet->setCellValue('E' . $rowWeek, 'W3 (W' . ($week_first + 2) . ')');
        $sheet->setCellValue('F' . $rowWeek, 'W4 (W' . ($week_first + 3) . ')');
        $sheet->setCellValue('G' . $rowWeek, 'W5 (W' . ($week_first + 4) . ')');
        $sheet->setCellValue('H' . $rowWeek, 'ACT');

        // total
        $spreadsheet->getActiveSheet()->mergeCells("A3:A5");
        $spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical('center');
        $sheet->setCellValue('A3', 'TOTAL');
        $sheet->setCellValue('B3', 'Plan');

        $sheet->setCellValue('C3', $data['plan_total_week1']['INBOUND']);
        $sheet->setCellValue('D3', $data['plan_total_week2']['INBOUND']);
        $sheet->setCellValue('E3', $data['plan_total_week3']['INBOUND']);
        $sheet->setCellValue('F3', $data['plan_total_week4']['INBOUND']);
        $sheet->setCellValue('G3', $data['plan_total_week5']['INBOUND']);
        $sheet->setCellValue('H3', $data['plan_total_act']['INBOUND']);

        $sheet->setCellValue('B4', 'ACT');

        $sheet->setCellValue('C4', $data['total_week1']['INBOUND']);
        $sheet->setCellValue('D4', $data['total_week2']['INBOUND']);
        $sheet->setCellValue('E4', $data['total_week3']['INBOUND']);
        $sheet->setCellValue('F4', $data['total_week4']['INBOUND']);
        $sheet->setCellValue('G4', $data['total_week5']['INBOUND']);
        $sheet->setCellValue('H4', $data['total_act']['INBOUND']);

        $sheet->setCellValue('B5', '%');

        $sheet->setCellValue('C5', ($data['plan_total_week1']['INBOUND'] == 0) ? '' : round($data['total_week1']['INBOUND'] / $data['plan_total_week1']['INBOUND'] * 100, 1));
        $sheet->setCellValue('D5', ($data['plan_total_week2']['INBOUND'] == 0) ? '' : round($data['total_week2']['INBOUND'] / $data['plan_total_week2']['INBOUND'] * 100, 1));
        $sheet->setCellValue('E5', ($data['plan_total_week3']['INBOUND'] == 0) ? '' : round($data['total_week3']['INBOUND'] / $data['plan_total_week3']['INBOUND'] * 100, 1));
        $sheet->setCellValue('F5', ($data['plan_total_week4']['INBOUND'] == 0) ? '' : round($data['total_week4']['INBOUND'] / $data['plan_total_week4']['INBOUND'] * 100, 1));
        $sheet->setCellValue('G5', ($data['plan_total_week5']['INBOUND'] == 0) ? '' : round($data['total_week5']['INBOUND'] / $data['plan_total_week5']['INBOUND'] * 100, 1));
        $sheet->setCellValue('H5', ($data['plan_total_act']['INBOUND'] == 0) ? '' : round($data['total_act']['INBOUND'] / $data['plan_total_act']['INBOUND'] * 100, 1));

        // PIRELLI
        $spreadsheet->getActiveSheet()->mergeCells("A6:A8");
        $spreadsheet->getActiveSheet()->getStyle('A6')->getAlignment()->setVertical('center');
        $sheet->setCellValue('A6', 'PIRELLI');
        $sheet->setCellValue('B6', 'Plan');

        $sheet->setCellValue('C6', $data['plan_pirelli_week1']['INBOUND']);
        $sheet->setCellValue('D6', $data['plan_pirelli_week2']['INBOUND']);
        $sheet->setCellValue('E6', $data['plan_pirelli_week3']['INBOUND']);
        $sheet->setCellValue('F6', $data['plan_pirelli_week4']['INBOUND']);
        $sheet->setCellValue('G6', $data['plan_pirelli_week5']['INBOUND']);
        $sheet->setCellValue('H6', $data['plan_pirelli_act']['INBOUND']);


        $sheet->setCellValue('B7', 'ACT');

        $sheet->setCellValue('C7', $data['pirelli_week1']['INBOUND']);
        $sheet->setCellValue('D7', $data['pirelli_week2']['INBOUND']);
        $sheet->setCellValue('E7', $data['pirelli_week3']['INBOUND']);
        $sheet->setCellValue('F7', $data['pirelli_week4']['INBOUND']);
        $sheet->setCellValue('G7', $data['pirelli_week5']['INBOUND']);
        $sheet->setCellValue('H7', $data['pirelli_act']['INBOUND']);

        $sheet->setCellValue('B8', '%');

        $sheet->setCellValue('C8', ($data['plan_pirelli_week1']['INBOUND'] == 0) ? '' : round($data['pirelli_week1']['INBOUND'] / $data['plan_pirelli_week1']['INBOUND'] * 100, 1));
        $sheet->setCellValue('D8', ($data['plan_pirelli_week2']['INBOUND'] == 0) ? '' : round($data['pirelli_week2']['INBOUND'] / $data['plan_pirelli_week2']['INBOUND'] * 100, 1));
        $sheet->setCellValue('E8', ($data['plan_pirelli_week3']['INBOUND'] == 0) ? '' : round($data['pirelli_week3']['INBOUND'] / $data['plan_pirelli_week3']['INBOUND'] * 100, 1));
        $sheet->setCellValue('F8', ($data['plan_pirelli_week4']['INBOUND'] == 0) ? '' : round($data['pirelli_week4']['INBOUND'] / $data['plan_pirelli_week4']['INBOUND'] * 100, 1));
        $sheet->setCellValue('G8', ($data['plan_pirelli_week5']['INBOUND'] == 0) ? '' : round($data['pirelli_week5']['INBOUND'] / $data['plan_pirelli_week5']['INBOUND'] * 100, 1));
        $sheet->setCellValue('H8', ($data['plan_pirelli_act']['INBOUND'] == 0) ? '' : round($data['pirelli_act']['INBOUND'] / $data['plan_pirelli_act']['INBOUND'] * 100, 1));

        // ASPIRA
        $spreadsheet->getActiveSheet()->mergeCells("A9:A11");
        $spreadsheet->getActiveSheet()->getStyle('A9')->getAlignment()->setVertical('center');
        $sheet->setCellValue('A9', 'ASPIRA');
        $sheet->setCellValue('B9', 'Plan');

        $sheet->setCellValue('C9', $data['plan_aspira_week1']['INBOUND']);
        $sheet->setCellValue('D9', $data['plan_aspira_week2']['INBOUND']);
        $sheet->setCellValue('E9', $data['plan_aspira_week3']['INBOUND']);
        $sheet->setCellValue('F9', $data['plan_aspira_week4']['INBOUND']);
        $sheet->setCellValue('G9', $data['plan_aspira_week5']['INBOUND']);
        $sheet->setCellValue('H9', $data['plan_aspira_act']['INBOUND']);

        $sheet->setCellValue('B10', 'ACT');

        $sheet->setCellValue('C10', $data['aspira_week1']['INBOUND']);
        $sheet->setCellValue('D10', $data['aspira_week2']['INBOUND']);
        $sheet->setCellValue('E10', $data['aspira_week3']['INBOUND']);
        $sheet->setCellValue('F10', $data['aspira_week4']['INBOUND']);
        $sheet->setCellValue('G10', $data['aspira_week5']['INBOUND']);
        $sheet->setCellValue('H10', $data['aspira_act']['INBOUND']);


        $sheet->setCellValue('B11', '%');

        $sheet->setCellValue('C11', ($data['plan_aspira_week1']['INBOUND'] == 0) ? '' : round($data['aspira_week1']['INBOUND'] / $data['plan_aspira_week1']['INBOUND'] * 100, 1));
        $sheet->setCellValue('D11', ($data['plan_aspira_week2']['INBOUND'] == 0) ? '' : round($data['aspira_week2']['INBOUND'] / $data['plan_aspira_week2']['INBOUND'] * 100, 1));
        $sheet->setCellValue('E11', ($data['plan_aspira_week3']['INBOUND'] == 0) ? '' : round($data['aspira_week3']['INBOUND'] / $data['plan_aspira_week3']['INBOUND'] * 100, 1));
        $sheet->setCellValue('F11', ($data['plan_aspira_week4']['INBOUND'] == 0) ? '' : round($data['aspira_week4']['INBOUND'] / $data['plan_aspira_week4']['INBOUND'] * 100, 1));
        $sheet->setCellValue('G11', ($data['plan_aspira_week5']['INBOUND'] == 0) ? '' : round($data['aspira_week5']['INBOUND'] / $data['plan_aspira_week5']['INBOUND'] * 100, 1));
        $sheet->setCellValue('H11', ($data['plan_aspira_act']['INBOUND'] == 0) ? '' : round($data['aspira_act']['INBOUND'] / $data['plan_aspira_act']['INBOUND'] * 100, 1));

        // OE
        $spreadsheet->getActiveSheet()->mergeCells("A12:A14");
        $spreadsheet->getActiveSheet()->getStyle('A12')->getAlignment()->setVertical('center');
        $sheet->setCellValue('A12', 'OE');
        $sheet->setCellValue('B12', 'Plan');

        $sheet->setCellValue('C12', $data['plan_oe_week1']['INBOUND']);
        $sheet->setCellValue('D12', $data['plan_oe_week2']['INBOUND']);
        $sheet->setCellValue('E12', $data['plan_oe_week3']['INBOUND']);
        $sheet->setCellValue('F12', $data['plan_oe_week4']['INBOUND']);
        $sheet->setCellValue('G12', $data['plan_oe_week5']['INBOUND']);
        $sheet->setCellValue('H12', $data['plan_oe_act']['INBOUND']);


        $sheet->setCellValue('B13', 'ACT');

        $sheet->setCellValue('C13', $data['oe_week1']['INBOUND']);
        $sheet->setCellValue('D13', $data['oe_week2']['INBOUND']);
        $sheet->setCellValue('E13', $data['oe_week3']['INBOUND']);
        $sheet->setCellValue('F13', $data['oe_week4']['INBOUND']);
        $sheet->setCellValue('G13', $data['oe_week5']['INBOUND']);
        $sheet->setCellValue('H13', $data['oe_act']['INBOUND']);

        $sheet->setCellValue('B14', '%');

        $sheet->setCellValue('C14', ($data['plan_oe_week1']['INBOUND'] == 0) ? '' : round($data['oe_week1']['INBOUND'] / $data['plan_oe_week1']['INBOUND'] * 100, 1));
        $sheet->setCellValue('D14', ($data['plan_oe_week2']['INBOUND'] == 0) ? '' : round($data['oe_week2']['INBOUND'] / $data['plan_oe_week2']['INBOUND'] * 100, 1));
        $sheet->setCellValue('E14', ($data['plan_oe_week3']['INBOUND'] == 0) ? '' : round($data['oe_week3']['INBOUND'] / $data['plan_oe_week3']['INBOUND'] * 100, 1));
        $sheet->setCellValue('F14', ($data['plan_oe_week4']['INBOUND'] == 0) ? '' : round($data['oe_week4']['INBOUND'] / $data['plan_oe_week4']['INBOUND'] * 100, 1));
        $sheet->setCellValue('G14', ($data['plan_oe_week5']['INBOUND'] == 0) ? '' : round($data['oe_week5']['INBOUND'] / $data['plan_oe_week5']['INBOUND'] * 100, 1));
        $sheet->setCellValue('H14', ($data['plan_oe_act']['INBOUND'] == 0) ? '' : round($data['oe_act']['INBOUND'] / $data['plan_oe_act']['INBOUND'] * 100, 1));



        // RPLC
        $spreadsheet->getActiveSheet()->mergeCells("A15:A17");
        $spreadsheet->getActiveSheet()->getStyle('A15')->getAlignment()->setVertical('center');
        $sheet->setCellValue('A15', 'RPLC');
        $sheet->setCellValue('B15', 'Plan');

        $sheet->setCellValue('C15', $data['plan_rem_week1']['INBOUND']);
        $sheet->setCellValue('D15', $data['plan_rem_week2']['INBOUND']);
        $sheet->setCellValue('E15', $data['plan_rem_week3']['INBOUND']);
        $sheet->setCellValue('F15', $data['plan_rem_week4']['INBOUND']);
        $sheet->setCellValue('G15', $data['plan_rem_week5']['INBOUND']);
        $sheet->setCellValue('H15', $data['plan_rem_act']['INBOUND']);

        $sheet->setCellValue('B16', 'ACT');

        $sheet->setCellValue('C16', $data['rem_week1']['INBOUND']);
        $sheet->setCellValue('D16', $data['rem_week2']['INBOUND']);
        $sheet->setCellValue('E16', $data['rem_week3']['INBOUND']);
        $sheet->setCellValue('F16', $data['rem_week4']['INBOUND']);
        $sheet->setCellValue('G16', $data['rem_week5']['INBOUND']);
        $sheet->setCellValue('H16', $data['rem_act']['INBOUND']);


        $sheet->setCellValue('B17', '%');

        $sheet->setCellValue('C17', ($data['plan_rem_week1']['INBOUND'] == 0) ? '' : round($data['rem_week1']['INBOUND'] / $data['plan_rem_week1']['INBOUND'] * 100, 1));
        $sheet->setCellValue('D17', ($data['plan_rem_week2']['INBOUND'] == 0) ? '' : round($data['rem_week2']['INBOUND'] / $data['plan_rem_week2']['INBOUND'] * 100, 1));
        $sheet->setCellValue('E17', ($data['plan_rem_week3']['INBOUND'] == 0) ? '' : round($data['rem_week3']['INBOUND'] / $data['plan_rem_week3']['INBOUND'] * 100, 1));
        $sheet->setCellValue('F17', ($data['plan_rem_week4']['INBOUND'] == 0) ? '' : round($data['rem_week4']['INBOUND'] / $data['plan_rem_week4']['INBOUND'] * 100, 1));
        $sheet->setCellValue('G17', ($data['plan_rem_week5']['INBOUND'] == 0) ? '' : round($data['rem_week5']['INBOUND'] / $data['plan_rem_week5']['INBOUND'] * 100, 1));
        $sheet->setCellValue('H17', ($data['plan_rem_act']['INBOUND'] == 0) ? '' : round($data['rem_act']['INBOUND'] / $data['plan_rem_act']['INBOUND'] * 100, 1));

        // BTU
        $spreadsheet->getActiveSheet()->mergeCells("A18:A20");
        $spreadsheet->getActiveSheet()->getStyle('A18')->getAlignment()->setVertical('center');
        $sheet->setCellValue('A18', 'BTU');
        $sheet->setCellValue('B18', 'Plan');

        $sheet->setCellValue('C18', $data['plan_btu_week1']['INBOUND']);
        $sheet->setCellValue('D18', $data['plan_btu_week2']['INBOUND']);
        $sheet->setCellValue('E18', $data['plan_btu_week3']['INBOUND']);
        $sheet->setCellValue('F18', $data['plan_btu_week4']['INBOUND']);
        $sheet->setCellValue('G18', $data['plan_btu_week5']['INBOUND']);
        $sheet->setCellValue('H18', $data['plan_btu_act']['INBOUND']);


        $sheet->setCellValue('B19', 'ACT');

        $sheet->setCellValue('C19', $data['btu_week1']['INBOUND']);
        $sheet->setCellValue('D19', $data['btu_week2']['INBOUND']);
        $sheet->setCellValue('E19', $data['btu_week3']['INBOUND']);
        $sheet->setCellValue('F19', $data['btu_week4']['INBOUND']);
        $sheet->setCellValue('G19', $data['btu_week5']['INBOUND']);
        $sheet->setCellValue('H19', $data['btu_act']['INBOUND']);


        $sheet->setCellValue('B20', '%');

        $sheet->setCellValue('C20', ($data['plan_btu_week1']['INBOUND'] == 0) ? '' : round($data['btu_week1']['INBOUND'] / $data['plan_btu_week1']['INBOUND'] * 100, 1));
        $sheet->setCellValue('D20', ($data['plan_btu_week2']['INBOUND'] == 0) ? '' : round($data['btu_week2']['INBOUND'] / $data['plan_btu_week2']['INBOUND'] * 100, 1));
        $sheet->setCellValue('E20', ($data['plan_btu_week3']['INBOUND'] == 0) ? '' : round($data['btu_week3']['INBOUND'] / $data['plan_btu_week3']['INBOUND'] * 100, 1));
        $sheet->setCellValue('F20', ($data['plan_btu_week4']['INBOUND'] == 0) ? '' : round($data['btu_week4']['INBOUND'] / $data['plan_btu_week4']['INBOUND'] * 100, 1));
        $sheet->setCellValue('G20', ($data['plan_btu_week5']['INBOUND'] == 0) ? '' : round($data['btu_week5']['INBOUND'] / $data['plan_btu_week5']['INBOUND'] * 100, 1));
        $sheet->setCellValue('H20', ($data['plan_btu_act']['INBOUND'] == 0) ? '' : round($data['btu_act']['INBOUND'] / $data['plan_btu_act']['INBOUND'] * 100, 1));

        // STU
        $spreadsheet->getActiveSheet()->mergeCells("A21:A23");
        $spreadsheet->getActiveSheet()->getStyle('A21')->getAlignment()->setVertical('center');
        $sheet->setCellValue('A21', 'STU');
        $sheet->setCellValue('B21', 'Plan');

        $sheet->setCellValue('C21', $data['plan_stu_week1']['INBOUND']);
        $sheet->setCellValue('D21', $data['plan_stu_week2']['INBOUND']);
        $sheet->setCellValue('E21', $data['plan_stu_week3']['INBOUND']);
        $sheet->setCellValue('F21', $data['plan_stu_week4']['INBOUND']);
        $sheet->setCellValue('G21', $data['plan_stu_week5']['INBOUND']);
        $sheet->setCellValue('H21', $data['plan_stu_act']['INBOUND']);

        $sheet->setCellValue('B22', 'ACT');

        $sheet->setCellValue('C22', $data['stu_week1']['INBOUND']);
        $sheet->setCellValue('D22', $data['stu_week2']['INBOUND']);
        $sheet->setCellValue('E22', $data['stu_week3']['INBOUND']);
        $sheet->setCellValue('F22', $data['stu_week4']['INBOUND']);
        $sheet->setCellValue('G22', $data['stu_week5']['INBOUND']);
        $sheet->setCellValue('H22', $data['stu_act']['INBOUND']);


        $sheet->setCellValue('B23', '%');

        $sheet->setCellValue('C23', ($data['plan_stu_week1']['INBOUND'] == 0) ? '' : round($data['stu_week1']['INBOUND'] / $data['plan_stu_week1']['INBOUND'] * 100, 1));
        $sheet->setCellValue('D23', ($data['plan_stu_week2']['INBOUND'] == 0) ? '' : round($data['stu_week2']['INBOUND'] / $data['plan_stu_week2']['INBOUND'] * 100, 1));
        $sheet->setCellValue('E23', ($data['plan_stu_week3']['INBOUND'] == 0) ? '' : round($data['stu_week3']['INBOUND'] / $data['plan_stu_week3']['INBOUND'] * 100, 1));
        $sheet->setCellValue('F23', ($data['plan_stu_week4']['INBOUND'] == 0) ? '' : round($data['stu_week4']['INBOUND'] / $data['plan_stu_week4']['INBOUND'] * 100, 1));
        $sheet->setCellValue('G23', ($data['plan_stu_week5']['INBOUND'] == 0) ? '' : round($data['stu_week5']['INBOUND'] / $data['plan_stu_week5']['INBOUND'] * 100, 1));
        $sheet->setCellValue('H23', ($data['plan_stu_act']['INBOUND'] == 0) ? '' : round($data['stu_act']['INBOUND'] / $data['plan_stu_act']['INBOUND'] * 100, 1));

        // MRU
        $spreadsheet->getActiveSheet()->mergeCells("A24:A26");
        $spreadsheet->getActiveSheet()->getStyle('A24')->getAlignment()->setVertical('center');
        $sheet->setCellValue('A24', 'MRU');
        $sheet->setCellValue('B24', 'Plan');

        $sheet->setCellValue('C24', $data['plan_mru_week1']['INBOUND']);
        $sheet->setCellValue('D24', $data['plan_mru_week2']['INBOUND']);
        $sheet->setCellValue('E24', $data['plan_mru_week3']['INBOUND']);
        $sheet->setCellValue('F24', $data['plan_mru_week4']['INBOUND']);
        $sheet->setCellValue('G24', $data['plan_mru_week5']['INBOUND']);
        $sheet->setCellValue('H24', $data['plan_mru_act']['INBOUND']);


        $sheet->setCellValue('B25', 'ACT');

        $sheet->setCellValue('C25', $data['mru_week1']['INBOUND']);
        $sheet->setCellValue('D25', $data['mru_week2']['INBOUND']);
        $sheet->setCellValue('E25', $data['mru_week3']['INBOUND']);
        $sheet->setCellValue('F25', $data['mru_week4']['INBOUND']);
        $sheet->setCellValue('G25', $data['mru_week5']['INBOUND']);
        $sheet->setCellValue('H25', $data['mru_act']['INBOUND']);

        $sheet->setCellValue('B26', '%');

        $sheet->setCellValue('C26', ($data['plan_mru_week1']['INBOUND'] == 0) ? '' : round($data['mru_week1']['INBOUND'] / $data['plan_mru_week1']['INBOUND'] * 100, 1));
        $sheet->setCellValue('D26', ($data['plan_mru_week2']['INBOUND'] == 0) ? '' : round($data['mru_week2']['INBOUND'] / $data['plan_mru_week2']['INBOUND'] * 100, 1));
        $sheet->setCellValue('E26', ($data['plan_mru_week3']['INBOUND'] == 0) ? '' : round($data['mru_week3']['INBOUND'] / $data['plan_mru_week3']['INBOUND'] * 100, 1));
        $sheet->setCellValue('F26', ($data['plan_mru_week4']['INBOUND'] == 0) ? '' : round($data['mru_week4']['INBOUND'] / $data['plan_mru_week4']['INBOUND'] * 100, 1));
        $sheet->setCellValue('G26', ($data['plan_mru_week5']['INBOUND'] == 0) ? '' : round($data['mru_week5']['INBOUND'] / $data['plan_mru_week5']['INBOUND'] * 100, 1));
        $sheet->setCellValue('H26', ($data['plan_mru_act']['INBOUND'] == 0) ? '' : round($data['mru_act']['INBOUND'] / $data['plan_mru_act']['INBOUND'] * 100, 1));


        // set height
        // $spreadsheet->getActiveSheet()->getRowDimension(3)->setRowHeight(45);

        $file_name = 'Performance SUBANG - ' . $data['bulan'] . ' ' . $tahun . '.xlsx';


        $writer = new Xlsx($spreadsheet);

        $writer->save($file_name);

        header("Content-Type: application/vnd.ms-excel");

        header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');

        header('Expires: 0');

        header('Cache-Control: must-revalidate');

        header('Pragma: public');

        header('Content-Length:' . filesize($file_name));

        flush();

        readfile($file_name);
        @unlink($file_name);

        exit;
    }



    public function inboundDetail()
    {
        $this->permissionCheck('inbound_detail');

        $this->updatePageData([
            'title' => 'Laporan Inbound Detail',
            'submenu' => 'inbound_list',
        ]);

        $bulan = ($this->request->getVar('bulan')) ? $this->request->getVar('bulan') : intval(date('m'));
        $tahun = ($this->request->getVar('tahun')) ? $this->request->getVar('tahun') : intval(date('Y'));

        $date1 = $tahun . '-' . $bulan . '-' . '01';
        // 👇 get the timestamp of the date
        $date = strtotime($date1);
        // $date = strtotime("2nd January 2022");

        // 👇 get the last date for that month
        $last_date = date("Y-m-t", $date);

        // print $last_date; // 2022-01-31

        $range_date = getDatesFromRange($date1, $last_date);
        $data_end_range = end($range_date);

        if ($last_date != $data_end_range) {
            $range_date[] = $last_date;
        }
        // dd($range_date);
        $data = [
            'title' => 'Dashboard Detail',
            'tahun' => $tahun,
            'range_date' => $range_date,
            'id_bulan' => $bulan,
            'bulan' => date('F', strtotime(date('Y-' . $bulan . '-d')))
        ];

        return view($this->view . '/inbound_detail', $data);
    }

    public function ajaxInboundDetail()
    {
        $this->permissionCheck('inbound_detail');
        $bulan = ($this->request->getVar('bulan')) ? $this->request->getVar('bulan') : intval(date('m'));
        $tahun = ($this->request->getVar('tahun')) ? $this->request->getVar('tahun') : intval(date('Y'));

        $date1 = $tahun . '-' . $bulan . '-' . '01';
        // 👇 get the timestamp of the date
        $date = strtotime($date1);
        // $date = strtotime("2nd January 2022");

        // 👇 get the last date for that month
        $last_date = date("Y-m-t", $date);

        // print $last_date; // 2022-01-31

        $range_date = getDatesFromRange($date1, $last_date);
        $data_end_range = end($range_date);

        if ($last_date != $data_end_range) {
            $range_date[] = $last_date;
        }
        // dd($range_date);
        $data = [
            'title' => 'Dashboard Detail',
            'tahun' => $tahun,
            'range_date' => $range_date,
            'id_bulan' => $bulan,
            'bulan' => date('F', strtotime(date('Y-' . $bulan . '-d')))
        ];

        return view($this->view . '/inbound_detail_ajax', $data);
    }

    public function exportInboundDetail()
    {
        $this->permissionCheck('inbound_detail_export');
        $bulan = ($this->request->getVar('bulan')) ? $this->request->getVar('bulan') : intval(date('m'));
        $tahun = ($this->request->getVar('tahun')) ? $this->request->getVar('tahun') : intval(date('Y'));

        $date1 = $tahun . '-' . $bulan . '-' . '01';
        // 👇 get the timestamp of the date
        $date = strtotime($date1);
        // $date = strtotime("2nd January 2022");

        // 👇 get the last date for that month
        $last_date = date("Y-m-t", $date);

        // print $last_date; // 2022-01-31

        $range_date = getDatesFromRange($date1, $last_date);
        $data_end_range = end($range_date);

        if ($last_date != $data_end_range) {
            $range_date[] = $last_date;
        }
        // dd($range_date);
        $data = [
            'title' => 'Dashboard Detail',
            'range_date' => $range_date,
            'id_bulan' => $bulan,
            'bulan' => date('F', strtotime(date('Y-' . $bulan . '-d')))
        ];

        // phpoffice/phpspreadsheet
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle("DETAIL - " . $data['bulan'] . ' ' . $tahun);

        $rowLabel = 1;

        $lineFreeze = 2;

        // $sheet->freezePane('A' . $lineFreeze);
        // // Freeze second line:
        // $sheet->freezePane('E' . $lineFreeze);

        // set bold
        $sheet->getStyle('A' . $rowLabel . ':N' . $rowLabel . '')->getFont()->setBold(true);

        // set wrap text
        $sheet->getStyle('A' . $rowLabel . ':N' . $rowLabel . '')->getAlignment()->setWrapText(true);

        //  biar gak dempet karena autosize

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->mergeCells("A1:B2");


        $sheet->setCellValue('A' . $rowLabel, 'SUBANG');
        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('C' . $rowLabel, $data['bulan'] . ' ' . $tahun);
        $spreadsheet->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal('center');
        $rowWeek = $rowLabel + 1;

        $abjad = [
            'A',
            'B',
            'C',
            'D',
            'E',
            'F',
            'G',
            'H',
            'I',
            'J',
            'K',
            'L',
            'M',
            'N',
            'O',
            'P',
            'Q',
            'R',
            'S',
            'T',
            'U',
            'V',
            'W',
            'X',
            'Y',
            'Z',
            'AA',
            'AB',
            'AC',
            'AD',
            'AE',
            'AF',
            'AG',
            'AH',
            'AI',
            'AJ',
            'AK',
            'AL',
            'AM',
            'AN',
            'AO',
            'AP',
            'AQ',
            'AR',
            'AS',
            'AT',
            'AU',
            'AV',
            'AW',
            'AX',
            'AY',
            'AZ',
        ];
        $startDate = 'C';




        // CREATE DATE
        $in = 2;
        $abjadStart = $abjad[$in];
        foreach ($range_date as $d) {
            $sheet->setCellValue($abjad[$in] . $rowWeek, date('d', strtotime($d)));
            $abjadEnd = $abjad[$in];
            $in++;
        }

        $spreadsheet->getActiveSheet()->mergeCells($abjadStart . "1:" . $abjad[$in] . "1");

        $sheet->setCellValue($abjad[$in] . $rowWeek, 'ACT');


        // total
        $spreadsheet->getActiveSheet()->mergeCells("A3:A5");
        $spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical('center');
        $sheet->setCellValue('A3', 'TOTAL');
        $sheet->setCellValue('B3', 'Plan');

        $in = 2;
        $rowWeek = 3;
        $abjadStart = $abjad[$in];
        $plan = [];
        $a = 0;
        foreach ($range_date as $d) {
            $res = $this->modelinbound->getDataInbound(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d)['INBOUND'];
            $plan[$a] = (is_null($res)) ? 0 : $res;
            $sheet->setCellValue($abjad[$in] . $rowWeek, (is_null($res)) ? '' : $res);
            $abjadEnd = $abjad[$in];
            $a++;
            $in++;
        }

        $sheet->setCellValue($abjad[$in] . $rowWeek, array_sum($plan));


        $sheet->setCellValue('B4', 'ACT');

        $in = 2;
        $rowWeek = 4;
        $abjadStart = $abjad[$in];
        $actual = [];
        $a = 0;
        foreach ($range_date as $d) {
            $res = $this->modelpcs->getDataInbound(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d)['INBOUND'];
            $actual[$a] = (is_null($res)) ? 0 : $res;
            $sheet->setCellValue($abjad[$in] . $rowWeek, (is_null($res)) ? '' : $res);
            $abjadEnd = $abjad[$in];
            $a++;
            $in++;
        }


        $sheet->setCellValue($abjad[$in] . $rowWeek, array_sum($actual));


        $sheet->setCellValue('B5', '%');

        $in = 2;
        $rowWeek = 5;
        $abjadStart = $abjad[$in];
        $a = 0;
        foreach ($range_date as $d) {
            $res = ($plan[$a] == 0 || $actual[$a] == 0) ? '' : round(($actual[$a] / $plan[$a] * 100), 1);
            $sheet->setCellValue($abjad[$in] . $rowWeek, (is_null($res)) ? '' : $res);
            $abjadEnd = $abjad[$in];
            $a++;
            $in++;
        }


        $sheet->setCellValue($abjad[$in] . $rowWeek, (array_sum($plan) == 0 || array_sum($actual) == 0) ? '' : round(array_sum($actual) / array_sum($plan) * 100, 1));


        // PIRELLI
        $spreadsheet->getActiveSheet()->mergeCells("A6:A8");
        $spreadsheet->getActiveSheet()->getStyle('A6')->getAlignment()->setVertical('center');
        $sheet->setCellValue('A6', 'PIRELLI');
        $sheet->setCellValue('B6', 'Plan');

        $in = 2;
        $rowWeek = 6;
        $abjadStart = $abjad[$in];
        $plan = [];
        $a = 0;
        foreach ($range_date as $d) {
            $res = $this->modelinbound->getDataInbound(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d, brand: "PIRELLI")['INBOUND'];
            $plan[$a] = (is_null($res)) ? 0 : $res;
            $sheet->setCellValue($abjad[$in] . $rowWeek, (is_null($res)) ? '' : $res);
            $abjadEnd = $abjad[$in];
            $a++;
            $in++;
        }

        $sheet->setCellValue($abjad[$in] . $rowWeek, array_sum($plan));


        $sheet->setCellValue('B7', 'ACT');

        $in = 2;
        $rowWeek = 7;
        $abjadStart = $abjad[$in];
        $actual = [];
        $a = 0;
        foreach ($range_date as $d) {
            $res = $this->modelpcs->getDataInbound(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d, brand: "PIRELLI")['INBOUND'];
            $actual[$a] = (is_null($res)) ? 0 : $res;
            $sheet->setCellValue($abjad[$in] . $rowWeek, (is_null($res)) ? '' : $res);
            $abjadEnd = $abjad[$in];
            $a++;
            $in++;
        }


        $sheet->setCellValue($abjad[$in] . $rowWeek, array_sum($actual));


        $sheet->setCellValue('B8', '%');

        $in = 2;
        $rowWeek = 8;
        $abjadStart = $abjad[$in];
        $a = 0;
        foreach ($range_date as $d) {
            $res = ($plan[$a] == 0 || $actual[$a] == 0) ? '' : round(($actual[$a] / $plan[$a] * 100), 1);
            $sheet->setCellValue($abjad[$in] . $rowWeek, (is_null($res)) ? '' : $res);
            $abjadEnd = $abjad[$in];
            $a++;
            $in++;
        }


        $sheet->setCellValue($abjad[$in] . $rowWeek, (array_sum($plan) == 0 || array_sum($actual) == 0) ? '' : round(array_sum($actual) / array_sum($plan) * 100, 1));


        // ASPIRA
        $spreadsheet->getActiveSheet()->mergeCells("A9:A11");
        $spreadsheet->getActiveSheet()->getStyle('A9')->getAlignment()->setVertical('center');
        $sheet->setCellValue('A9', 'ASPIRA');
        $sheet->setCellValue('B9', 'Plan');

        $in = 2;
        $rowWeek = 9;
        $abjadStart = $abjad[$in];
        $plan = [];
        $a = 0;
        foreach ($range_date as $d) {
            $res = $this->modelinbound->getDataInbound(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d, brand: "ASPIRA")['INBOUND'];
            $plan[$a] = (is_null($res)) ? 0 : $res;
            $sheet->setCellValue($abjad[$in] . $rowWeek, (is_null($res)) ? '' : $res);
            $abjadEnd = $abjad[$in];
            $a++;
            $in++;
        }

        $sheet->setCellValue($abjad[$in] . $rowWeek, array_sum($plan));


        $sheet->setCellValue('B10', 'ACT');

        $in = 2;
        $rowWeek = 10;
        $abjadStart = $abjad[$in];
        $actual = [];
        $a = 0;
        foreach ($range_date as $d) {
            $res = $this->modelpcs->getDataInbound(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d, brand: "ASPIRA")['INBOUND'];
            $actual[$a] = (is_null($res)) ? 0 : $res;
            $sheet->setCellValue($abjad[$in] . $rowWeek, (is_null($res)) ? '' : $res);
            $abjadEnd = $abjad[$in];
            $a++;
            $in++;
        }


        $sheet->setCellValue($abjad[$in] . $rowWeek, array_sum($actual));


        $sheet->setCellValue('B11', '%');

        $in = 2;
        $rowWeek = 11;
        $abjadStart = $abjad[$in];
        $a = 0;
        foreach ($range_date as $d) {
            $res = ($plan[$a] == 0 || $actual[$a] == 0) ? '' : round(($actual[$a] / $plan[$a] * 100), 1);
            $sheet->setCellValue($abjad[$in] . $rowWeek, (is_null($res)) ? '' : $res);
            $abjadEnd = $abjad[$in];
            $a++;
            $in++;
        }


        $sheet->setCellValue($abjad[$in] . $rowWeek, (array_sum($plan) == 0 || array_sum($actual) == 0) ? '' : round(array_sum($actual) / array_sum($plan) * 100, 1));


        // OE
        $spreadsheet->getActiveSheet()->mergeCells("A12:A14");
        $spreadsheet->getActiveSheet()->getStyle('A12')->getAlignment()->setVertical('center');
        $sheet->setCellValue('A12', 'OE');
        $sheet->setCellValue('B12', 'Plan');

        $in = 2;
        $rowWeek = 12;
        $abjadStart = $abjad[$in];
        $plan = [];
        $a = 0;
        foreach ($range_date as $d) {
            $res = $this->modelinbound->getDataInbound(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d, cost_center: '10')['INBOUND'];
            $plan[$a] = (is_null($res)) ? 0 : $res;
            $sheet->setCellValue($abjad[$in] . $rowWeek, (is_null($res)) ? '' : $res);
            $abjadEnd = $abjad[$in];
            $a++;
            $in++;
        }

        $sheet->setCellValue($abjad[$in] . $rowWeek, array_sum($plan));


        $sheet->setCellValue('B13', 'ACT');

        $in = 2;
        $rowWeek = 13;
        $abjadStart = $abjad[$in];
        $actual = [];
        $a = 0;
        foreach ($range_date as $d) {
            $res = $this->modelpcs->getDataInbound(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d, cost_center: '10')['INBOUND'];
            $actual[$a] = (is_null($res)) ? 0 : $res;
            $sheet->setCellValue($abjad[$in] . $rowWeek, (is_null($res)) ? '' : $res);
            $abjadEnd = $abjad[$in];
            $a++;
            $in++;
        }


        $sheet->setCellValue($abjad[$in] . $rowWeek, array_sum($actual));


        $sheet->setCellValue('B14', '%');

        $in = 2;
        $rowWeek = 14;
        $abjadStart = $abjad[$in];
        $a = 0;
        foreach ($range_date as $d) {
            $res = ($plan[$a] == 0 || $actual[$a] == 0) ? '' : round(($actual[$a] / $plan[$a] * 100), 1);
            $sheet->setCellValue($abjad[$in] . $rowWeek, (is_null($res)) ? '' : $res);
            $abjadEnd = $abjad[$in];
            $a++;
            $in++;
        }


        $sheet->setCellValue($abjad[$in] . $rowWeek, (array_sum($plan) == 0 || array_sum($actual) == 0) ? '' : round(array_sum($actual) / array_sum($plan) * 100, 1));


        // RPLC
        $spreadsheet->getActiveSheet()->mergeCells("A15:A17");
        $spreadsheet->getActiveSheet()->getStyle('A15')->getAlignment()->setVertical('center');
        $sheet->setCellValue('A15', 'RPLC');
        $sheet->setCellValue('B15', 'Plan');

        $in = 2;
        $rowWeek = 15;
        $abjadStart = $abjad[$in];
        $plan = [];
        $a = 0;
        foreach ($range_date as $d) {
            $res = $this->modelinbound->getDataInbound(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d, cost_center: '00')['INBOUND'];
            $plan[$a] = (is_null($res)) ? 0 : $res;
            $sheet->setCellValue($abjad[$in] . $rowWeek, (is_null($res)) ? '' : $res);
            $abjadEnd = $abjad[$in];
            $a++;
            $in++;
        }

        $sheet->setCellValue($abjad[$in] . $rowWeek, array_sum($plan));


        $sheet->setCellValue('B16', 'ACT');

        $in = 2;
        $rowWeek = 16;
        $abjadStart = $abjad[$in];
        $actual = [];
        $a = 0;
        foreach ($range_date as $d) {
            $res = $this->modelpcs->getDataInbound(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d, cost_center: '00')['INBOUND'];
            $actual[$a] = (is_null($res)) ? 0 : $res;
            $sheet->setCellValue($abjad[$in] . $rowWeek, (is_null($res)) ? '' : $res);
            $abjadEnd = $abjad[$in];
            $a++;
            $in++;
        }


        $sheet->setCellValue($abjad[$in] . $rowWeek, array_sum($actual));


        $sheet->setCellValue('B17', '%');

        $in = 2;
        $rowWeek = 17;
        $abjadStart = $abjad[$in];
        $a = 0;
        foreach ($range_date as $d) {
            $res = ($plan[$a] == 0 || $actual[$a] == 0) ? '' : round(($actual[$a] / $plan[$a] * 100), 1);
            $sheet->setCellValue($abjad[$in] . $rowWeek, (is_null($res)) ? '' : $res);
            $abjadEnd = $abjad[$in];
            $a++;
            $in++;
        }


        $sheet->setCellValue($abjad[$in] . $rowWeek, (array_sum($plan) == 0 || array_sum($actual) == 0) ? '' : round(array_sum($actual) / array_sum($plan) * 100, 1));


        // BTU
        $spreadsheet->getActiveSheet()->mergeCells("A18:A20");
        $spreadsheet->getActiveSheet()->getStyle('A18')->getAlignment()->setVertical('center');
        $sheet->setCellValue('A18', 'BTU');
        $sheet->setCellValue('B18', 'Plan');

        $in = 2;
        $rowWeek = 18;
        $abjadStart = $abjad[$in];
        $plan = [];
        $a = 0;
        foreach ($range_date as $d) {
            $res = $this->modelinbound->getDataInbound(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d, mch_type: 'BTU')['INBOUND'];
            $plan[$a] = (is_null($res)) ? 0 : $res;
            $sheet->setCellValue($abjad[$in] . $rowWeek, (is_null($res)) ? '' : $res);
            $abjadEnd = $abjad[$in];
            $a++;
            $in++;
        }

        $sheet->setCellValue($abjad[$in] . $rowWeek, array_sum($plan));


        $sheet->setCellValue('B19', 'ACT');

        $in = 2;
        $rowWeek = 19;
        $abjadStart = $abjad[$in];
        $actual = [];
        $a = 0;
        foreach ($range_date as $d) {
            $res = $this->modelpcs->getDataInbound(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d, mch_type: 'BTU')['INBOUND'];
            $actual[$a] = (is_null($res)) ? 0 : $res;
            $sheet->setCellValue($abjad[$in] . $rowWeek, (is_null($res)) ? '' : $res);
            $abjadEnd = $abjad[$in];
            $a++;
            $in++;
        }


        $sheet->setCellValue($abjad[$in] . $rowWeek, array_sum($actual));


        $sheet->setCellValue('B20', '%');

        $in = 2;
        $rowWeek = 20;
        $abjadStart = $abjad[$in];
        $a = 0;
        foreach ($range_date as $d) {
            $res = ($plan[$a] == 0 || $actual[$a] == 0) ? '' : round(($actual[$a] / $plan[$a] * 100), 1);
            $sheet->setCellValue($abjad[$in] . $rowWeek, (is_null($res)) ? '' : $res);
            $abjadEnd = $abjad[$in];
            $a++;
            $in++;
        }


        $sheet->setCellValue($abjad[$in] . $rowWeek, (array_sum($plan) == 0 || array_sum($actual) == 0) ? '' : round(array_sum($actual) / array_sum($plan) * 100, 1));


        // STU
        $spreadsheet->getActiveSheet()->mergeCells("A21:A23");
        $spreadsheet->getActiveSheet()->getStyle('A21')->getAlignment()->setVertical('center');
        $sheet->setCellValue('A21', 'STU');
        $sheet->setCellValue('B21', 'Plan');

        $in = 2;
        $rowWeek = 21;
        $abjadStart = $abjad[$in];
        $plan = [];
        $a = 0;
        foreach ($range_date as $d) {
            $res = $this->modelinbound->getDataInbound(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d, mch_type: 'STU')['INBOUND'];
            $plan[$a] = (is_null($res)) ? 0 : $res;
            $sheet->setCellValue($abjad[$in] . $rowWeek, (is_null($res)) ? '' : $res);
            $abjadEnd = $abjad[$in];
            $a++;
            $in++;
        }

        $sheet->setCellValue($abjad[$in] . $rowWeek, array_sum($plan));


        $sheet->setCellValue('B22', 'ACT');

        $in = 2;
        $rowWeek = 22;
        $abjadStart = $abjad[$in];
        $actual = [];
        $a = 0;
        foreach ($range_date as $d) {
            $res = $this->modelpcs->getDataInbound(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d, mch_type: 'STU')['INBOUND'];
            $actual[$a] = (is_null($res)) ? 0 : $res;
            $sheet->setCellValue($abjad[$in] . $rowWeek, (is_null($res)) ? '' : $res);
            $abjadEnd = $abjad[$in];
            $a++;
            $in++;
        }


        $sheet->setCellValue($abjad[$in] . $rowWeek, array_sum($actual));


        $sheet->setCellValue('B23', '%');

        $in = 2;
        $rowWeek = 23;
        $abjadStart = $abjad[$in];
        $a = 0;
        foreach ($range_date as $d) {
            $res = ($plan[$a] == 0 || $actual[$a] == 0) ? '' : round(($actual[$a] / $plan[$a] * 100), 1);
            $sheet->setCellValue($abjad[$in] . $rowWeek, (is_null($res)) ? '' : $res);
            $abjadEnd = $abjad[$in];
            $a++;
            $in++;
        }


        $sheet->setCellValue($abjad[$in] . $rowWeek, (array_sum($plan) == 0 || array_sum($actual) == 0) ? '' : round(array_sum($actual) / array_sum($plan) * 100, 1));


        // MRU
        $spreadsheet->getActiveSheet()->mergeCells("A24:A26");
        $spreadsheet->getActiveSheet()->getStyle('A24')->getAlignment()->setVertical('center');
        $sheet->setCellValue('A24', 'MRU');
        $sheet->setCellValue('B24', 'Plan');

        $in = 2;
        $rowWeek = 24;
        $abjadStart = $abjad[$in];
        $plan = [];
        $a = 0;
        foreach ($range_date as $d) {
            $res = $this->modelinbound->getDataInbound(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d, mch_type: 'MRU')['INBOUND'];
            $plan[$a] = (is_null($res)) ? 0 : $res;
            $sheet->setCellValue($abjad[$in] . $rowWeek, (is_null($res)) ? '' : $res);
            $abjadEnd = $abjad[$in];
            $a++;
            $in++;
        }

        $sheet->setCellValue($abjad[$in] . $rowWeek, array_sum($plan));


        $sheet->setCellValue('B25', 'ACT');

        $in = 2;
        $rowWeek = 25;
        $abjadStart = $abjad[$in];
        $actual = [];
        $a = 0;
        foreach ($range_date as $d) {
            $res = $this->modelpcs->getDataInbound(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d, mch_type: 'MRU')['INBOUND'];
            $actual[$a] = (is_null($res)) ? 0 : $res;
            $sheet->setCellValue($abjad[$in] . $rowWeek, (is_null($res)) ? '' : $res);
            $abjadEnd = $abjad[$in];
            $a++;
            $in++;
        }


        $sheet->setCellValue($abjad[$in] . $rowWeek, array_sum($actual));


        $sheet->setCellValue('B26', '%');

        $in = 2;
        $rowWeek = 26;
        $abjadStart = $abjad[$in];
        $a = 0;
        foreach ($range_date as $d) {
            $res = ($plan[$a] == 0 || $actual[$a] == 0) ? '' : round(($actual[$a] / $plan[$a] * 100), 1);
            $sheet->setCellValue($abjad[$in] . $rowWeek, (is_null($res)) ? '' : $res);
            $abjadEnd = $abjad[$in];
            $a++;
            $in++;
        }


        $sheet->setCellValue($abjad[$in] . $rowWeek, (array_sum($plan) == 0 || array_sum($actual) == 0) ? '' : round(array_sum($actual) / array_sum($plan) * 100, 1));





        $file_name = 'Performance SUBANG Detail - ' . $data['bulan'] . ' ' . $tahun . '.xlsx';


        $writer = new Xlsx($spreadsheet);

        $writer->save($file_name);

        header("Content-Type: application/vnd.ms-excel");

        header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');

        header('Expires: 0');

        header('Cache-Control: must-revalidate');

        header('Pragma: public');

        header('Content-Length:' . filesize($file_name));

        flush();

        readfile($file_name);
        @unlink($file_name);

        exit;
    }


    private function inboundChartWeekly($type = 'line')
    {
        $bulan = ($this->request->getVar('bulan')) ? $this->request->getVar('bulan') : intval(date('m'));
        $tahun = ($this->request->getVar('tahun')) ? $this->request->getVar('tahun') : intval(date('Y'));


        if ($type == 'line') {
            $week1 = idate('W', strtotime($tahun . '-' . $bulan . '-' . '01'));
            $week2 = idate('W', strtotime($tahun . '-' . $bulan . '-' . (1 + 7)));
            $week3 = idate('W', strtotime($tahun . '-' . $bulan . '-' . (1 + (7 * 2))));
            $week4 = idate('W', strtotime($tahun . '-' . $bulan . '-' . (1 + (7 * 3))));
            $week5 = idate('W', strtotime($tahun . '-' . $bulan . '-' . (1 + (7 * 4))));


            $data = [
                'title' => 'Report',
                'tahun' => $tahun,
                // 'rim_list' => $this->modelpcs->getRimList($tahun, $bulan, 0),
                'total_week1' => $this->modelpcs->getDataInbound($tahun, $bulan, $week1),
                'total_week2' => $this->modelpcs->getDataInbound($tahun, $bulan, $week2),
                'total_week3' => $this->modelpcs->getDataInbound($tahun, $bulan, $week3),
                'total_week4' => $this->modelpcs->getDataInbound($tahun, $bulan, $week4),
                'total_week5' => $this->modelpcs->getDataInbound($tahun, $bulan, $week5),

                'plan_total_week1' => $this->modelinbound->getDataInbound($tahun, $bulan, $week1),
                'plan_total_week2' => $this->modelinbound->getDataInbound($tahun, $bulan, $week2),
                'plan_total_week3' => $this->modelinbound->getDataInbound($tahun, $bulan, $week3),
                'plan_total_week4' => $this->modelinbound->getDataInbound($tahun, $bulan, $week4),
                'plan_total_week5' => $this->modelinbound->getDataInbound($tahun, $bulan, $week5),


                'total_act' => $this->modelpcs->getDataInbound($tahun, $bulan, 0, null, null, null, null, null, 'week'),
                'plan_total_act' => $this->modelinbound->getDataInbound($tahun, $bulan, 0, null, null, null, null, null, 'week'),

                'pirelli_week1' => $this->modelpcs->getDataInbound($tahun, $bulan, $week1, 'PIRELLi'),
                'pirelli_week2' => $this->modelpcs->getDataInbound($tahun, $bulan, $week2, 'PIRELLi'),
                'pirelli_week3' => $this->modelpcs->getDataInbound($tahun, $bulan, $week3, 'PIRELLi'),
                'pirelli_week4' => $this->modelpcs->getDataInbound($tahun, $bulan, $week4, 'PIRELLi'),
                'pirelli_week5' => $this->modelpcs->getDataInbound($tahun, $bulan, $week5, 'PIRELLi'),

                'plan_pirelli_week1' => $this->modelinbound->getDataInbound($tahun, $bulan, $week1, 'PIRELLi'),
                'plan_pirelli_week2' => $this->modelinbound->getDataInbound($tahun, $bulan, $week2, 'PIRELLi'),
                'plan_pirelli_week3' => $this->modelinbound->getDataInbound($tahun, $bulan, $week3, 'PIRELLi'),
                'plan_pirelli_week4' => $this->modelinbound->getDataInbound($tahun, $bulan, $week4, 'PIRELLi'),
                'plan_pirelli_week5' => $this->modelinbound->getDataInbound($tahun, $bulan, $week5, 'PIRELLi'),

                'plan_pirelli_act' => $this->modelinbound->getDataInbound($tahun, $bulan, 0, 'PIRELLi',  null, null, null, null, 'week'),

                'pirelli_act' => $this->modelpcs->getDataInbound($tahun, $bulan, 0, 'PIRELLi',  null, null, null, null, 'week'),
                'aspira_week1' => $this->modelpcs->getDataInbound($tahun, $bulan, $week1, 'aspira'),
                'aspira_week2' => $this->modelpcs->getDataInbound($tahun, $bulan, $week2, 'aspira'),
                'aspira_week3' => $this->modelpcs->getDataInbound($tahun, $bulan, $week3, 'aspira'),
                'aspira_week4' => $this->modelpcs->getDataInbound($tahun, $bulan, $week4, 'aspira'),
                'aspira_week5' => $this->modelpcs->getDataInbound($tahun, $bulan, $week5, 'aspira'),
                'aspira_act' => $this->modelpcs->getDataInbound($tahun, $bulan, 0, 'aspira',  null, null, null, null, 'week'),

                'plan_aspira_week1' => $this->modelinbound->getDataInbound($tahun, $bulan, $week1, 'aspira'),
                'plan_aspira_week2' => $this->modelinbound->getDataInbound($tahun, $bulan, $week2, 'aspira'),
                'plan_aspira_week3' => $this->modelinbound->getDataInbound($tahun, $bulan, $week3, 'aspira'),
                'plan_aspira_week4' => $this->modelinbound->getDataInbound($tahun, $bulan, $week4, 'aspira'),
                'plan_aspira_week5' => $this->modelinbound->getDataInbound($tahun, $bulan, $week5, 'aspira'),
                'plan_aspira_act' => $this->modelinbound->getDataInbound($tahun, $bulan, 0, 'aspira',  null, null, null, null, 'week'),

                'plan_oe_week1' => $this->modelinbound->getDataInbound($tahun, $bulan, $week1, null, null, '10'),
                'plan_oe_week2' => $this->modelinbound->getDataInbound($tahun, $bulan, $week2, null, null, '10'),
                'plan_oe_week3' => $this->modelinbound->getDataInbound($tahun, $bulan, $week3, null, null, '10'),
                'plan_oe_week4' => $this->modelinbound->getDataInbound($tahun, $bulan, $week4, null, null, '10'),
                'plan_oe_week5' => $this->modelinbound->getDataInbound($tahun, $bulan, $week5, null, null, '10'),
                'plan_oe_act' => $this->modelinbound->getDataInbound($tahun, $bulan, 0, null, null, '10', null, null, 'week'),

                'oe_week1' => $this->modelpcs->getDataInbound($tahun, $bulan, $week1, null, null, '10'),
                'oe_week2' => $this->modelpcs->getDataInbound($tahun, $bulan, $week2, null, null, '10'),
                'oe_week3' => $this->modelpcs->getDataInbound($tahun, $bulan, $week3, null, null, '10'),
                'oe_week4' => $this->modelpcs->getDataInbound($tahun, $bulan, $week4, null, null, '10'),
                'oe_week5' => $this->modelpcs->getDataInbound($tahun, $bulan, $week5, null, null, '10'),
                'oe_act' => $this->modelpcs->getDataInbound($tahun, $bulan, 0, null, null, '10', null, null, 'week'),


                'plan_rem_week1' => $this->modelinbound->getDataInbound($tahun, $bulan, $week1, null, null, '00'),
                'plan_rem_week2' => $this->modelinbound->getDataInbound($tahun, $bulan, $week2, null, null, '00'),
                'plan_rem_week3' => $this->modelinbound->getDataInbound($tahun, $bulan, $week3, null, null, '00'),
                'plan_rem_week4' => $this->modelinbound->getDataInbound($tahun, $bulan, $week4, null, null, '00'),
                'plan_rem_week5' => $this->modelinbound->getDataInbound($tahun, $bulan, $week5, null, null, '00'),
                'plan_rem_act' => $this->modelinbound->getDataInbound($tahun, $bulan, 0, null, null, '00', null, null, 'week'),

                'rem_week1' => $this->modelpcs->getDataInbound($tahun, $bulan, $week1, null, null, '00'),
                'rem_week2' => $this->modelpcs->getDataInbound($tahun, $bulan, $week2, null, null, '00'),
                'rem_week3' => $this->modelpcs->getDataInbound($tahun, $bulan, $week3, null, null, '00'),
                'rem_week4' => $this->modelpcs->getDataInbound($tahun, $bulan, $week4, null, null, '00'),
                'rem_week5' => $this->modelpcs->getDataInbound($tahun, $bulan, $week5, null, null, '00'),
                'rem_act' => $this->modelpcs->getDataInbound($tahun, $bulan, 0, null, null, '00', null, null, 'week'),

                'plan_btu_week1' => $this->modelinbound->getDataInbound($tahun, $bulan, $week1, null, null, null, 'BTU'),
                'plan_btu_week2' => $this->modelinbound->getDataInbound($tahun, $bulan, $week2, null, null, null, 'BTU'),
                'plan_btu_week3' => $this->modelinbound->getDataInbound($tahun, $bulan, $week3, null, null, null, 'BTU'),
                'plan_btu_week4' => $this->modelinbound->getDataInbound($tahun, $bulan, $week4, null, null, null, 'BTU'),
                'plan_btu_week5' => $this->modelinbound->getDataInbound($tahun, $bulan, $week5, null, null, null, 'BTU'),
                'plan_btu_act' => $this->modelinbound->getDataInbound($tahun, $bulan, 0, null, null, null, 'BTU', null, 'week'),

                'btu_week1' => $this->modelpcs->getDataInbound($tahun, $bulan, $week1, null, null, null, 'BTU'),
                'btu_week2' => $this->modelpcs->getDataInbound($tahun, $bulan, $week2, null, null, null, 'BTU'),
                'btu_week3' => $this->modelpcs->getDataInbound($tahun, $bulan, $week3, null, null, null, 'BTU'),
                'btu_week4' => $this->modelpcs->getDataInbound($tahun, $bulan, $week4, null, null, null, 'BTU'),
                'btu_week5' => $this->modelpcs->getDataInbound($tahun, $bulan, $week5, null, null, null, 'BTU'),
                'btu_act' => $this->modelpcs->getDataInbound($tahun, $bulan, 0, null, null, null, 'BTU', null, 'week'),


                'plan_stu_week1' => $this->modelinbound->getDataInbound($tahun, $bulan, $week1, null, null, null, 'stu'),
                'plan_stu_week2' => $this->modelinbound->getDataInbound($tahun, $bulan, $week2, null, null, null, 'stu'),
                'plan_stu_week3' => $this->modelinbound->getDataInbound($tahun, $bulan, $week3, null, null, null, 'stu'),
                'plan_stu_week4' => $this->modelinbound->getDataInbound($tahun, $bulan, $week4, null, null, null, 'stu'),
                'plan_stu_week5' => $this->modelinbound->getDataInbound($tahun, $bulan, $week5, null, null, null, 'stu'),
                'plan_stu_act' => $this->modelinbound->getDataInbound($tahun, $bulan, 0, null, null, null, 'stu', null, 'week'),

                'stu_week1' => $this->modelpcs->getDataInbound($tahun, $bulan, $week1, null, null, null, 'stu'),
                'stu_week2' => $this->modelpcs->getDataInbound($tahun, $bulan, $week2, null, null, null, 'stu'),
                'stu_week3' => $this->modelpcs->getDataInbound($tahun, $bulan, $week3, null, null, null, 'stu'),
                'stu_week4' => $this->modelpcs->getDataInbound($tahun, $bulan, $week4, null, null, null, 'stu'),
                'stu_week5' => $this->modelpcs->getDataInbound($tahun, $bulan, $week5, null, null, null, 'stu'),
                'stu_act' => $this->modelpcs->getDataInbound($tahun, $bulan, 0, null, null, null, 'stu', null, 'week'),


                'plan_mru_week1' => $this->modelinbound->getDataInbound($tahun, $bulan, $week1, null, null, null, 'mru'),
                'plan_mru_week2' => $this->modelinbound->getDataInbound($tahun, $bulan, $week2, null, null, null, 'mru'),
                'plan_mru_week3' => $this->modelinbound->getDataInbound($tahun, $bulan, $week3, null, null, null, 'mru'),
                'plan_mru_week4' => $this->modelinbound->getDataInbound($tahun, $bulan, $week4, null, null, null, 'mru'),
                'plan_mru_week5' => $this->modelinbound->getDataInbound($tahun, $bulan, $week5, null, null, null, 'mru'),
                'plan_mru_act' => $this->modelinbound->getDataInbound($tahun, $bulan, 0, null, null, null, 'mru', null, 'week'),

                'mru_week1' => $this->modelpcs->getDataInbound($tahun, $bulan, $week1, null, null, null, 'mru'),
                'mru_week2' => $this->modelpcs->getDataInbound($tahun, $bulan, $week2, null, null, null, 'mru'),
                'mru_week3' => $this->modelpcs->getDataInbound($tahun, $bulan, $week3, null, null, null, 'mru'),
                'mru_week4' => $this->modelpcs->getDataInbound($tahun, $bulan, $week4, null, null, null, 'mru'),
                'mru_week5' => $this->modelpcs->getDataInbound($tahun, $bulan, $week5, null, null, null, 'mru'),
                'mru_act' => $this->modelpcs->getDataInbound($tahun, $bulan, 0, null, null, null, 'mru', null, 'week'),

                'id_bulan' => $bulan,
                'bulan' => date('F', strtotime(date('Y-' . $bulan . '-d')))
            ];

            $total = [];
            $total[] = ($data['total_week1'] == '' || $data['plan_total_week1'] == '') ? 0 : round(($data['total_week1'] / $data['plan_total_week1']) * 100, 1);
            $total[] = ($data['total_week2'] == '' || $data['plan_total_week2'] == '') ? 0 : round(($data['total_week2'] / $data['plan_total_week2']) * 100, 1);
            $total[] = ($data['total_week3'] == '' || $data['plan_total_week3'] == '') ? 0 : round(($data['total_week3'] / $data['plan_total_week3']) * 100, 1);
            $total[] = ($data['total_week4'] == '' || $data['plan_total_week4'] == '') ? 0 : round(($data['total_week4'] / $data['plan_total_week4']) * 100, 1);
            $total[] = ($data['total_week5'] == '' || $data['plan_total_week5'] == '') ? 0 : round(($data['total_week5'] / $data['plan_total_week5']) * 100, 1);

            $pirelli = [];
            $pirelli[] = ($data['pirelli_week1'] == '' || $data['plan_pirelli_week1'] == '') ? 0 : round(($data['pirelli_week1'] / $data['plan_pirelli_week1']) * 100, 1);
            $pirelli[] = ($data['pirelli_week2'] == '' || $data['plan_pirelli_week2'] == '') ? 0 : round(($data['pirelli_week2'] / $data['plan_pirelli_week2']) * 100, 1);
            $pirelli[] = ($data['pirelli_week3'] == '' || $data['plan_pirelli_week3'] == '') ? 0 : round(($data['pirelli_week3'] / $data['plan_pirelli_week3']) * 100, 1);
            $pirelli[] = ($data['pirelli_week4'] == '' || $data['plan_pirelli_week4'] == '') ? 0 : round(($data['pirelli_week4'] / $data['plan_pirelli_week4']) * 100, 1);
            $pirelli[] = ($data['pirelli_week5'] == '' || $data['plan_pirelli_week5'] == '') ? 0 : round(($data['pirelli_week5'] / $data['plan_pirelli_week5']) * 100, 1);

            $aspira = [];
            $aspira[] = ($data['aspira_week1'] == '' || $data['plan_aspira_week1'] == '') ? 0 : round(($data['aspira_week1'] / $data['plan_aspira_week1']) * 100, 1);
            $aspira[] = ($data['aspira_week2'] == '' || $data['plan_aspira_week2'] == '') ? 0 : round(($data['aspira_week2'] / $data['plan_aspira_week2']) * 100, 1);
            $aspira[] = ($data['aspira_week3'] == '' || $data['plan_aspira_week3'] == '') ? 0 : round(($data['aspira_week3'] / $data['plan_aspira_week3']) * 100, 1);
            $aspira[] = ($data['aspira_week4'] == '' || $data['plan_aspira_week4'] == '') ? 0 : round(($data['aspira_week4'] / $data['plan_aspira_week4']) * 100, 1);
            $aspira[] = ($data['aspira_week5'] == '' || $data['plan_aspira_week5'] == '') ? 0 : round(($data['aspira_week5'] / $data['plan_aspira_week5']) * 100, 1);

            $oe = [];
            $oe[] = ($data['oe_week1'] == '' || $data['plan_oe_week1'] == '') ? 0 : round(($data['oe_week1'] / $data['plan_oe_week1']) * 100, 1);
            $oe[] = ($data['oe_week2'] == '' || $data['plan_oe_week2'] == '') ? 0 : round(($data['oe_week2'] / $data['plan_oe_week2']) * 100, 1);
            $oe[] = ($data['oe_week3'] == '' || $data['plan_oe_week3'] == '') ? 0 : round(($data['oe_week3'] / $data['plan_oe_week3']) * 100, 1);
            $oe[] = ($data['oe_week4'] == '' || $data['plan_oe_week4'] == '') ? 0 : round(($data['oe_week4'] / $data['plan_oe_week4']) * 100, 1);
            $oe[] = ($data['oe_week5'] == '' || $data['plan_oe_week5'] == '') ? 0 : round(($data['oe_week5'] / $data['plan_oe_week5']) * 100, 1);

            $rem = [];
            $rem[] = ($data['rem_week1'] == '' || $data['plan_rem_week1'] == '') ? 0 : round(($data['rem_week1'] / $data['plan_rem_week1']) * 100, 1);
            $rem[] = ($data['rem_week2'] == '' || $data['plan_rem_week2'] == '') ? 0 : round(($data['rem_week2'] / $data['plan_rem_week2']) * 100, 1);
            $rem[] = ($data['rem_week3'] == '' || $data['plan_rem_week3'] == '') ? 0 : round(($data['rem_week3'] / $data['plan_rem_week3']) * 100, 1);
            $rem[] = ($data['rem_week4'] == '' || $data['plan_rem_week4'] == '') ? 0 : round(($data['rem_week4'] / $data['plan_rem_week4']) * 100, 1);
            $rem[] = ($data['rem_week5'] == '' || $data['plan_rem_week5'] == '') ? 0 : round(($data['rem_week5'] / $data['plan_rem_week5']) * 100, 1);

            $btu = [];
            $btu[] = ($data['btu_week1'] == '' || $data['plan_btu_week1'] == '') ? 0 : round(($data['btu_week1'] / $data['plan_btu_week1']) * 100, 1);
            $btu[] = ($data['btu_week2'] == '' || $data['plan_btu_week2'] == '') ? 0 : round(($data['btu_week2'] / $data['plan_btu_week2']) * 100, 1);
            $btu[] = ($data['btu_week3'] == '' || $data['plan_btu_week3'] == '') ? 0 : round(($data['btu_week3'] / $data['plan_btu_week3']) * 100, 1);
            $btu[] = ($data['btu_week4'] == '' || $data['plan_btu_week4'] == '') ? 0 : round(($data['btu_week4'] / $data['plan_btu_week4']) * 100, 1);
            $btu[] = ($data['btu_week5'] == '' || $data['plan_btu_week5'] == '') ? 0 : round(($data['btu_week5'] / $data['plan_btu_week5']) * 100, 1);

            $stu = [];
            $stu[] = ($data['stu_week1'] == '' || $data['plan_stu_week1'] == '') ? 0 : round(($data['stu_week1'] / $data['plan_stu_week1']) * 100, 1);
            $stu[] = ($data['stu_week2'] == '' || $data['plan_stu_week2'] == '') ? 0 : round(($data['stu_week2'] / $data['plan_stu_week2']) * 100, 1);
            $stu[] = ($data['stu_week3'] == '' || $data['plan_stu_week3'] == '') ? 0 : round(($data['stu_week3'] / $data['plan_stu_week3']) * 100, 1);
            $stu[] = ($data['stu_week4'] == '' || $data['plan_stu_week4'] == '') ? 0 : round(($data['stu_week4'] / $data['plan_stu_week4']) * 100, 1);
            $stu[] = ($data['stu_week5'] == '' || $data['plan_stu_week5'] == '') ? 0 : round(($data['stu_week5'] / $data['plan_stu_week5']) * 100, 1);

            $mru = [];
            $mru[] = ($data['mru_week1'] == '' || $data['plan_mru_week1'] == '') ? 0 : round(($data['mru_week1'] / $data['plan_mru_week1']) * 100, 1);
            $mru[] = ($data['mru_week2'] == '' || $data['plan_mru_week2'] == '') ? 0 : round(($data['mru_week2'] / $data['plan_mru_week2']) * 100, 1);
            $mru[] = ($data['mru_week3'] == '' || $data['plan_mru_week3'] == '') ? 0 : round(($data['mru_week3'] / $data['plan_mru_week3']) * 100, 1);
            $mru[] = ($data['mru_week4'] == '' || $data['plan_mru_week4'] == '') ? 0 : round(($data['mru_week4'] / $data['plan_mru_week4']) * 100, 1);
            $mru[] = ($data['mru_week5'] == '' || $data['plan_mru_week5'] == '') ? 0 : round(($data['mru_week5'] / $data['plan_mru_week5']) * 100, 1);


            $data = [
                'title' => 'chart',
                'total' => $total,
                'pirelli' => $pirelli,
                'aspira' => $aspira,
                'oe' => $oe,
                'rem' => $rem,
                'btu' => $btu,
                'stu' => $stu,
                'mru' => $mru,
                'bulan' => $data['bulan'],
                'tahun' => $tahun,
            ];
        } else {
            $data = [
                'total_act' => $this->modelpcs->getDataInbound($tahun, $bulan, 0, null, null, null, null, null, 'week')['INBOUND'],
                'plan_total_act' => $this->modelinbound->getDataInbound($tahun, $bulan, 0, null, null, null, null, null, 'week')['INBOUND'],
                'plan_pirelli_act' => $this->modelinbound->getDataInbound($tahun, $bulan, 0, 'PIRELLi',  null, null, null, null, 'week')['INBOUND'],
                'pirelli_act' => $this->modelpcs->getDataInbound($tahun, $bulan, 0, 'pirelli',  null, null, null, null, 'week')['INBOUND'],
                'aspira_act' => $this->modelpcs->getDataInbound($tahun, $bulan, 0, 'aspira',  null, null, null, null, 'week')['INBOUND'],
                'plan_aspira_act' => $this->modelinbound->getDataInbound($tahun, $bulan, 0, 'aspira',  null, null, null, null, 'week')['INBOUND'],
                'plan_oe_act' => $this->modelinbound->getDataInbound($tahun, $bulan, 0, null, null, '10', null, null, 'week')['INBOUND'],
                'oe_act' => $this->modelpcs->getDataInbound($tahun, $bulan, 0, null, null, '10', null, null, 'week')['INBOUND'],
                'plan_rem_act' => $this->modelinbound->getDataInbound($tahun, $bulan, 0, null, null, '00', null, null, 'week')['INBOUND'],
                'rem_act' => $this->modelpcs->getDataInbound($tahun, $bulan, 0, null, null, '00', null, null, 'week')['INBOUND'],
                'plan_btu_act' => $this->modelinbound->getDataInbound($tahun, $bulan, 0, null, null, null, 'BTU',  null, 'week')['INBOUND'],
                'btu_act' => $this->modelpcs->getDataInbound($tahun, $bulan, 0, null, null, null, 'BTU',  null, 'week')['INBOUND'],
                'plan_stu_act' => $this->modelinbound->getDataInbound($tahun, $bulan, 0, null, null, null, 'stu',  null, 'week')['INBOUND'],
                'stu_act' => $this->modelpcs->getDataInbound($tahun, $bulan, 0, null, null, null, 'stu',  null, 'week')['INBOUND'],
                'plan_mru_act' => $this->modelinbound->getDataInbound($tahun, $bulan, 0, null, null, null, 'mru',  null, 'week')['INBOUND'],
                'mru_act' => $this->modelpcs->getDataInbound($tahun, $bulan, 0, null, null, null, 'mru',  null, 'week')['INBOUND'],
                'id_bulan' => $bulan,
                'bulan' => date('F', strtotime(date('Y-' . $bulan . '-d')))
            ];


            $res = [
                'title' => 'chart',
                'total' => $data['total_act'] - $data['plan_total_act'],
                'pirelli' => $data['pirelli_act'] - $data['plan_pirelli_act'],
                'aspira' => $data['aspira_act'] - $data['plan_aspira_act'],
                'oe' => $data['oe_act'] - $data['plan_oe_act'],
                'rem' => $data['rem_act'] - $data['plan_rem_act'],
                'btu' => $data['btu_act'] - $data['plan_btu_act'],
                'stu' => $data['stu_act'] - $data['plan_stu_act'],
                'mru' => $data['mru_act'] - $data['plan_mru_act'],
                'bulan' => $data['bulan'],
                'tahun' => $tahun,
            ];

            $json = [];
            $json[] = $res['total'];
            $json[] = $res['pirelli'];
            $json[] = $res['aspira'];
            $json[] = $res['oe'];
            $json[] = $res['rem'];
            $json[] = $res['btu'];
            $json[] = $res['stu'];
            $json[] = $res['mru'];

            $data = [
                'title' => 'chart',
                'data'  => $json,
                'bulan' => $data['bulan'],
                'tahun' => $tahun,
            ];
        }

        return $data;
    }

    public function inboundChart()
    {
        $this->permissionCheck('inbound_chart');
        $this->updatePageData([
            'title' => 'Laporan Inbound Chart',
            'submenu' => 'inbound_list',
        ]);
        $data  = $this->inboundChartWeekly('bar');
        return view($this->view . '/inbound_chart', $data);
    }

    public function ajaxInboundChart()
    {
        $this->permissionCheck('inbound_chart');
        $data  = $this->inboundChartWeekly('bar');
        return json_encode($data);
    }

    public function inboundRim()
    {
        $this->permissionCheck('inbound_rim');
        $this->updatePageData([
            'title' => 'Laporan Inbound Rim',
            'submenu' => 'inbound_rim',
        ]);

        $bulan = ($this->request->getVar('bulan')) ? $this->request->getVar('bulan') : intval(date('m'));
        $tahun = ($this->request->getVar('tahun')) ? $this->request->getVar('tahun') : intval(date('Y'));

        $data = [
            'title' => 'Rim',
            'tahun' => $tahun,
            'rim_list' => $this->modelpcs->getDataInboundRimList($tahun, $bulan, 0),

            'id_bulan' => $bulan,
            'bulan' => date('F', strtotime(date('Y-' . $bulan . '-d')))
        ];


        return view($this->view . '/inbound_rim', $data);
    }

    public function ajaxInboundRim()
    {
        $this->permissionCheck('inbound_rim');
        $this->updatePageData([
            'title' => 'Laporan Inbound Rim',
            'submenu' => 'inbound_rim',
        ]);

        $bulan = ($this->request->getVar('bulan')) ? $this->request->getVar('bulan') : intval(date('m'));
        $tahun = ($this->request->getVar('tahun')) ? $this->request->getVar('tahun') : intval(date('Y'));

        $data = [
            'title' => 'Rim',
            'tahun' => $tahun,
            'rim_list' => $this->modelpcs->getDataInboundRimList($tahun, $bulan, 0),

            'id_bulan' => $bulan,
            'bulan' => date('F', strtotime(date('Y-' . $bulan . '-d')))
        ];


        return view($this->view . '/inbound_rim_ajax', $data);
    }

    public function exportInboundRim()
    {
        $this->permissionCheck('inbound_rim_export');
        $bulan = ($this->request->getVar('bulan')) ? $this->request->getVar('bulan') : intval(date('m'));
        $tahun = ($this->request->getVar('tahun')) ? $this->request->getVar('tahun') : intval(date('Y'));

        $data = [
            'title' => 'Rim',
            'tahun' => $tahun,
            'rim_list' => $this->modelpcs->getDataInboundRimList($tahun, $bulan, 0),

            'id_bulan' => $bulan,
            'bulan' => date('F', strtotime(date('Y-' . $bulan . '-d')))
        ];
        // phpoffice/phpspreadsheet
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle("RIM " . $data['bulan'] . ' ' . $tahun);

        $rowLabel = 1;

        // $sheet->setCellValue('A2', 'Handover:');
        // $sheet->setCellValue('B2', '');

        // $sheet->setCellValue('D2', 'Export:');
        // $sheet->setCellValue('E2', date('Y-m-d H:i:s'));

        $lineFreeze = 2;

        // $sheet->freezePane('A' . $lineFreeze);
        // // Freeze second line:
        // $sheet->freezePane('E' . $lineFreeze);

        // set bold
        $sheet->getStyle('A' . $rowLabel . ':N' . $rowLabel . '')->getFont()->setBold(true);

        // set wrap text
        $sheet->getStyle('A' . $rowLabel . ':N' . $rowLabel . '')->getAlignment()->setWrapText(true);

        //  biar gak dempet karena autosize

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->mergeCells("A1:B2");
        $spreadsheet->getActiveSheet()->mergeCells("C1:H1");

        $sheet->setCellValue('A' . $rowLabel, 'SUBANG');
        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('C' . $rowLabel, $data['bulan'] . ' ' . $tahun);
        $spreadsheet->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal('center');
        $rowWeek = $rowLabel + 1;
        $week_first = idate('W', strtotime($tahun . '-' . $data['id_bulan'] . '-' . '01'));
        $week_first = ($week_first > 51) ? 1 : $week_first + 1;
        $sheet->setCellValue('C' . $rowWeek, 'W1 (W' . $week_first . ')');
        $sheet->setCellValue('D' . $rowWeek, 'W2 (W' . ($week_first + 1) . ')');
        $sheet->setCellValue('E' . $rowWeek, 'W3 (W' . ($week_first + 2) . ')');
        $sheet->setCellValue('F' . $rowWeek, 'W4 (W' . ($week_first + 3) . ')');
        $sheet->setCellValue('G' . $rowWeek, 'W5 (W' . ($week_first + 4) . ')');
        $sheet->setCellValue('H' . $rowWeek, 'ACT');
        $sheet->setCellValue('H' . $rowWeek, 'ACT');

        $no_plan = 3;
        $no_act = 4;
        $no_persen = 5;
        $week1 = idate('W', strtotime($tahun . '-' . $data['id_bulan'] . '-' . '01'));
        $week2 = idate('W', strtotime($tahun . '-' . $data['id_bulan'] . '-' . (1 + 7)));
        $week3 = idate('W', strtotime($tahun . '-' . $data['id_bulan'] . '-' . (1 + (7 * 2))));
        $week4 = idate('W', strtotime($tahun . '-' . $data['id_bulan'] . '-' . (1 + (7 * 3))));
        $week5 = idate('W', strtotime($tahun . '-' . $data['id_bulan'] . '-' . (1 + (7 * 4))));
        foreach ($data['rim_list'] as $d) {

            $rim_week1 = $this->modelpcs->getDataInbound(bulan: $bulan, week: $week1, rim: $d['RIM']);
            $rim_week2 = $this->modelpcs->getDataInbound(bulan: $bulan, week: $week2, rim: $d['RIM']);
            $rim_week3 = $this->modelpcs->getDataInbound(bulan: $bulan, week: $week3, rim: $d['RIM']);
            $rim_week4 = $this->modelpcs->getDataInbound(bulan: $bulan, week: $week4, rim: $d['RIM']);
            $rim_week5 = $this->modelpcs->getDataInbound(bulan: $bulan, week: $week5, rim: $d['RIM']);
            $rim_act = $this->modelpcs->getDataInbound(bulan: $bulan, week: 0, rim: $d['RIM'], get: 'week');

            $plan_rim_week1 = $this->modelinbound->getDataInbound(bulan: $bulan, week: $week1, rim: $d['RIM']);
            $plan_rim_week2 = $this->modelinbound->getDataInbound(bulan: $bulan, week: $week2, rim: $d['RIM']);
            $plan_rim_week3 = $this->modelinbound->getDataInbound(bulan: $bulan, week: $week3, rim: $d['RIM']);
            $plan_rim_week4 = $this->modelinbound->getDataInbound(bulan: $bulan, week: $week4, rim: $d['RIM']);
            $plan_rim_week5 = $this->modelinbound->getDataInbound(bulan: $bulan, week: $week5, rim: $d['RIM']);
            $plan_rim_act = $this->modelinbound->getDataInbound(bulan: $bulan, week: 0, rim: $d['RIM'], get: 'week');

            // total
            $spreadsheet->getActiveSheet()->mergeCells("A" . $no_plan . ":A" . $no_persen);
            $spreadsheet->getActiveSheet()->getStyle('A' . $no_plan)->getAlignment()->setVertical('center');
            $sheet->setCellValue('A' . $no_plan, $d['RIM']);
            $sheet->setCellValue('B' . $no_plan, 'Plan');

            $sheet->setCellValue('C' . $no_plan, ($plan_rim_week1['INBOUND'] == '') ? '' : $plan_rim_week1['INBOUND']);
            $sheet->setCellValue('D' . $no_plan, ($plan_rim_week2['INBOUND'] == '') ? '' : $plan_rim_week2['INBOUND']);
            $sheet->setCellValue('E' . $no_plan, ($plan_rim_week3['INBOUND'] == '') ? '' : $plan_rim_week3['INBOUND']);
            $sheet->setCellValue('F' . $no_plan, ($plan_rim_week4['INBOUND'] == '') ? '' : $plan_rim_week4['INBOUND']);
            $sheet->setCellValue('G' . $no_plan, ($plan_rim_week5['INBOUND'] == '') ? '' : $plan_rim_week5['INBOUND']);
            $sheet->setCellValue('H' . $no_plan, $plan_rim_act['INBOUND']);

            $sheet->setCellValue('B' . $no_act, 'ACT');

            $sheet->setCellValue('C' . $no_act, ($rim_week1['INBOUND'] == '') ? '' : $rim_week1['INBOUND']);
            $sheet->setCellValue('D' . $no_act, ($rim_week2['INBOUND'] == '') ? '' : $rim_week2['INBOUND']);
            $sheet->setCellValue('E' . $no_act, ($rim_week3['INBOUND'] == '') ? '' : $rim_week3['INBOUND']);
            $sheet->setCellValue('F' . $no_act, ($rim_week4['INBOUND'] == '') ? '' : $rim_week4['INBOUND']);
            $sheet->setCellValue('G' . $no_act, ($rim_week5['INBOUND'] == '') ? '' : $rim_week5['INBOUND']);
            $sheet->setCellValue('H' . $no_act, $rim_act['INBOUND']);

            $sheet->setCellValue('B' . $no_persen, '%');

            $sheet->setCellValue('C' . $no_persen, (($rim_week1['INBOUND'] == '' || $plan_rim_week1['INBOUND'] == '' || $plan_rim_week1['INBOUND'] == 0) ? '' :  round($rim_week1['INBOUND'] / $plan_rim_week1['INBOUND'] * 100, 1)));
            $sheet->setCellValue('D' . $no_persen, (($rim_week2['INBOUND'] == '' || $plan_rim_week2['INBOUND'] == '' || $plan_rim_week2['INBOUND'] == 0) ? '' :  round($rim_week2['INBOUND'] / $plan_rim_week2['INBOUND'] * 100, 1)));
            $sheet->setCellValue('E' . $no_persen, (($rim_week3['INBOUND'] == '' || $plan_rim_week3['INBOUND'] == '' || $plan_rim_week3['INBOUND'] == 0) ? '' :  round($rim_week3['INBOUND'] / $plan_rim_week3['INBOUND'] * 100, 1)));
            $sheet->setCellValue('F' . $no_persen, (($rim_week4['INBOUND'] == '' || $plan_rim_week4['INBOUND'] == '' || $plan_rim_week4['INBOUND'] == 0) ? '' :  round($rim_week4['INBOUND'] / $plan_rim_week4['INBOUND'] * 100, 1)));
            $sheet->setCellValue('G' . $no_persen, (($rim_week5['INBOUND'] == '' || $plan_rim_week5['INBOUND'] == '' || $plan_rim_week5['INBOUND'] == 0) ? '' :  round($rim_week5['INBOUND'] / $plan_rim_week5['INBOUND'] * 100, 1)));
            $sheet->setCellValue('H' . $no_persen, (($rim_act['INBOUND'] == '' || $plan_rim_act['INBOUND'] == '' || $plan_rim_act['INBOUND'] == 0) ? '' :  round($rim_act['INBOUND'] / $plan_rim_act['INBOUND'] * 100, 1)));

            $no_plan += 3;
            $no_act += 3;
            $no_persen += 3;
        }

        $file_name = 'Performance SUBANG RIM - ' . $data['bulan'] . ' ' . $tahun . '.xlsx';


        $writer = new Xlsx($spreadsheet);

        $writer->save($file_name);

        header("Content-Type: application/vnd.ms-excel");

        header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');

        header('Expires: 0');

        header('Cache-Control: must-revalidate');

        header('Pragma: public');

        header('Content-Length:' . filesize($file_name));

        flush();

        readfile($file_name);
        @unlink($file_name);

        exit;
    }
}

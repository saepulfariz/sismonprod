<?php

namespace App\Controllers;

use App\Controllers\AdminBaseController;

class Dashboard extends AdminBaseController
{
    public $title = 'Dashboard';

    public function index()
    {
        $this->permissionCheck('dashboard');

        $date_now = date('Y-m-d');

        $data = [
            'plan_curing' => number_format((new \App\Models\PlannedCuringModel)->select('sum(qty) as jumlah')->where('p_date', $date_now)->first()['jumlah']),
            'act_curing' => number_format((new \App\Models\PcsModel)->getDataCuringDate($date_now, $date_now)['jumlah']),
            'plan_inbound' => number_format((new \App\Models\PlannedInboundModel)->select('sum(qty) as jumlah')->where('p_date', $date_now)->first()['jumlah']),
            'act_inbound' => number_format((new \App\Models\PcsModel)->getDataInboundDate($date_now, $date_now)['jumlah']),
            'start_total' => $date_now,
            'end_total' => $date_now,
            'start_chart' => date('Y-m-d', strtotime('-7 Days', strtotime($date_now))),
            'end_chart' => $date_now,
        ];

        $data['chart'] = (new \App\Models\PcsModel)->getChartBuildingDate($data['start_chart'], $data['end_chart']);

        return view('admin/dashboard/index', $data);
    }


    function ajaxTotalDashboard()
    {
        $start = $this->request->getVar('start');
        $end = $this->request->getVar('end');

        $start = ($start) ? $start : date('Y-m-d');
        $end = ($end) ? $end : date('Y-m-d');

        $data = [
            'plan_curing' => number_format((new \App\Models\PlannedCuringModel)->select('sum(qty) as jumlah')->where('p_date >=', $start)->where('p_date <=', $end)->first()['jumlah']),
            'act_curing' => number_format((new \App\Models\PcsModel)->getDataCuringDate($start, $end)['jumlah']),
            'plan_inbound' => number_format((new \App\Models\PlannedInboundModel)->select('sum(qty) as jumlah')->where('p_date >=', $start)->where('p_date <=', $end)->first()['jumlah']),
            'act_inbound' => number_format((new \App\Models\PcsModel)->getDataInboundDate($start, $end)['jumlah']),
        ];

        $result['error'] = false;
        $result['data'] = $data;
        return json_encode($result);
    }

    function ajaxChartDashboard()
    {
        $start = $this->request->getVar('start');
        $end = $this->request->getVar('end');

        $start = ($start) ? $start : date('Y-m-d');
        $end = ($end) ? $end : date('Y-m-d');

        $data = (new \App\Models\PcsModel)->getChartBuildingDate($start, $end);

        return json_encode($data);
    }
}

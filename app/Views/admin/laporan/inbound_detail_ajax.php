<?php

$modelpcs = new \App\Models\PcsModel();
$modelinbound = new \App\Models\PlannedInboundModel();

?>
<table class="table text-light striped">
    <thead class="table-light fw-bold">
        <tr>
            <td rowspan="2" colspan="2" class="text-center my-auto align-middle">SUBANG</td>
            <td colspan="<?= count($range_date) + 1; ?>" class="text-center"><?= $bulan; ?> <?= $tahun; ?></td>
        </tr>
        <tr>
            <?php foreach ($range_date as $d) : ?>
                <td><?= date('d', strtotime($d)); ?></td>
            <?php endforeach; ?>
            <td>ACT</td>
        </tr>
    </thead>
    <tbody>
        <tr class="">
            <td align="center" rowspan="3" class="text-center align-middle">TOTAL</td>
            <td>Plan</td>
            <?php
            $plan = [];
            $a = 0;
            foreach ($range_date as $d) : ?>
                <?php
                $res = $modelinbound->getReport(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d)['INBOUND'];
                $plan[$a] = (is_null($res)) ? 0 : $res;
                $a++;
                ?>
                <td><?= (is_null($res)) ? '' : number_format($res, 0); ?></td>

            <?php endforeach; ?>
            <td><?= number_format(array_sum($plan), 0); ?></td>
        </tr>
        <tr class="">
            <td>ACT</td>
            <?php
            $actual = [];
            $a = 0;
            foreach ($range_date as $d) : ?>
                <?php
                $res = $modelpcs->getReport(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d)['INBOUND'];
                $actual[$a] = (is_null($res)) ? 0 : $res;
                $a++;
                ?>
                <td><?= (is_null($res)) ? '' : number_format($res, 0); ?></td>
            <?php endforeach; ?>
            <td><?= number_format(array_sum($actual), 0); ?></td>
        </tr>
        <tr class="table-primary">
            <td>%</td>
            <?php $a = 0;
            foreach ($range_date as $d) : ?>
                <?php


                $res = ($plan[$a] == 0 || $actual[$a] == 0) ? '' : round(($actual[$a] / $plan[$a] * 100), 1) . '%';
                $a++; ?><td><?= $res; ?></td>
            <?php endforeach; ?>
            <td><?= (array_sum($plan) == 0 || array_sum($actual) == 0) ? '' : number_format(array_sum($actual) / array_sum($plan) * 100, 1) . '%'; ?></td>
        </tr>


        <!-- PIRELLI -->
        <tr class="">
            <td align="center" rowspan="3" class="text-center align-middle bg-warning text-dark"><small class="fw-bold m-0 p-0">BRAND</small> <br class="m-0 p-0">PIRELLI</td>
            <td>Plan</td>
            <?php
            $plan = [];
            $a = 0;
            foreach ($range_date as $d) : ?>
                <?php
                $res = $modelinbound->getReport(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d, brand: 'PIRELLI')['INBOUND'];
                $plan[$a] = (is_null($res)) ? 0 : $res;
                $a++;
                ?>
                <td><?= (is_null($res)) ? '' : number_format($res, 0); ?></td>
            <?php endforeach; ?>
            <td><?= number_format(array_sum($plan), 0); ?></td>
        </tr>
        <tr class="">
            <td>ACT</td>
            <?php
            $actual = [];
            $a = 0;
            foreach ($range_date as $d) : ?>
                <?php
                $res = $modelpcs->getReport(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d, brand: 'PIRELLI')['INBOUND'];
                $actual[$a] = (is_null($res)) ? 0 : $res;
                $a++;
                ?>
                <td><?= (is_null($res)) ? '' : number_format($res, 0); ?></td>
            <?php endforeach; ?>
            <td><?= number_format(array_sum($actual), 0); ?></td>
        </tr>
        <tr class="table-primary">
            <td>%</td>
            <?php $a = 0;
            foreach ($range_date as $d) : ?>
                <?php


                $res = ($plan[$a] == 0 || $actual[$a] == 0) ? '' : round(($actual[$a] / $plan[$a] * 100), 1) . '%';
                $a++; ?><td><?= $res; ?></td>
            <?php endforeach; ?>
            <td><?= (array_sum($plan) == 0 || array_sum($actual) == 0) ? '' : number_format(array_sum($actual) / array_sum($plan) * 100, 1) . '%'; ?></td>
        </tr>

        <!-- ASPIRA -->
        <tr class="">
            <td align="center" rowspan="3" class="text-center align-middle bg-warning text-dark"><small class="fw-bold m-0 p-0">BRAND</small> <br class="m-0 p-0">ASPIRA</td>
            <td>Plan</td>
            <?php
            $plan = [];
            $a = 0;
            foreach ($range_date as $d) : ?>
                <?php
                $res = $modelinbound->getReport(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d, brand: 'ASPIRA')['INBOUND'];
                $plan[$a] = (is_null($res)) ? 0 : $res;
                $a++;
                ?>
                <td><?= (is_null($res)) ? '' : number_format($res, 0); ?></td>
            <?php endforeach; ?>
            <td><?= number_format(array_sum($plan), 0); ?></td>
        </tr>
        <tr class="">
            <td>ACT</td>
            <?php
            $actual = [];
            $a = 0;
            foreach ($range_date as $d) : ?>
                <?php
                $res = $modelpcs->getReport(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d, brand: 'ASPIRA')['INBOUND'];
                $actual[$a] = (is_null($res)) ? 0 : $res;
                $a++;
                ?>
                <td><?= (is_null($res)) ? '' : number_format($res, 0); ?></td>
            <?php endforeach; ?>
            <td><?= number_format(array_sum($actual), 0); ?></td>
        </tr>
        <tr class="table-primary">
            <td>%</td>
            <?php $a = 0;
            foreach ($range_date as $d) : ?>
                <?php


                $res = ($plan[$a] == 0 || $actual[$a] == 0) ? '' : round(($actual[$a] / $plan[$a] * 100), 1) . '%';
                $a++; ?><td><?= $res; ?></td>
            <?php endforeach; ?>
            <td><?= (array_sum($plan) == 0 || array_sum($actual) == 0) ? '' : number_format(array_sum($actual) / array_sum($plan) * 100, 1) . '%'; ?></td>
        </tr>


        <!-- OE -->
        <tr>
            <td align="center" rowspan="3" class="text-center align-middle bg-success text-white"><small class="fw-bold m-0 p-0">MARKET</small> <br class="m-0 p-0">OE</td>
            <td>Plan</td>
            <?php
            $plan = [];
            $a = 0;
            foreach ($range_date as $d) : ?>
                <?php
                $res = $modelinbound->getReport(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d, cost_center: '10')['INBOUND'];
                $plan[$a] = (is_null($res)) ? 0 : $res;
                $a++;
                ?>
                <td><?= (is_null($res)) ? '' : number_format($res, 0); ?></td>
            <?php endforeach; ?>
            <td><?= number_format(array_sum($plan), 0); ?></td>
        </tr>
        <tr>
            <td>ACT</td>
            <?php
            $actual = [];
            $a = 0;
            foreach ($range_date as $d) : ?>
                <?php
                $res = $modelpcs->getReport(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d, cost_center: '10')['INBOUND'];
                $actual[$a] = (is_null($res)) ? 0 : $res;
                $a++;
                ?>
                <td><?= (is_null($res)) ? '' : number_format($res, 0); ?></td>
            <?php endforeach; ?>
            <td><?= number_format(array_sum($actual), 0); ?></td>
        </tr>
        <tr class="table-primary">
            <td>%</td>
            <?php $a = 0;
            foreach ($range_date as $d) : ?>
                <?php


                $res = ($plan[$a] == 0 || $actual[$a] == 0) ? '' : round(($actual[$a] / $plan[$a] * 100), 1) . '%';
                $a++; ?><td><?= $res; ?></td>
            <?php endforeach; ?>
            <td><?= (array_sum($plan) == 0 || array_sum($actual) == 0) ? '' : number_format(array_sum($actual) / array_sum($plan) * 100, 1) . '%'; ?></td>
        </tr>

        <!-- RPLC -->
        <tr>
            <td align="center" rowspan="3" class="text-center align-middle bg-success text-white "><small class="fw-bold m-0 p-0">MARKET</small> <br class="m-0 p-0">RPLC</td>
            <td>Plan</td>
            <?php
            $plan = [];
            $a = 0;
            foreach ($range_date as $d) : ?>
                <?php
                $res = $modelinbound->getReport(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d, cost_center: '00')['INBOUND'];
                $plan[$a] = (is_null($res)) ? 0 : $res;
                $a++;
                ?>
                <td><?= (is_null($res)) ? '' : number_format($res, 0); ?></td>
            <?php endforeach; ?>
            <td><?= number_format(array_sum($plan), 0); ?></td>
        </tr>
        <tr>
            <td>ACT</td>
            <?php
            $actual = [];
            $a = 0;
            foreach ($range_date as $d) : ?>
                <?php
                $res = $modelpcs->getReport(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d, cost_center: '00')['INBOUND'];
                $actual[$a] = (is_null($res)) ? 0 : $res;
                $a++;
                ?>
                <td><?= (is_null($res)) ? '' : number_format($res, 0); ?></td>
            <?php endforeach; ?>
            <td><?= number_format(array_sum($actual), 0); ?></td>
        </tr>
        <tr class="table-primary">
            <td>%</td>
            <?php $a = 0;
            foreach ($range_date as $d) : ?>
                <?php


                $res = ($plan[$a] == 0 || $actual[$a] == 0) ? '' : round(($actual[$a] / $plan[$a] * 100), 1) . '%';
                $a++; ?><td><?= $res; ?></td>
            <?php endforeach; ?>
            <td><?= (array_sum($plan) == 0 || array_sum($actual) == 0) ? '' : number_format(array_sum($actual) / array_sum($plan) * 100, 1) . '%'; ?></td>
        </tr>


        <!-- BTU -->
        <tr>
            <td align="center" rowspan="3" class="text-center align-middle"><small class="fw-bold m-0 p-0">PROCESS</small> <br class="m-0 p-0">BTU</td>
            <td>Plan</td>
            <?php
            $plan = [];
            $a = 0;
            foreach ($range_date as $d) : ?>
                <?php
                $res = $modelinbound->getReport(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d, mch_type: 'BTU')['INBOUND'];
                $plan[$a] = (is_null($res)) ? 0 : $res;
                $a++;
                ?>
                <td><?= (is_null($res)) ? '' : number_format($res, 0); ?></td>
            <?php endforeach; ?>
            <td><?= number_format(array_sum($plan), 0); ?></td>
        </tr>
        <tr>
            <td>ACT</td>
            <?php
            $actual = [];
            $a = 0;
            foreach ($range_date as $d) : ?>
                <?php
                $res = $modelpcs->getReport(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d, mch_type: 'BTU')['INBOUND'];
                $actual[$a] = (is_null($res)) ? 0 : $res;
                $a++;
                ?>
                <td><?= (is_null($res)) ? '' : number_format($res, 0); ?></td>
            <?php endforeach; ?>
            <td><?= number_format(array_sum($actual), 0); ?></td>
        </tr>
        <tr class="table-primary">
            <td>%</td>
            <?php $a = 0;
            foreach ($range_date as $d) : ?>
                <?php


                $res = ($plan[$a] == 0 || $actual[$a] == 0) ? '' : round(($actual[$a] / $plan[$a] * 100), 1) . '%';
                $a++; ?><td><?= $res; ?></td>
            <?php endforeach; ?>
            <td><?= (array_sum($plan) == 0 || array_sum($actual) == 0) ? '' : number_format(array_sum($actual) / array_sum($plan) * 100, 1) . '%'; ?></td>
        </tr>

        <!-- STU -->
        <tr>
            <td align="center" rowspan="3" class="text-center align-middle"><small class="fw-bold m-0 p-0">PROCESS</small> <br class="m-0 p-0">STU</td>
            <td>Plan</td>
            <?php
            $plan = [];
            $a = 0;
            foreach ($range_date as $d) : ?>
                <?php
                $res = $modelinbound->getReport(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d, mch_type: 'STU')['INBOUND'];
                $plan[$a] = (is_null($res)) ? 0 : $res;
                $a++;
                ?>
                <td><?= (is_null($res)) ? '' : number_format($res, 0); ?></td>
            <?php endforeach; ?>
            <td><?= number_format(array_sum($plan), 0); ?></td>
        </tr>
        <tr>
            <td>ACT</td>
            <?php
            $actual = [];
            $a = 0;
            foreach ($range_date as $d) : ?>
                <?php
                $res = $modelpcs->getReport(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d, mch_type: 'STU')['INBOUND'];
                $actual[$a] = (is_null($res)) ? 0 : $res;
                $a++;
                ?>
                <td><?= (is_null($res)) ? '' : number_format($res, 0); ?></td>
            <?php endforeach; ?>
            <td><?= number_format(array_sum($actual), 0); ?></td>
        </tr>
        <tr class="table-primary">
            <td>%</td>
            <?php $a = 0;
            foreach ($range_date as $d) : ?>
                <?php


                $res = ($plan[$a] == 0 || $actual[$a] == 0) ? '' : round(($actual[$a] / $plan[$a] * 100), 1) . '%';
                $a++; ?><td><?= $res; ?></td>
            <?php endforeach; ?>
            <td><?= (array_sum($plan) == 0 || array_sum($actual) == 0) ? '' : number_format(array_sum($actual) / array_sum($plan) * 100, 1) . '%'; ?></td>
        </tr>

        <!-- MRU -->
        <tr>
            <td align="center" rowspan="3" class="text-center align-middle"><small class="fw-bold m-0 p-0">PROCESS</small> <br class="m-0 p-0">MRU</td>
            <td>Plan</td>
            <?php
            $plan = [];
            $a = 0;
            foreach ($range_date as $d) : ?>
                <?php
                $res = $modelinbound->getReport(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d, mch_type: 'MRU')['INBOUND'];
                $plan[$a] = (is_null($res)) ? 0 : $res;
                $a++;
                ?>
                <td><?= (is_null($res)) ? '' : number_format($res, 0); ?></td>
            <?php endforeach; ?>
            <td><?= number_format(array_sum($plan), 0); ?></td>
        </tr>
        <tr>
            <td>ACT</td>
            <?php
            $actual = [];
            $a = 0;
            foreach ($range_date as $d) : ?>
                <?php
                $res = $modelpcs->getReport(tahun: date('Y', strtotime($d)), bulan: date('m', strtotime($d)), date: $d, mch_type: 'MRU')['INBOUND'];
                $actual[$a] = (is_null($res)) ? 0 : $res;
                $a++;
                ?>
                <td><?= (is_null($res)) ? '' : number_format($res, 0); ?></td>
            <?php endforeach; ?>
            <td><?= number_format(array_sum($actual), 0); ?></td>
        </tr>
        <tr class="table-primary">
            <td>%</td>
            <?php $a = 0;
            foreach ($range_date as $d) : ?>
                <?php


                $res = ($plan[$a] == 0 || $actual[$a] == 0) ? '' : round(($actual[$a] / $plan[$a] * 100), 1) . '%';
                $a++; ?><td><?= $res; ?></td>
            <?php endforeach; ?>
            <td><?= (array_sum($plan) == 0 || array_sum($actual) == 0) ? '' : number_format(array_sum($actual) / array_sum($plan) * 100, 1) . '%'; ?></td>
        </tr>

    </tbody>
</table>
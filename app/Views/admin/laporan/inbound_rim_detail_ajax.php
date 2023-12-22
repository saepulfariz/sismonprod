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

        <?php $total_plan = 0;
        $total_act = 0;
        foreach ($rim_list as $d) : ?>

            <!-- produk RIM <?= $d['RIM']; ?> -->
            <?php

            $modelpcs = new \App\Models\PcsModel();
            $modelinbound = new \App\Models\PlannedInboundModel();

            // $rim_week1 = $modelpcs->getDataInbound(bulan: $id_bulan, week: 1, rim: $d['RIM']);

            // $plan_rim_week1 = $modelinbound->getDataInbound(bulan: $id_bulan, week: 1, rim: $d['RIM']);
            ?>
            <tr>
                <td align="center" rowspan="3" class="text-center align-middle"><?= $d['RIM']; ?>"</td>
                <td>Plan</td>
                <?php
                $plan = [];
                $a = 0;
                foreach ($range_date as $day) : ?>
                    <?php
                    $res = $modelinbound->getDataInbound(tahun: date('Y', strtotime($day)), bulan: date('m', strtotime($day)), date: $day, rim: $d['RIM'])['INBOUND'];
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
                foreach ($range_date as $day) : ?>
                    <?php
                    $res = $modelpcs->getDataInbound(tahun: date('Y', strtotime($day)), bulan: date('m', strtotime($day)), date: $day, rim: $d['RIM'])['INBOUND'];
                    $actual[$a] = (is_null($res)) ? 0 : $res;
                    $a++;
                    ?>
                    <td><?= (is_null($res)) ? '' : number_format($res, 0); ?></td>

                <?php endforeach; ?>
                <td><?= number_format(array_sum($actual), 0); ?></td>
            </tr>
            <tr class="table-info">
                <td>%</td>
                <?php $a = 0;
                foreach ($range_date as $d) : ?>
                    <?php


                    $res = ($plan[$a] == 0 || $actual[$a] == 0) ? '' : round(($actual[$a] / $plan[$a] * 100), 1) . '%';
                    $a++; ?><td><?= $res; ?></td>
                <?php endforeach; ?>
                <td><?= (array_sum($plan) == 0 || array_sum($actual) == 0) ? '' : number_format(array_sum($actual) / array_sum($plan) * 100, 1) . '%'; ?></td>
            </tr>
            <?php


            $total_plan += array_sum($plan);
            $total_act += array_sum($actual);

            ?>
        <?php endforeach; ?>

        <tr>
            <td colspan="<?= count($range_date) + 2; ?>" class="text-end">TOTAL PLAN : </td>
            <td><?= number_format($total_plan, 0); ?></td>
        </tr>

        <tr>
            <td colspan="<?= count($range_date) + 2; ?>" class="text-end">TOTAL ACT : </td>
            <td><?= number_format($total_act, 0); ?></td>
        </tr>

        <tr>
            <td colspan="<?= count($range_date) + 2; ?>" class="text-end">PERCENTAGE : </td>
            <td class="table-info"><?= ($total_act == 0 || $total_plan == 0) ? 0 : round($total_act / $total_plan * 100, 1); ?>%</td>
        </tr>

    </tbody>
</table>
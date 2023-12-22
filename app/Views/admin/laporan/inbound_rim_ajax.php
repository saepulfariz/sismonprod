<table class="table text-light striped">
    <thead class="table-light fw-bold">
        <tr>
            <td rowspan="2" colspan="2" class="text-center my-auto align-middle">SUBANG</td>
            <td colspan="6" class="text-center"><?= $bulan; ?> <?= $tahun; ?></td>
        </tr>
        <tr>
            <?php
            $week_first = idate('W', strtotime($tahun . '-' . $id_bulan . '-' . '01'));
            // $week_first = ($week_first > 51) ? 1 : $week_first + 1; 

            ?>
            <td>W1 (W<?= $week_first; ?>)</td>
            <td>W2 (W<?= idate('W', strtotime($tahun . '-' . $id_bulan . '-' . (1 + 7))); ?>)</td>
            <td>W3 (W<?= idate('W', strtotime($tahun . '-' . $id_bulan . '-' . (1 + (7 * 2)))); ?>)</td>
            <td>W4 (W<?= idate('W', strtotime($tahun . '-' . $id_bulan . '-' . (1 + (7 * 3)))); ?>)</td>
            <td>W5 (W<?= idate('W', strtotime($tahun . '-' . $id_bulan . '-' . (1 + (7 * 4)))); ?>)</td>
            <td>ACT</td>
        </tr>
    </thead>
    <tbody>

        <?php $total_plan = 0;
        $total_act = 0;

        $week1 = idate('W', strtotime($tahun . '-' . $id_bulan . '-' . '01'));
        $week2 = idate('W', strtotime($tahun . '-' . $id_bulan . '-' . (1 + 7)));
        $week3 = idate('W', strtotime($tahun . '-' . $id_bulan . '-' . (1 + (7 * 2))));
        $week4 = idate('W', strtotime($tahun . '-' . $id_bulan . '-' . (1 + (7 * 3))));
        $week5 = idate('W', strtotime($tahun . '-' . $id_bulan . '-' . (1 + (7 * 4))));
        foreach ($rim_list as $d) : ?>

            <!-- produk RIM <?= $d['RIM']; ?> -->
            <?php

            $modelpcs = new \App\Models\PcsModel();
            $modelinbound = new \App\Models\PlannedInboundModel();

            $rim_week1 = $modelpcs->getDataInbound(bulan: $id_bulan, week: $week1, rim: $d['RIM']);
            $rim_week2 = $modelpcs->getDataInbound(bulan: $id_bulan, week: $week2, rim: $d['RIM']);
            $rim_week3 = $modelpcs->getDataInbound(bulan: $id_bulan, week: $week3, rim: $d['RIM']);
            $rim_week4 = $modelpcs->getDataInbound(bulan: $id_bulan, week: $week4, rim: $d['RIM']);
            $rim_week5 = $modelpcs->getDataInbound(bulan: $id_bulan, week: $week5, rim: $d['RIM']);
            $rim_act = $modelpcs->getDataInbound(bulan: $id_bulan, week: 0, rim: $d['RIM'], get: 'week');

            $plan_rim_week1 = $modelinbound->getDataInbound(bulan: $id_bulan, week: $week1, rim: $d['RIM']);
            $plan_rim_week2 = $modelinbound->getDataInbound(bulan: $id_bulan, week: $week2, rim: $d['RIM']);
            $plan_rim_week3 = $modelinbound->getDataInbound(bulan: $id_bulan, week: $week3, rim: $d['RIM']);
            $plan_rim_week4 = $modelinbound->getDataInbound(bulan: $id_bulan, week: $week4, rim: $d['RIM']);
            $plan_rim_week5 = $modelinbound->getDataInbound(bulan: $id_bulan, week: $week5, rim: $d['RIM']);
            $plan_rim_act = $modelinbound->getDataInbound(bulan: $id_bulan, week: 0, rim: $d['RIM'], get: 'week');

            $total_plan += $plan_rim_act['INBOUND'];
            $total_act += $rim_act['INBOUND'];
            ?>
            <tr>
                <td align="center" rowspan="3" class="text-center align-middle"><?= $d['RIM']; ?>"</td>
                <td>Plan</td>
                <td><?= ($plan_rim_week1['INBOUND'] == '') ? '' : number_format($plan_rim_week1['INBOUND'], 0); ?></td>
                <td><?= ($plan_rim_week2['INBOUND'] == '') ? '' : number_format($plan_rim_week2['INBOUND'], 0); ?></td>
                <td><?= ($plan_rim_week3['INBOUND'] == '') ? '' : number_format($plan_rim_week3['INBOUND'], 0); ?></td>
                <td><?= ($plan_rim_week4['INBOUND'] == '') ? '' : number_format($plan_rim_week4['INBOUND'], 0); ?></td>
                <td><?= ($plan_rim_week5['INBOUND'] == '') ? '' : number_format($plan_rim_week5['INBOUND'], 0); ?></td>
                <td><?= number_format($plan_rim_act['INBOUND'], 0); ?></td>
            </tr>
            <tr>
                <td>ACT</td>
                <td><?= ($rim_week1['INBOUND'] == '') ? '' : number_format($rim_week1['INBOUND'], 0); ?></td>
                <td><?= ($rim_week2['INBOUND'] == '') ? '' : number_format($rim_week2['INBOUND'], 0); ?></td>
                <td><?= ($rim_week3['INBOUND'] == '') ? '' : number_format($rim_week3['INBOUND'], 0); ?></td>
                <td><?= ($rim_week4['INBOUND'] == '') ? '' : number_format($rim_week4['INBOUND'], 0); ?></td>
                <td><?= ($rim_week5['INBOUND'] == '') ? '' : number_format($rim_week5['INBOUND'], 0); ?></td>
                <td><?= number_format($rim_act['INBOUND'], 0); ?></td>
            </tr>
            <tr class="table-info">
                <td>%</td>
                <td><?= ($rim_week1['INBOUND'] == '' || $plan_rim_week1['INBOUND'] == '' || $plan_rim_week1['INBOUND'] == 0) ? '' :  round($rim_week1['INBOUND'] / $plan_rim_week1['INBOUND'] * 100, 1) . '%'; ?></td>
                <td><?= ($rim_week2['INBOUND'] == '' || $plan_rim_week2['INBOUND'] == '' || $plan_rim_week2['INBOUND'] == 0) ? '' :  round($rim_week2['INBOUND'] / $plan_rim_week2['INBOUND'] * 100, 1) . '%'; ?></td>
                <td><?= ($rim_week3['INBOUND'] == '' || $plan_rim_week3['INBOUND'] == '' || $plan_rim_week3['INBOUND'] == 0) ? '' :  round($rim_week3['INBOUND'] / $plan_rim_week3['INBOUND'] * 100, 1) . '%'; ?></td>
                <td><?= ($rim_week4['INBOUND'] == '' || $plan_rim_week4['INBOUND'] == '' || $plan_rim_week4['INBOUND'] == 0) ? '' :  round($rim_week4['INBOUND'] / $plan_rim_week4['INBOUND'] * 100, 1) . '%'; ?></td>
                <td><?= ($rim_week5['INBOUND'] == '' || $plan_rim_week5['INBOUND'] == '' || $plan_rim_week5['INBOUND'] == 0) ? '' :  round($rim_week5['INBOUND'] / $plan_rim_week5['INBOUND'] * 100, 1) . '%'; ?></td>
                <td><?= ($rim_act['INBOUND'] == '' || $plan_rim_act['INBOUND'] == '' || $plan_rim_act['INBOUND'] == 0) ? '' :  round($rim_act['INBOUND'] / $plan_rim_act['INBOUND'] * 100, 1) . '%'; ?></td>
            </tr>
        <?php endforeach; ?>


        <tr>
            <td colspan="7" class="text-end">TOTAL PLAN : </td>
            <td><?= number_format($total_plan, 0); ?></td>
        </tr>

        <tr>
            <td colspan="7" class="text-end">TOTAL ACT : </td>
            <td><?= number_format($total_act, 0); ?></td>
        </tr>

        <tr>
            <td colspan="7" class="text-end">PERCENTAGE : </td>
            <td class="table-info"><?= ($total_act == 0 || $total_plan == 0) ? 0 : round($total_act / $total_plan * 100, 1); ?>%</td>
        </tr>
    </tbody>
</table>
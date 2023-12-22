<style>
    .verticalTableHeader {
        text-align: center;
        white-space: nowrap;
        transform-origin: 50% 50%;
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);

    }

    .verticalTableHeader:before {
        content: '';
        padding-top: 110%;
        /* takes width as reference, + 10% for faking some extra padding */
        display: inline-block;
        vertical-align: middle;
    }
</style>
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
        <tr class="">
            <td align="center" rowspan="3" class="text-center align-middle ">TOTAL</td>
            <td>Plan</td>
            <td><?= ($plan_total_week1['INBOUND'] == '') ? '' : number_format($plan_total_week1['INBOUND'], 0); ?></td>
            <td><?= ($plan_total_week2['INBOUND'] == '') ? '' : number_format($plan_total_week2['INBOUND'], 0); ?></td>
            <td><?= ($plan_total_week3['INBOUND'] == '') ? '' : number_format($plan_total_week3['INBOUND'], 0); ?></td>
            <td><?= ($plan_total_week4['INBOUND'] == '') ? '' : number_format($plan_total_week4['INBOUND'], 0); ?></td>
            <td><?= ($plan_total_week5['INBOUND'] == '') ? '' : number_format($plan_total_week5['INBOUND'], 0); ?></td>
            <td><?= ($plan_total_act['INBOUND'] == '') ? '' : number_format($plan_total_act['INBOUND'], 0); ?></td>
        </tr>
        <tr class="">
            <td>ACT</td>
            <td><?= ($total_week1['INBOUND'] == '') ? '' : number_format($total_week1['INBOUND'], 0); ?></td>
            <td><?= ($total_week2['INBOUND'] == '') ? '' : number_format($total_week2['INBOUND'], 0); ?></td>
            <td><?= ($total_week3['INBOUND'] == '') ? '' : number_format($total_week3['INBOUND'], 0); ?></td>
            <td><?= ($total_week4['INBOUND'] == '') ? '' : number_format($total_week4['INBOUND'], 0); ?></td>
            <td><?= ($total_week5['INBOUND'] == '') ? '' : number_format($total_week5['INBOUND'], 0); ?></td>
            <td><?= ($total_act['INBOUND'] == '') ? '' : number_format($total_act['INBOUND'], 0); ?></td>
        </tr>
        <tr class="table-primary">
            <td>%</td>
            <td><?= ($plan_total_week1['INBOUND'] == 0) ? '' : round(($total_week1['INBOUND'] / $plan_total_week1['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_total_week2['INBOUND'] == 0) ? '' : round(($total_week2['INBOUND'] / $plan_total_week2['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_total_week3['INBOUND'] == 0) ? '' : round(($total_week3['INBOUND'] / $plan_total_week3['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_total_week4['INBOUND'] == 0) ? '' : round(($total_week4['INBOUND'] / $plan_total_week4['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_total_week5['INBOUND'] == 0) ? '' : round(($total_week5['INBOUND'] / $plan_total_week5['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_total_act['INBOUND'] == '') ? '' : round(($total_act['INBOUND'] / $plan_total_act['INBOUND'] * 100), 1) . ' %'; ?></td>
        </tr>

        <!-- produk pirelli -->
        <tr class="">
            <!-- <td align="center" rowspan="6" class="text-center align-middle bg-warning text-dark verticalTableHeader">BRAND</td> -->
            <td align="center" rowspan="3" class="text-center align-middle bg-warning text-dark"><small class="fw-bold m-0 p-0">BRAND</small> <br class="m-0 p-0">PIRELLI </td>
            <td>Plan</td>
            <td><?= ($plan_pirelli_week1['INBOUND'] == '') ? '' : number_format($plan_pirelli_week1['INBOUND'], 0); ?></td>
            <td><?= ($plan_pirelli_week2['INBOUND'] == '') ? '' : number_format($plan_pirelli_week2['INBOUND'], 0); ?></td>
            <td><?= ($plan_pirelli_week3['INBOUND'] == '') ? '' : number_format($plan_pirelli_week3['INBOUND'], 0); ?></td>
            <td><?= ($plan_pirelli_week4['INBOUND'] == '') ? '' : number_format($plan_pirelli_week4['INBOUND'], 0); ?></td>
            <td><?= ($plan_pirelli_week5['INBOUND'] == '') ? '' : number_format($plan_pirelli_week5['INBOUND'], 0); ?></td>
            <td><?= ($plan_pirelli_act['INBOUND'] == '') ? '' : number_format($plan_pirelli_act['INBOUND'], 0); ?></td>
        </tr>
        <tr class="">
            <td>ACT</td>
            <td><?= ($pirelli_week1['INBOUND'] == '') ? '' : number_format($pirelli_week1['INBOUND'], 0); ?></td>
            <td><?= ($pirelli_week2['INBOUND'] == '') ? '' : number_format($pirelli_week2['INBOUND'], 0); ?></td>
            <td><?= ($pirelli_week3['INBOUND'] == '') ? '' : number_format($pirelli_week3['INBOUND'], 0); ?></td>
            <td><?= ($pirelli_week4['INBOUND'] == '') ? '' : number_format($pirelli_week4['INBOUND'], 0); ?></td>
            <td><?= ($pirelli_week5['INBOUND'] == '') ? '' : number_format($pirelli_week5['INBOUND'], 0); ?></td>
            <td><?= ($pirelli_act['INBOUND'] == '') ? '' : number_format($pirelli_act['INBOUND'], 0); ?></td>
        </tr>
        <tr class="table-primary">
            <td>%</td>
            <td><?= ($plan_pirelli_week1['INBOUND'] == '' || $plan_pirelli_week1['INBOUND'] == 0) ? ''  : round(($pirelli_week1['INBOUND'] / $plan_pirelli_week1['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_pirelli_week2['INBOUND'] == '' || $plan_pirelli_week2['INBOUND'] == 0) ? ''  : round(($pirelli_week2['INBOUND'] / $plan_pirelli_week2['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_pirelli_week3['INBOUND'] == '' || $plan_pirelli_week3['INBOUND'] == 0) ? ''  : round(($pirelli_week3['INBOUND'] / $plan_pirelli_week3['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_pirelli_week4['INBOUND'] == '' || $plan_pirelli_week4['INBOUND'] == 0) ? ''  : round(($pirelli_week4['INBOUND'] / $plan_pirelli_week4['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_pirelli_week5['INBOUND'] == '' || $plan_pirelli_week5['INBOUND'] == 0) ? ''  : round(($pirelli_week5['INBOUND'] / $plan_pirelli_week5['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_pirelli_act['INBOUND'] == '' || $plan_pirelli_act['INBOUND'] == 0) ? ''  : round(($pirelli_act['INBOUND'] / $plan_pirelli_act['INBOUND'] * 100), 1) . ' %'; ?></td>
        </tr>

        <!-- produk astra -->
        <tr class="">
            <td align="center" rowspan="3" class="text-center align-middle bg-warning text-dark"><small class="fw-bold m-0 p-0">BRAND</small> <br class="m-0 p-0"> ASPIRA</td>
            <td>Plan</td>
            <td><?= ($plan_aspira_week1['INBOUND'] == '') ? '' : number_format($plan_aspira_week1['INBOUND'], 0); ?></td>
            <td><?= ($plan_aspira_week2['INBOUND'] == '') ? '' : number_format($plan_aspira_week2['INBOUND'], 0); ?></td>
            <td><?= ($plan_aspira_week3['INBOUND'] == '') ? '' : number_format($plan_aspira_week3['INBOUND'], 0); ?></td>
            <td><?= ($plan_aspira_week4['INBOUND'] == '') ? '' : number_format($plan_aspira_week4['INBOUND'], 0); ?></td>
            <td><?= ($plan_aspira_week5['INBOUND'] == '') ? '' : number_format($plan_aspira_week5['INBOUND'], 0); ?></td>
            <td><?= ($plan_aspira_act['INBOUND'] == '') ? '' : number_format($plan_aspira_act['INBOUND'], 0); ?></td>

        </tr>
        <tr class="">
            <td>ACT</td>
            <td><?= ($aspira_week1['INBOUND'] == '') ? '' : number_format($aspira_week1['INBOUND'], 0); ?></td>
            <td><?= ($aspira_week2['INBOUND'] == '') ? '' : number_format($aspira_week2['INBOUND'], 0); ?></td>
            <td><?= ($aspira_week3['INBOUND'] == '') ? '' : number_format($aspira_week3['INBOUND'], 0); ?></td>
            <td><?= ($aspira_week4['INBOUND'] == '') ? '' : number_format($aspira_week4['INBOUND'], 0); ?></td>
            <td><?= ($aspira_week5['INBOUND'] == '') ? '' : number_format($aspira_week5['INBOUND'], 0); ?></td>
            <td><?= ($aspira_act['INBOUND'] == '') ? '' : number_format($aspira_act['INBOUND'], 0); ?></td>
        </tr>
        <tr class="table-primary">
            <td>%</td>
            <td><?= ($plan_aspira_week1['INBOUND'] == '' || $plan_aspira_week1['INBOUND'] == 0) ? ''  : round(($aspira_week1['INBOUND'] / $plan_aspira_week1['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_aspira_week2['INBOUND'] == '' || $plan_aspira_week2['INBOUND'] == 0) ? ''  : round(($aspira_week2['INBOUND'] / $plan_aspira_week2['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_aspira_week3['INBOUND'] == '' || $plan_aspira_week3['INBOUND'] == 0) ? ''  : round(($aspira_week3['INBOUND'] / $plan_aspira_week3['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_aspira_week4['INBOUND'] == '' || $plan_aspira_week4['INBOUND'] == 0) ? ''  : round(($aspira_week4['INBOUND'] / $plan_aspira_week4['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_aspira_week5['INBOUND'] == '' || $plan_aspira_week5['INBOUND'] == 0) ? ''  : round(($aspira_week5['INBOUND'] / $plan_aspira_week5['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_aspira_act['INBOUND'] == '' || $plan_aspira_act['INBOUND'] == 0) ? ''  : round(($aspira_act['INBOUND'] / $plan_aspira_act['INBOUND'] * 100), 1) . ' %'; ?></td>
        </tr>


        <!-- produk OE -->
        <tr>
            <td align="center" rowspan="3" class="text-center align-middle bg-success text-white"><small class="fw-bold m-0 p-0">MARKET</small> <br class="m-0 p-0"> OE</td>
            <td>Plan</td>
            <td><?= ($plan_oe_week1['INBOUND'] == '') ? '' : number_format($plan_oe_week1['INBOUND'], 0); ?></td>
            <td><?= ($plan_oe_week2['INBOUND'] == '') ? '' : number_format($plan_oe_week2['INBOUND'], 0); ?></td>
            <td><?= ($plan_oe_week3['INBOUND'] == '') ? '' : number_format($plan_oe_week3['INBOUND'], 0); ?></td>
            <td><?= ($plan_oe_week4['INBOUND'] == '') ? '' : number_format($plan_oe_week4['INBOUND'], 0); ?></td>
            <td><?= ($plan_oe_week5['INBOUND'] == '') ? '' : number_format($plan_oe_week5['INBOUND'], 0); ?></td>
            <td><?= ($plan_oe_act['INBOUND'] == '') ? '' : number_format($plan_oe_act['INBOUND'], 0); ?></td>

        </tr>
        <tr>
            <td>ACT</td>
            <td><?= ($oe_week1['INBOUND'] == '') ? '' : number_format($oe_week1['INBOUND'], 0); ?></td>
            <td><?= ($oe_week2['INBOUND'] == '') ? '' : number_format($oe_week2['INBOUND'], 0); ?></td>
            <td><?= ($oe_week3['INBOUND'] == '') ? '' : number_format($oe_week3['INBOUND'], 0); ?></td>
            <td><?= ($oe_week4['INBOUND'] == '') ? '' : number_format($oe_week4['INBOUND'], 0); ?></td>
            <td><?= ($oe_week5['INBOUND'] == '') ? '' : number_format($oe_week5['INBOUND'], 0); ?></td>
            <td><?= ($oe_act['INBOUND'] == '') ? '' : number_format($oe_act['INBOUND'], 0); ?></td>
        </tr>
        <tr class="table-primary">
            <td>%</td>
            <td><?= ($plan_oe_week1['INBOUND'] == '' || $plan_oe_week1['INBOUND'] == 0) ? ''  : round(($oe_week1['INBOUND'] / $plan_oe_week1['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_oe_week2['INBOUND'] == '' || $plan_oe_week2['INBOUND'] == 0) ? ''  : round(($oe_week2['INBOUND'] / $plan_oe_week2['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_oe_week3['INBOUND'] == '' || $plan_oe_week3['INBOUND'] == 0) ? ''  : round(($oe_week3['INBOUND'] / $plan_oe_week3['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_oe_week4['INBOUND'] == '' || $plan_oe_week4['INBOUND'] == 0) ? ''  : round(($oe_week4['INBOUND'] / $plan_oe_week4['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_oe_week5['INBOUND'] == '' || $plan_oe_week5['INBOUND'] == 0) ? ''  : round(($oe_week5['INBOUND'] / $plan_oe_week5['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_oe_act['INBOUND'] == '' || $plan_oe_act['INBOUND'] == 0) ? ''  : round(($oe_act['INBOUND'] / $plan_oe_act['INBOUND'] * 100), 1) . ' %'; ?></td>
        </tr>


        <!-- produk Replacem -->
        <tr>
            <td align="center" rowspan="3" class="text-center align-middle bg-success text-white "><small class="fw-bold m-0 p-0">MARKET</small> <br class="m-0 p-0"> RPLC</td>
            <td>Plan</td>
            <td><?= ($plan_rem_week1['INBOUND'] == '') ? '' : number_format($plan_rem_week1['INBOUND'], 0); ?></td>
            <td><?= ($plan_rem_week2['INBOUND'] == '') ? '' : number_format($plan_rem_week2['INBOUND'], 0); ?></td>
            <td><?= ($plan_rem_week3['INBOUND'] == '') ? '' : number_format($plan_rem_week3['INBOUND'], 0); ?></td>
            <td><?= ($plan_rem_week4['INBOUND'] == '') ? '' : number_format($plan_rem_week4['INBOUND'], 0); ?></td>
            <td><?= ($plan_rem_week5['INBOUND'] == '') ? '' : number_format($plan_rem_week5['INBOUND'], 0); ?></td>
            <td><?= ($plan_rem_act['INBOUND'] == '') ? '' : number_format($plan_rem_act['INBOUND'], 0); ?></td>

        </tr>
        <tr>
            <td>ACT</td>
            <td><?= ($rem_week1['INBOUND'] == '') ? '' : number_format($rem_week1['INBOUND'], 0); ?></td>
            <td><?= ($rem_week2['INBOUND'] == '') ? '' : number_format($rem_week2['INBOUND'], 0); ?></td>
            <td><?= ($rem_week3['INBOUND'] == '') ? '' : number_format($rem_week3['INBOUND'], 0); ?></td>
            <td><?= ($rem_week4['INBOUND'] == '') ? '' : number_format($rem_week4['INBOUND'], 0); ?></td>
            <td><?= ($rem_week5['INBOUND'] == '') ? '' : number_format($rem_week5['INBOUND'], 0); ?></td>
            <td><?= ($rem_act['INBOUND'] == '') ? '' : number_format($rem_act['INBOUND'], 0); ?></td>
        </tr>
        <tr class="table-primary">
            <td>%</td>
            <td><?= (is_null($plan_rem_week1['INBOUND'])) ? ''  : round(($rem_week1['INBOUND'] / $plan_rem_week1['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= (is_null($plan_rem_week2['INBOUND'])) ? ''  : round(($rem_week2['INBOUND'] / $plan_rem_week2['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= (is_null($plan_rem_week3['INBOUND'])) ? ''  : round(($rem_week3['INBOUND'] / $plan_rem_week3['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= (is_null($plan_rem_week4['INBOUND'])) ? ''  : round(($rem_week4['INBOUND'] / $plan_rem_week4['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= (is_null($plan_rem_week5['INBOUND'])) ? ''  : round(($rem_week5['INBOUND'] / $plan_rem_week5['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= (is_null($plan_rem_act['INBOUND'])) ? ''  : round(($rem_act['INBOUND'] / $plan_rem_act['INBOUND'] * 100), 1) . ' %'; ?></td>
        </tr>


        <!-- produk BTU -->
        <tr>
            <td align="center" rowspan="3" class="text-center align-middle"><small class="fw-bold m-0 p-0">PROCESS</small> <br class="m-0 p-0"> BTU</td>
            <td>Plan</td>
            <td><?= ($plan_btu_week1['INBOUND'] == '') ? '' : number_format($plan_btu_week1['INBOUND'], 0); ?></td>
            <td><?= ($plan_btu_week2['INBOUND'] == '') ? '' : number_format($plan_btu_week2['INBOUND'], 0); ?></td>
            <td><?= ($plan_btu_week3['INBOUND'] == '') ? '' : number_format($plan_btu_week3['INBOUND'], 0); ?></td>
            <td><?= ($plan_btu_week4['INBOUND'] == '') ? '' : number_format($plan_btu_week4['INBOUND'], 0); ?></td>
            <td><?= ($plan_btu_week5['INBOUND'] == '') ? '' : number_format($plan_btu_week5['INBOUND'], 0); ?></td>
            <td><?= ($plan_btu_act['INBOUND'] == '') ? '' : number_format($plan_btu_act['INBOUND'], 0); ?></td>

        </tr>
        <tr>
            <td>ACT</td>
            <td><?= ($btu_week1['INBOUND'] == '') ? '' : number_format($btu_week1['INBOUND'], 0); ?></td>
            <td><?= ($btu_week2['INBOUND'] == '') ? '' : number_format($btu_week2['INBOUND'], 0); ?></td>
            <td><?= ($btu_week3['INBOUND'] == '') ? '' : number_format($btu_week3['INBOUND'], 0); ?></td>
            <td><?= ($btu_week4['INBOUND'] == '') ? '' : number_format($btu_week4['INBOUND'], 0); ?></td>
            <td><?= ($btu_week5['INBOUND'] == '') ? '' : number_format($btu_week5['INBOUND'], 0); ?></td>
            <td><?= ($btu_act['INBOUND'] == '') ? '' : number_format($btu_act['INBOUND'], 0); ?></td>
        </tr>
        <tr class="table-primary">
            <td>%</td>
            <td><?= ($plan_btu_week1['INBOUND'] == '' || $plan_btu_week1['INBOUND'] == 0) ? ''  : round(($btu_week1['INBOUND'] / $plan_btu_week1['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_btu_week2['INBOUND'] == '' || $plan_btu_week2['INBOUND'] == 0) ? ''  : round(($btu_week2['INBOUND'] / $plan_btu_week2['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_btu_week3['INBOUND'] == '' || $plan_btu_week3['INBOUND'] == 0) ? ''  : round(($btu_week3['INBOUND'] / $plan_btu_week3['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_btu_week4['INBOUND'] == '' || $plan_btu_week4['INBOUND'] == 0) ? ''  : round(($btu_week4['INBOUND'] / $plan_btu_week4['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_btu_week5['INBOUND'] == '' || $plan_btu_week5['INBOUND'] == 0) ? ''  : round(($btu_week5['INBOUND'] / $plan_btu_week5['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_btu_act['INBOUND'] == '' || $plan_btu_act['INBOUND'] == 0) ? ''  : round(($btu_act['INBOUND'] / $plan_btu_act['INBOUND'] * 100), 1) . ' %'; ?></td>
        </tr>

        <!-- produk STU -->
        <tr>
            <td align="center" rowspan="3" class="text-center align-middle"><small class="fw-bold m-0 p-0">PROCESS</small> <br class="m-0 p-0"> STU</td>
            <td>Plan</td>
            <td><?= ($plan_stu_week1['INBOUND'] == '') ? '' : number_format($plan_stu_week1['INBOUND'], 0); ?></td>
            <td><?= ($plan_stu_week2['INBOUND'] == '') ? '' : number_format($plan_stu_week2['INBOUND'], 0); ?></td>
            <td><?= ($plan_stu_week3['INBOUND'] == '') ? '' : number_format($plan_stu_week3['INBOUND'], 0); ?></td>
            <td><?= ($plan_stu_week4['INBOUND'] == '') ? '' : number_format($plan_stu_week4['INBOUND'], 0); ?></td>
            <td><?= ($plan_stu_week5['INBOUND'] == '') ? '' : number_format($plan_stu_week5['INBOUND'], 0); ?></td>
            <td><?= ($plan_stu_act['INBOUND'] == '') ? '' : number_format($plan_stu_act['INBOUND'], 0); ?></td>

        </tr>
        <tr>
            <td>ACT</td>
            <td><?= ($stu_week1['INBOUND'] == '') ? '' : number_format($stu_week1['INBOUND'], 0); ?></td>
            <td><?= ($stu_week2['INBOUND'] == '') ? '' : number_format($stu_week2['INBOUND'], 0); ?></td>
            <td><?= ($stu_week3['INBOUND'] == '') ? '' : number_format($stu_week3['INBOUND'], 0); ?></td>
            <td><?= ($stu_week4['INBOUND'] == '') ? '' : number_format($stu_week4['INBOUND'], 0); ?></td>
            <td><?= ($stu_week5['INBOUND'] == '') ? '' : number_format($stu_week5['INBOUND'], 0); ?></td>
            <td><?= ($stu_act['INBOUND'] == '') ? '' : number_format($stu_act['INBOUND'], 0); ?></td>
        </tr>
        <tr class="table-primary">
            <td>%</td>
            <td><?= ($plan_stu_week1['INBOUND'] == '' || $plan_stu_week1['INBOUND'] == 0) ? ''  : round(($stu_week1['INBOUND'] / $plan_stu_week1['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_stu_week2['INBOUND'] == '' || $plan_stu_week2['INBOUND'] == 0) ? ''  : round(($stu_week2['INBOUND'] / $plan_stu_week2['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_stu_week3['INBOUND'] == '' || $plan_stu_week3['INBOUND'] == 0) ? ''  : round(($stu_week3['INBOUND'] / $plan_stu_week3['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_stu_week4['INBOUND'] == '' || $plan_stu_week4['INBOUND'] == 0) ? ''  : round(($stu_week4['INBOUND'] / $plan_stu_week4['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_stu_week5['INBOUND'] == '' || $plan_stu_week5['INBOUND'] == 0) ? ''  : round(($stu_week5['INBOUND'] / $plan_stu_week5['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_stu_act['INBOUND'] == '' || $plan_stu_act['INBOUND'] == 0) ? ''  : round(($stu_act['INBOUND'] / $plan_stu_act['INBOUND'] * 100), 1) . ' %'; ?></td>
        </tr>

        <!-- produk MRU -->
        <tr>
            <td align="center" rowspan="3" class="text-center align-middle"><small class="fw-bold m-0 p-0">PROCESS</small> <br class="m-0 p-0"> MRU</td>
            <td>Plan</td>
            <td><?= ($plan_mru_week1['INBOUND'] == '') ? '' : number_format($plan_mru_week1['INBOUND'], 0); ?></td>
            <td><?= ($plan_mru_week2['INBOUND'] == '') ? '' : number_format($plan_mru_week2['INBOUND'], 0); ?></td>
            <td><?= ($plan_mru_week3['INBOUND'] == '') ? '' : number_format($plan_mru_week3['INBOUND'], 0); ?></td>
            <td><?= ($plan_mru_week4['INBOUND'] == '') ? '' : number_format($plan_mru_week4['INBOUND'], 0); ?></td>
            <td><?= ($plan_mru_week5['INBOUND'] == '') ? '' : number_format($plan_mru_week5['INBOUND'], 0); ?></td>
            <td><?= ($plan_mru_act['INBOUND'] == '') ? '' : number_format($plan_mru_act['INBOUND'], 0); ?></td>

        </tr>
        <tr>
            <td>ACT</td>
            <td><?= ($mru_week1['INBOUND'] == '') ? '' : number_format($mru_week1['INBOUND'], 0); ?></td>
            <td><?= ($mru_week2['INBOUND'] == '') ? '' : number_format($mru_week2['INBOUND'], 0); ?></td>
            <td><?= ($mru_week3['INBOUND'] == '') ? '' : number_format($mru_week3['INBOUND'], 0); ?></td>
            <td><?= ($mru_week4['INBOUND'] == '') ? '' : number_format($mru_week4['INBOUND'], 0); ?></td>
            <td><?= ($mru_week5['INBOUND'] == '') ? '' : number_format($mru_week5['INBOUND'], 0); ?></td>
            <td><?= ($mru_act['INBOUND'] == '') ? '' : number_format($mru_act['INBOUND'], 0); ?></td>
        </tr>
        <tr class="table-primary">
            <td>%</td>
            <td><?= ($plan_mru_week1['INBOUND'] == '' || $plan_mru_week1['INBOUND'] == 0) ? ''  : round(($mru_week1['INBOUND'] / $plan_mru_week1['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_mru_week2['INBOUND'] == '' || $plan_mru_week2['INBOUND'] == 0) ? ''  : round(($mru_week2['INBOUND'] / $plan_mru_week2['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_mru_week3['INBOUND'] == '' || $plan_mru_week3['INBOUND'] == 0) ? ''  : round(($mru_week3['INBOUND'] / $plan_mru_week3['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_mru_week4['INBOUND'] == '' || $plan_mru_week4['INBOUND'] == 0) ? ''  : round(($mru_week4['INBOUND'] / $plan_mru_week4['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_mru_week5['INBOUND'] == '' || $plan_mru_week5['INBOUND'] == 0) ? ''  : round(($mru_week5['INBOUND'] / $plan_mru_week5['INBOUND'] * 100), 1) . ' %'; ?></td>
            <td><?= ($plan_mru_act['INBOUND'] == '' || $plan_mru_act['INBOUND'] == 0) ? ''  : round(($mru_act['INBOUND'] / $plan_mru_act['INBOUND'] * 100), 1) . ' %'; ?></td>
        </tr>


    </tbody>
</table>
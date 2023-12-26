<?= $this->extend('admin/template/index') ?>

<?= $this->section('head') ?>
<meta http-equiv="refresh" content="720">
<!-- <meta http-equiv="refresh" content="900; url=https://www.conductor.com/"> -->
<style>
    @media print {
        .noprint {
            visibility: hidden;
            display: none;
            margin: 0;
        }
    }

    .get-ip,
    .get-mch {
        cursor: pointer;
    }
</style>

<?= $this->endSection('head') ?>
<?= $this->section('content') ?>
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3 class="text-capitalize"><?= $_page->title; ?></h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">

                <?= breadcrumb(); ?>
            </nav>
        </div>
    </div>
</div>
<section class="section">
    <div class="row">
        <div class="col-md-12">

            <div class="card">

                <div class="card-body">
                    <form action="" method="get" class="noprint mb-2">
                        <div class="row mt-3">
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <select name="bulan" id="bulan" class="form-control">
                                        <?php for ($a = 1; $a < 13; $a++) : ?>
                                            <?php if ($id_bulan == $a) : ?>

                                                <option selected value="<?= $a; ?>"><?= date('F', strtotime(date('Y-' . $a . '-d'))); ?></option>
                                            <?php else : ?>
                                                <option value="<?= $a; ?>"><?= date('F', strtotime(date('Y-' . $a . '-d'))); ?></option>

                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <select name="tahun" id="tahun" class="form-control">
                                        <?php foreach ($list_tahun as $d) : ?>
                                            <?php if ($d['tahun'] == $tahun) : ?>
                                                <option selected><?= $d['tahun']; ?></option>
                                            <?php else : ?>
                                                <option><?= $d['tahun']; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <input type="hidden" id="mch" name="mch" value="MRU1">
                                <input type="hidden" id="ip" name="ip" value="37779">
                                <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                                <button type="button" id="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>

                    <div class="row text-white">
                        <div class="col-md-3 mb-2 text-warning">
                            <h3 class="get-mch" data-mch="MRU1">MRU1</h3>
                            <canvas id="mruChart"></canvas>
                            <div class="row mt-3">
                                <div class="col-6 mb-2">
                                    <table class="w-100 bg-transparent text-warning" cellpadding="4">
                                        <thead class="">
                                            <tr>
                                                <th colspan="2" class="bg-success text-warning">TOP 10 GAIN</th>
                                            </tr>
                                            <tr>
                                                <th>IP CODE</th>
                                                <th>GAIN</th>
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            <!-- top  -->
                                            <?php for ($a = 0; $a <= (setLimit(count($curing['MRU1']), $limit)) - 1; $a++) : ?>
                                                <tr class="tooltips" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="MACHINE CURING : A01-B01">
                                                    <td class="get-ip" data-ip="<?= $curing['MRU1'][$a]['MAT_CODE']; ?>"><?= $curing['MRU1'][$a]['MAT_CODE']; ?></td>
                                                    <td><?= $curing['MRU1'][$a]['GAP']; ?></td>
                                                </tr>
                                            <?php endfor; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-6 mb-2">
                                    <table class="w-100 bg-transparent text-warning" cellpadding="4">
                                        <thead class="">
                                            <tr>
                                                <th colspan="2" class="bg-danger text-warning">TOP 10 LOSS</th>
                                            </tr>
                                            <tr>
                                                <th>IP CODE</th>
                                                <th>LOSS</th>
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            <?php for ($a = count($curing['MRU1']) - 1; $a >= (count($curing['MRU1']) - (setLimit(count($curing['MRU1']), $limit))); $a--) : ?>
                                                <?php if ($curing['MRU1'][$a]['GAP'] < 0) : ?>

                                                    <tr class="tooltips" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="MACHINE CURING : A01-B01">
                                                        <td class="get-ip" data-ip="<?= $curing['MRU1'][$a]['MAT_CODE']; ?>"><?= $curing['MRU1'][$a]['MAT_CODE']; ?></td>
                                                        <td><?= $curing['MRU1'][$a]['GAP']; ?></td>
                                                    </tr>

                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-2 text-warning">
                            <h3 class="get-mch" data-mch="BTUM">BTUM</h3>
                            <canvas id="btumChart"></canvas>
                            <div class="row mt-3">
                                <div class="col-6 mb-2">
                                    <table class="w-100 bg-transparent text-warning" cellpadding="4">
                                        <thead class="">
                                            <tr>
                                                <th colspan="2" class="bg-success text-warning">TOP 10 GAIN</th>
                                            </tr>
                                            <tr>
                                                <th>IP CODE</th>
                                                <th>GAIN</th>
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            <!-- top  -->
                                            <?php for ($a = 0; $a <= (setLimit(count($curing['BTUM']), $limit)); $a++) : ?>
                                                <tr class="tooltips" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="MACHINE CURING : A01-B01">
                                                    <td class="get-ip" data-ip="<?= $curing['BTUM'][$a]['MAT_CODE']; ?>"><?= $curing['BTUM'][$a]['MAT_CODE']; ?></td>
                                                    <td><?= $curing['BTUM'][$a]['GAP']; ?></td>
                                                </tr>
                                            <?php endfor; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-6 mb-2">
                                    <table class="w-100 bg-transparent text-warning" cellpadding="4">
                                        <thead class="">
                                            <tr>
                                                <th colspan="2" class="bg-danger text-warning">TOP 10 LOSS</th>
                                            </tr>
                                            <tr>
                                                <th>IP CODE</th>
                                                <th>LOSS</th>
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            <?php for ($a = count($curing['BTUM']) - 1; $a >= count($curing['BTUM']) - (setLimit(count($curing['BTUM']), $limit)); $a--) : ?>
                                                <tr class="tooltips" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="MACHINE CURING : A01-B01">
                                                    <td class="get-ip" data-ip="<?= $curing['BTUM'][$a]['MAT_CODE']; ?>"><?= $curing['BTUM'][$a]['MAT_CODE']; ?></td>
                                                    <td><?= $curing['BTUM'][$a]['GAP']; ?></td>
                                                </tr>
                                            <?php endfor; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-3 mb-2 text-warning">
                            <h3 class="get-mch" data-mch="SBTU">SBTU</h3>
                            <canvas id="SBTUChart"></canvas>
                            <div class="row mt-3">
                                <div class="col-6 mb-2">
                                    <table class="w-100 bg-transparent text-warning" cellpadding="4">
                                        <thead class="">
                                            <tr>
                                                <th colspan="2" class="bg-success text-warning">TOP 10 GAIN</th>
                                            </tr>
                                            <tr>
                                                <th>IP CODE</th>
                                                <th>GAIN</th>
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            <!-- top  -->
                                            <?php for ($a = 0; $a <= (setLimit(count($curing['SBTU']), $limit)); $a++) : ?>
                                                <tr class="tooltips" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="MACHINE CURING : A01-B01">
                                                    <td class="get-ip" data-ip="<?= $curing['SBTU'][$a]['MAT_CODE']; ?>"><?= $curing['SBTU'][$a]['MAT_CODE']; ?></td>
                                                    <td><?= $curing['SBTU'][$a]['GAP']; ?></td>
                                                </tr>
                                            <?php endfor; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-6 mb-2">
                                    <table class="w-100 bg-transparent text-warning" cellpadding="4">
                                        <thead class="">
                                            <tr>
                                                <th colspan="2" class="bg-danger text-warning">TOP 10 LOSS</th>
                                            </tr>
                                            <tr>
                                                <th>IP CODE</th>
                                                <th>LOSS</th>
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            <?php for ($a = count($curing['SBTU']) - 1; $a >= count($curing['SBTU']) - (setLimit(count($curing['SBTU']), $limit)); $a--) : ?>
                                                <tr class="tooltips" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="MACHINE CURING : A01-B01">
                                                    <td class="get-ip" data-ip="<?= $curing['SBTU'][$a]['MAT_CODE']; ?>"><?= $curing['SBTU'][$a]['MAT_CODE']; ?></td>
                                                    <td><?= $curing['SBTU'][$a]['GAP']; ?></td>
                                                </tr>
                                            <?php endfor; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-2 text-warning">
                            <h3 class="get-mch" data-mch="STUM">STUM</h3>
                            <canvas id="stumChart"></canvas>
                            <div class="row mt-3">
                                <div class="col-6 mb-2">
                                    <table class="w-100 bg-transparent text-warning" cellpadding="4">
                                        <thead class="">
                                            <tr>
                                                <th colspan="2" class="bg-success text-warning">TOP 10 GAIN</th>
                                            </tr>
                                            <tr>
                                                <th>IP CODE</th>
                                                <th>GAIN</th>
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            <!-- top  -->
                                            <?php for ($a = 0; $a <= (setLimit(count($curing['STUM']), $limit)); $a++) : ?>
                                                <tr class="tooltips" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="MACHINE CURING : A01-B01">
                                                    <td class="get-ip" data-ip="<?= $curing['STUM'][$a]['MAT_CODE']; ?>"><?= $curing['STUM'][$a]['MAT_CODE']; ?></td>
                                                    <td><?= $curing['STUM'][$a]['GAP']; ?></td>
                                                </tr>
                                            <?php endfor; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-6 mb-2">
                                    <table class="w-100 bg-transparent text-warning" cellpadding="4">
                                        <thead class="">
                                            <tr>
                                                <th colspan="2" class="bg-danger text-warning">TOP 10 LOSS</th>
                                            </tr>
                                            <tr>
                                                <th>IP CODE</th>
                                                <th>LOSS</th>
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            <?php for ($a = count($curing['STUM']) - 1; $a >= count($curing['STUM']) - (setLimit(count($curing['STUM']), $limit)); $a--) : ?>
                                                <tr class="tooltips" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="MACHINE CURING : A01-B01">
                                                    <td class="get-ip" data-ip="<?= $curing['STUM'][$a]['MAT_CODE']; ?>"><?= $curing['STUM'][$a]['MAT_CODE']; ?></td>
                                                    <td><?= $curing['STUM'][$a]['GAP']; ?></td>
                                                </tr>
                                            <?php endfor; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>




            </div>


        </div>
    </div>
</section>

<div class="modal fade" id="modalAct" tabindex="-1" aria-labelledby="modalActLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalActLabel">Detail IP Act vs Plan - <span class="fw-bold" id="res-ip"></span></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table w-100 table1" id="area_lod_act">
                    <thead>
                        <tr>
                            <th>DATE</th>
                            <th>IP</th>
                            <!-- <th>MCH</th> -->
                            <th>ACT</th>
                            <th>PLAN</th>
                            <th>GAP</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody id="res-table">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalMch" tabindex="-1" aria-labelledby="modalMchLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalMchLabel">Detail MCH - <span class="fw-bold" id="res-mch"></span></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">

                        <table class="table w-100 table2" id="area_lod">
                            <thead>
                                <tr>
                                    <th>IP</th>
                                    <!-- <th>MCH</th> -->
                                    <th>ACT</th>
                                    <th>PLAN</th>
                                    <th>GAP</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody id="res-table-mch">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?= $this->endSection('content') ?>

<?= $this->section('script') ?>

<script>
    // let tooltipelemets = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    // tooltipelemets.forEach((el) => {
    //     new bootstrap.Tooltip(el);
    // });

    var colorDanger = "rgb(220, 53, 69)";
    var colorWarning = "rgb(255, 193, 7)";

    const modalAct = new bootstrap.Modal('#modalAct', {
        keyboard: false
    })

    const modalMch = new bootstrap.Modal('#modalMch', {
        keyboard: false
    })

    // table detail IP
    var datatable1 = $('.table1').DataTable({
        dom: 'Bflrtip',
        buttons: [{
            extend: 'excel',
            className: "btn btn-sm bg-tranparent btn-warning",
            footer: true
        }, ],
        "pageLength": -1,
        "lengthMenu": [
            [5, 100, 1000, -1],
            [5, 100, 1000, "ALL"],
        ],
        // order dari tanggal sekarang
        order: [
            [0, 'desc']
        ],
        ajax: {
            url: '<?= base_url($_page->link . '/ajax_curingip'); ?>',
            type: "GET",
            data: {
                'ip': function() {
                    return $('#ip').val()
                },
                'bulan': function() {
                    return $('#bulan').val()
                },
                'tahun': function() {
                    return $('#tahun').val()
                },
            },
            beforeSend: function() {
                loading('area_lod_act');

            },
            complete: function() {
                unblock('area_lod_act');
            },
        },
        columns: [{
                data: 'PS_DATE'
            }, {
                data: 'MAT_CODE'
            },
            // {
            //     data: 'MCH_TYPE'
            // },
            {
                data: 'ACT'
            },
            {
                data: 'PLAN'
            },
            {
                data: 'GAP'
            },
            {
                data: 'STATUS'
            },
        ],
    });

    var datatable2 = $('.table2').DataTable({
        processing: false,
        fixedHeader: true,
        dom: 'Bflrtip',
        buttons: [{
            extend: 'excel',
            className: "btn btn-sm bg-tranparent btn-warning",
            footer: true
        }, ],
        "pageLength": -1,
        "lengthMenu": [
            [5, 100, 1000, -1],
            [5, 100, 1000, "ALL"],
        ],
        // order dari GAP gede
        order: [
            [4, 'desc']
        ],
        ajax: {
            url: '<?= base_url($_page->link . '/ajax_curingmachine'); ?>',
            type: "GET",
            data: {
                'mch': function() {
                    return $('#mch').val()
                },
                'bulan': function() {
                    return $('#bulan').val()
                },
                'tahun': function() {
                    return $('#tahun').val()
                },
            },
            beforeSend: function() {
                loading('area_lod');

            },
            complete: function() {
                unblock('area_lod');
            },
        },
        columns: [{
                data: 'MAT_CODE'
            },
            // {
            //     data: 'MCH_TYPE'
            // },
            {
                data: 'ACT'
            },
            {
                data: 'PLAN'
            },
            {
                data: 'GAP'
            },
            {
                render: function(data, type, row, meta) {
                    return `<button onclick="detailIp('` + row.MAT_CODE + `')"  class="btn btn-sm btn-warning">Detail</button>`;
                }
            },
        ],
    });

    $('.get-mch').on('click', function() {
        const mch = $(this).attr('data-mch');
        $('#mch').val(mch);
        $('#res-mch').html(mch);
        datatable2.ajax.reload();
        modalMch.show();
    });

    $('#submit').on('click', function() {
        const bulan = $('#bulan').val();
        const tahun = $('#tahun').val();

        window.location.href = '<?= base_url($_page->link . '/chart_curing'); ?>/' + bulan + '/' + tahun;
    })

    function detailIp(ip) {
        $('#ip').val(ip);
        datatable1.ajax.reload();
        $('#res-ip').html(ip);
        modalAct.show();
        const bulan = $('#bulan').val();
        const tahun = $('#tahun').val();
        modalMch.hide();

    }


    $('.get-ip').on('click', function() {
        const ip = $(this).attr('data-ip');
        detailIp(ip);
    })


    var data = {
        labels: ['MRU1'],
        datasets: [{
            label: 'Plan',
            data: [<?= $mru1['plan']; ?>],
            backgroundColor: [
                colorDanger,
            ],
            borderColor: [
                'rgba(255, 26, 104, 1)',
            ],
            borderWidth: 1
        }, {
            label: 'Act',
            data: [<?= $mru1['act']; ?>],
            borderColor: [
                'rgb(255,193,7,1)',
            ],
            borderWidth: 1
        }]
    };

    // config 
    var config = {
        type: 'bar',
        data,
        plugins: [ChartDataLabels],
        options: {
            plugins: {
                datalabels: {
                    color: colorWarning,
                    anchor: 'center',
                    align: 'end',
                    // display: false,
                    font: {
                        // size: 10
                        size: 14
                    },
                    formatter: (value, context) => {
                        return (parseFloat(value) / 1000).toFixed(1) + 'K';
                    },
                    rotation: 0
                },
                legend: {
                    // https://www.chartjs.org/docs/latest/configuration/legend.html
                    display: true,
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 14
                        },
                        color: colorWarning,
                    },
                },
                title: {
                    // https://www.chartjs.org/docs/latest/configuration/title.html
                    display: false,
                    text: 'Chart',
                    color: colorWarning,
                    position: 'top',
                    font: {
                        size: 20
                    }
                },
                labels: {
                    display: false
                }
            },
            scales: {
                x: {
                    stacked: false,
                    display: false,
                    // hidden hari bawah
                    ticks: {
                        color: colorWarning,
                        // maxRotation: 90,
                        // minRotation: 90
                    }
                },
                y: {
                    stacked: false,
                    display: false,
                    ticks: {
                        color: colorWarning,
                    },
                    title: {
                        display: false,
                        color: colorWarning,
                    }
                },
            }
        }
    };

    // render init block
    const mruChart = new Chart(
        document.getElementById('mruChart'),
        config
    );


    // setup 
    var data = {
        labels: ['BTUM'],
        datasets: [{
            label: 'Plan',
            data: [<?= $btum['plan']; ?>],
            backgroundColor: [
                colorDanger,
            ],
            borderColor: [
                'rgba(255, 26, 104, 1)',
            ],
            borderWidth: 1
        }, {
            label: 'Act',
            data: [<?= $btum['act']; ?>],
            borderColor: [
                'rgb(255,193,7,1)',
            ],
            borderWidth: 1
        }]
    };

    // config 
    var config = {
        type: 'bar',
        data,
        plugins: [ChartDataLabels],
        options: {
            plugins: {
                datalabels: {
                    color: colorWarning,
                    anchor: 'center',
                    align: 'end',
                    // display: false,
                    font: {
                        // size: 10
                        size: 14
                    },
                    formatter: (value, context) => {
                        return (parseFloat(value) / 1000).toFixed(1) + 'K';
                    },
                    rotation: 0
                },
                legend: {
                    // https://www.chartjs.org/docs/latest/configuration/legend.html
                    display: true,
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 14
                        },
                        color: colorWarning,
                    },
                },
                title: {
                    // https://www.chartjs.org/docs/latest/configuration/title.html
                    display: false,
                    text: 'Plan VS Actual April 2023',
                    color: colorWarning,
                    position: 'top',
                    font: {
                        size: 20
                    }
                },
                labels: {
                    display: false
                }
            },
            scales: {
                x: {
                    stacked: false,
                    display: false,
                    // hidden hari bawah
                    ticks: {
                        color: colorWarning,
                        // maxRotation: 90,
                        // minRotation: 90
                    }
                },
                y: {
                    stacked: false,
                    display: false,
                    ticks: {
                        color: colorWarning,
                    },
                    title: {
                        display: false,
                        color: colorWarning,
                    }
                },
            }
        }
    };

    // render init block
    const btumChart = new Chart(
        document.getElementById('btumChart'),
        config
    );

    // setup 
    var data = {
        labels: ['SBTU'],
        datasets: [{
            label: 'Plan',
            data: [<?= $sbtu['plan']; ?>],
            backgroundColor: [
                colorDanger,
            ],
            borderColor: [
                'rgba(255, 26, 104, 1)',
            ],
            borderWidth: 1
        }, {
            label: 'Act',
            data: [<?= $sbtu['act']; ?>],
            borderColor: [
                'rgb(255,193,7,1)',
            ],
            borderWidth: 1
        }]
    };

    // config 
    var config = {
        type: 'bar',
        data,
        plugins: [ChartDataLabels],
        options: {
            plugins: {
                datalabels: {
                    color: colorWarning,
                    anchor: 'center',
                    align: 'end',
                    // display: false,
                    font: {
                        // size: 10
                        size: 14
                    },
                    formatter: (value, context) => {
                        return (parseFloat(value) / 1000).toFixed(1) + 'K';
                    },
                    rotation: 0
                },
                legend: {
                    // https://www.chartjs.org/docs/latest/configuration/legend.html
                    display: true,
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 14
                        },
                        color: colorWarning,
                    },
                },
                title: {
                    // https://www.chartjs.org/docs/latest/configuration/title.html
                    display: false,
                    text: 'Plan VS Actual April 2023',
                    color: colorWarning,
                    position: 'top',
                    font: {
                        size: 20
                    }
                },
                labels: {
                    display: false
                }
            },
            scales: {
                x: {
                    stacked: false,
                    display: false,
                    // hidden hari bawah
                    ticks: {
                        color: colorWarning,
                        // maxRotation: 90,
                        // minRotation: 90
                    }
                },
                y: {
                    stacked: false,
                    display: false,
                    ticks: {
                        color: colorWarning,
                    },
                    title: {
                        display: false,
                        color: colorWarning,
                    }
                },
            }
        }
    };

    // render init block
    const SBTUChart = new Chart(
        document.getElementById('SBTUChart'),
        config
    );

    // setup 
    var data = {
        labels: ['STUM'],
        datasets: [{
            label: 'Plan',
            data: [<?= $stum['plan']; ?>],
            backgroundColor: [
                colorDanger,
            ],
            borderColor: [
                'rgba(255, 26, 104, 1)',
            ],
            borderWidth: 1
        }, {
            label: 'Act',
            data: [<?= $stum['act']; ?>],
            borderColor: [
                'rgb(255,193,7,1)',
            ],
            borderWidth: 1
        }]
    };

    // config 
    var config = {
        type: 'bar',
        data,
        plugins: [ChartDataLabels],
        options: {
            plugins: {
                datalabels: {
                    color: colorWarning,
                    anchor: 'center',
                    align: 'end',
                    // display: false,
                    font: {
                        // size: 10
                        size: 14
                    },
                    formatter: (value, context) => {
                        return (parseFloat(value) / 1000).toFixed(1) + 'K';
                    },
                    rotation: 0
                },
                legend: {
                    // https://www.chartjs.org/docs/latest/configuration/legend.html
                    display: true,
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 14
                        },
                        color: colorWarning,
                    },
                },
                title: {
                    // https://www.chartjs.org/docs/latest/configuration/title.html
                    display: false,
                    text: 'Plan VS Actual April 2023',
                    color: colorWarning,
                    position: 'top',
                    font: {
                        size: 20
                    }
                },
                labels: {
                    display: false
                }
            },
            scales: {
                x: {
                    stacked: false,
                    display: false,
                    // hidden hari bawah
                    ticks: {
                        color: colorWarning,
                        // maxRotation: 90,
                        // minRotation: 90
                    }
                },
                y: {
                    stacked: false,
                    display: false,
                    ticks: {
                        color: colorWarning,
                    },
                    title: {
                        display: false,
                        color: colorWarning,
                    }
                },
            }
        }
    };

    // render init block
    const stumChart = new Chart(
        document.getElementById('stumChart'),
        config
    );
</script>
<?= $this->endSection('script') ?>
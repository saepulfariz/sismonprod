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
                    <div class="row">
                        <form action="" method="get" class="noprint">
                            <div class="row mt-3">
                                <div class="col-md-2">
                                    <div class="mb-2">
                                        <select name="bulan" id="bulan" class="form-control">
                                            <?php for ($a = 1; $a < 13; $a++) : ?>
                                                <?php if (date('m', strtotime($bulan)) == $a) : ?>

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
                                <div class="col-md-4">
                                    <button type="button" id="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" id="png" class="btn btn-success">Download</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-12 w-100" id="area_lod">
                            <canvas id="myChart"></canvas>
                            <!-- <button id="png">Download</button> -->
                        </div>
                    </div>
                </div>




            </div>


        </div>
    </div>
</section>


<?= $this->endSection('content') ?>



<?= $this->section('script') ?>
<script>
    var colorWarning = "rgb(255, 193, 7)";

    function colorize(opaque) {
        return (ctx) => {
            // const v = ctx.parsed.y;
            // jika indexAxis: 'y', maka x yang di baca nya
            const v = ctx.raw;

            const c = v < 0 ? 'rgb(255,0,0)' :
                'rgb(25,135,84)';

            // return opaque ? c : Utils.transparentize(c, 1 - Math.abs(v / 150));
            // https://stackoverflow.com/questions/67210101/utils-package-in-chart-js
            return opaque ? c : Samples.utils.transparentize(c, 1 - Math.abs(v / 150));
        };
    }

    const plugin = {
        id: 'customCanvasBackgroundColor',
        beforeDraw: (chart, args, options) => {
            const {
                ctx
            } = chart;
            ctx.save();
            ctx.globalCompositeOperation = 'destination-over';
            // ctx.fillStyle = options.color || '#212529';
            ctx.fillStyle = options.color || '#fff';
            ctx.fillRect(0, 0, chart.width, chart.height);
            ctx.restore();
        }
    };


    const data = {
        labels: [
            'TOTAL',
            'PIRELLI',
            'ASPIRA',
            'OE',
            'RPLC',
            'BTU',
            'STU',
            'MRU',
        ],
        datasets: [{
            label: 'K Pieces',
            data: <?= json_encode($data); ?>,
            backgroundColor: colorize(true),
            // fill: false,
            borderColor: colorize(true),
            tension: 0.1
        }, ]
    };

    // config 
    const config = {
        type: 'bar',
        data,
        plugins: [ChartDataLabels, plugin],
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: {
                datalabels: {
                    color: colorWarning,
                    anchor: 'end',
                    align: 'end',
                    // display: false,
                    font: {
                        size: 12
                        // size: 12
                    },
                    formatter: (value, context) => {
                        return (parseFloat(value) / 1000).toFixed(1) + ' K';
                    },
                    rotation: 0
                },
                legend: {
                    // https://www.chartjs.org/docs/latest/configuration/legend.html
                    display: true,
                    position: 'bottom',
                    labels: {
                        color: colorWarning,
                    }
                },
                title: {
                    // https://www.chartjs.org/docs/latest/configuration/title.html
                    display: true,
                    text: 'Plan VS Actual <?= $bulan; ?> <?= $tahun; ?>',
                    color: colorWarning,
                    position: 'top',
                    font: {
                        size: 20
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.yLabel;
                        },
                        label: function(context) {
                            // console.log(context);
                            // context.formattedValue
                            return context.dataset.label + ' : ' + context.formattedValue +
                                '';
                        },
                        title: function(context) {

                        },

                    }
                },
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
                    // display: false,
                    ticks: {
                        color: colorWarning,
                    },
                    title: {
                        display: true,
                        color: colorWarning,
                    }
                },
            }
        }
    };

    // render init block
    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );

    function getChart() {
        var bulan = $('#bulan').val();
        var tahun = $('#tahun').val();

        $('.reload').html('Loading..');
        $('.reload').addClass('disabled');
        loading('area_lod');

        $.ajax({
            url: '<?= base_url(); ?>laporan/inbound_chart_ajax',
            method: 'GET', // POST
            data: {
                bulan: bulan,
                tahun: tahun,
            },
            dataType: 'json', // json
            success: function(data) {
                addData(myChart, data, 0);
                unblock('area_lod');
                $('.reload').html('Submit');
                $('.reload').removeClass('disabled');
            }
        });
    }


    $('#submit').on('click', function() {
        getChart();
    })


    function addData(chart, data, datasetIndex) {

        // chart.data.labels = data.LABEL;
        chart.data.datasets[0].data = data.data;
        chart.options.plugins.title = {
            // https://www.chartjs.org/docs/latest/configuration/title.html
            display: true,
            text: 'Chart Inbound ' + data.bulan + ' ' + data.tahun,
            color: colorWarning,
            position: 'top',
            font: {
                size: 20
            }
        };

        chart.update();

    }

    document.getElementById('png').addEventListener('click', function() {

        // var a = document.getElementById('#png');
        var a = document.createElement('a');
        a.href = myChart.toBase64Image();
        a.download = 'my_chart.png';
        a.click();
    })
    // https://www.youtube.com/watch?v=jlgeG5K6bBg&t=484s
</script>
<?= $this->endSection('script') ?>
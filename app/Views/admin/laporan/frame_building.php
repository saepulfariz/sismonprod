<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart Building</title>

    <link rel="stylesheet" href="<?= base_url(); ?>public/assets/compiled/css/app.css">
</head>

<body class="bg-transparent">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <canvas id="chartBt"></canvas>

            </div>
        </div>
    </div>

    <script src="<?= base_url(); ?>public/assets/extensions/jquery/jquery.min.js"></script>
    <script src="<?= base_url(); ?>public/assets/extensions/chart.js/chart3.js"></script>
    <script src="<?= base_url(); ?>public/assets/extensions/chart.js/chart.utils.js"></script>
    <script src="<?= base_url(); ?>public/assets/extensions/chart.js/chartjs-plugin-datalabels.min.js"></script>

    <script>
        // var colorText = "#FFC107";
        var colorText = "#000";

        function colorize(opaque) {
            return (ctx) => {
                const v = ctx.parsed.y;

                const c = v < 60 ? '#D60000' :
                    v < 80 ? '#FFA500' :
                    v < 100 ? '#44DE28' :
                    '#44DE28';

                // return opaque ? c : Utils.transparentize(c, 1 - Math.abs(v / 150));
                // https://stackoverflow.com/questions/67210101/utils-package-in-chart-js
                return opaque ? c : Samples.utils.transparentize(c, 1 - Math.abs(v / 150));
                // return opaque ? c : '#000000';
            };
        }
        var data = {
            labels: <?= json_encode($chart['label']); ?>,
            datasets: [
                <?php $a = 0;
                foreach ($chart['res'] as $d) : ?> {
                        label: 'Data Building ',
                        data: <?= json_encode($d); ?>,
                        backgroundColor: colorize(true),
                        borderColor: [
                            'rgb(254,221,0)'
                        ],
                        borderWidth: 1,
                        stack: 'Stack <?= $a++; ?>'
                    },
                <?php endforeach; ?>

            ],

        };

        // config 
        var config = {
            type: 'bar',
            data,
            options: {
                scales: {
                    y: {
                        ticks: {
                            color: '#FFFFFF',
                            // Include a dollar sign in the ticks
                            callback: function(value, index, ticks) {
                                return value + '%';
                            }
                        },
                        title: {
                            color: colorText,
                            display: true,
                            text: 'PERFORMANCE',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        },
                        stacked: true


                    },
                    x: {
                        ticks: {
                            color: colorText,
                            autoSkip: false,
                            maxRotation: 45,
                            minRotation: 45
                        },
                        title: {
                            color: colorText,
                            display: true,
                            text: 'MACHINE',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        },
                        stacked: true
                    }
                },
                datalabels: {
                    formatter: (value, ctx) => {
                        return value;
                    },
                    color: '#fff',
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Chart Building PT. Evoluzione Tyres',
                        padding: 20,
                        color: colorText,
                        font: {
                            size: 14
                        }
                    },
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        callbacks: {
                            // label: function(tooltipItem) {
                            //     return tooltipItem.yLabel;
                            // },
                            // beforeTitle: function(context) {
                            //     return 'Before';
                            // },
                            afterTitle: function(context) {
                                return 'MCH CODE : ' + context[0].label;
                            },
                            label: function(context) {
                                // return 'Before';
                                // console.log(context);
                                // label : context.label
                                // value : context.formattedValue
                                // return 'MCH ' + context.formattedValue;
                                // return true;
                            },
                            title: function(context) {

                            },
                            beforeBody: function(context) {
                                // console.log(context);
                                return 'ACTUAL : ';
                            },
                            afterBody: function(context) {
                                return 'PERFORMANCE : ' + context[0].formattedValue + '%';
                            },
                            beforeFooter: function(context) {
                                // console.log(context);
                                return 'IP CODE : ';
                            },
                            afterFooter: function(context) {
                                // console.log(context);
                                // return 'IP CODE : ' + data.res[context[0].dataIndex].ip_code;


                                return 'MAT SAP CODE : ' + '\n' + 'Time : ';
                            },
                        }
                    },
                    datalabels: {
                        color: colorText,
                        anchor: 'end',
                        align: 'top',
                        formatter: (value, context) => {
                            // console.log(context);
                            // ipcode + persen
                            return 'Loading\n' + value + '%';
                        },
                        rotation: 320
                    }
                },
            },
            plugins: [ChartDataLabels]
        };

        // render init block
        const chartBt = new Chart(
            document.getElementById('chartBt'),
            config
        );

        function updateChart() {

            $.ajax({
                url: "<?= base_url($_page->link . '/ajax_chart_building'); ?>",
                method: "GET",
                data: {
                    'mch': '<?= $mch; ?>'
                },
                dataType: "JSON",
                success: function(result) {
                    addData(chartBt, result, 0);
                }
            });
        }

        // setInterval(updateChart, 2000); 2 detik
        setInterval(updateChart, 10000);


        function addData(chart, data, datasetIndex) {


            chart.options = {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Chart Building PT. Evoluzione Tyres',
                        padding: 20,
                        color: colorText,
                        font: {
                            size: 14
                        }
                    },
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        callbacks: {
                            // label: function(tooltipItem) {
                            //     return tooltipItem.yLabel;
                            // },
                            // beforeTitle: function(context) {
                            //     return 'Before';
                            // },
                            afterTitle: function(context) {
                                // return 'MCH CODE : ' + context[0].label;

                                // ambil dari label mch yang ada
                                return 'MCH CODE : ' + data.label[context[0].dataIndex];

                            },
                            label: function(context) {
                                // return 'Before';
                                // console.log(context);
                                // label : context.label
                                // value : context.formattedValue
                                // return 'MCH ' + context.formattedValue;
                                // return true;
                            },
                            title: function(context) {

                            },
                            beforeBody: function(context) {



                                // + data.actual[context.datasetIndex][context.dataIndex]
                                // console.log(context);
                                return 'ACTUAL : ' + data.actual[context[0].datasetIndex][context[0].dataIndex];

                            },
                            afterBody: function(context) {

                                // data.res[context.datasetIndex][context.dataIndex]
                                return 'PERFORMANCE : ' + data.res[context[0].datasetIndex][context[0].dataIndex] + '%';
                            },
                            beforeFooter: function(context) {

                                return 'IP CODE : ' + data.ip_code[context[0].datasetIndex][context[0].dataIndex];
                                // console.log(context);
                            },
                            afterFooter: function(context) {

                                // return 'MAT SAP CODE : ' + data.mat_sap_code[context[0].dataIndex];

                                return 'MAT SAP CODE : ' + data.mat_sap_code[context[0].datasetIndex][context[0].dataIndex] + '\n' + 'Time : ' + data.time_start[context[0].datasetIndex][context[0].dataIndex].split(' ')[1].split('.00')[0] + '-' + data.time_end[context[0].datasetIndex][context[0].dataIndex].split(' ')[1].split('.00')[0];

                            },
                        },
                        // backgroundColor: '#227799'
                    },
                    datalabels: {
                        color: colorText,
                        anchor: 'end',
                        align: 'top',
                        formatter: (value, context) => {
                            // console.log(context);
                            // ipcode + persen
                            return data.ip_code[context.datasetIndex][context.dataIndex] + '\n' + value + '%';
                        },
                        rotation: 320
                    }

                },
                scales: {
                    y: {
                        ticks: {
                            color: '#000',
                            // Include a dollar sign in the ticks
                            callback: function(value, index, ticks) {
                                return value + '%';
                            }
                        },
                        title: {
                            color: colorText,
                            display: true,
                            text: 'PERFORMANCE',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        },
                        stacked: true


                    },
                    x: {
                        ticks: {
                            color: colorText,
                            autoSkip: false,
                            maxRotation: 45,
                            minRotation: 45
                        },
                        title: {
                            color: colorText,
                            display: true,
                            text: 'MACHINE',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        },
                        stacked: true
                    }
                },
                datalabels: {
                    formatter: (value, ctx) => {
                        return value;
                    },
                    color: '#fff',
                }
            };



            chart.data.labels = data.label;
            for (let i = 0; i < data.res.length; i++) {

                chart.data.datasets[i].data = data.res[i];
                chart.data.datasets[i].stack = "Stack " + i;
            }


            chart.update();
        }

        // chart ST
    </script>

</body>

</html>
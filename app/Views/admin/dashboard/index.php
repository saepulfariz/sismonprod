<?= $this->extend('admin/template/index') ?>

<?= $this->section('content') ?>
<link rel="stylesheet" crossorigin href="<?= base_url(); ?>public/assets/compiled/css/iconly.css">
<?= $this->endSection('content') ?>
<?= $this->section('content') ?>
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3 class="text-capitalize">Dashboard</h3>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">

        <?= breadcrumb(); ?>
      </nav>
    </div>
  </div>
</div>
<section class="row">
  <div class="col-12 col-lg-10">
    <div class="row mb-2">
      <div class="col-md-3">
        <div class="input-group mb-3">
          <span class="input-group-text">Start</span>
          <input type="date" id="start_total" name="start_total" class="form-control" value="<?= $start_total; ?>" placeholder="Start">
        </div>
      </div>
      <div class="col-md-3">
        <div class="input-group mb-3">
          <span class="input-group-text">End</span>
          <input type="date" id="end_total" name="end_total" class="form-control" value="<?= $end_total; ?>" placeholder="End">
        </div>
      </div>
      <div class="col-md-3">
        <button type="button" id="submit-total" class="btn btn-primary">Submit</button>
      </div>
    </div>
    <div class="row">
      <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
          <div class="card-body px-4 py-4-5">
            <div class="row">
              <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                <div class="stats-icon blue mb-2">
                  <!-- <i class="iconly-boldProfile"></i> -->
                  <i class="fas fa-clipboard-list"></i>
                </div>
              </div>
              <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                <h6 class="text-muted font-semibold">Plan Curing <span class="today">Today</span></h6>
                <h6 class="font-extrabold mb-0" id="plan-curing"><?= $plan_curing; ?></h6>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
          <div class="card-body px-4 py-4-5">
            <div class="row">
              <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                <div class="stats-icon  mb-2">
                  <i class="fas fa-ring"></i>
                </div>
              </div>
              <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                <h6 class="text-muted font-semibold">Act Curing <span class="today">Today</span></h6>

                <h6 class="font-extrabold mb-0" id="act-curing"><?= $act_curing; ?></h6>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
          <div class="card-body px-4 py-4-5">
            <div class="row">
              <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                <div class="stats-icon green mb-2">
                  <i class="fas fa-clipboard-list"></i>
                </div>
              </div>
              <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                <h6 class="text-muted font-semibold">Plan Inbound <span class="today">Today</span></h6>
                <h6 class="font-extrabold mb-0" id="plan-inbound"><?= $plan_inbound; ?></h6>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
          <div class="card-body px-4 py-4-5">
            <div class="row">
              <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                <div class="stats-icon bg-warning mb-2">
                  <i class="fas fa-dolly-flatbed"></i>
                </div>
              </div>
              <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                <h6 class="text-muted font-semibold">Act Inbound <span class="today">Today</span></h6>
                <h6 class="font-extrabold mb-0" id="act-inbound"><?= $act_inbound; ?></h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-12 col-lg-10">
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-header">
            <h3>Production Building Daily</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                <div class="input-group mb-3">
                  <span class="input-group-text">Start</span>
                  <input type="date" id="start_chart" name="start_chart" class="form-control" value="<?= $start_chart; ?>" placeholder="Start">
                </div>
              </div>
              <div class="col-md-3">
                <div class="input-group mb-3">
                  <span class="input-group-text">End</span>
                  <input type="date" id="end_chart" name="end_chart" class="form-control" value="<?= $end_chart; ?>" placeholder="End">
                </div>
              </div>
              <div class="col-md-3">
                <button type="button" id="submit-chart" class="btn btn-primary">Submit</button>
              </div>
            </div>
            <div class="row">
              <canvas id="chart-daily"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?= $this->endSection('content') ?>


<?= $this->section('script') ?>
<!-- Need: Apexcharts -->
<!-- <script src="<?= base_url(); ?>public/assets/extensions/apexcharts/apexcharts.min.js"></script> -->
<!-- <script src="<?= base_url(); ?>public/assets/static/js/pages/dashboard.js"></script> -->

<script>
  function ajaxTotalDashboard() {
    var start = $('#start_total').val();
    var end = $('#end_total').val();
    var now = '<?= date('Y-m-d'); ?>';
    $('#submit-total').html('Loading');

    $.ajax({
      url: "<?= base_url('dashboard/ajax_total'); ?>",
      method: "GET",
      data: {
        start: start,
        end: end,
      },
      dataType: "JSON",
      success: function(result) {
        $('#submit-total').html('Submit');
        if (start == now && end == now) {
          $('.today').html('Today');
        } else {
          $('.today').html('');
        }
        $('#plan-curing').html(result.data.plan_curing);
        $('#act-curing').html(result.data.act_curing);
        $('#plan-inbound').html(result.data.plan_inbound);
        $('#act-inbound').html(result.data.act_inbound);
      }
    });

  }

  $('#submit-total').on('click', ajaxTotalDashboard);

  var ctx1 = $("#chart-daily").get(0).getContext("2d");
  var myChart1 = new Chart(ctx1, {
    type: "bar",
    data: {
      labels: <?= json_encode($chart['label']); ?>,
      datasets: [{
        label: "Act Building",
        data: <?= json_encode($chart['data']); ?>,
        backgroundColor: "rgb(57,80,162)"
      }]
    },
    options: {
      responsive: true
    }
  });



  function addData(chart, data, datasetIndex) {

    chart.data.labels = data.label;
    chart.data.datasets[0].data = data.data;

    chart.update();

  }

  function ajaxChart() {
    var start = $('#start_chart').val();
    var end = $('#end_chart').val();
    var now = '<?= date('Y-m-d'); ?>';
    $('#submit-chart').html('Loading');

    $.ajax({
      url: "<?= base_url('dashboard/ajax_chart'); ?>",
      method: "GET",
      data: {
        start: start,
        end: end,
      },
      dataType: "JSON",
      success: function(result) {
        $('#submit-chart').html('Submit');
        addData(myChart1, result, 0);
      }
    });
  }

  $('#submit-chart').on('click', ajaxChart);
</script>
<?= $this->endSection('script') ?>
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
    <div class="row">
      <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
          <div class="card-body px-4 py-4-5">
            <div class="row">
              <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                <div class="stats-icon purple mb-2">
                  <i class="iconly-boldShow"></i>
                </div>
              </div>
              <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                <h6 class="text-muted font-semibold">Plan Building Today</h6>
                <h6 class="font-extrabold mb-0">112.000</h6>
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
                <div class="stats-icon blue mb-2">
                  <i class="iconly-boldProfile"></i>
                </div>
              </div>
              <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                <h6 class="text-muted font-semibold">Plan Curing Today</h6>
                <h6 class="font-extrabold mb-0">183.000</h6>
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
                  <i class="iconly-boldAdd-User"></i>
                </div>
              </div>
              <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                <h6 class="text-muted font-semibold">Plan Inbound Today</h6>
                <h6 class="font-extrabold mb-0">80.000</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-12 col-lg-10">
    <div class="row">
      <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
          <div class="card-body px-4 py-4-5">
            <div class="row">
              <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                <div class="stats-icon purple mb-2">
                  <i class="iconly-boldShow"></i>
                </div>
              </div>
              <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                <h6 class="text-muted font-semibold">Act Building Today</h6>
                <h6 class="font-extrabold mb-0">112.000</h6>
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
                <div class="stats-icon blue mb-2">
                  <i class="iconly-boldProfile"></i>
                </div>
              </div>
              <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                <h6 class="text-muted font-semibold">Act Curing Today</h6>
                <h6 class="font-extrabold mb-0">183.000</h6>
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
                  <i class="iconly-boldAdd-User"></i>
                </div>
              </div>
              <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                <h6 class="text-muted font-semibold">Act Inbound Today</h6>
                <h6 class="font-extrabold mb-0">80.000</h6>
              </div>
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
<?= $this->endSection('script') ?>
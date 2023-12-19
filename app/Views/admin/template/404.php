<?= $this->extend('admin/template/auth') ?>


<?= $this->section('head') ?>
<link rel="stylesheet" href="<?= base_url(); ?>public/assets/compiled/css/error.css">
<?= $this->endSection('head') ?>
<?= $this->section('content') ?>
<div id="error">


  <div class="error-page container">
    <div class="col-md-8 col-12 offset-md-2">
      <div class="text-center">
        <img class="img-error" src="<?= base_url(); ?>public/assets/compiled/svg/error-404.svg" alt="Not Found">
        <h1 class="error-title">Not Found</h1>
        <p class='fs-5 text-gray-600'>The page you are looking not found.</p>
        <a href="<?= $back; ?>" class="btn btn-lg btn-outline-primary mt-0">Go Back</a>
      </div>
    </div>
  </div>


</div>
<?= $this->endSection('content') ?>
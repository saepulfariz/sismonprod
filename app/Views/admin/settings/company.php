<?= $this->extend('admin/template/index') ?>

<?= $this->section('content') ?>
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3 class="text-capitalize"><?= $_page->menu; ?></h3>
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
    <div class="col-md-7">

      <div class="card">

        <div class="card-header border-bottom">
          <h3 class="card-title m-0">Company Settings</h3>
        </div>

        <form action="<?= base_url($_page->link . '/company'); ?>" method="post" enctype="multipart/form-data">
          <input type='hidden' name='_method' value='PUT' />
          <?= csrf_field(); ?>
          <div class="card-body">
            <div class="form-group">
              <label for="company_name">Company Name</label>
              <input type="text" class="form-control" name="company_name" ir="company_name" value="<?= $_page->settings['company_name']; ?>" required="" autofocus="">

            </div>

            <div class="form-group">
              <label for="company_email">Company Email</label>
              <input type="text" class="form-control" name="company_email" ir="company_email" value="<?= $_page->settings['company_email']; ?>" required="" autofocus="">

            </div>

          </div>

          <div class="card-footer">
            <button type="submit" class="btn btn-flat btn-primary">Submit</button>
          </div>
          <!-- /.card-footer-->
        </form>
      </div>
    </div>
  </div>
</section>



<?= $this->endSection('content') ?>


<?= $this->section('script') ?>
<?= $this->endSection('script') ?>
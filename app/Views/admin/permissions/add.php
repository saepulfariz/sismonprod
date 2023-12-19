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
  <div class="card ">
    <div class="card-header border-bottom">
      <h4 class="card-title float-start">List of <span class="text-capitalize"><?= $_page->menu; ?></span></h4>
      <div class="float-end">
        <a href="<?= base_url($_page->link); ?>" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> <span class="text-capitalize"><?= $_page->menu; ?></span></a>
      </div>

    </div>
    <form action="<?= base_url($_page->link); ?>" method="post">
      <?= csrf_field(); ?>
      <div class="card-body">
        <div class="form-group">
          <label for="title">Name</label>
          <input type="text" class="form-control <?= (validation_show_error('title')) ? 'border-danger text-danger' : ''; ?>" id="title" name="title" placeholder="Enter Name" value="<?= old('title'); ?>">
          <span class="text-danger"><?= validation_show_error('title'); ?></span>
        </div>
        <div class="form-group">
          <label for="code">Code</label>
          <input type="text" class="form-control <?= (validation_show_error('code')) ? 'border-danger text-danger' : ''; ?>" id="code" name="code" placeholder="Enter Code" value="<?= old('code'); ?>">
          <span class="text-danger"><?= validation_show_error('code'); ?></span>
          <p class="text-danger">* code must be unique</p>
        </div>
      </div>
      <div class="card-footer">
        <div class="row">
          <div class="col">
            <a href="<?= base_url($_page->link); ?>" onclick="return confirm('Are you sure you want to leave?')" class="btn btn-flat btn-danger"> Cancel</a>
            <button type="submit" class="btn btn-flat btn-primary"> Submit</button>
          </div>
          <div class="col text-end">
          </div>
        </div>
      </div>
    </form>
  </div>
</section>
<?= $this->endSection('content') ?>
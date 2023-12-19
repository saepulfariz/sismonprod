<?= $this->extend('admin/template/index') ?>

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
  <form action="<?= base_url($_page->link); ?>" method="post">
    <div class="row">
      <div class="col-md-12 mb-2">

        <div class="card">

          <div class="card-header">
            <h4 class="card-title float-start">List of <span class="text-capitalize"><?= $_page->title; ?></span></h4>
            <div class="float-end">
              <a href="<?= base_url($_page->link . ''); ?>" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> <?= $_page->title; ?></a>
            </div>

          </div>

          <?= csrf_field(); ?>
          <div class="card-body">

            <div class="row">
              <div class="col-md-12 mb-2">

                <div class="form-group">
                  <label for="dept_id">Department</label>
                  <select name="dept_id" id="dept_id" class="form-control  <?= ($error = validation_show_error('dept_id')) ? 'border-danger' : ''; ?>">
                    <?php foreach ($departments as $d) : ?>
                      <?php if (@old('dept_id') == $d['id']) : ?>
                        <option selected value="<?= $d['id']; ?>"><?= $d['name']; ?></option>
                      <?php else : ?>
                        <option value="<?= $d['id']; ?>"><?= $d['name']; ?></option>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </select>
                  <?= ($error) ? '<span class="error text-danger mb-2">' . $error . '</span>' : ''; ?>
                </div>

                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class=" form-control <?= ($error = validation_show_error('name')) ? 'border-danger' : ''; ?>" id="name" name="name" placeholder="Name" value="<?= old('name'); ?>">
                  <?= ($error) ? '<span class="error text-danger mb-2">' . $error . '</span>' : ''; ?>
                </div>

              </div>
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



        </div>
      </div>
    </div>
  </form>
</section>
<?= $this->endSection('content') ?>
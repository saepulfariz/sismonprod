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
    <div class="col-sm-7">
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
              <label for="formClient-Table">Permissions</label>
              <div class="row">
                <div class="col">
                  <table class="table table-bordered table-striped" id="table-roles">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th width="50" class="text-center"><input type="checkbox" class="check-select-all-p"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (!empty($permissions = model('App\Models\PermissionModel')->findAll())) : ?>
                        <?php foreach ($permissions as $row) : ?>
                          <tr>
                            <td><?= ucfirst($row['title']); ?></td>
                            <td width="50" class="text-center"><input type="checkbox" class="check-select-p" name="permission[]" value="<?= $row['id']; ?>"></td>
                          </tr>
                        <?php endforeach ?>
                      <?php else : ?>
                        <td colspan="2" class="text-center">No Permissions Found</td>
                        </tr>
                      <?php endif ?>
                    </tbody>
                  </table>
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
        </form>
      </div>
    </div>
  </div>
</section>
<?= $this->endSection('content') ?>

<?= $this->section('script') ?>
<script>
  $('.check-select-all-p').on('change', function() {

    $('.check-select-p').attr('checked', $(this).is(':checked'));

  })
</script>
<?= $this->endSection('script') ?>
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
  <div class="card">
    <div class="card-header">
      <h4 class="card-title float-start">List of <span class="text-capitalize"><?= $_page->menu; ?></span></h4>
      <?php if (hasPermissions($_page->menu . '_add')) : ?>
        <div class="float-end">
          <a href="<?= base_url($_page->link . '/new'); ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Create <?= $_page->menu; ?></a>
        </div>
      <?php endif ?>

    </div>
    <div class="card-body">
      <div class="table-responsive datatable-minimal">
        <?php

        $hasEdit = hasPermissions($_page->menu . '_edit');
        $hasDelete = hasPermissions($_page->menu . '_delete');
        $hasView = hasPermissions($_page->menu . '_view');

        ?>
        <table class="table w-100" id="table2">
          <thead>
            <tr>
              <td>No</td>
              <td>Image</td>
              <td>Name</td>
              <td>Email</td>
              <td>Role</td>
              <td>Last Login</td>
              <?php if ($hasEdit) : ?>
                <td>Status</td>
              <?php endif ?>
              <td>Action</td>
            </tr>
          </thead>
          <tbody>

            <?php $a = 1;
            foreach ($data as $d) : ?>
              <tr>
                <td><?= $a++; ?></td>
                <td>
                  <img src="<?= base_url(); ?><?= dirUploadUser(); ?>/<?= $d['image']; ?>?<?= time(); ?>=" width="40" height="40" alt="">
                </td>
                <td><?= $d['name']; ?></td>
                <td><?= $d['email']; ?></td>
                <td><?= $d['title']; ?></td>
                <td><?= date($_page->settings['date_format'], strtotime($d['last_login'])); ?></td>
                <?php if ($hasEdit) : ?>
                  <td>
                    <div class="form-check form-switch">
                      <input class="form-check-input" onchange="updateUserStatus('<?= $d['id']; ?>', $(this).is(':checked') )" type="checkbox" role="switch" id="flexSwitchCheckChecked" <?= ($d['is_active'] == 1) ? 'checked' : ''; ?>>
                    </div>
                  </td>
                <?php endif ?>
                <td>
                  <?php if ($hasEdit) : ?>
                    <a href="<?= base_url($_page->link . '/' . $d['id'] . '/edit'); ?>" class="btn btn-sm btn-outline-primary" title="Edit" data-toggle="tooltip"><i class="fas fa-edit"></i></a>
                  <?php endif ?>
                  <?php if ($hasView) : ?>
                    <a href="<?= base_url($_page->link . '/' . $d['id']); ?>" class="btn btn-sm btn-outline-info" title="View" data-toggle="tooltip"><i class="fas fa-eye"></i></a>
                  <?php endif ?>
                  <?php if ($hasDelete) : ?>
                    <form class="d-inline" action='<?= base_url($_page->link . '/' . $d['id']); ?>' method='post' enctype='multipart/form-data'>
                      <?= csrf_field(); ?>
                      <input type='hidden' name='_method' value='DELETE' />
                      <button type='button' onclick='deleteTombol(this)' class='btn btn-sm btn-outline-danger'><i class="fa fa-trash"></i></button>
                    </form>
                  <?php endif ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
<?= $this->endSection('content') ?>

<?= $this->section('script') ?>
<script>
  window.updateUserStatus = (id, status) => {
    $.get('<?= base_url(); ?><?= $_page->link; ?>/change_status/' + id, {
      status: status
    }, (data, status) => {
      if (data == 'done') {
        // code
      } else {
        alert('Unable to change Status ! Try Again');
      }
    })
  }
</script>
<?= $this->endSection('script') ?>
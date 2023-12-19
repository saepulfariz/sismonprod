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
  <div class="card">
    <div class="card-header">
      <h4 class="card-title float-start">List of <span class="text-capitalize"><?= $_page->title; ?></span></h4>
      <div class="float-end">
        <?php if (hasPermissions($_page->menu . '_import')) : ?>
          <button type="button" data-bs-toggle="modal" data-bs-target="#modal" class="btn btn-success btn-sm">Import</button>
        <?php endif ?>
        <?php if (hasPermissions($_page->menu . '_add')) : ?>
          <a href="<?= base_url($_page->link . '/new'); ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Create <?= $_page->title; ?></a>
        <?php endif ?>
      </div>

    </div>
    <div class="card-body">
      <div class="table-responsive datatable-minimal">
        <?php

        $hasEdit = hasPermissions($_page->menu . '_edit');
        $hasDelete = hasPermissions($_page->menu . '_delete');
        $hasView = hasPermissions($_page->menu . '_view');

        ?>
        <table class="table w-100" id="table-export">
          <thead>
            <tr>
              <td>No</td>
              <td>Mat Sap Code</td>
              <td>Ip Code</td>
              <td>Mat Desc</td>
              <td>Shift</td>
              <td>Hour</td>
              <td>Minute</td>
              <td>Action</td>
            </tr>
          </thead>
          <tbody>

            <?php $a = 1;
            foreach ($data as $d) : ?>
              <tr>
                <td><?= $a++; ?></td>
                <td><?= $d['mat_sap_code']; ?></td>
                <td><?= $d['ip_code']; ?></td>
                <td><?= $d['mat_desc']; ?></td>
                <td><?= $d['target_shift']; ?></td>
                <td><?= $d['target_hour']; ?></td>
                <td><?= $d['target_minute']; ?></td>
                <td>
                  <?php if ($hasEdit) : ?>
                    <a href="<?= base_url($_page->link . '/' . $d['id'] . '/edit'); ?>" class="btn btn-sm btn-outline-primary" title="Edit" data-toggle="tooltip"><i class="fas fa-edit"></i></a>
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

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="<?= base_url($_page->link . '/import'); ?>" method="post" enctype="multipart/form-data">
      <?= csrf_field(); ?>
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalLabel">Import Data</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <a class="fw-bold" href="<?= base_url(); ?>public/example/planned_material.xlsx">Download Format Excel</a>
          <p>
            <span class="text-danger fw-bold">Warning!!</span>
            Backup your data, because this replace data in upload
          </p>
          <div class="mb-2">
            <label for="upload_file">Import Excel</label>
            <input type="file" name="upload_file" id="upload_file" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </form>
  </div>
</div>
<?= $this->endSection('content') ?>
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

        ?>
        <table class="table w-100" id="table-export">
          <thead>
            <tr>
              <td>No</td>
              <td>Ip Seven</td>
              <td>Brand</td>
              <td>Mch Type</td>
              <td>Date</td>
              <td>Rim</td>
              <td>Qty</td>
              <td>Status</td>
              <td>Action</td>
            </tr>
          </thead>
          <tbody>

            <?php $a = 1;
            foreach ($data as $d) : ?>
              <tr>
                <td><?= $a++; ?></td>
                <td><?= $d['ip_seven']; ?></td>
                <td><?= $d['brand']; ?></td>
                <td><?= $d['mch_type']; ?></td>
                <td><?= $d['p_date']; ?></td>
                <td><?= $d['rim']; ?></td>
                <td><?= $d['qty']; ?></td>
                <td><?= $d['status']; ?></td>
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
          <p>Download format excel Upload <a href="<?= base_url('public/example/template_curing_planner.xlsx'); ?>">Disini</a>, </p>
          <div>
            <ul>
              <li>Aplikasi Akomodir <b>7 Hari</b> Planning</li>
              <li>Tanggal sesuai dengan Format English <b>9-May</b></li>
              <li>Kolom <b>BRAND, RIM, Dan MACHINE TYPE</b> required</li>
              <li>Machine Type dengan format <span class="text-danger fw-bold">BTUM SBTU STUM MRU1</span></li>
            </ul>
          </div>
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
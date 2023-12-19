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
        <table class="table w-100" id="table2">
          <thead>
            <tr>
              <td>No</td>
              <td>Name</td>
              <td>Action</td>
            </tr>
          </thead>
          <tbody>

            <?php $a = 1;
            foreach ($data as $d) : ?>
              <tr>
                <td><?= $a++; ?></td>
                <td><?= $d['name']; ?></td>
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

<?= $this->endSection('content') ?>
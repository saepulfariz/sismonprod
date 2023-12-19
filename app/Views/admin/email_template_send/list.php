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
    <div class="col-md-10 mb-2">

      <div class="card">

        <div class="card-header">
          <h4 class="card-title float-start">List of <span class="text-capitalize"><?= $_page->title; ?></span></h4>
          <div class="float-end">
            <a href="<?= base_url($_page->link . '/' . $id . '/new'); ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Create <?= $_page->title; ?></a>
          </div>

        </div>
        <div class="card-body">
          <div class="table-responsive datatable-minimal">
            <table class="table w-100" id="table2">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Template Name</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Type</th>
                  <th>Is Send</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php

                $hasEdit = hasPermissions('email_template_send_edit');
                $hasDelete = hasPermissions('email_template_send_delete');

                ?>
                <?php $a = 1;
                foreach ($data as $d) : ?>
                  <tr>
                    <td><?= $a++; ?></td>
                    <td><?= $d['template_name']; ?></td>
                    <td><?= $d['name']; ?></td>
                    <td><?= $d['email']; ?></td>
                    <td><?= $d['type']; ?></td>
                    <td>
                      <?php if ($d['is_send'] == 1) : ?>
                        <a class="btn btn-success btn-sm" href="<?= base_url($link . '/active/' . $d['id'] . '/0'); ?>">
                          <i class="fas fa-check"></i>
                        </a>
                      <?php else : ?>
                        <a class="btn btn-danger btn-sm" href="<?= base_url($link . '/active/' . $d['id'] . '/1'); ?>">
                          <i class="fas fa-times"></i>
                        </a>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if ($hasEdit) : ?>
                        <a href="<?= base_url($_page->link . '/' . $d['id'] . '/edit'); ?>" class="btn btn-sm mb-2 btn-outline-primary" title="<?php echo lang('App.edit_permission') ?>" data-toggle="tooltip"><i class="fas fa-edit"></i></a>
                      <?php endif ?>
                      <?php if ($hasDelete) : ?>
                        <form class="d-inline" action='<?= base_url($_page->link . '/' . $d['id']); ?>' method='post' enctype='multipart/form-data'>
                          <?= csrf_field(); ?>
                          <input type='hidden' name='_method' value='DELETE' />
                          <button type='button' onclick='deleteTombol(this)' class='btn btn-sm mb-2 btn-outline-danger'><i class="fa fa-trash"></i></button>
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
    </div>
  </div>
</section>


<!-- Modal -->
<div class="modal fade" id="modalTemplates" tabindex="-1" aria-labelledby="modalTemplatesLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalTemplatesLabel"> View Template</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="template-result">
        ...
      </div>
    </div>
  </div>
</div>
<?= $this->endSection('content') ?>


<?= $this->section('script') ?>
<script>
  const modalTemplates = new bootstrap.Modal('#modalTemplates', {
    keyboard: false
  })

  function showTemplate(id) {
    $.ajax({
      url: '<?= base_url($_page->link); ?>/' + id,
      method: 'GET', // POST
      data: {
        // id: id
      },
      dataType: 'json', // json
      success: function(data) {
        // $('#modalTemplates').modal('show');
        modalTemplates.show();
        $('#template-result').html(data.body);
        $('#modalTemplatesLabel').html('View Template - ' + data.name);
      }
    });
  }
</script>
<?= $this->endSection('script') ?>
<?= $this->extend('admin/template/index') ?>

<?= $this->section('content') ?>
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3 class="text-capitalize">Activity Logs</h3>
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
      <h4 class="card-title float-start">View Activity </h4>

    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table w-100 table-striped">
          <tbody>
            <tr>
              <td>ID:</td>
              <td class="fw-bold"><?= $data['id']; ?></td>
            </tr>
            <tr>
              <td>Message:</td>
              <td class="fw-bold"><?= $data['title']; ?></td>
            </tr>
            <tr>
              <td>User:</td>
              <td class="fw-bold"><?= $data['name']; ?> <a href="<?= base_url('users/' . $data['user_id']); ?>"><i class="fas fa-eye"></i></a></td>
            </tr>
            <tr>
              <td>Date Time:</td>
              <td class="fw-bold"><?= date($_page->settings['datetime_format'], strtotime($data['created_at'])) ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
<?= $this->endSection('content') ?>
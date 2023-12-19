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
      <h4 class="card-title float-start">List of All Activites</h4>

    </div>
    <div class="card-body">
      <form action="" method="get">
        <div class="row">
          <div class="col-md-3">
            <div class="input-group mb-3">
              <span class="input-group-text" id="ip">IP</span>
              <input type="text" class="form-control" id="ip" name="ip" value="<?= $ip; ?>">
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group mb-3">
              <span class="input-group-text" id="ip">USER</span>
              <select name="user_id" id="user_id" class="form-control">
                <option value="" selected>== ALL ==</option>
                <?php foreach ($users as $d) : ?>
                  <?php if ($user_id == $d['id']) : ?>
                    <option selected value="<?= $d['id']; ?>"><?= $d['name'] . ' #' . $d['id']; ?></option>
                  <?php else : ?>
                    <option value="<?= $d['id']; ?>"><?= $d['name'] . ' #' . $d['id']; ?></option>
                  <?php endif; ?>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="col-md-3">
            <a href="<?= $_page->link; ?>" class="btn btn-danger">RESET</a>
            <button type="submit" class="btn btn-primary">FILTER</button>
          </div>
        </div>
      </form>
      <div class="table-responsive datatable-minimal">
        <table class="table w-100" id="table2">
          <thead>
            <tr>
              <th>ID</th>
              <th>IP Address</th>
              <th>Message</th>
              <th>Datetime</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php

            $hasView = hasPermissions($_page->menu . '_view');
            $hasUser = hasPermissions('users_view');

            ?>
            <?php $a = 1;
            foreach ($data as $d) : ?>
              <tr>
                <td><?= $a++; ?></td>
                <td>
                  <a href="<?= base_url('activitylogs?ip=' . $d['ip_address']); ?>"><?= $d['ip_address']; ?></a>
                </td>
                <td><?= $d['title']; ?></td>
                <td><?= date($_page->settings['datetime_format'], strtotime($d['created_at'])) ?></td>
                <td>
                  <?php if ($hasView) : ?>
                    <a href="<?= base_url($_page->link . '/' . $d['id']); ?>" class="btn btn-sm btn-outline-secondary mb-2" title="Edit" data-toggle="tooltip"><i class="fas fa-eye"></i></a>
                  <?php endif ?>
                  <?php if ($hasUser) : ?>
                    <a target="_blank" href="<?= base_url('users/' . $d['user_id']); ?>" class="btn btn-sm btn-outline-secondary mb-2" title="View" data-toggle="tooltip"><i class="fas fa-user"></i></a>
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
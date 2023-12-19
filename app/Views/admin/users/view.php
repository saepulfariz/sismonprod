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
      <div class="float-end">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview-tab-pane" type="button" role="tab" aria-controls="overview-tab-pane" aria-selected="true">Overview</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity-tab-pane" type="button" role="tab" aria-controls="activity-tab-pane" aria-selected="false">Activity</button>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" href="<?= base_url($_page->link . '/' . $data['id']); ?>">Edit</a>
          </li>
        </ul>
      </div>

    </div>
    <div class="card-body">
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="overview-tab-pane" role="tabpanel" aria-labelledby="overview-tab" tabindex="0">
          <div class="row">
            <div class="col-sm-2 ">

              <img src="<?= base_url(); ?><?= dirUploadUser(); ?>/<?= $data['image']; ?>?<?= time(); ?>=" width="150" class="rounded-circle text-center mx-auto" alt="">
            </div>
            <div class="col-sm-10" style="padding-left: 50px;">
              <table class="table table-bordered table-striped">
                <tbody>
                  <tr>
                    <td width="160"><strong>Name</strong>:</td>
                    <td><?= $data['name']; ?></td>
                  </tr>
                  <tr>
                    <td><strong>Email</strong>:</td>
                    <td><?= $data['email']; ?></td>
                  </tr>
                  <tr>
                    <td><strong>Contact Number</strong>:</td>
                    <td><?= $data['phone']; ?></td>
                  </tr>
                  <tr>
                    <td><strong>Last Login</strong>:</td>
                    <td><?= date($_page->settings['date_format'], strtotime($data['last_login'])); ?></td>
                  </tr>
                  <tr>
                    <td><strong>Username</strong>:</td>
                    <td><?= $data['username']; ?></td>
                  </tr>
                  <tr>
                    <td><strong>Role</strong>:</td>
                    <td><?= $data['title']; ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="activity-tab-pane" role="tabpanel" aria-labelledby="activity-tab" tabindex="0">
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

                $hasView = hasPermissions('activity_log_view');

                ?>
                <?php $a = 1;
                foreach ($activity as $d) : ?>
                  <tr>
                    <td><?= $a++; ?></td>
                    <td>
                      <a href="<?= base_url('activitylogs?ip=' . $d['ip_address']); ?>"><?= $d['ip_address']; ?></a>
                    </td>
                    <td><?= $d['title']; ?></td>
                    <td><?= date($_page->settings['datetime_format'], strtotime($d['created_at'])) ?></td>
                    <td>
                      <?php if ($hasView) : ?>
                        <a href="<?= base_url('activitylogs/' . $d['id']); ?>" class="btn btn-sm btn-outline-secondary" title="Edit" data-toggle="tooltip"><i class="fas fa-eye"></i></a>
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
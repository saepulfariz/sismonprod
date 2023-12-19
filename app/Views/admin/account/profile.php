<?= $this->extend('admin/template/index') ?>

<?= $this->section('content') ?>
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3 class="text-capitalize">My Account</h3>
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
    <div class="col-md-3 mb-2">

      <!-- Profile Image -->
      <div class="card card-primary">
        <div class="card-body card-profile">
          <div class="text-center">
            <img class="rounded-circle border border-2 mb-2" width="100px" height="100px" src="<?= base_url(); ?><?= dirUploadUser(); ?>/<?= @$user['image']; ?>?<?= time(); ?>" alt="Profile Image" />
          </div>

          <h4 class="profile-username text-center"><?= @$user['name'] ?></h4>

          <p class="text-muted text-center"><?= @$user['title'] ?></p>

          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <b>Username </b> <a class="pull-right"><?= @$user['username'] ?></a>
            </li>
            <li class="list-group-item">
              <b>Last Login</b> <a class="pull-right"><?= date($_page->settings['date_format'], strtotime(@$user['last_login'])); ?></a>
            </li>
            <li class="list-group-item">
              <b>Member Sience </b> <a class="pull-right"><?= date($_page->settings['date_format'], strtotime(@$user['created_at'])); ?></a>
            </li>
          </ul>

          <a href="<?= base_url($_page->link . '/edit'); ?>" class="btn btn-primary btn-block mt-2"><b>Edit</b></a>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </div>

    <div class="col-md-9">
      <div class="card">
        <div class="card-header p-2">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link <?= ($tab == 'profile') ? 'active' : ''; ?>" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="true">Profile</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link <?= ($tab == 'edit') ? 'active' : ''; ?>" id="edit-tab" data-bs-toggle="tab" data-bs-target="#edit-tab-pane" type="button" role="tab" aria-controls="edit-tab-pane" aria-selected="false">Edit</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link <?= ($tab == 'change_picture') ? 'active' : ''; ?>" id="change-picture-tab" data-bs-toggle="tab" data-bs-target="#change-picture-tab-pane" type="button" role="tab" aria-controls="change-picture-tab-pane" aria-selected="false">Change Picture Image</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link <?= ($tab == 'change_password') ? 'active' : ''; ?>" id="change-password-tab" data-bs-toggle="tab" data-bs-target="#change-password-tab-pane" type="button" role="tab" aria-controls="change-password-tab-pane" aria-selected="false">Change Password</button>
            </li>
          </ul>
        </div>
        <div class="card-body pt-3">
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade <?= ($tab == 'profile') ? 'active show' : ''; ?>" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
              <table class="table table-bordered table-striped">
                <tbody>
                  <tr>
                    <td width="160"><strong>Name</strong>:</td>
                    <td><?= @$user['name'] ?></td>
                  </tr>
                  <tr>
                    <td><strong>Username</strong>:</td>
                    <td><?= @$user['username'] ?></td>
                  </tr>
                  <tr>
                    <td><strong>Email</strong>:</td>
                    <td><?= @$user['email'] ?></td>
                  </tr>
                  <tr>
                    <td><strong>Role</strong>:</td>
                    <td><?= @$user['title']; ?></td>
                  </tr>
                  <tr>
                    <td><strong>Contect Number</strong>:</td>
                    <td><?= @$user['phone'] ?></td>
                  </tr>
                  <tr>
                    <td><strong>Address</strong>:</td>
                    <td><?= nl2br(@$user['address']) ?></td>
                  </tr>
                  <tr>
                    <td><strong>Last Login</strong>:</td>
                    <td><?= (@$user['last_login'] != '0000-00-00 00:00:00') ? date($_page->settings['datetime_format'], strtotime(@$user['last_login'])) : 'No Record' ?></td>
                  </tr>
                  <tr>
                    <td><strong>Member Since</strong>:</td>
                    <td><?= (@$user['created_at'] != '0000-00-00 00:00:00') ? date($_page->settings['datetime_format'], strtotime(@$user['created_at'])) : 'No Record' ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="tab-pane fade <?= ($tab == 'edit') ? 'active show' : ''; ?>" id="edit-tab-pane" role="tabpanel" aria-labelledby="edit-tab" tabindex="0">
              <form action="<?= base_url($_page->link . '/update'); ?>" method="post">
                <?= csrf_field(); ?>
                <input type='hidden' name='_method' value='PUT' />
                <div class="form-group">
                  <label for="name" class="control-label">Name</label>

                  <div class="col-sm-10">
                    <input type="name" name="name" required class="form-control" id="name" value="<?= @$user['name'] ?>" autofocus placeholder="Name">
                  </div>
                </div>

                <div class="form-group">
                  <label for="username" class="control-label">Username</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control <?= (validation_show_error('username')) ? 'border-danger text-danger' : ''; ?>" disabled minlength="5" name="username" id="username" required placeholder="Username" value="<?= @$user['username'] ?>" />
                    <span class="text-danger"><?= validation_show_error('username'); ?></span>
                  </div>
                </div>

                <div class="form-group">
                  <label for="email" class="control-label">Email</label>

                  <div class="col-sm-10">
                    <input type="email" name="email" required class="form-control <?= (validation_show_error('email')) ? 'border-danger text-danger' : ''; ?>" id="email" placeholder="Email" value="<?= @$user['email'] ?>">
                    <span class="text-danger"><?= validation_show_error('email'); ?></span>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputContact" class="control-label">Contact Number</label>

                  <div class="col-sm-10">
                    <input type="name" name="contact" class="form-control" id="inputContact" value="<?= @$user['phone'] ?>" placeholder="Contact Number">
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputContact" class="control-label">Address</label>

                  <div class="col-sm-10">
                    <textarea type="text" class="form-control" name="address" id="inputAddress" placeholder="Address" rows="3"><?= @$user['address'] ?></textarea>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary btn-flat">Submit</button>
                  </div>
                </div>
              </form>
            </div>
            <div class="tab-pane fade <?= ($tab == 'change_picture') ? 'active show' : ''; ?>" id="change-picture-tab-pane" role="tabpanel" aria-labelledby="change-picture-tab" tabindex="0">
              <form action="<?= base_url(); ?><?= $_page->link; ?>/updatePicture" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <input type='hidden' name='_method' value='PUT' />
                <div class="form-group">
                  <label for="formAdmin-Image" class="control-label">Profile Image</label>

                  <div class="col-sm-10">
                    <input type="file" class="form-control" name="image" id="formAdmin-Image" placeholder="Upload Image" required accept="image/*" onchange="previewImage(this, '#imagePreview')">
                  </div>
                </div>
                <div class="form-group" id="imagePreview">
                  <div class="col-sm-10">
                    <img src="<?= base_url(); ?><?= dirUploadUser(); ?>/<?= @$user['image']; ?>?<?= time(); ?>" class="img-circle" width="150" alt="Profile Image">
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary btn-flat">Submit</button>
                  </div>
                </div>

              </form>
            </div>
            <div class="tab-pane fade <?= ($tab == 'change_password') ? 'active show' : ''; ?>" id="change-password-tab-pane" role="tabpanel" aria-labelledby="change-password-tab" tabindex="0">
              <form action="<?= base_url(); ?><?= $_page->link; ?>/updatePassword" method="post">
                <?= csrf_field(); ?>
                <input type='hidden' name='_method' value='PUT' />

                <div class="alert alert-warning">
                  <span><i class="fas fa-lock"></i> &nbsp;</span> You will need to login again after password is changed !
                </div>

                <div class="form-group">
                  <label for="inputContact" class="control-label">Old Password</label>

                  <div class="col-sm-10">
                    <div class="input-group">
                      <span class="input-group-text"><i class="fa fa-lock"></i></span>
                      <input type="password" class="form-control" placeholder="Old Password" minlength="6" name="old_password" required autofocus id="old_password" />
                      <!-- <span class="fa fa-lock form-control-feedback"></span> -->
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputContact" class="control-label">New Password</label>

                  <div class="col-sm-10">
                    <div class="input-group">
                      <span class="input-group-text"><i class="fa fa-lock"></i></span>
                      <input type="password" class="form-control" placeholder="New Password" minlength="6" name="password" required autofocus id="password" />
                    </div>
                  </div>
                </div>

                <div class="form-group">

                  <label for="inputContact" class="control-label">Confirm New Password</label>

                  <div class="col-sm-10">
                    <div class="input-group">
                      <span class="input-group-text"><i class="fa fa-lock"></i></span>
                      <input type="password" class="form-control" equalTo="#password" placeholder="Confirm New Password" required name="password_confirm" />
                    </div>
                  </div>

                </div>

                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary btn-flat">Submit</button>
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?= $this->endSection('content') ?>


<?= $this->section('script') ?>
<script>
</script>
<?= $this->endSection('script') ?>
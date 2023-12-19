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
  <form action="<?= base_url($_page->link); ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field(); ?>
    <div class="row">
      <div class="col-sm-6">
        <!-- Default card -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Basic Details</h3>
          </div>
          <div class="card-body">

            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control <?= (validation_show_error('name')) ? 'border-danger text-danger' : ''; ?>" name="name" id="name" placeholder="Enter Name" onkeyup="$('#username').val(createUsername(this.value))" autofocus="" value="<?= old('name'); ?>">
              <span class="text-danger"><?= validation_show_error('name'); ?></span>
            </div>

            <div class="form-group">
              <label for="phone">Contact Number</label>
              <input type="text" class="form-control <?= (validation_show_error('phone')) ? 'border-danger text-danger' : ''; ?>" name="phone" id="phone" placeholder="Enter Contact Number" value="<?= old('phone'); ?>">
              <span class="text-danger"><?= validation_show_error('phone'); ?></span>
            </div>

          </div>
          <!-- /.card-body -->

        </div>
        <!-- /.card -->

        <!-- Default card -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Login Details</h3>
          </div>
          <div class="card-body">

            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control <?= (validation_show_error('email')) ? 'border-danger text-danger' : ''; ?>" name="email" data-rule-remote="https://adminpro.raman.work/users/check" data-msg-remote="Email Already Exists" id="email" required="" placeholder="Enter email" value="<?= old('email'); ?>">
              <span class="text-danger"><?= validation_show_error('email'); ?></span>
            </div>

            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control <?= (validation_show_error('username')) ? 'border-danger text-danger' : ''; ?>" data-rule-remote="https://adminpro.raman.work/users/check" data-msg-remote="Username Already taken" name="username" id="username" required="" placeholder="Enter Username" value="<?= old('username'); ?>">
              <span class="text-danger"><?= validation_show_error('username'); ?></span>
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control <?= (validation_show_error('password')) ? 'border-danger text-danger' : ''; ?>" name="password" minlength="6" id="password" required="" placeholder="Password">
              <span class="text-danger"><?= validation_show_error('password'); ?></span>
            </div>

            <div class="form-group">
              <label for="confirm_password">Confirm Password</label>
              <input type="password" class="form-control <?= (validation_show_error('confirm_password')) ? 'border-danger text-danger' : ''; ?>" name="confirm_password" equalto="#password" id="confirm_password" required="" placeholder="Confirm Password">
              <span class="text-danger"><?= validation_show_error('confirm_password'); ?></span>
            </div>

          </div>
          <!-- /.card-body -->

        </div>
        <!-- /.card -->

      </div>
      <div class="col-sm-6">
        <!-- Default card -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Other Details</h3>
          </div>
          <div class="card-body">

            <div class="form-group">
              <label for="address">Address</label>
              <textarea type="text" class="form-control" name="address" id="address" placeholder="Enter Address" rows="3"></textarea>
            </div>

            <div class="form-group">
              <label for="role_id">Role</label>
              <select name="role_id" id="role_id" class="form-control">
                <?php foreach ($roles as $d) : ?>
                  <option value="<?= $d['id']; ?>"><?= $d['title']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <label for="is_active">Status</label>
              <select name="is_active" id="is_active" class="form-control">
                <option value="1" selected="">Active</option>
                <option value="0">InActive</option>
              </select>
            </div>

          </div>
          <!-- /.card-body -->

        </div>
        <!-- /.card -->

        <!-- Default card -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Profile Image</h3>
          </div>
          <div class="card-body">

            <div class="form-group">
              <label for="image">Image</label>
              <input type="file" class="form-control" name="image" id="image" placeholder="Upload Image" accept="image/*" onchange="previewImage(this, '#imagePreview')">
            </div>
            <div class="form-group" id="imagePreview">
              <img src="<?= base_url(); ?><?= dirUploadUser(); ?>/default.jpg?<?= time(); ?>" class="img-circle" alt="Uploaded Image Preview" width="100" height="100">
            </div>

          </div>
          <!-- /.card-body -->

        </div>
        <!-- /.card -->

      </div>
    </div>

    <!-- Default card -->
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col">
            <a href="<?= base_url($_page->link); ?>" onclick="return confirm('Are you sure you want to leave?')" class="btn btn-flat btn-danger"> Cancel</a>
            <button type="submit" class="btn btn-flat btn-primary"> Submit</button>
          </div>
        </div>
      </div>
      <!-- /.card-footer-->

    </div>
    <!-- /.card -->
  </form>
</section>
<?= $this->endSection('content') ?>

<?= $this->section('script') ?>
<script>
  function previewImage(input, previewDom) {

    if (input.files && input.files[0]) {

      $(previewDom).show();

      var reader = new FileReader();

      reader.onload = function(e) {
        $(previewDom).find('img').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    } else {
      $(previewDom).hide();
    }

  }


  function createUsername(name) {
    return name.toLowerCase()
      .replace(/ /g, '_')
      .replace(/[^\w-]+/g, '');;
  }
</script>
<?= $this->endSection('script') ?>
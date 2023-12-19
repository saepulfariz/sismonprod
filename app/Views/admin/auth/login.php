<?= $this->extend('admin/template/auth') ?>


<?= $this->section('head') ?>
<style>
  .logo {
    /* padding: 2rem 2rem 1rem; */
    font-size: 2rem;
    font-weight: 700;
  }

  .field-icon {
    float: right;
    margin-right: 20px;
    margin-top: -40px;
    position: relative;
    z-index: 2;
    color: #868e96;
  }
</style>
<?= $this->endSection('head') ?>
<?= $this->section('content') ?>
<div id="auth">

  <div class="row h-100">
    <div class="col-lg-5 col-12">
      <div id="auth-left">
        <!-- <div class="auth-logo mb-5">
          <a href="<?= base_url(); ?>"><img src="<?= base_url(); ?>public/assets/compiled/svg/logo.svg" alt="Logo"></a>
        </div> -->
        <div class="logo mb-3">
          <a href="<?= base_url(); ?>">
            <?= setting('company_name', 'test'); ?>
          </a>
        </div>
        <p class="mb-3 fs-3">Login in with your data.</p>
        <form method="post" action="<?= base_url('auth/verify'); ?>">
          <?= csrf_field(); ?>
          <div class="form-group position-relative has-icon-left mb-4">
            <input type="text" required class="form-control form-control-xl <?= (validation_show_error('username')) ? 'border-danger text-danger' : ''; ?>" name="username" id="username" placeholder="Username" value="<?= old('username'); ?>">
            <div class="form-control-icon">
              <i class="bi bi-person"></i>
            </div>
            <span class="text-danger"><?= validation_show_error('username'); ?></span>
          </div>
          <div class="form-group position-relative has-icon-left mb-4">
            <input type="password" required class="form-control form-control-xl <?= (validation_show_error('password')) ? 'border-danger text-danger' : ''; ?>" name="password" id="password" placeholder="Password">
            <div class="form-control-icon">
              <i class="bi bi-shield-lock"></i>
            </div>
            <span toggle="#password" class="bi bi-eye-fill field-icon toggle-password "></span>
            <span class="text-danger"><?= validation_show_error('password'); ?></span>
          </div>
          <?php if (setting('google_recaptcha_enabled') == '1') : ?>
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
            <div class="form-group">
              <div class="g-recaptcha" data-sitekey="<?php echo setting('google_recaptcha_sitekey') ?>"></div>
              <span class="text-danger"><?= validation_show_error('g-recaptcha-response'); ?></span>
            </div>
          <?php endif ?>
          <div class="form-check form-check-lg d-flex align-items-end">
            <input class="form-check-input me-2" name="remember_me" type="checkbox" value="remember_me" id="flexCheckDefault">
            <label class="form-check-label text-gray-600" for="flexCheckDefault">
              Keep me logged in
            </label>
          </div>
          <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
        </form>
        <div class="text-center mt-5 text-lg fs-5">
          <?php if (setting('page_register') == '1') : ?>
            <p class="text-gray-600">Don't have an account? <a href="<?= base_url('register'); ?>" class="font-bold">Sign
                up</a>.</p>
          <?php endif; ?>
          <p>
            <?php if (setting('page_forgot') == '1') : ?>
              <a class="font-bold" href="<?= base_url('forgot-password'); ?>">Forgot password?</a>.
            <?php endif; ?>
          </p>
        </div>
      </div>
    </div>
    <div class="col-lg-7 d-none d-lg-block">
      <div id="auth-right">

      </div>
    </div>
  </div>

</div>
<?= $this->endSection('content') ?>


<?= $this->section('script') ?>
<script>
  $(".toggle-password").click(function() {

    $(this).toggleClass("bi bi-eye-slash-fill");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
</script>
<?= $this->endSection('script') ?>
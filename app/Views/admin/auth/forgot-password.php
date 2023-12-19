<?= $this->extend('admin/template/auth') ?>


<?= $this->section('head') ?>
<style>
  .logo {
    /* padding: 2rem 2rem 1rem; */
    font-size: 2rem;
    font-weight: 700;
  }
</style>
<?= $this->endSection('head') ?>
<?= $this->section('content') ?>
<div id="auth">

  <div class="row h-100">
    <div class="col-lg-5 col-12">
      <div id="auth-left">
        <div class="logo mb-3">
          <a href="<?= base_url(); ?>">
            <?= setting('company_name', 'test'); ?>
          </a>
        </div>
        <p class="mb-3 fs-3">Input your email and we will send you reset password link.</p>
        <form action="<?= base_url('forgot-password'); ?>" method="post">
          <?= csrf_field(); ?>
          <div class="form-group position-relative has-icon-left mb-4">
            <input type="email" name="email" required id="email" class="form-control form-control-xl" placeholder="Email">
            <div class="form-control-icon">
              <i class="bi bi-envelope"></i>
            </div>
          </div>
          <?php if (setting('google_recaptcha_enabled') == '1') : ?>
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
            <div class="form-group">
              <div class="g-recaptcha" data-sitekey="<?php echo setting('google_recaptcha_sitekey') ?>"></div>
              <span class="text-danger"><?= validation_show_error('g-recaptcha-response'); ?></span>
            </div>
          <?php endif ?>
          <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Send</button>
        </form>
        <div class="text-center mt-5 text-lg fs-5">
          <p class='text-gray-600'>Remember your account? <a href="<?= base_url('login'); ?>" class="font-bold">Log in</a>.
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
<?= $this->include('admin/template/header'); ?>
<script src="<?= base_url(); ?>public/assets/static/js/initTheme.js"></script>
<div id="app">
  <?= $this->include('admin/template/sidebar'); ?>
  <div id="main" class='layout-navbar navbar-fixed'>
    <header>
      <?= $this->include('admin/template/topbar'); ?>

    </header>
    <div id="main-content">

      <div class="page-heading">
        <?= $this->renderSection('content'); ?>
      </div>

    </div>
    <footer>
      <div class="footer clearfix mb-0 text-muted">
        <div class="float-start">
          <p><?= copyright($_page->settings['app_year']); ?> &copy; <?= $_page->settings['company_name']; ?> <?= $_page->settings['app_version']; ?></p>
        </div>
        <div class="float-end">
          <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
            by <a target="_blank" href="<?= $_page->settings['app_copyright_link']; ?>"><?= $_page->settings['app_copyright']; ?></a></p>
        </div>
      </div>
    </footer>
  </div>
</div>
<?= $this->include('admin/template/footer'); ?>
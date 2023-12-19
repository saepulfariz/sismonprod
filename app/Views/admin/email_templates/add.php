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
    <div class="col-md-7 mb-2">

      <div class="card">

        <div class="card-header">
          <h4 class="card-title float-start">List of <span class="text-capitalize"><?= $_page->title; ?></span></h4>
          <div class="float-end">
            <a href="<?= base_url($_page->link . '/new'); ?>" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Create <?= $_page->title; ?></a>
          </div>

        </div>
        <form action="<?= base_url($_page->link); ?>" method="post">
          <?= csrf_field(); ?>
          <div class="card-body">

            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control <?= ($error = validation_show_error('name')) ? 'border-danger' : ''; ?>" id="name" name="name" placeholder="Name" value="<?= old('name'); ?>">
              <?= ($error) ? '<span class="error text-danger mb-2">' . $error . '</span>' : ''; ?>
            </div>

            <div class="form-group">
              <label for="code">Code</label>
              <input type="text" class="form-control <?= ($error = validation_show_error('code')) ? 'border-danger' : ''; ?>" id="code" name="code" placeholder="code" value="<?= old('code'); ?>">
              <?= ($error) ? '<span class="error text-danger mb-2">' . $error . '</span>' : ''; ?>
            </div>

            <div class="form-group">
              <label for="subject">Subject</label>
              <input type="text" class="form-control <?= ($error = validation_show_error('subject')) ? 'border-danger' : ''; ?>" id="subject" name="subject" placeholder="Subject" value="<?= old('subject'); ?>">
              <?= ($error) ? '<span class="error text-danger mb-2">' . $error . '</span>' : ''; ?>
            </div>

            <div class="form-group">
              <label for="body">Body</label>
              <textarea name="body" id="body" class="form-control <?= ($error = validation_show_error('subject')) ? 'border-danger' : ''; ?>" cols="30" rows="10"><?= old('body'); ?></textarea>
              <?= ($error) ? '<span class="error text-danger mb-2">' . $error . '</span>' : ''; ?>
            </div>

          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col">
                <a href="<?= base_url($_page->link); ?>" onclick="return confirm('Are you sure you want to leave?')" class="btn btn-flat btn-danger"> Cancel</a>
                <button type="submit" class="btn btn-flat btn-primary"> Submit</button>
              </div>
              <div class="col text-end">
              </div>
            </div>
          </div>
        </form>


      </div>
    </div>
  </div>
</section>



<?= $this->endSection('content') ?>

<?= $this->section('script') ?>
<script>
  $(document).ready(function() {
    $('#body').summernote();
    var noteBar = $('.note-toolbar');
    noteBar.find('[data-toggle]').each(function() {
      $(this).attr('data-bs-toggle', $(this).attr('data-toggle')).removeAttr('data-toggle');
    });
  });
</script>
<?= $this->endSection('script') ?>
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
  <form action="<?= base_url($_page->link . '/' . $data['id']); ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field(); ?>
    <input type='hidden' name='_method' value='PUT' />
    <div class="row">
      <div class="col-md-12 mb-2">

        <div class="card">

          <div class="card-header">
            <h4 class="card-title float-start">List of <span class="text-capitalize"><?= $_page->title; ?></span></h4>
            <div class="float-end">
              <a href="<?= base_url($_page->link . ''); ?>" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> <?= $_page->title; ?></a>
            </div>

          </div>

          <?= csrf_field(); ?>
          <div class="card-body">

            <div class="row">
              <div class="col-md-6 mb-2">
                <div class="form-group">
                  <label for="ip_seven">Ip Seven</label>
                  <select name="ip_seven" id="ip_seven" class="form-control <?= ($error = validation_show_error('ip_seven')) ? 'border-danger' : ''; ?>">
                    <option selected disabled>== SELECT ==</option>
                    <?php foreach ($ip_seven as $d) : ?>
                      <?php if ($data['ip_seven'] == $d['ip_seven']) : ?>
                        <option selected><?= $d['ip_seven']; ?></option>
                      <?php else : ?>
                        <option><?= $d['ip_seven']; ?></option>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </select>
                  <?= ($error) ? '<span class="error text-danger mb-2">' . $error . '</span>' : ''; ?>
                </div>

                <div class="form-group">
                  <label for="ip_code">Ip Code</label>
                  <input type="text" readonly class="readonly form-control <?= ($error = validation_show_error('ip_code')) ? 'border-danger' : ''; ?>" id="ip_code" name="ip_code" placeholder="Ip Code" value="<?= $data['ip_code']; ?>">
                  <?= ($error) ? '<span class="error text-danger mb-2">' . $error . '</span>' : ''; ?>
                </div>

                <div class="form-group">
                  <label for="cost_center">Cost Center</label>
                  <input type="text" readonly class="readonly form-control <?= ($error = validation_show_error('cost_center')) ? 'border-danger' : ''; ?>" id="cost_center" name="cost_center" placeholder="Cost Center" value="<?= $data['cost_center']; ?>">
                  <?= ($error) ? '<span class="error text-danger mb-2">' . $error . '</span>' : ''; ?>
                </div>

                <div class="form-group">
                  <label for="brand">Brand</label>
                  <select name="brand" id="brand" class="form-control <?= ($error = validation_show_error('brand')) ? 'border-danger' : ''; ?>">
                    <option selected disabled>== SELECT ==</option>
                    <?php foreach ($brand as $d) : ?>
                      <?php if ($data['brand'] == $d) : ?>
                        <option selected><?= $d; ?></option>
                      <?php else : ?>
                        <option><?= $d; ?></option>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </select>
                  <?= ($error) ? '<span class="error text-danger mb-2">' . $error . '</span>' : ''; ?>
                </div>

                <div class="form-group">
                  <label for="mch_type">MCH TYPE</label>
                  <select name="mch_type" id="mch_type" class="form-control <?= ($error = validation_show_error('mch_type')) ? 'border-danger' : ''; ?>">
                    <option selected disabled>== SELECT ==</option>
                    <?php foreach ($mch_type as $d) : ?>
                      <?php if ($data['mch_type'] == $d) : ?>
                        <option selected><?= $d; ?></option>
                      <?php else : ?>
                        <option><?= $d; ?></option>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </select>
                  <?= ($error) ? '<span class="error text-danger mb-2">' . $error . '</span>' : ''; ?>
                </div>

              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="rim">RIM</label>
                  <input type="number" class="form-control <?= ($error = validation_show_error('rim')) ? 'border-danger' : ''; ?>" id="rim" name="rim" placeholder="RIM" value="<?= $data['rim']; ?>">
                  <?= ($error) ? '<span class="error text-danger mb-2">' . $error . '</span>' : ''; ?>
                </div>

                <div class="form-group">
                  <label for="p_date">DATE</label>
                  <input type="date" class="form-control <?= ($error = validation_show_error('p_date')) ? 'border-danger' : ''; ?>" id="p_date" name="p_date" placeholder="DATE" value="<?= $data['p_date']; ?>">
                  <?= ($error) ? '<span class="error text-danger mb-2">' . $error . '</span>' : ''; ?>
                </div>

                <div class="form-group">
                  <label for="status">STATUS</label>
                  <select name="status" id="status" class="form-control <?= ($error = validation_show_error('status')) ? 'border-danger' : ''; ?>">
                    <option selected disabled>== SELECT ==</option>
                    <?php foreach ($status as $d) : ?>
                      <?php if ($data['status'] == $d) : ?>
                        <option selected><?= $d; ?></option>
                      <?php else : ?>
                        <option><?= $d; ?></option>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </select>
                  <?= ($error) ? '<span class="error text-danger mb-2">' . $error . '</span>' : ''; ?>
                </div>

                <div class="form-group">
                  <label for="qty">QTY</label>
                  <input type="number" class="form-control <?= ($error = validation_show_error('qty')) ? 'border-danger' : ''; ?>" id="qty" name="qty" placeholder="QTY" value="<?= $data['qty']; ?>">
                  <?= ($error) ? '<span class="error text-danger mb-2">' . $error . '</span>' : ''; ?>
                </div>

              </div>
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



        </div>
      </div>
    </div>

  </form>
</section>
<?= $this->endSection('content') ?>

<?= $this->section('script') ?>
<script>
  function getMaterial() {
    var ip_seven = $('#ip_seven').val();
    console.log(ip_seven);
    $.ajax({
      url: '<?= base_url($_page->link . '/ajax_ipcode'); ?>',
      method: 'GET', // POST
      data: {
        ip_seven: ip_seven
      },
      dataType: 'json', // json
      success: function(data) {
        if (data.error != true) {
          $('#ip_code').val(data.data.ip_code);
          $('#cost_center').val(data.data.cost_center);
          $('#brand').val(data.data.brand).change();
          $('#mch_type').val(data.data.mch_type).change();
          $('#rim').val(data.data.rim);
        } else {

          if (ip_seven.length == 7) {
            $('#ip_code').val(ip_seven.substr(0, 5));
            $('#cost_center').val(ip_seven.substr(5, 2));
          }
        }
      }
    });

  }

  $('#ip_seven').on('change', getMaterial);

  $("select#ip_seven").select2({
    theme: 'bootstrap-5',
    width: '100%',
    tags: true
  });
</script>
<?= $this->endSection('script') ?>
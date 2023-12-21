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
                  <label for="ip_code">Ip Code</label>
                  <select name="ip_code" id="ip_code" class="form-control <?= ($error = validation_show_error('ip_code')) ? 'border-danger' : ''; ?>">
                    <option selected disabled>== SELECT ==</option>
                    <?php foreach ($materials as $d) : ?>
                      <?php if ($data['ip_code'] == $d['MAT_CODE']) : ?>
                        <option selected value="<?= $d['MAT_CODE']; ?>"><?= $d['MAT_CODE']; ?> - <?= $d['MAT_SAP_CODE']; ?></option>
                      <?php else : ?>
                        <option value="<?= $d['MAT_CODE']; ?>"><?= $d['MAT_CODE']; ?> - <?= $d['MAT_SAP_CODE']; ?></option>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </select>
                  <?= ($error) ? '<span class="error text-danger mb-2">' . $error . '</span>' : ''; ?>
                </div>

                <div class="form-group">
                  <label for="mat_sap_code">Mat Sap Code</label>
                  <input type="text" readonly class="readonly form-control <?= ($error = validation_show_error('mat_sap_code')) ? 'border-danger' : ''; ?>" id="mat_sap_code" name="mat_sap_code" placeholder="Mat Sap Code" value="<?= $data['mat_sap_code']; ?>">
                  <?= ($error) ? '<span class="error text-danger mb-2">' . $error . '</span>' : ''; ?>
                </div>

                <div class="form-group">
                  <label for="mat_desc">Mat Desc</label>
                  <input type="text" readonly class="readonly form-control <?= ($error = validation_show_error('mat_desc')) ? 'border-danger' : ''; ?>" id="mat_desc" name="mat_desc" placeholder="Mat Desc" value="<?= $data['mat_desc']; ?>">
                  <?= ($error) ? '<span class="error text-danger mb-2">' . $error . '</span>' : ''; ?>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="target_shift">Target Shift</label>
                  <input type="number" class="form-control <?= ($error = validation_show_error('target_shift')) ? 'border-danger' : ''; ?>" id="target_shift" name="target_shift" placeholder="Target Shift" value="<?= $data['target_shift']; ?>">
                  <?= ($error) ? '<span class="error text-danger mb-2">' . $error . '</span>' : ''; ?>
                </div>

                <div class="form-group">
                  <label for="target_hour">Target Hour</label>
                  <input type="number" readonly class="form-control <?= ($error = validation_show_error('target_hour')) ? 'border-danger' : ''; ?>" id="target_hour" name="target_hour" placeholder="Target Hour" value="<?= $data['target_hour']; ?>">
                  <?= ($error) ? '<span class="error text-danger mb-2">' . $error . '</span>' : ''; ?>
                </div>

                <div class="form-group">
                  <label for="target_minute">Target Minute</label>
                  <input type="number" readonly class="form-control <?= ($error = validation_show_error('target_minute')) ? 'border-danger' : ''; ?>" id="target_minute" name="target_minute" placeholder="Target Minute" value="<?= $data['target_minute']; ?>">
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
    var ip_code = $('#ip_code').val();
    $.ajax({
      url: '<?= base_url($_page->link . '/ajax_ipcode'); ?>',
      method: 'GET', // POST
      data: {
        mat_code: ip_code
      },
      dataType: 'json', // json
      success: function(data) {
        if (data.error != true) {
          $('#mat_sap_code').val(data.MAT_SAP_CODE);
          $('#mat_desc').val(data.MAT_DESC);
        } else {
          Swal.fire({
            icon: 'warning',
            title: 'Warning',
            text: data.message
          })
        }
      }
    });

  }

  $('#ip_code').on('change', getMaterial);

  $('#target_shift').on('keyup', function() {
    const targetShift = $(this).val();
    const hours = targetShift / 7.25;
    const TenMinutes = hours / 6;

    $('#target_hour').val(Math.round(hours));
    $('#target_minute').val(Math.round(TenMinutes));

  })
</script>
<?= $this->endSection('script') ?>
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
    <div class="col-md-3 mb-2">



      <div class="nav flex-column nav-pills me-3 text-start" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <button class="nav-link  <?= ($tab == 'general') ? 'active' : ''; ?>" id="v-pills-general-tab" data-bs-toggle="pill" data-bs-target="#v-pills-general" type="button" role="tab" aria-controls="v-pills-general" aria-selected="true">General Settings</button>
        <button class="nav-link  <?= ($tab == 'company') ? 'active' : ''; ?>" id="v-pills-company-tab" data-bs-toggle="pill" data-bs-target="#v-pills-company" type="button" role="tab" aria-controls="v-pills-company" aria-selected="false">Company Settings</button>
      </div>
    </div>
    <div class="col-md-9">

      <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade  <?= ($tab == 'general') ? 'active show' : ''; ?>" id="v-pills-general" role="tabpanel" aria-labelledby="v-pills-general-tab" tabindex="0">
          <div class="card">

            <div class="card-header border-bottom">
              <h3 class="card-title m-0">General Settings</h3>
            </div>

            <form action="<?= base_url($_page->link . '/general'); ?>" method="post" enctype="multipart/form-data">
              <input type='hidden' name='_method' value='PUT' />
              <?= csrf_field(); ?>
              <div class="card-body">

                <div class="form-group">
                  <label for="formSetting-Company-Name">Timezone</label>
                  <select name="timezone" id="timezone" class="form-control">
                    <?php $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL); ?>
                    <?php foreach ($tzlist as $key => $value) : ?>
                      <?php $sel = $_page->settings['timezone'] == $value ? 'selected' : ''; ?>
                      <option value="<?php echo $value ?>" <?php echo $sel ?>><?php echo $value ?></option>
                    <?php endforeach ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="formSetting-DateFormat">Date Format &nbsp; <a href="#" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-info-circle"></i></a></label>
                  <input type="text" class="form-control" name="date_format" id="formSetting-DateFormat" value="<?= $_page->settings['date_format']; ?>" required="" placeholder="Date Format" autofocus="" aria-invalid="false">
                </div>

                <div class="form-group">
                  <label for="formSetting-DateTimeFormat">DateTime Format &nbsp; <a href="#" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-info-circle"></i></a> </label>
                  <input type="text" class="form-control" name="datetime_format" id="formSetting-DateTimeFormat" value="<?= $_page->settings['datetime_format']; ?>" required="" placeholder="Enter Date Time Format" autofocus="">

                </div>

                <div class="form-group">
                  <label for="expired_password_reset">Expired Password Reset <span class="fw-bold text-danger">(Minutes)</span></label>
                  <input type="text" class="form-control" name="expired_password_reset" id="expired_password_reset" value="<?= $_page->settings['expired_password_reset']; ?>" required="" autofocus="">

                </div>

                <div class="form-group">
                  <label for="expired_cookie">Expired Cookie Login <span class="fw-bold text-danger">(Minutes)</span></label>
                  <input type="text" class="form-control" name="expired_cookie" id="expired_cookie" value="<?= $_page->settings['expired_cookie']; ?>" required="" autofocus="">

                </div>

                <div class="form-group">
                  <label for="app_version">App Version</label>
                  <input type="text" class="form-control" name="app_version" id="app_version" value="<?= $_page->settings['app_version']; ?>" required="" autofocus="">

                </div>

                <div class="form-group">
                  <label for="app_year">App Year</label>
                  <input type="text" class="form-control" name="app_year" id="app_year" value="<?= $_page->settings['app_year']; ?>" required="" autofocus="">

                </div>



                <br>
                <h4>Google Recaptcha &nbsp; &nbsp; <input type="checkbox" <?= ($_page->settings['google_recaptcha_enabled'] == 1) ? 'checked' : ''; ?> value="ok" class="js-switch" name="google_recaptcha_enabled" onchange="recaptchKeysHideShow( $(this).is(':checked') )"> </h4>
                <hr>

                <div class="form-group recaptchKeysHideShow" style="display: none;">
                  <label for="formSetting-DateTimeFormat">Site Key </label>
                  <input type="text" class="form-control" name="google_recaptcha_sitekey" id="formSetting-DateTimeFormat" value="<?= $_page->settings['google_recaptcha_sitekey']; ?>" required="" placeholder="Site Key" autofocus="">

                </div>
                <div class="form-group recaptchKeysHideShow" style="display: none;">
                  <label for="formSetting-DateTimeFormat">Secret Key </label>
                  <input type="text" class="form-control" name="google_recaptcha_secretkey" id="formSetting-DateTimeFormat" value="<?= $_page->settings['google_recaptcha_secretkey']; ?>" required="" placeholder="Secret Key" autofocus="">

                </div>




              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-flat btn-primary">Submit</button>
              </div>
              <!-- /.card-footer-->

            </form>
          </div>
        </div>
        <div class="tab-pane fade <?= ($tab == 'company') ? 'active show' : ''; ?>" id="v-pills-company" role="tabpanel" aria-labelledby="v-pills-company-tab" tabindex="0">
          <div class="card">

            <div class="card-header border-bottom">
              <h3 class="card-title m-0">Company Settings</h3>
            </div>

            <form action="<?= base_url($_page->link . '/company'); ?>" method="post" enctype="multipart/form-data">
              <input type='hidden' name='_method' value='PUT' />
              <?= csrf_field(); ?>
              <div class="card-body">
                <div class="form-group">
                  <label for="company_name">Company Name</label>
                  <input type="text" class="form-control" name="company_name" ir="company_name" value="<?= $_page->settings['company_name']; ?>" required="" autofocus="">

                </div>

                <div class="form-group">
                  <label for="company_email">Company Email</label>
                  <input type="text" class="form-control" name="company_email" ir="company_email" value="<?= $_page->settings['company_email']; ?>" required="" autofocus="">

                </div>

              </div>

              <div class="card-footer">
                <button type="submit" class="btn btn-flat btn-primary">Submit</button>
              </div>
              <!-- /.card-footer-->
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="myModalLabel">Date & Date Time Formats</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-info">Supports <code>date</code> function available characters. For more info <a href="https://www.php.net/manual/en/function.date.php">link</a></div>
        <ul>
          <li>d - The day of the month (from 01 to 31)</li>
          <li>D - A textual representation of a day (three letters)</li>
          <li>j - The day of the month without leading zeros (1 to 31)</li>
          <li>l (lowercase 'L') - A full textual representation of a day</li>
          <li>N - The ISO-8601 numeric representation of a day (1 for Monday, 7 for Sunday)</li>
          <li>S - The English ordinal suffix for the day of the month (2 characters st, nd, rd or th. Works well with j)</li>
          <li>w - A numeric representation of the day (0 for Sunday, 6 for Saturday)</li>
          <li>z - The day of the year (from 0 through 365)</li>
          <li>W - The ISO-8601 week number of year (weeks starting on Monday)</li>
          <li>F - A full textual representation of a month (January through December)</li>
          <li>m - A numeric representation of a month (from 01 to 12)</li>
          <li>M - A short textual representation of a month (three letters)</li>
          <li>n - A numeric representation of a month, without leading zeros (1 to 12)</li>
          <li>t - The number of days in the given month</li>
          <li>L - Whether it's a leap year (1 if it is a leap year, 0 otherwise)</li>
          <li>o - The ISO-8601 year number</li>
          <li>Y - A four digit representation of a year</li>
          <li>y - A two digit representation of a year</li>
          <li>a - Lowercase am or pm</li>
          <li>A - Uppercase AM or PM</li>
          <li>B - Swatch Internet time (000 to 999)</li>
          <li>g - 12-hour format of an hour (1 to 12)</li>
          <li>G - 24-hour format of an hour (0 to 23)</li>
          <li>h - 12-hour format of an hour (01 to 12)</li>
          <li>H - 24-hour format of an hour (00 to 23)</li>
          <li>i - Minutes with leading zeros (00 to 59)</li>
          <li>s - Seconds, with leading zeros (00 to 59)</li>
          <li>u - Microseconds (added in PHP 5.2.2)</li>
          <li>e - The timezone identifier (Examples: UTC, GMT, Atlantic/Azores)</li>
          <li>I (capital i) - Whether the date is in daylights savings time (1 if Daylight Savings Time, 0 otherwise)</li>
          <li>O - Difference to Greenwich time (GMT) in hours (Example: +0100)</li>
          <li>P - Difference to Greenwich time (GMT) in hours:minutes (added in PHP 5.1.3)</li>
          <li>T - Timezone abbreviations (Examples: EST, MDT)</li>
          <li>Z - Timezone offset in seconds. The offset for timezones west of UTC is negative (-43200 to 50400)</li>
          <li>c - The ISO-8601 date (e.g. 2013-05-05T16:34:42+00:00)</li>
          <li>r - The RFC 2822 formatted date (e.g. Fri, 12 Apr 2013 12:01:05 +0200)</li>
          <li>U - The seconds since the Unix Epoch (January 1 1970 00:00:00 GMT)</li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection('content') ?>


<?= $this->section('script') ?>
<script>
  function recaptchKeysHideShow(checked) {

    if (!checked)
      $('.recaptchKeysHideShow').hide(300);
    else
      $('.recaptchKeysHideShow').show(300);

  }

  recaptchKeysHideShow(<?= $_page->settings['google_recaptcha_enabled']; ?>);
</script>
<?= $this->endSection('script') ?>
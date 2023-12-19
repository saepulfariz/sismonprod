<?= $this->extend('admin/template/index') ?>

<?= $this->section('content') ?>
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3 class="text-capitalize">Backup</h3>
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
    <div class="col-md-7">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title float-start">Database Backup</h4>

        </div>
        <div class="card-body">
          <a href="<?= base_url('backup/exportDB') ?>" class="btn btn-primary mb-2"> <i class="fa fa-download"></i> &nbsp;&nbsp;&nbsp; Generate & Download Database Backup</a>
          <p class="fw-bold">Import Database Use MYSQL</p>
          <ul>
            <li>Create new database</li>
            <li>Open new database</li>
            <li>Import <b>BackupFile.sql</b></li>
            <li>Waiting and import done</li>
            <li><a target="_blank" class="fw-bold" href="https://www.niagahoster.co.id/blog/cara-import-database-mysql/">Source Articel</a></li>
          </ul>

          <p class="fw-bold">Import Database Use SQL SERVER</p>
          <ul>
            <li>Connect to a server you want to store your DB</li>
            <li>Right-click Database</li>
            <li>Click Restore</li>
            <li>Choose the Device radio button under the source section. <b>BackupFile.bak</b></li>
            <li>Click Add.</li>
            <li>Navigate to the path where your .bak file is stored, select it and click OK</li>
            <li>Enter the destination of your DB</li>
            <li>Enter the name by which you want to store your DB</li>
            <li>Click OK</li>
            <li><a target="_blank" class="fw-bold" href="https://stackoverflow.com/questions/1535914/import-bak-file-to-a-database-in-sql-server">Source Articel</a></li>
          </ul>
        </div>
      </div>

    </div>
  </div>
</section>
<?= $this->endSection('content') ?>
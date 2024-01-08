<?= $this->extend('admin/template/index') ?>



<?= $this->section('head'); ?>
<meta http-equiv="refresh" content="720">
<?= $this->endSection('head'); ?>


<?= $this->section('content'); ?>

<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3 class="text-capitalize"><?= $_page->title; ?></h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">

                <?= breadcrumb(); ?>
            </nav>
        </div>
    </div>
</div>
<section class="section">
    <form action="" method="get">
        <div class="row mb-2">
            <div class="col-md-3">
                <div class="input-group mb-3">
                    <span class="input-group-text">Start</span>
                    <input type="date" id="start" name="start" class="form-control" value="<?= $start; ?>" placeholder="Start">
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group mb-3">
                    <span class="input-group-text">End</span>
                    <input type="date" id="end" name="end" class="form-control" value="<?= $end; ?>" placeholder="End">
                </div>
            </div>

            <div class="col-md-3">
                <div class="input-group mb-3">
                    <span class="input-group-text">Shift</span>
                    <select name="shift" id="shift" class="form-select">
                        <option <?= ($shift == 'ALL') ? 'selected' : '' ?> value="ALL">ALL</option>
                        <option <?= ($shift == '1') ? 'selected' : '' ?> value="1">Shift 1</option>
                        <option <?= ($shift == '2') ? 'selected' : '' ?> value="2">Shift 2</option>
                        <option <?= ($shift == '3') ? 'selected' : '' ?> value="3">Shift 3</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <button type="submit" id="submit-total" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-md-12">

            <div class="card">

                <div class="card-header">
                    <h4>Table Data Grafik</h4>
                </div>
                <div class="card-body">
                    <table class="table mb-2">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Actual</th>
                                <th>Plane /hour</th>
                                <th>Performance</th>
                                <th>Mat Sap Code</th>
                                <th>Ip Code</th>
                                <th>Shift</th>
                                <th>Time Start</th>
                                <th>Time End</th>
                                <th>Machine</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $b = 1;
                            foreach ($data['result'] as $d) : ?>

                                <tr>
                                    <td><?= $b++; ?></td>
                                    <td><?= $d['actual']; ?></td>
                                    <td><?= $d['planning']; ?></td>
                                    <td><?= $d['hours']; ?> %</td>
                                    <td><?= $d['mat_sap_code']; ?></td>
                                    <td><?= $d['ip_code']; ?></td>
                                    <td><?= $d['shf_code']; ?></td>
                                    <td><?= $d['time_start']; ?></td>
                                    <td><?= $d['time_end']; ?></td>
                                    <td><?= $d['machine']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>




<?= $this->endSection('content'); ?>

<?= $this->section('script'); ?>

<script>
    var table = $('.table').dataTable({
        dom: 'Bflrtip',
        buttons: [
            'excel'
        ]
    });
</script>


<?= $this->endSection('script'); ?>
<?= $this->extend('admin/template/index') ?>



<?= $this->section('head'); ?>
<meta http-equiv="refresh" content="720">
<?= $this->endSection('head'); ?>


<div class="container">
    <div class="row">
        <div class="col-7">
            <?php $a = 0;
            foreach ($chart['label'] as $l) : ?>
                <table class="table mb-2">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Actual</th>
                            <th>Plane</th>
                            <th>Performance</th>
                            <th>Mat Sap Code</th>
                            <th>Ip Code</th>
                            <th>Time Start</th>
                            <th>Time End</th>
                            <th>Machine</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $b = 1;
                        foreach ($chart['result'][$a] as $r) : ?>

                            <tr>
                                <td><?= $b++; ?></td>
                                <td><?= $r['actual']; ?></td>
                                <td><?= $r['planning']; ?></td>
                                <td><?= $r['hours']; ?></td>
                                <td><?= $r['mat_sap_code']; ?></td>
                                <td><?= $r['ip_code']; ?></td>
                                <td><?= $r['time_start']; ?></td>
                                <td><?= $r['time_end']; ?></td>
                                <td><?= $r['machine']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php $a++;
            endforeach; ?>
        </div>
    </div>
</div>
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
    <div class="row">
        <div class="col-md-12">

            <div class="card">

                <div class="card-header">
                    <h4>Table Data Grafik</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Actual</th>
                                <th>Planning</th>
                                <th>Performance</th>
                                <th>Mat Sap Code</th>
                                <th>Ip Code</th>
                                <th>Time Start</th>
                                <th>Time End</th>
                                <th>Machine</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $a = 0;
                            $b = 1;
                            foreach ($chart['label'] as $l) : ?>
                                <?php
                                foreach ($chart['result'][$a] as $r) : ?>

                                    <tr class="<?= ($r['mat_sap_code'] == "empty") ? "table-secondary" : ""; ?> <?= ($r['mat_sap_code'] == "null") ? "table-danger" : ""; ?>">
                                        <td><?= $b++; ?></td>
                                        <td><?= $r['actual']; ?></td>
                                        <td><?= $r['planning']; ?></td>
                                        <td><?= $r['hours']; ?>%</td>
                                        <td><?= $r['mat_sap_code']; ?></td>
                                        <td><?= $r['ip_code']; ?></td>
                                        <td><?= $r['time_start']; ?></td>
                                        <td><?= $r['time_end']; ?></td>
                                        <td><?= $r['machine']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php $a++;
                            endforeach; ?>
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
<?= $this->extend('admin/template/index') ?>

<?= $this->section('head') ?>
<meta http-equiv="refresh" content="720">
<!-- <meta http-equiv="refresh" content="900; url=https://www.conductor.com/"> -->
<style>
    @media print {
        .noprint {
            visibility: hidden;
            display: none;
            margin: 0;
        }
    }

    .get-ip,
    .get-mch {
        cursor: pointer;
    }
</style>

<?= $this->endSection('head') ?>
<?= $this->section('content') ?>
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

                <div class="card-body">
                    <form action="" method="get" class="noprint">
                        <div class="row mt-3">
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <select name="bulan" id="bulan" class="form-control">
                                        <?php for ($a = 1; $a < 13; $a++) : ?>
                                            <?php if ($id_bulan == $a) : ?>

                                                <option selected value="<?= $a; ?>"><?= date('F', strtotime(date('Y-' . $a . '-d'))); ?></option>
                                            <?php else : ?>
                                                <option value="<?= $a; ?>"><?= date('F', strtotime(date('Y-' . $a . '-d'))); ?></option>

                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 mb-2">
                                <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                                <button type="button" id="submit" class="btn btn-primary">Submit</button>
                                <?php if (hasPermissions('inbound_detail_export')) : ?>
                                    <button type="button" id="export" class="btn btn-success">Export</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>


                    <div class="row mt-1">
                        <div class="col table-responsive" id="area_lod">
                            <?= $this->include('admin/laporan/inbound_detail_ajax'); ?>
                        </div>
                    </div>
                </div>




            </div>


        </div>
    </div>
</section>


<style>
    @media print {
        .noprint {
            visibility: hidden;
            display: none;
            margin: 0;
        }
    }
</style>
<?= $this->endSection('content') ?>



<?= $this->section('script') ?>
<script>
    $('#export').on('click', function() {
        var bulan = $('#bulan').val();
        var link = '<?= base_url(); ?>laporan/inbound_detail_export?bulan=' + bulan;
        // console.log(link);
        window.open(link, '_blank');
    })

    $('#submit').on('click', function() {
        var bulan = $('#bulan').val();
        var tahun = $('#tahun').val();

        $('.reload').html('Loading..');
        $('.reload').addClass('disabled');
        loading('area_lod');

        $.ajax({
            url: '<?= base_url(); ?>laporan/inbound_detail_ajax',
            method: 'GET', // POST
            data: {
                bulan: bulan,
                // tahun: tahun,
            },
            dataType: 'html', // json
            success: function(data) {
                unblock('area_lod');
                $('.reload').html('Submit');
                $('.reload').removeClass('disabled');
                $('#area_lod').html(data);
            }
        });
    })
</script>
<?= $this->endSection('script') ?>
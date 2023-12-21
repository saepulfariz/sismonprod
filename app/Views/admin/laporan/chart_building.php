<?= $this->extend('admin/template/index') ?>


<?= $this->section('content') ?>
<style>
    .embed-responsive {
        min-height: 740px;
        position: relative;
        display: block;
        width: 100%;
        padding: 0;
        overflow: hidden;
    }

    .embed-responsive .embed-responsive-item,
    .embed-responsive embed,
    .embed-responsive iframe,
    .embed-responsive object,
    .embed-responsive video {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }


    @media only screen and (max-width: 600px) {
        .embed-responsive {
            /* buat embed gak error ketika potrait */
            /* min-height: 800px; */
            min-height: 740px;
        }
    }
</style>
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
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-bt-tab" data-bs-toggle="pill" data-bs-target="#pills-bt" type="button" role="tab" aria-controls="pills-bt" aria-selected="true">BT</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-st-tab" data-bs-toggle="pill" data-bs-target="#pills-st" type="button" role="tab" aria-controls="pills-st" aria-selected="false">ST</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-overview-tab" data-bs-toggle="pill" data-bs-target="#pills-overview" type="button" role="tab" aria-controls="pills-overview" aria-selected="false">OVERVIEW</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-bt" role="tabpanel" aria-labelledby="pills-bt-tab" tabindex="0">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe id="buildinglive2" class="embed-responsive-item" src="<?= base_url($_page->link . '/frame_building/btum'); ?>" allowfullscreen=""></iframe>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-st" role="tabpanel" aria-labelledby="pills-st-tab" tabindex="0">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe id="buildinglive2" class="embed-responsive-item" src="<?= base_url($_page->link . '/frame_building/stum'); ?>" allowfullscreen=""></iframe>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-overview" role="tabpanel" aria-labelledby="pills-overview-tab" tabindex="0">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe id="buildinglive2" class="embed-responsive-item" src="<?= base_url($_page->link . '/frame_building/all'); ?>" allowfullscreen=""></iframe>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</section>



<?= $this->endSection('content') ?>
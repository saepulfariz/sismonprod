<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $_page->title; ?> - <?= $_page->settings['company_name']; ?></title>

  <?php

  $favicon = 'public/uploads/apps/' . $_page->settings['app_favicon'];
  $favicon_info = getimagesize($favicon);
  $image = 'public/uploads/apps/' . $_page->settings['app_image'];
  $image_info = getimagesize($image);

  ?>

  <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url() . $favicon; ?>">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() . $favicon; ?>">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() . $favicon; ?>">
  <link rel="manifest" href="/site.webmanifest">
  <meta property='og:title' content='<?= $_page->settings['app_name']; ?>' />
  <meta property='og:image' content='<?= base_url() . $image; ?>' />
  <meta property='og:description' content='<?= $_page->settings['app_description']; ?>' />
  <meta property='og:url' content='<?= base_url(); ?>' />
  <meta property='og:image:width' content='<?= $image_info[0]; ?>' />
  <meta property='og:image:height' content='<?= $image_info[1]; ?>' />

  <link rel="stylesheet" href="<?= base_url(); ?>public/assets/extensions/@fortawesome/fontawesome-free/css/all.min.css">

  <link rel="stylesheet" href="<?= base_url(); ?>public/assets/extensions/summernote/summernote-bs5.min.css">
  <style>
    .fontawesome-icons {
      text-align: center;
    }

    article dl {
      background-color: rgba(0, 0, 0, .02);
      padding: 20px;
    }

    .fontawesome-icons .the-icon {
      font-size: 24px;
      line-height: 1.2;
    }
  </style>

  <link rel="stylesheet" href="<?= base_url(); ?>public/assets/extensions/sweetalert2/sweetalert2.min.css">

  <link rel="stylesheet" href="<?= base_url(); ?>public/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">


  <link rel="stylesheet" href="<?= base_url(); ?>public/assets/compiled/css/table-datatable-jquery.css">

  <link rel="stylesheet" href="<?= base_url(); ?>public/assets/compiled/css/app.css">
  <link rel="stylesheet" href="<?= base_url(); ?>public/assets/compiled/css/app-dark.css">
  <link rel="stylesheet" href="<?= base_url(); ?>public/assets/compiled/css/auth.css">

  <link rel="stylesheet" href="<?= base_url(); ?>public/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>public/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <link rel="stylesheet" href="<?= base_url(); ?>public/assets/plugins/select2-bootstrap-5/select2-bootstrap-5-theme.css">
  <link rel="stylesheet" href="<?= base_url(); ?>public/assets/plugins/select2js/css/select2.min.css">
</head>

<body>
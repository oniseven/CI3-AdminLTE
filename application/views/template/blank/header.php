<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <base href="<?php echo base_url(); ?>" />
  <title><?php echo $page_title; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Vendors style -->
  <!-- Sweet Alert 2 -->
  <link rel="stylesheet" href="assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <?php
    foreach ($plugin_css as $key => $value) {
      echo sprintf('<link rel="stylesheet" type="text/css" href="%s" />', $value);
    }
  ?>
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <!-- Custom style -->
  <link rel="stylesheet" href="assets/dist/css/custom.css">
  <!-- Current Custom Page CSS -->
  <?php
    foreach ($page_css as $key => $value) {
      echo sprintf('<link rel="stylesheet" href="%s">', $value);
    }
  ?>
</head>
<body class="<?php echo $classes['body'] ?? ''; ?>">
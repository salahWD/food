<!DOCTYPE html>
<html lang="en">
  <head>

    <!-- Meta -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta charset="UTF-8" />

    <!-- The Title -->
    <title>Simple House Template</title>

    <!-- Favicons -->
    <link rel="shortcut icon" href="assets/img/favicon.png">
    <link rel="apple-touch-icon" href="assets/img/favicon_60x60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/favicon_76x76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/img/favicon_120x120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/img/favicon_152x152.png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&family=Raleway:wght@100;200;400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/b54f5615ab.js" crossorigin="anonymous"></script>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- CSS Styles -->
    <link href="<?php echo CSS_URL;?>core.css" rel="stylesheet" /><!-- Core Css -->
    <link href="<?php echo CSS_URL;?>theme-red.css" rel="stylesheet" /><!-- Theme: Colors and Variables -->
    <link href="<?php echo CSS_URL;?>general.css" rel="stylesheet" /><!-- Global Styles -->
      <?php if (isset($custom_css) && $custom_css != NULL):?><!-- Specific Styles For Page -->
        <?php if (is_array($custom_css)):?>
          <?php foreach($custom_css as $css):?>
            <link href="<?php echo CSS_URL;?><?php echo $css;?>.css" rel="stylesheet" />
          <?php endforeach;?>
          <?php else:?>
            <link href="<?php echo CSS_URL;?><?php echo $custom_css;?>.css" rel="stylesheet" />
        <?php endif;?>
      <?php endif;?>
  </head>
<body class="">
  <!-- Body Wrapper -->
  <div id="body-wrapper" class="animsition header-absolute">

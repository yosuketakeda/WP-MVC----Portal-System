<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="<?php echo $description; ?>">
    <meta name="author" content="">

    <title><?php echo $title; ?></title>

    <link rel="apple-touch-icon" href="<?php echo DRONESPOV_IMAGE . 'apple-touch-icon.png'; ?>">
    <link rel="shortcut icon" href="<?php echo DRONESPOV_IMAGE . 'favicon.ico'; ?>">


    <!--[if lt IE 9]>
    <script src="../../../global/vendor/html5shiv/html5shiv.min.js"></script>
    <![endif]-->

    <!--[if lt IE 10]>
    <script src="../../../global/vendor/media-match/media.match.min.js"></script>
    <script src="../../../global/vendor/respond/respond.min.js"></script>
    <![endif]-->

    <?php do_action( 'doronespov_head' ); ?>
    <script>
      Breakpoints();
    </script>
</head>

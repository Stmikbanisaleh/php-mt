<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="bootstrap admin template">
  <meta name="author" content="">
  <title>MT</title>
  <link rel="apple-touch-icon" href="<?= base_url('assets/base/assets/'); ?>images/apple-touch-icon.png">
  <link rel="shortcut icon" href="<?= base_url('assets/base/assets/'); ?>images/favicon.ico">
  <!-- Stylesheets -->
  <link href="<?= base_url('assets/'); ?>global/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>global/css/bootstrap-extend.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/base/assets/'); ?>css/site.min.css">
  <!-- Plugins -->
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>global/vendor/animsition/animsition.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>global/vendor/asscrollable/asScrollable.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>global/vendor/switchery/switchery.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>global/vendor/intro-js/introjs.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>global/vendor/slidepanel/slidePanel.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>global/vendor/flag-icon-css/flag-icon.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>global/vendor/jquery-wizard/jquery-wizard.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>global/vendor/formvalidation/formValidation.css">
  <link rel="stylesheet" href="<?= base_url('assets/base/assets/'); ?>examples/css/forms/validation.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>global/vendor/blueimp-file-upload/jquery.fileupload.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>global/vendor/dropify/dropify.css">
  <link rel="stylesheet" href="<?= base_url('assets/base/assets/'); ?>examples/css/uikit/modals.css">

  <link rel="stylesheet" href="<?= base_url('assets/'); ?>global/vendor/jvectormap/jquery-jvectormap.css">
  <link rel="stylesheet" href="<?= base_url('assets/base/assets/'); ?>examples/css/dashboard/v1.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>global/vendor/datatables-bootstrap/dataTables.bootstrap.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>global/vendor/bootstrap-datepicker/bootstrap-datepicker.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>global/vendor/datatables-fixedheader/dataTables.fixedHeader.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>global/vendor/datatables-responsive/dataTables.responsive.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>global/vendor/datatables-buttons/buttons.dataTables.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/base/assets/'); ?>examples/css/tables/datatable.css">
  <link rel="stylesheet" href="<?= base_url('assets/base/assets/'); ?>examples/css/dashboard/analytics.css">
  <link rel="stylesheet" href="<?= base_url('assets/base/assets/'); ?>examples/css/charts/chartjs.css">
  <!-- Fonts -->
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>global/fonts/font-awesome/font-awesome.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>global/fonts/weather-icons/weather-icons.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>global/fonts/web-icons/web-icons.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>global/fonts/brand-icons/brand-icons.min.css">
  <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
  <!--[if lt IE 9]>
    <script src="../../global/vendor/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
  <!--[if lt IE 10]>
    <script src="../../global/vendor/media-match/media.match.min.js"></script>
    <script src="../../global/vendor/respond/respond.min.js"></script>
    <![endif]-->
  <!-- Scripts -->
  <script src="<?= base_url('assets/'); ?>global/vendor/breakpoints/breakpoints.js"></script>
  <script>
    Breakpoints();
  </script>
</head>

<body class="animsition dashboard">
  <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
  <nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega" role="navigation">
    <div class="navbar-header">
      <button type="button" class="navbar-toggler hamburger hamburger-close navbar-toggler-left hided" data-toggle="menubar">
        <span class="sr-only">Toggle navigation</span>
        <span class="hamburger-bar"></span>
      </button>
      <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-collapse" data-toggle="collapse">
        <i class="icon wb-more-horizontal" aria-hidden="true"></i>
      </button>
      <div class="navbar-brand navbar-brand-center site-gridmenu-toggle" data-toggle="gridmenu">
        <img class="navbar-brand-logo" src="<?= base_url('assets/base/assets/'); ?>images/logolapan.png" title="Remark">
        <span class="navbar-brand-text hidden-xs-down"> LAPAN </span>
      </div>
      <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-search" data-toggle="collapse">
        <span class="sr-only">Toggle Search</span>
        <i class="icon wb-search" aria-hidden="true"></i>
      </button>
    </div>
    <div class="navbar-container container-fluid">
      <!-- Navbar Collapse -->
      <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
        <!-- Navbar Toolbar -->
        <ul class="nav navbar-toolbar">
          <li class="nav-item hidden-float" id="toggleMenubar">
            <a class="nav-link" data-toggle="menubar" href="#" role="button">
              <i class="icon hamburger hamburger-arrow-left">
                <span class="sr-only">Toggle menubar</span>
                <span class="hamburger-bar"></span>
              </i>
            </a>
          </li>
          <li class="nav-item hidden-sm-down" id="toggleFullscreen">
            <a class="nav-link icon icon-fullscreen" data-toggle="fullscreen" href="#" role="button">
              <span class="sr-only">Toggle fullscreen</span>
            </a>
          </li>
          <li class="nav-item hidden-float">
            <a class="nav-link icon wb-search" data-toggle="collapse" href="#" data-target="#site-navbar-search" role="button">
              <span class="sr-only">Toggle Search</span>
            </a>
          </li>
        </ul>
        <!-- End Navbar Toolbar -->
        <!-- Navbar Toolbar Right -->
        <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right mx-15">
          <li class="nav-item dropdown">
            <a class="nav-link navbar-avatar" data-toggle="dropdown" href="#" aria-expanded="false" data-animation="scale-up" role="button">

              <span class="avatar avatar-online">
                <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" alt="...">
                <i></i>

              </span>

            </a>
            <div class="dropdown-menu" role="menu">
              <?php

              ?>
              <h5 class="text-center"><?php echo $user['name']; ?></h5>
              <p class="text-center"><?php echo $role['NAMA_REV']; ?></p>
              <div class="dropdown-divider" role="presentation"></div>
              <a class="dropdown-item" href="<?= base_url('profil') ?>" role="menuitem"><i class="icon wb-user" aria-hidden="true"></i> Profile</a>
              <div class="dropdown-divider" role="presentation"></div>
              <a class="dropdown-item" href="<?= base_url('auth/logout') ?>" role="menuitem" data-toggle="modal" data-target="#logoutModal"><i class="icon wb-power" aria-hidden="true"></i> Logout</a>
            </div>
          </li>
        </ul>
        <!-- End Navbar Toolbar Right -->
      </div>
      <!-- End Navbar Collapse -->
      <!-- Site Navbar Seach -->
      <div class="collapse navbar-search-overlap" id="site-navbar-search">
        <form role="search">
          <div class="form-group">
            <div class="input-search">
              <i class="input-search-icon wb-search" aria-hidden="true"></i>
              <input type="text" class="form-control" name="site-search" placeholder="Search...">
              <button type="button" class="input-search-close icon wb-close" data-target="#site-navbar-search" data-toggle="collapse" aria-label="Close"></button>
            </div>
          </div>
        </form>
      </div>
      <!-- End Site Navbar Seach -->
    </div>
  </nav>
  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="<?= base_url('auth/logout') ?>">Logout</a>
        </div>
      </div>
    </div>
  </div>
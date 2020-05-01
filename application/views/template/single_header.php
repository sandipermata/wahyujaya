<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dummy Dash</title>
  <link rel="shortcut icon" href="<?php echo base_url('image/traffic-light.png')?>">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap/dist/css/bootstrap.min.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome/css/font-awesome.min.css')?>">

  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/select2/select2.min.css')?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/AdminLTE.min.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/skins/_all-skins.min.css')?>">
  
  <!--script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=placeses,visualization,drawing,geometry,places&key=AIzaSyDgLKFYNu6pg-cPOZ3KmQGXHHVhgSfouGI"></script-->
  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=placeses,visualization,drawing,geometry,places&key=AIzaSyDgLKFYNu6pg-cPOZ3KmQGXHHVhgSfouGI" async defer></script>

  <script type="text/javascript" src="<?php echo base_url('assets/js/angular/angular.min.js')?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js/idle/angular-idle.js')?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js/angular/angularMap.js')?>"></script>
  <!--for 360 view image-->
  <script type="text/javascript" src="<?php echo base_url('assets/js/kaleidoscope.min.js')?>"></script>

  <script type="text/javascript" src="<?php echo base_url('assets/alertify/alertify.min.js')?>"></script>
  <link rel="stylesheet" href="<?php echo base_url('assets/alertify/css/alertify.min.css')?>"/>
  <link rel="stylesheet" href="<?php echo base_url('assets/alertify/css/themes/default.min.css')?>"/>
  <link rel="stylesheet" href="<?php echo base_url('assets/alertify/css/themes/semantic.min.css')?>"/>
  <link rel="stylesheet" href="<?php echo base_url('assets/alertify/css/themes/bootstrap.min.css')?>"/>

  <link rel="stylesheet" href="<?php echo base_url('assets/css/custom_style.css')?>"/>

  <script src="https://cdn.aerisapi.com/sdk/js/latest/aerisweather.min.js"></script>
  <link rel="stylesheet" href="https://cdn.aerisapi.com/sdk/js/latest/aerisweather.css">

  <style type="text/css">
    .label-caption {
      cursor: pointer; 
      padding: 20px; 
      background: #00a65a; 
      color: #FFF; 
      width: 100%; 
      text-transform: uppercase;
    }

    li.treeview > .treeview-menu > li {
      margin-left: 20px;
    }

    li.treeview:hover > a,
    li.treeview.active > a {
      border-left: 3px solid #00a65a;
    }

    li.treeview.active > a > i.fa,
    li.treeview.active > a > span {
      color: #00a65a;
    }

    li.treeview.active > .treeview-menu > li.active i::before,
    li.treeview.active > .treeview-menu > li.active a {
      content: "\f192";
      color: #00a65a;
    }

  </style>

</head>
<!-- skin-green-light -->
<body class="hold-transition skin-green-light sidebar-collapse" ng-app="starter">

  <div class="wrapper" ng-init="page_single_code='single'" >

    <!--header class="main-header">

    <a href="<?php echo site_url() ?>" class="logo">
      <span class="logo-mini">DD</span>
      <span class="logo-lg"><b>Dummy Dash</b></span>
    </a>

    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo base_url('assets/dist/img/user2-160x160.jpg')?>" class="user-image" alt="User Image">
              <span class="hidden-xs">Admin Support</span>
            </a>
            <?php

            if($title == "Scheduler"){

            }else{ ?>
              <ul class="dropdown-menu">
                <li class="user-header">
                  <img src="<?php echo base_url('assets/dist/img/user2-160x160.jpg')?>" class="img-circle" alt="User Image">
                  <p>
                    Admin Support
                    <small>dummy</small>
                  </p>
                </li>
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                  </div>
                  <div class="pull-right">
                    <a href="#" class="btn btn-default btn-flat" ng-click="logout()" >Sign out</a>
                  </div>
                </li>
              </ul>
            <?php } ?>
          </li>
        </ul>
      </div>

    </nav>
  </header-->

  <!-- | SIDEBAR | -->
  <!--aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url('assets/dist/img/user2-160x160.jpg')?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Admin Support</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <?php

      if($title == "Scheduler"){

      }else{ ?>

      <ul class="sidebar-menu">
        <li class="header">Main Menu</li>
        <?php
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, site_url("api/menus/" . $this->session->userdata("loginId") )); 
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
          $output = curl_exec($ch);
          curl_close($ch);
          echo $output;
        ?>
      </ul>
      <?php } ?>
    </section>
  </aside-->

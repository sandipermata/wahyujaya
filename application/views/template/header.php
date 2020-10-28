<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Monika</title>
  <link rel="shortcut icon" href="<?php echo base_url('image/logo.png')?>">
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

    <script type="text/javascript" src="<?php echo base_url('assets/js/xlsx/xlsx.full.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/xlsx/jszip.js') ?>"></script>

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
<body class="hold-transition skin-green-light sidebar-mini" ng-app="starter">

  <div class="textloading">
    <svg id="loading">
      <g>
        <path class="ld-l" fill="#39C0C4" d="M43.6,33.2h9.2V35H41.6V15.2h2V33.2z"/>
        <path class="ld-o" fill="#39C0C4" d="M74.7,25.1c0,1.5-0.3,2.9-0.8,4.2c-0.5,1.3-1.2,2.4-2.2,3.3c-0.9,0.9-2,1.6-3.3,2.2
        c-1.3,0.5-2.6,0.8-4.1,0.8s-2.8-0.3-4.1-0.8c-1.3-0.5-2.4-1.2-3.3-2.2s-1.6-2-2.2-3.3C54.3,28,54,26.6,54,25.1s0.3-2.9,0.8-4.2
        c0.5-1.3,1.2-2.4,2.2-3.3s2-1.6,3.3-2.2c1.3-0.5,2.6-0.8,4.1-0.8s2.8,0.3,4.1,0.8c1.3,0.5,2.4,1.2,3.3,2.2c0.9,0.9,1.6,2,2.2,3.3
        C74.4,22.2,74.7,23.6,74.7,25.1z M72.5,25.1c0-1.2-0.2-2.3-0.6-3.3c-0.4-1-0.9-2-1.6-2.8c-0.7-0.8-1.6-1.4-2.6-1.9
        c-1-0.5-2.2-0.7-3.4-0.7c-1.3,0-2.4,0.2-3.4,0.7c-1,0.5-1.9,1.1-2.6,1.9c-0.7,0.8-1.3,1.7-1.6,2.8c-0.4,1-0.6,2.1-0.6,3.3
        c0,1.2,0.2,2.3,0.6,3.3c0.4,1,0.9,2,1.6,2.7c0.7,0.8,1.6,1.4,2.6,1.9c1,0.5,2.2,0.7,3.4,0.7c1.3,0,2.4-0.2,3.4-0.7
        c1-0.5,1.9-1.1,2.6-1.9c0.7-0.8,1.3-1.7,1.6-2.7C72.4,27.4,72.5,26.3,72.5,25.1z"/>
        <path class="ld-a" fill="#39C0C4" d="M78.2,35H76l8.6-19.8h2L95.1,35h-2.2l-2.2-5.2H80.4L78.2,35z M81.1,27.9h8.7l-4.4-10.5L81.1,27.9z"/>
        <path class="ld-d" fill="#39C0C4" d="M98,15.2h6.6c1.2,0,2.5,0.2,3.7,0.6c1.2,0.4,2.4,1,3.4,1.9c1,0.8,1.8,1.9,2.4,3.1s0.9,2.7,0.9,4.3
        c0,1.7-0.3,3.1-0.9,4.3s-1.4,2.3-2.4,3.1c-1,0.8-2.1,1.5-3.4,1.9c-1.2,0.4-2.5,0.6-3.7,0.6H98V15.2z M100,33.2h4
        c1.5,0,2.8-0.2,3.9-0.7c1.1-0.5,2-1.1,2.8-1.8c0.7-0.8,1.3-1.6,1.6-2.6s0.5-2,0.5-3c0-1-0.2-2-0.5-3c-0.4-1-0.9-1.8-1.6-2.6
        c-0.7-0.8-1.6-1.4-2.8-1.8c-1.1-0.5-2.4-0.7-3.9-0.7h-4V33.2z"/>
        <path class="ld-i" fill="#39C0C4" d="M121.2,35h-2V15.2h2V35z"/>
        <path class="ld-n" fill="#39C0C4" d="M140.5,32.1L140.5,32.1l0.1-16.9h2V35h-2.5l-11.5-17.1h-0.1V35h-2V15.2h2.5L140.5,32.1z"/>
        <path class="ld-g" fill="#39C0C4" d="M162.9,18.8c-0.7-0.7-1.5-1.3-2.5-1.7c-1-0.4-2-0.6-3.3-0.6c-1.3,0-2.4,0.2-3.4,0.7s-1.9,1.1-2.6,1.9
        c-0.7,0.8-1.3,1.7-1.6,2.8c-0.4,1-0.6,2.1-0.6,3.3c0,1.2,0.2,2.3,0.6,3.3c0.4,1,0.9,2,1.6,2.7c0.7,0.8,1.6,1.4,2.6,1.9
        s2.2,0.7,3.4,0.7c1.1,0,2.1-0.1,3.1-0.4c0.9-0.2,1.7-0.5,2.3-0.9v-6h-4.6v-1.8h6.6v9c-1.1,0.7-2.2,1.1-3.5,1.5
        c-1.3,0.3-2.5,0.5-3.9,0.5c-1.5,0-2.9-0.3-4.1-0.8s-2.4-1.2-3.3-2.2c-0.9-0.9-1.6-2-2.1-3.3s-0.8-2.7-0.8-4.2s0.3-2.9,0.8-4.2
        c0.5-1.3,1.2-2.4,2.2-3.3c0.9-0.9,2-1.6,3.3-2.2c1.3-0.5,2.6-0.8,4.1-0.8c1.6,0,3,0.2,4.1,0.7s2.2,1.1,3,2L162.9,18.8z"/>
      </g>
    </svg>
  </div>

  <div class="wrapper">
    <header class="main-header">

    <a href="<?php echo site_url() ?>" class="logo">
      <span class="logo-mini">WT</span>
      <span class="logo-lg"><b>Monika</b></span>
    </a>

    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" ng-cloak>
              <img ng-src="{{base_url}}assets/dist/img/{{LoginImage}}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{LoginName}}</span>
            </a>
            <?php

            if($title == "Scheduler"){

            }else{ ?>
              <ul class="dropdown-menu">
                <li class="user-header" ng-cloak>
                  <img ng-src="{{base_url}}assets/dist/img/{{LoginImage}}" class="img-circle" alt="User Image">
                  <p>
                    {{LoginName}}
                    <small>{{LoginTitle}}</small>
                  </p>
                </li>
                <li class="user-footer">
                 <!--  <div class="pull-left">
                    <a href="#" class="btn btn-success btn-sm btn-block">Profile</a>
                  </div> -->
                  <div class="pull-center">
                    <a href="#" class="btn btn-success btn-sm btn-block" ng-click="logout()" >Sign out</a>
                  </div>
                </li>
              </ul>
            <?php } ?>
          </li>
        </ul>
      </div>

    </nav>
  </header>

  <!-- | SIDEBAR | -->
  <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <img ng-src="{{base_url}}assets/dist/img/{{LoginImage}}" class="img-circle" alt="User Image" ng-cloak>
        </div>
        <div class="pull-left info" ng-cloak>
          <p>{{LoginName}}</p>
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
  </aside>

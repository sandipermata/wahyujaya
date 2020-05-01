<!DOCTYPE html>
<html lang="en" class="body-full-height">
  <head>
    <!-- META SECTION -->
    <title>DummyDash | Login</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- END META SECTION -->

    <!-- CSS INCLUDE -->
    <!-- Tell the browser to be responsive to screen width -->
    <link rel="shortcut icon" href="<?php echo base_url('image/traffic-light.png')?>">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap/dist/css/bootstrap.min.css')?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome/css/font-awesome.min.css')?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/AdminLTE.min.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/ionicons/css/ionicons.min.css')?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/login_style.css')?>">
    <!-- EOF CSS INCLUDE -->

    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=placeses,visualization,drawing,geometry,places&key=AIzaSyDgLKFYNu6pg-cPOZ3KmQGXHHVhgSfouGI"></script>

    <script type="text/javascript" src="<?php echo base_url('assets/js/angular/angular.min.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/idle/angular-idle.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/angular/angularMap.js')?>"></script>

    <script type="text/javascript" src="<?php echo base_url('assets/js/xlsx/xlsx.full.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/xlsx/jszip.js') ?>"></script>

    <style type="text/css">
  		[ng\:cloak],[ng-cloak],.ng-cloak{
  			display:none !important
  		}

      .loading {
         position: fixed;
         left: 0px;
         top: 0px;
         width: 100%;
         height: 100%;
         z-index: 9999;
         background: url(<?php echo base_url('image/loader.gif') ?>) center no-repeat #fff;
      }

  		.LoadImg {
  			position:absolute;
  			top:0;
  			height:80px;
  		}

  		.progress-bar span {
  			display:none;
  		}

  		.progress-bar:hover span {
  			display:block;
  			position:absolute;
  			z-index:999;
  			top:0;
  		}

      .iradio_minimal-blue {
          display: inline-block;
          *display: inline;
          vertical-align: middle;
          margin: 0;
          padding: 0;
          width: 18px;
          height: 18px;
          background: url(../assets/images/blue.png) no-repeat;
          border: none;
          cursor: pointer;
      }

      .titleprog{
        position:absolute; top:-40px; margin-left:-20px; z-index:9999;color:#000;
      }

      .cone {
        position:absolute;
        top:-20px;
        margin-left:7px;
        width: 0;
        height: 0;
        border-left: 10px solid transparent;
        border-right: 10px solid transparent;
        border-top: 20px solid red;
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
        border-radius: 50%;
      }

      .map_wrapper {
        margin-top: -1200px;
      }

      .redbar {
        background-color: #F00;
        color: #FFF;
        font-weight: bold;
      }

      .main_bg {
  /*      background: url('../image/bg_main.jpg');*/
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        z-index: 9999;
        position: absolute;
        top: 0;
      }
       .main_logo {
        background: url('../image/logo.png');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
      }

      .img-holder {
        background: url('../image/blue_main_bg.png');
        background-repeat: no-repeat;
        background-size: 100% 100%;
        background-position: center;
        width: 100%;
        height: 100%;
      }

      .img-content {
        max-width:100%;
        height: auto;
        max-height: 630px;
      }

      @media (max-width:2000px) {
        .img-holder {
          padding-bottom: 20%;
        }

        .img-content{
          margin-left: 120px;
        }
      }

      @media (max-width:1200px) {
        .img-holder {
          padding-bottom: 50%;
        }

        .img-content{
          margin-left: 0px;
        }
      }

      @media (max-width:900px) {
        .img-holder {
          padding-bottom: 50%;
        }

        .img-content{
          margin-left: 10px;
        }
      }

      @media (max-width:767px) {
        .tagline {
          font-size: 17px;
        }
        .img-holder {
          padding-bottom: 100%;
        }

        .img-content {
          margin-top: 50px;
          margin-left: 0px;
        }
      }

      .login-container {
        background-color: transparent !important;
      }

      .login-body {
        background-color: white;
      }

  	</style>

  </head>

  <body ng-app="starter" >

    <div class="img-holder">
      <img class="img-content" src="<?= base_url('image/bg_content.png') ?>">
    </div>
    
    <div class="login-container main_bg" ng-controller="loginCtrl" style="background-color: red" ng-click="askToShow()" >

      <div class="login-box animated fadeInDown" ng-show="ask_to_show">
        <div class="login-body">
<!--           <button class="close" ng-click="askToHide()" >X</button>
 -->
          <div class="login-logo" style="z-index: 9999; margin-bottom: 70px;">
            <!--a href=""><b>USER</b> LOGIN</a-->
            <img src="<?php echo base_url('image/logo.png') ?>" height="120" width="120" style="">
          </div>

          <div align="center" style="position:absolute; left:50%; margin-top:20px;" ng-show="loadPage" ng-cloak>
            <span class="fa fa-spinner fa-spin"></span> &nbsp;Processing
          </div>

          <h4 class="login-box-msg">Sign in to start your session</h4>
          <span ng-cloak style="color: red" >{{infoError}}</span>
          <div class="main_logo"> </div>
          <div class="form-horizontal">
            <div class="form-group">
              <div class="col-md-12">
                <input type="text" ng-model="username" class="form-control" ng-keydown="keyLogin($event, username, password)" placeholder="Username"/>
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-12">
                <input type="password" ng-model="password" class="form-control" ng-keydown="keyLogin($event, username, password)" placeholder="Password"/>
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-12">
                <button class="btn btn-info btn-block" ng-click="login(username, password)">Log In</button>
              </div>
            </div>

            <div class="pull-right">&copy; 2018 | APP V1.demo</div>
          </div>
        </div>

      </div>
    </div>

    <!-- jQuery 2.2.3 -->
    <script src="<?php echo base_url('assets/plugins/jQuery/jquery-2.2.3.min.js')?>"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="<?php echo base_url('assets/css/bootstrap/dist/js/bootstrap.min.js')?>"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url('assets/dist/js/app.min.js')?>"></script>
    <!-- upload -->
    <script src="<?php echo base_url('assets/js/upload/ng-file-upload-shim.js')?>"></script>
    <script src="<?php echo base_url('assets/js/upload/ng-file-upload.js')?>"></script>

    <script type="text/javascript" src="<?php echo base_url('assets/js/angular/angular-sanitize.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/ng-csv/build/ng-csv.min.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/ng-csv/build/ng-csv.min.js')?>"></script>

    <!-- ANGULAR JS -->
    <?php $version = md5(date('YmdHis').'wantech'); ?>

    <script src="<?php echo base_url('assets/js/angular/app/app_Main_20190705.js'). "?v=" . $version; ?>"></script>
    <script src="<?php echo base_url('assets/js/angular/app/app_Controller_20200301.js'). "?v=" . $version; ?>"></script>
    <script src="<?php echo base_url('assets/js/angular/app/app_Service_20200301.js'). "?v=" . $version; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/dirPagination.js');?>"></script>
    <!-- menu handler -->
    <script type="text/javascript" src="<?php echo base_url('assets/js/custom-menu-handler.js')?>"></script>
    <script type="text/javascript">
      $(window).load(function() {
        $(".loading").fadeOut("slow");
      });
    </script>

  </body>
</html>

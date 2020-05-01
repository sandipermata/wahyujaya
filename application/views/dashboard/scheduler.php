<style type="text/css">

  .info-box {
    cursor: pointer;
  }
  
  .info-box-text {
    text-align: right;
    margin: 0px;
    padding: 0px;
  }

  .info-box-number {
    font-size: 27px;
    text-align: right;
  }

  .info-box-footer {
    padding-right: 10px;
    text-align: right;
  }

  .info-box-footer small{
    font-size: 12px;
  }

</style>

<div class="content-wrapper" ng-controller='schCtrl'>
  <section class="content-header">
    <h1><?= $title ?> <small ng-cloak><?= $desc ?></small></h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> <?= $parent ?></a></li>
      <li class="active"><?= $title ?></li>
    </ol>
  </section>
 
  <!-- Main content -->
  <section class="content">

    <div class="row">

      <div class="clearfix visible-sm-block"></div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box box-dash-yellow">
          <span class="info-box-icon bg-yellow"><i class="fa fa-cloud-download"></i></span>
          <div class="info-box-content">

            <span class="info-box-text">Data Pending</span>
            <span class="info-box-number" ng-cloak>{{dash.pending >= 1000 ? dash.pending / 1000 + " K" : dash.pending || 0}} </span>
            <img src="<?php echo base_url('image/loader.gif') ?>" class="LoadImg" ng-show="!dash" />
          </div>
          <div class="info-box-footer">
            <small><i>data terakhir <b>{{dash.last_sync_2}}</b></i></small>
          </div>
        </div>
      </div>

      <div class="clearfix visible-sm-block"></div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box box-dash-green">
          <span class="info-box-icon bg-green"><i class="fa fa-check"></i></span>
          <div class="info-box-content">

            <span class="info-box-text">Data Berhasil</span>
            <span class="info-box-number" ng-cloak>{{dash.berhasil >= 1000 ? dash.berhasil / 1000 + " K" : dash.berhasil || 0}} </span>
            <img src="<?php echo base_url('image/loader.gif') ?>" class="LoadImg" ng-show="!dash" />

          </div>
          <div class="info-box-footer">
            <small><i>data terakhir <b>{{dash.last_sync_2}}</b></i></small>
          </div>
        </div>
      </div>

      <div class="clearfix visible-sm-block"></div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box box-dash-red">
          <span class="info-box-icon bg-red"><i class="fa fa-remove"></i></span>
          <div class="info-box-content">

            <span class="info-box-text">Data Gagal</span>
            <span class="info-box-number" ng-cloak>0</span>
            <img src="<?php echo base_url('image/loader.gif') ?>" class="LoadImg" ng-show="!dash" />

          </div>
          <div class="info-box-footer">
            <small><i>data terakhir <b>{{dash.last_sync_2}}</b></i></small>
          </div>
        </div>
      </div>

      <div class="clearfix visible-sm-block"></div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box box-dash-teal">
          <span class="info-box-icon bg-teal"><i class="fa fa-info"></i></span>
          <div class="info-box-content">

            <span class="info-box-text">Progress</span>
            <span class="info-box-number" ng-cloak>{{dash.progress}} % </span>
            <img src="<?php echo base_url('image/loader.gif') ?>" class="LoadImg" ng-show="!dash" />

          </div>
          <div class="info-box-footer" align="center">
            <small><i>data terakhir <b>{{dash.last_sync_2}}</b></i></small>
          </div>
        </div>
      </div>

    </div>

  </section>
  <section class="content"></section>

</div>







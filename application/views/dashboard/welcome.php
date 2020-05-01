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

    <h4><b>EWS</b></h4>
    {{testValue}}

    <div class="row">
      <div class="clearfix visible-sm-block"></div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box box-dash-yellow">
          <span class="info-box-icon bg-yellow"><i class="fa fa-cloud-download"></i></span>
          <div class="info-box-content">

            <span class="info-box-text">Data Pending</span>
            <span class="info-box-number" ng-cloak>{{dash_ews.pending_ews >= 1000 ? (dash_ews.pending_ews / 1000) + " K" : dash_ews.pending_ews || 0}} </span>
            <img src="<?php echo base_url('image/loader.gif') ?>" class="LoadImg" ng-show="!dash_ews" />
          </div>
          <div class="info-box-footer">
            <small><i>data terakhir <b>{{dash_ews.last_sync_2_ews}}</b></i></small>
          </div>
        </div>
      </div>

      <div class="clearfix visible-sm-block"></div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box box-dash-green">
          <span class="info-box-icon bg-green"><i class="fa fa-check"></i></span>
          <div class="info-box-content">

            <span class="info-box-text">Data Berhasil</span>
            <span class="info-box-number" ng-cloak>{{dash_ews.berhasil_ews >= 1000 ? (dash_ews.berhasil_ews / 1000) + " K" : dash_ews.berhasil_ews || 0}} </span>
            <img src="<?php echo base_url('image/loader.gif') ?>" class="LoadImg" ng-show="!dash_ews" />

          </div>
          <div class="info-box-footer">
            <small><i>data terakhir <b>{{dash_ews.last_sync_2_ews}}</b></i></small>
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
            <img src="<?php echo base_url('image/loader.gif') ?>" class="LoadImg" ng-show="!dash_ews" />

          </div>
          <div class="info-box-footer">
            <small><i>data terakhir <b>{{dash_ews.last_sync_2_ews}}</b></i></small>
          </div>
        </div>
      </div>

      <div class="clearfix visible-sm-block"></div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box box-dash-teal">
          <span class="info-box-icon bg-teal"><i class="fa fa-info"></i></span>
          <div class="info-box-content">

            <span class="info-box-text">Progress</span>
            <span class="info-box-number" ng-cloak>{{dash_ews.progress_ews || 0 |number:2 }} % </span>
            <img src="<?php echo base_url('image/loader.gif') ?>" class="LoadImg" ng-show="!dash_ews" />

          </div>
          <div class="info-box-footer" align="center">
            <small><i>data terakhir <b>{{dash_ews.last_sync_2_ews}}</b></i></small>
          </div>
        </div>
      </div>

    </div>

    <h4><b>Traffic Light</b></h4>
    <div class="row">
      <div class="clearfix visible-sm-block"></div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box box-dash-yellow">
          <span class="info-box-icon bg-yellow"><i class="fa fa-cloud-download"></i></span>
          <div class="info-box-content">

            <span class="info-box-text">Data Pending</span>
            <span class="info-box-number" ng-cloak>{{dash_tl.pending_tl >= 1000 ? (dash_tl.pending_tl / 1000) + " K" : dash_tl.pending_tl || 0}} </span>
            <img src="<?php echo base_url('image/loader.gif') ?>" class="LoadImg" ng-show="!dash_tl" />
          </div>
          <div class="info-box-footer">
            <small><i>data terakhir <b>{{dash_tl.last_sync_2_tl}}</b></i></small>
          </div>
        </div>
      </div>

      <div class="clearfix visible-sm-block"></div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box box-dash-green">
          <span class="info-box-icon bg-green"><i class="fa fa-check"></i></span>
          <div class="info-box-content">

            <span class="info-box-text">Data Berhasil</span>
            <span class="info-box-number" ng-cloak>{{dash_tl.berhasil_tl >= 1000 ? (dash_tl.berhasil_tl / 1000) + " K" : dash_tl.berhasil_tl || 0}} </span>
            <img src="<?php echo base_url('image/loader.gif') ?>" class="LoadImg" ng-show="!dash_tl" />

          </div>
          <div class="info-box-footer">
            <small><i>data terakhir <b>{{dash_tl.last_sync_2_tl}}</b></i></small>
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
            <img src="<?php echo base_url('image/loader.gif') ?>" class="LoadImg" ng-show="!dash_tl" />

          </div>
          <div class="info-box-footer">
            <small><i>data terakhir <b>{{dash_tl.last_sync_2_tl}}</b></i></small>
          </div>
        </div>
      </div>

      <div class="clearfix visible-sm-block"></div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box box-dash-teal">
          <span class="info-box-icon bg-teal"><i class="fa fa-info"></i></span>
          <div class="info-box-content">

            <span class="info-box-text">Progress</span>
            <span class="info-box-number" ng-cloak>{{dash_tl.progress_tl || 0 |number:2 }} % </span>
            <img src="<?php echo base_url('image/loader.gif') ?>" class="LoadImg" ng-show="!dash_tl" />

          </div>
          <div class="info-box-footer" align="center">
            <small><i>data terakhir <b>{{dash_tl.last_sync_2_tl}}</b></i></small>
          </div>
        </div>
      </div>

    </div>

    <h4><b>Warning Light</b></h4>
    <div class="row">
      <div class="clearfix visible-sm-block"></div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box box-dash-yellow">
          <span class="info-box-icon bg-yellow"><i class="fa fa-cloud-download"></i></span>
          <div class="info-box-content">

            <span class="info-box-text">Data Pending</span>
            <span class="info-box-number" ng-cloak>{{dash_wl.pending_wl >= 1000 ? (dash_wl.pending_wl / 1000) + " K" : dash_wl.pending_wl || 0}} </span>
            <img src="<?php echo base_url('image/loader.gif') ?>" class="LoadImg" ng-show="!dash_wl" />
          </div>
          <div class="info-box-footer">
            <small><i>data terakhir <b>{{dash_wl.last_sync_2_wl}}</b></i></small>
          </div>
        </div>
      </div>

      <div class="clearfix visible-sm-block"></div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box box-dash-green">
          <span class="info-box-icon bg-green"><i class="fa fa-check"></i></span>
          <div class="info-box-content">

            <span class="info-box-text">Data Berhasil</span>
            <span class="info-box-number" ng-cloak>{{dash_wl.berhasil_wl >= 1000 ? (dash_wl.berhasil_wl / 1000) + " K" : dash_wl.berhasil_wl || 0}} </span>
            <img src="<?php echo base_url('image/loader.gif') ?>" class="LoadImg" ng-show="!dash_wl" />

          </div>
          <div class="info-box-footer">
            <small><i>data terakhir <b>{{dash_wl.last_sync_2_wl}}</b></i></small>
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
            <img src="<?php echo base_url('image/loader.gif') ?>" class="LoadImg" ng-show="!dash_wl" />

          </div>
          <div class="info-box-footer">
            <small><i>data terakhir <b>{{dash_wl.last_sync_2_wl}}</b></i></small>
          </div>
        </div>
      </div>

      <div class="clearfix visible-sm-block"></div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box box-dash-teal">
          <span class="info-box-icon bg-teal"><i class="fa fa-info"></i></span>
          <div class="info-box-content">

            <span class="info-box-text">Progress</span>
            <span class="info-box-number" ng-cloak>{{dash_wl.progress_wl || 0 |number:2 }} % </span>
            <img src="<?php echo base_url('image/loader.gif') ?>" class="LoadImg" ng-show="!dash_wl" />

          </div>
          <div class="info-box-footer" align="center">
            <small><i>data terakhir <b>{{dash_wl.last_sync_2_wl}}</b></i></small>
          </div>
        </div>
      </div>

    </div>


  </section>
  <section class="content"></section>

</div>







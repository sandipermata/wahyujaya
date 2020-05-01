<div class="content-wrapper" ng-controller='dashCtrl' ng-init="map_code = 'pju'">
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
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Demo</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>

          <div class="box-body">
            <div class="row">
              <div class="col-md-12">

                <div class="row">
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Provinsi</label>
                      <select class="form-control select2" id="s_prov">
                        <option>&nbsp;</option>
                        <option ng-repeat="p in provinces" value="{{p.prov_code}}">{{p.prov_name}}</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Kabupaten / Kota</label>
                      <select class="form-control select2" id="s_kab">
                        <option>&nbsp;</option>
                        <option ng-repeat="kab in kabupaten" ng-disabled="kab.kab_code != '3171'" value="{{kab.kab_code}}">{{kab.kab_name}}</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Kecamatan / Desa</label>
                      <select class="form-control select2" id="s_kec">
                        <option>&nbsp;</option>
                        <option ng-repeat="kec in kecamatan" ng-disabled="kec.kec_code != '3171090'" value="{{kec.kec_code}}">{{kec.kec_name}}</option>
                      </select>
                    </div>
                  </div>

                </div>

                <div class="chart">
                  <ng-map center="[{{centerLocLat}}, {{centerLocLon}}]" scrollwheel='false' gesture-handling='greedy' style="height:450px;" zoom="{{centerZoom}}">
                    <marker
                    animation= 'google.maps.Animation.DROP'
                    icon= "{{base_url}}/image/traffic-light-small.png"
                    ng-repeat="pos in posisi" position="{{pos.pju_loc_lat}}, {{pos.pju_loc_lon}}"
                    label="{{pos.pju_pole}}"
                    on-click="showContent(event, pos)"
                    ></marker>
                  </ng-map>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

  </section>
  <section class="content"></section>

  <div id="modal_detail" class="modal fade in">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Information <b>{{data_pos.pju_pole}}</b></h4>
          </div>
          <div class="modal-body">
            <small><i>Location :</i></small>
            <p>{{data_pos.pju_loc_desc}}</p>

            <small><i>Battery :</i></small>
            <p>{{data_pos.pju_battery}} %</p>

            <small><i>Status :</i></small>
            <p style="cursor: pointer;"><b>click here</b></p>

            <div class="row" align="center">

              <div class="col-sm-12" align="center" style="margin-bottom: 20px;">
                <h3>{{total_time}}</h3>
              </div>

              <div class="col-sm-6" ng-repeat='p in posisi'>
                <b>{{p.pju_pole}} : </b> {{p.pju_duration}} seconds <br>
                {{action}} <br>

                <img src="<?php echo base_url('image/palang-small.png') ?>" width="80" height="80" >
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success btn-sm" ng-click="closeModal()">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>







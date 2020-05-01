<div class="content-wrapper" ng-controller='dashCtrl'>
  <section class="content-header">
    <h1>Dashboard <small ng-cloak>Control Panel</small></h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
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

                <div class="col-sm-3" align="center">
                  <label class="label-caption" ng-click="showMap('tl')">
                    <input type="checkbox" style="display: none;">
                    Traffic Light
                  </label>
                </div>

                <div class="col-sm-3" align="center">
                  <label class="label-caption" ng-click="showMap('ews')" >
                    <input type="checkbox" style="display: none;">
                    EWS
                  </label>
                </div>

                <div class="col-sm-3" align="center">
                  <label class="label-caption" ng-click="showMap('wl')">
                    <input type="checkbox" ng-model="cekWrn" style="display: none;">
                    Warning Light
                  </label>
                </div>

                <div class="col-sm-3" align="center">
                  <label class="label-caption" ng-click="showMap('pju')">
                    <input type="checkbox" ng-model="cekPju" style="display: none;">
                    PJU
                  </label>
                </div>

                <audio id="myAudio">
                  <source src="<?php echo base_url('assets/sound/palang_kereta.wav') ?>" type="audio/wav">
                  Your browser does not support the audio element.
                </audio>

              </div>
            </div>
          </div>

        </div>
      </div>
    </div>


    <div class="row" ng-show="is_show">
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
                    icon= "{{base_url}}/image/{{pos.image}}"
                    ng-repeat="pos in posisi" position="{{pos.geolat}}, {{pos.geolong}}"
                    label="{{pos.tiang}}"
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
            <h4 class="modal-title">Information <b>{{data_pos.tiang}}</b></h4>
          </div>
          <div class="modal-body">
            <small><i>Location :</i></small>
            <p>{{data_pos.lokasi}}</p>

            <small ng-show="map_code == 'pju'"><i>Battery :</i></small>
            <p ng-show="map_code == 'pju'">{{data_pos.battery}}</p>

            <small><i>Status :</i></small>
            <p style="cursor: pointer;"><b>click here</b></p>

            <div class="col-sm-12" align="center">
              <h3>{{total_time}}</h3>
            </div>

            <div class="row" align="center" ng-show="map_code == 'ews'">
              <div class="col-sm-12" ng-repeat='p in posisi'>
                <img src="<?php echo base_url('image/palang.gif') ?>" width="220" height="220" >

                <div class="row">
                  <div class="col-sm-12">
                    <button class="btn btn-app" ng-click="playAudio()">
                      <i class="fa fa-play"></i> Play
                    </button>
                    <button class="btn btn-app" ng-click="pauseAudio()">
                      <i class="fa fa-pause"></i> Pause
                    </button>
                    <button class="btn btn-app" ng-click="muteAudio()">
                      <i class="fa fa-volume-off"></i> Mute
                    </button>
                    <button class="btn btn-app" ng-click="stopAudio()">
                      <i class="fa fa-stop"></i> Stop
                    </button>                    
                  </div>                  
                </div>

              </div>
            </div>

            <div class="row" align="center" ng-show="map_code == 'tl'">
              <div class="col-sm-6" ng-repeat='p in posisi'>
                <b>{{p.tiang}} : </b> {{p.duration}} seconds <br>
                {{action}} <br>

                <img ng-if="p.status == 'mati'" src="<?php echo base_url('image/red.png') ?>" width="80" height="80" >
                <img ng-if="p.status == 'nyala'" src="<?php echo base_url('image/green.png') ?>" width="80" height="80">
                <img ng-if="p.status == 'kuning'" src="<?php echo base_url('image/yellow.png') ?>" width="80" height="80">
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







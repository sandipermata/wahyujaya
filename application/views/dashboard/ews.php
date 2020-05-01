<style type="text/css">
  
.outer-layer {
  width:100%;
  height:100%;
  z-index:15000;
  top:0px;
  left:0;
}

.main-body-layer {
  top:0%;
  background:#fff;
  width:100%;
  min-height:0%;
  max-height: 450px;
  overflow-y: scroll;
  height: 0%;
  padding:10px;
}

.header-layer {
  height:10%;
  max-height:10%;
}

.content-layer {
  max-height:90%;
  width:100%;
  height:90%;
  overflow:auto;
  box-sizing: border-box;
  display: table-cell;
  vertical-align: middle;
}

#modal_detail_ews table td {
  display: table-cell;
  vertical-align: middle;  
}

.img_icon {
  height: 50px;
  width: 50px;
}

.img_suhu {
  height: 40px;
  width: 30px;
}

.img_icon_small {
  height: 30px;
  width: 30px;
}

.img_icon_large {
  height: 40px;
  width: 40px;
}

.img_icon_larger {
  height: 60px;
  width: 60px;
}

</style>

<div class="content-wrapper" ng-controller='dashCtrl' ng-init="map_code = 'ews'">
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
                      <select class="form-control selectProv" id="s_prov">
                        <option value="">&nbsp;</option>
                        <option ng-repeat="p in provinces" value="{{p.prov_code}}">{{p.prov_name}}</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Kabupaten / Kota</label>
                      <select class="form-control selectKota" id="s_kab">
                        <option value="">&nbsp;</option>
                        <option ng-repeat="kab in kabupaten" value="{{kab.city_code}}">{{kab.city_name_convert}}</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Kecamatan / Desa</label>
                      <select class="form-control selectKec" id="s_kec">
                        <option value="">&nbsp;</option>
                        <option ng-repeat="kec in kecamatan" value="{{kec.district_code}}">{{kec.district_name}}</option>
                      </select>
                    </div>
                  </div>

                </div>

                <div class="chart">

                  <div id="map0" style="height: 450px;" align="center">
                    <p align="center"><h4><span class="fa fa-spin fa-spinner"></span> memuat peta </h4></p>
                  </div>

                  <!--ng-map center="[{{centerLocLat}}, {{centerLocLon}}]" scrollwheel='false' gesture-handling='greedy' style="height:450px;" zoom="{{centerZoom}}">
                    <marker
                    ng-repeat="pos in posisi" position="{{pos.ews_loc_lat}}, {{pos.ews_loc_lon}}"
                    animation= 'google.maps.Animation.DROP'
                    icon= "{{base_url}}/image/icons/{{pos.icon_image}}"
                    label="{{pos.ews_pole}}"
                    on-click="showContent(event, pos)"
                    ></marker>
                  </ng-map-->
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
          <button type="button" class="close" ng-click="closeModal(ewsArah)" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Information <b>{{ewsIP}} </b></h4>
        </div>
        <div class="modal-body">
          <button type="button" class="btn btn-success btn-sm" ng-click="showDetailEws(data_pos)">Laporan Detail</button> <br>
          <small><i>Location :</i></small><br>

          <small>{{data_pos.ews_loc_desc}}</small>
          <p>{{data_pos.ews_area}}</p>

          <small><i>{{ewsArah}}</i></small>
          <div class="row" align="center" ng-if="video_isplay" ng-cloak>
            <div class="pull-right" style="position: absolute; right: 20px; top: 20px; z-index: 999;"><h3>{{total_time_ews}}</h3></div>
            <div class="col-sm-12">
              <img width="100%" height="80%" src="<?php echo base_url('assets/video/standby.gif') ?>">
            </div>
          </div>

          <div class="row" align="center" ng-if="video_isplay_kanan" ng-cloak>
            <div class="pull-right" style="position: absolute; right: 20px; top: 20px; z-index: 999;"><h3>{{total_time_ews}}</h3></div>
            <div class="col-sm-12">
              <video width="100%" height="80%" autoplay loop id="video_ews_kanan">
                <source src="<?php echo base_url('assets/video/KananToKiri.mp4') ?>" type="video/mp4">
                Your browser does not support the video tag.
              </video>
            </div>
          </div>

          <div class="row" align="center" ng-if="video_isplay_kiri" ng-cloak>
            <!--div class="pull-right" style="position: absolute; right: 20px; top: 20px; z-index: 999;"><h3>{{total_time_ews}}</h3></div-->
            <div class="col-sm-12">
              <video width="100%" height="80%" autoplay loop id="video_ews_kiri">
                <source src="<?php echo base_url('assets/video/KiriToKanan.mp4') ?>" type="video/mp4">
                Your browser does not support the video tag.
              </video>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success btn-sm" ng-click="closeModal(ewsArah)">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div id="modal_detail_ews" class="modal fade in">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #8eaadb;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <div class="row" style="margin-top: -10px;">

            <div class="col-xs-12 hidden-sm hidden-md hidden-lg show-xs">
              <div class="col-xs-6">
                <img ng-src="{{base_url}}image/project/dishub.png" width="80" height="100">
              </div>
              <div class="col-xs-6" align="right">
                <img ng-src="{{base_url}}image/prov/jawatimur.png" width="80" height="100">
              </div>
            </div>

            <div class="col-xs-12 hidden-sm hidden-md hidden-lg show-xs" align="center" style="color: white;">
              <b style="font-size: 18px;">SELAMAT DATANG DI SMART MONITORING SYSTEM</b><br>
              <b style="font-size: 16px;">Automatic Early Warning System</b><br>
              <b>PENGEMBANGAN TRANSPORTASI DAN MULTIMODA</b><br>
              <b>Dinas Perhubungan Provinsi {{(header.ews_area).split(" - ")[2]}} </b>
            </div>

            <div class="col-sm-12 hidden-xs">
              <div class="row" style="color: white;">
                <div class="col-sm-2">
                  <img ng-src="{{base_url}}image/project/dishub.png" width="80" height="100">
                </div>

                <div class="col-sm-8" align="center">
                  <b style="font-size: 18px;">SELAMAT DATANG DI SMART MONITORING SYSTEM</b><br>
                  <b style="font-size: 16px;">Automatic Early Warning System</b><br>
                  <b>PENGEMBANGAN TRANSPORTASI DAN MULTIMODA</b><br>
                  <b>Dinas Perhubungan Provinsi {{(header.ews_area).split(" - ")[2]}} </b>
                </div>

                <div class="col-sm-2" align="right" style="padding: 10px;">
                  <img ng-src="{{base_url}}image/prov/jawatimur.png" width="70" height="80">
                </div>

              </div>              
            </div>
            
          </div>

        </div>
        <div class="modal-body">
          <div class="row" style="background-color: rgba(100,100,100, 0.3); margin-top: -17px;">

            <div class="col-sm-12" >
              <div class="col-sm-6">

                <div class="row">
                  <table>
                    <tr>
                      <td>Serial Number &nbsp;</td>
                      <td> : {{ip_address}}</td>
                    </tr>
                    <tr>
                      <td>Koordinat</td>
                      <td> : {{header.ews_loc_lat}} , {{header.ews_loc_lon}}</td>
                    </tr>
                    <tr>
                      <td>No JPL</td>
                      <td> : {{header.ews_jpl}}</td>
                    </tr>
                    <tr>
                      <td>Km</td>
                      <td> : {{header.ews_kms}}</td>
                    </tr>
                    <tr>
                      <td>Desa</td>
                      <td> : {{header.ews_loc_desc}}</td>
                    </tr>
                    <tr>
                      <td>Kecamatan</td>
                      <td> : {{(header.ews_area).split(" - ")[0]}}</td>
                    </tr>
                    <tr>
                      <td>Kabupaten</td>
                      <td> : {{(header.ews_area).split(" - ")[1]}}</td>
                    </tr>
                    <tr>
                      <td>Provinsi</td>
                      <td> : {{(header.ews_area).split(" - ")[2]}}</td>
                    </tr>
                  </table>
                  
                </div>
                
              </div>

              <div class="col-sm-6">
                <div class="row" align="right">
                  {{weathers.current.condition.text || "mengambil data ..." }} <br>
                  {{weathers.current.temp_c || 0 }} <sup>o</sup>C<br>
                  <img ng-src="https:{{weathers.current.condition.icon}}" height="100" width="100" >
                </div>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="row">
                <div class="col-sm-12">
                  <br>
                  <b>Laporan EWS Periode</b>
                </div>

                <div class="form-group">
                  <div class="col-sm-3">
                    <div class="input-group date datepicker">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control input-sm pull-right dateFrom" placeholder="dari">
                    </div>
                  </div>

                  <div class="col-sm-3">
                    <div class="input-group date datepicker">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control input-sm pull-right dateTo" placeholder="sampai">
                    </div>
                  </div>

                  <div class="col-sm-2">
                    <button class="btn btn-block btn-sm btn-primary" ng-click="filterReport(ip_address)">Cari</button>
                  </div>

                  <div class="col-sm-2">
                    <button class="btn btn-block btn-sm btn-success" 
                    ng-csv="getDetailsFilter()" csv-header="getHeaderFilter()" lazy-load="true" filename="{{filenames}}" field-separator="," >Print</button>
                  </div>

                  <div class="col-sm-2">
                    <button class="btn btn-block btn-sm btn-primary" ng-click="filterReport(ip_address)">Refresh</button>
                  </div>

                </div>
                
              </div>
            </div>

            <div class="col-sm-12 table table-responsive" style="margin-top: 10px;">
              <table class="table table-condensed table-bordered">
                <tr bgcolor="#8eaadb">
                  <td align="center" valign="middle"><b>No</b></td>
                  <td align="center"><b>Waktu</b></td>
                  <td align="center"><b>Baterai</b></td>
                  <td align="center"><b>Solar Cell</b></td>
                  <td align="center"><b>Lampu Merah</b></td>
                  <td align="center"><b>Indikator Arah</b></td>
                  <td align="center"><b>Lampu Kuning</b></td>
                  <td align="center"><b>Volume Sirine</b></td>
                  <td align="center"><b>Sensor Kanan</b></td>
                  <td align="center"><b>Sensor Reset</b></td>
                  <td align="center"><b>Sensor Kiri</b></td>
                  <td align="center"><b>Suhu</b></td>
                  <td align="center"><b>Sinyal Modem</b></td>
                  <td align="center"><b>Speaker</b></td>
                </tr>
                <tr ng-repeat="his in datafilters">
                  <td align="center">{{$index+1}}</td>
                  <td style="white-space: nowrap;" align="center">
                    {{his.date_rpt}} <br> 
                    {{his.jam_rpt}}
                  </td>
                  <td align="center">
                    <img class="img_icon" ng-src="{{base_url}}image/indicator/{{his.icon_bat}}"><br><br>
                    {{his.ews_battery_percent | number:0}} %
                  </td>
                  <td align="center"><img class="img_icon" ng-src="{{base_url}}image/indicator/{{his.icon_chg_ind}}"><br><br>{{his.chg_ind_status}} </td>
                  <td align="center">

                    <img ng-if="his.lampu_merah == 'ON'" class="img_icon" ng-src="{{base_url}}image/indicator/lampu_merah_on.gif">
                    <img ng-if="his.lampu_merah == 'RUSAK'" class="img_icon" ng-src="{{base_url}}image/indicator/lampu_merah_off_rusak.png">
                    <img ng-if="his.lampu_merah == 'OFF'" class="img_icon" ng-src="{{base_url}}image/indicator/lampu_merah_off.png">

                    <span><b>{{his.lampu_merah}}</b></span>

                  </td>
                  <td align="center">
                    <table class="" border="0">
                      <tr>
                        <td colspan="2" align="center">
                          <img class="img_icon_larger" ng-src="{{base_url}}image/indicator/{{his.lampu_arah}}">
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2"><img height="10" width="auto" ng-src="{{base_url}}image/indicator/arahBaruTanda.png"></td>
                      </tr>
                      <tr>
                        <td align="left">{{his.ews_dir_left}}</td>
                        <td align="right">{{his.ews_dir_right}}</td>
                      </tr>
                      <tr>
                        <td colspan="2" align="center">
                           <small>Kecepatan KA km/jam</small><br>
                          {{his.ews_kecepatan}}
                        </td>
                      </tr>
                    </table>

                  </td>
                  <td align="center">
                    <img ng-if="his.lampu_kuning == 'OFF'" class="img_icon" ng-src="{{base_url}}image/indicator/lampu_kuning_off.png">
                    <img ng-if="his.lampu_kuning == 'ON'" class="img_icon" ng-src="{{base_url}}image/indicator/lampu_kuning_on.gif">
                    <img ng-if="his.lampu_kuning == 'RUSAK'" class="img_icon" ng-src="{{base_url}}image/indicator/lampu_kuning_off_rusak.png">

                    <span><b>{{his.lampu_kuning}}</b></span>
                  </td>
                  <td align="center"><img class="img_icon_large" ng-src="{{base_url}}image/indicator/{{his.icon_sirine}}"></td>
                  <td align="center"><img class="img_icon_small" ng-src="{{base_url}}image/indicator/{{his.icon_sensor_R}}"><br><br>{{his.ews_jml_pulse_sensor_R}}</td>
                  <td align="center"><img class="img_icon_small" ng-src="{{base_url}}image/indicator/{{his.icon_sensor_C}}"><br><br>{{his.ews_jml_pulse_sensor_C}}</td>
                  <td align="center"><img class="img_icon_small" ng-src="{{base_url}}image/indicator/{{his.icon_sensor_L}}"><br><br>{{his.ews_jml_pulse_sensor_L}}</td>
                  <td align="center"><img class="img_suhu" ng-src="{{base_url}}image/indicator/{{his.icon_suhu}}"><br>
                    Modul <br>
                    {{(his.ews_suhu_confan).split("/")[0]}} <sup>o</sup>C
                    Box <br>
                    {{(his.ews_suhu_confan).split("/")[1]}} <sup>o</sup>C
                  </td>
                  <td align="center">
                    <img class="img_icon_small" ng-if="his.ews_modem_signal" ng-src="{{base_url}}image/indicator/sinyal-modem-aktif.gif">
                    <img class="img_icon_small" ng-if="!his.ews_modem_signal" ng-src="{{base_url}}image/indicator/sinyal-modem.gif">
                  </td>
                  <td align="center">
                    <!-- <img ng-hide="(his.ews_arus_speaker == '0' && (his.ews_arah == 'LEFT' || his.ews_arah == 'RIGHT' ) )" class="img_icon_large" ng-src="{{base_url}}image/indicator/{{his.icon_status_toa}}"> <br>
                    <b ng-if="(his.ews_arus_speaker == '0' && (his.ews_arah == 'LEFT' || his.ews_arah == 'RIGHT' ) )" >Mohon Cek Speaker</b> -->

                    <img ng-if="his.speaker == 'OFF'" class="img_icon" ng-src="{{base_url}}image/indicator/Speaker_off.png">
                    <img ng-if="his.speaker == 'ON'" class="img_icon" ng-src="{{base_url}}image/indicator/Speaker_Bunyi.gif">
                    <img ng-if="his.speaker == 'RUSAK'" class="img_icon" ng-src="{{base_url}}image/indicator/Speaker_rusak.png">
                    <img ng-if="his.speaker == 'MUTE'" class="img_icon" ng-src="{{base_url}}image/indicator/Speaker_Tidak_Bunyi.gif">
                    
                  </td>
                </tr>
              </table>
            </div>
          </div>

        </div>
        <div class="modal-footer" style="background-color: rgba(100,100,100, 0.3); margin-top: -17px;">
          <button type="button" class="btn btn-success btn-sm" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


</div>







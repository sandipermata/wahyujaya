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

<div class="content-wrapper" ng-controller='rEwsCtrl'>
  <section class="content-header">
    <h1><?= $title ?> <small ng-cloak><?= $desc ?></small></h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> <?= $parent ?></a></li>
      <li class="active"><?= $title ?></li>
    </ol>
  </section>
 
  <!-- Main content -->
  <section class="content" ng-cloak>

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
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Provinsi</label>
                      <select class="form-control select2" id="s_prov">
                        <option value="all">Semua Propinsi</option>
                        <option ng-repeat="p in provinces" value="{{p.prov_code}}">{{p.prov_name}}</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Kabupaten / Kota</label>
                      <select class="form-control select2" id="s_kab">
                        <option value="all">Semua Kabupaten / Kota</option>
                        <option ng-repeat="kab in kabupaten" value="{{kab.city_code}}">{{kab.city_name_convert}}</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Kecamatan / Desa</label>
                      <select class="form-control select2" id="s_kec">
                        <option value="all">Semua Kecamatan / Desa</option>
                        <option ng-repeat="kec in kecamatan" value="{{kec.district_code}}">{{kec.district_name}}</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>&nbsp;</label>
                      <button class="btn btn-success btn-sm btn-block" ng-click="getReport()" >Search</button>
                    </div>
                  </div>

                </div>

            <div class="row">
              <div class="col-md-12">

                <div class="row" style="margin-bottom: 10px">
                  <!--div class="col-sm-2">
                    <button class="btn btn-sm btn-success btn-block" ng-click="addUser()" >Add New Menu</button>
                  </div-->
                  <div class="col-sm-4 pull-right">
                    <input type="text" ng-model="searchTable" class="form-control input-sm" placeholder="Search" autofocus="">
                  </div>
                </div>

                <div class="table table-responsive">
                  <table class="table table-bordered">
                    <thead>                     
                      <tr>
                        <td align="center" width="50"><b>No</b></td>
                        <td align="center"><b>ID EWS</b></td>
                        <td align="center"><b>Lokasi</b></td>
                        <td align="center"><b>Peta</b></td>
                        <td align="center"><b>KA Melintas Nomor Perlintasan</b></td>
                        <td align="center"><b>Batterai</b></td>
                        <td align="center" width="100"><b>Histori Data</b></td>
                      </tr>
                    </thead>
                    <tbody ng-if="(reports | filter:searchTable).length < 1">
                      <tr>
                        <td colspan="8"><b><i>No match data found</i></b></td>
                      </tr>
                    </tbody>
                    <tbody ng-if="!reports">
                      <tr>
                        <td colspan="8" align="center"><i class="fa fa-spinner fa-spin"></i> mengambil data</td>
                      </tr>
                    </tbody>
                    <tbody >
                      <tr ng-repeat-start="u in reports | filter:searchTable">
                        <td align="center">{{$index + 1}}</td>
                        <td align="center">{{u.ews_sn_alias}}<br>{{u.ews_ip}}<br><br>
                          <b>Pembangunan</b> <br>
                          {{u.umur_alat | number}} Hari<br><br>

                          <b>Perawatan</b><br>
                          {{u.umur_alat_rawat | number}} Hari
                          <br><br>

                          <i style="color: red" ng-show="(u.umur_alat_rawat > 180)" >Masa Perawatan Habis</i>

                        </td>
                        <td>{{u.ews_loc_desc + " - " + u.ews_area}}</td>
                        <td align="center">
                          <a href="" ng-click="showMapLokasi(u)" target="_blank" class="btn-sm btn-success btn-block btn-xs">
                             <i class="fa fa-map"></i> &nbsp;Peta
                          </a>
                          <a href="" ng-click="showDataUmum(u)" class="btn btn-primary btn-xs btn-block">
                            Data Umum
                          </a>
                          <a href="" ng-click="showFoto(u)" class="btn btn-primary btn-xs btn-block">
                            Foto Lokasi
                          </a>
                          <a href="{{u.ews_cctv}}" ng-if="u.ews_cctv" target="_blank" class="btn btn-primary btn-xs btn-block">
                            CCTV
                          </a>
                          <a href="{{u.ews_cctv}}" ng-if="!u.ews_cctv" target="_blank" class="btn btn-primary btn-xs btn-block">
                            CCTV
                          </a>
                            <!-- <img ng-if="!u.ews_cctv" ng-src="{{base_url}}image/indicator/cctv_error.gif" height="40" width="40"> -->
                          <a href="{{u.ews_street_view}}"  target="_blank" class="btn btn-primary btn-xs btn-block">
                            Street View
                          </a>
                          <a href="" ng-click="showSensor(u)" target="_blank" class="btn btn-primary btn-xs btn-block">
                            Sensor
                          </a>
                          <a href="" ng-click="showHistory(u)" class="btn btn-primary btn-xs btn-block">
                            History
                          </a>
                        </td>
                        <td align="center">
                          {{(u.ews_rpt_date).split(" ")[0] | date:'dd-MMM-yyyy'}} <br> 
                          {{(u.ews_rpt_date).split(" ")[1] | date:'HH:mm:ss'}}                          

                          <table class="" border="0">
                            <tr>
                              <td colspan="2" align="center">
                                <!-- <img class="img_icon_larger" ng-src="{{base_url}}image/indicator/{{u.arah_icon}}"><br> -->
                                <img class="img_icon_larger" ng-src="{{base_url}}image/indicator/{{u.lampu_arah}}"><br>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="2"><img height="10" width="auto" ng-src="{{base_url}}image/indicator/arahBaruTanda.png"></td>
                            </tr>
                            <tr>
                              <td align="left">{{u.ews_dir_left}}</td>
                              <td align="right">{{u.ews_dir_right}}</td>
                            </tr>
                            <tr>
                              <td colspan="2" align="center">
                                <small>Kecepatan KA km/jam</small><br>
                                {{u.ews_kecepatan}}
                              </td>
                            </tr>
                          </table>

                        </td>
                        <td align="center">
                          <img class="img_icon" ng-src="{{base_url}}image/indicator/{{u.icon_bat}}"><br>
                          {{u.ews_battery_percent}} %

                          <button class="btn btn-success btn-block btn-xs" ng-click="showBatteryGraph(u.ews_ip)" >Grafik Batterai</button><br>

                          <button class="btn btn-success btn-block btn-xs" ng-click="showPvGraph(u.ews_ip)" >Grafik Solar Charge</button>
                        </td>
                        <td align="center">
                          <button class="btn btn-xs btn-success btn-block" ng-click="showDetail(u)" ><i class="fa fa-eye"></i> Details</button>
                        </td>
                      </tr>
                      <tr ng-repeat-end ng-if="toggle[$index]">
                      <!--tr ng-if="toggle[$index]"-->
                        <td colspan="5" >
                          <div class="col-sm-12">
                            <table class="table table-condensed">
                              <tr>
                                <th width="35">&nbsp;</th>
                                <th width="50">No</th>
                                <th>Pole</th>
                                <th>Coordinate</th>
                                <th>location</th>
                                <th>Default Duration</th>
                                <th>Temp Duration</th>
                                <td align="right" width="100"><b>Tools</b></td>
                              </tr>
                              <tr ng-repeat="ud in u.data_child">
                                <td>&nbsp;</td>
                                <td>{{$index + 1}}</td>
                                <td>{{ud.tfc_pole}}</td>
                                <td>{{ud.tfc_loc_lat + "," + ud.tfc_loc_lon}}</td>
                                <td>{{ud.tfc_loc_desc}}</td>
                                <td>{{ud.tfc_G}} seconds</td>
                                <td>{{ud.tfc_G1}} seconds</td>
                                <td align="right">
                                  <button class="btn btn-xs btn-success" ng-click="editUser(u)" ><i class="fa fa-pencil"></i></button>
                                  <button class="btn btn-xs btn-danger" ng-click="delUser(u)"><i class="fa fa-remove"></i></button>
                                </td>
                              </tr>
                            </table>                            
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

  </section>
  <section class="content"></section>

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
                      <td>Nomor Perlintasan</td>
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

                    <span><b>{{his.speaker}}</b></span>
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

  <div id="modal_data_umum" class="modal fade in">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title"><b>Data Perlintasan</b></h4>
        </div>
        <div class="modal-body">
          <div class="row">

            <div class="col-sm-12">              

              <table class="table">
                <tr bgcolor="#00b0f0">
                  <th>No</th>
                  <th>Data Perlintasan</th>
                  <th width="30">&nbsp;</th>
                  <th>Keterangan</th>
                </tr>
                <tr bgcolor="#d5dce4">
                  <td width="50">1</td>
                  <td width="200">Nomor Perlintasan</td>
                  <td width="30">:</td>
                  <td>{{dataumum.ews_jpl}}</td>
                </tr>
                <tr bgcolor="#acb9ca">
                  <td>2</td>
                  <td>Km / Hm</td>
                  <td>:</td>
                  <td>{{dataumum.ews_kms}}</td>
                </tr>
                <tr bgcolor="#d5dce4">
                  <td>3</td>
                  <td>DAOP</td>
                  <td>:</td>
                  <td>{{dataumum.ews_daop}}</td>
                </tr>
                <tr bgcolor="#acb9ca">
                  <td>4</td>
                  <td>Titik Lokasi</td>
                  <td>:</td>
                  <td>{{dataumum.ews_lokasi}}</td>
                </tr>
                <tr bgcolor="#d5dce4">
                  <td>5</td>
                  <td>Nomor SIM Card EWS</td>
                  <td>:</td>
                  <td>{{dataumum.ews_gsm_no}}</td>
                </tr>
                <tr bgcolor="#acb9ca">
                  <td>6</td>
                  <td>Desa</td>
                  <td>:</td>
                  <td>{{dataumum.ews_loc_desc}}</td>
                </tr>
                <tr bgcolor="#d5dce4">
                  <td>7</td>
                  <td>Kecamatan</td>
                  <td>:</td>
                  <td>{{(dataumum.ews_area).split(" - ")[0]}}</td>
                </tr>
                <tr bgcolor="#acb9ca">
                  <td>8</td>
                  <td>Kabupaten</td>
                  <td>:</td>
                  <td>{{(dataumum.ews_area).split(" - ")[1]}}</td>
                </tr>
                <tr bgcolor="#d5dce4">
                  <td>9</td>
                  <td>Provinsi</td>
                  <td>:</td>
                  <td>{{(dataumum.ews_area).split(" - ")[2]}}</td>
                </tr>
                <tr bgcolor="#acb9ca">
                  <td>10</td>
                  <td>Koordinat</td>
                  <td>:</td>
                  <td>{{dataumum.ews_loc_lat + ',' + dataumum.ews_loc_lon }}</td>
                </tr>
                <tr bgcolor="#d5dce4">
                  <td>11</td>
                  <td>Lebar Jalan</td>
                  <td>:</td>
                  <td>{{dataumum.ews_road_width}} m</td>
                </tr>
                  <tr bgcolor="#acb9ca">
                  <td>12</td>
                  <td>Kelas Jalan</td>
                  <td>:</td>
                  <td>{{dataumum.ews_road_class}}</td>
                </tr>
                <tr bgcolor="#d5dce4">
                  <td>13</td>
                  <td>Jenis Jalan</td>
                  <td>:</td>
                  <td>{{dataumum.ews_road_type}}</td>
                </tr>
                <tr bgcolor="#acb9ca">
                  <td>14</td>
                  <td>PJU</td>
                  <td>:</td>
                  <td>{{dataumum.ews_pju > 0 ? "Ada (" + dataumum.ews_pju + ")" : "Tidak Ada"}}</td>
                </tr>
                <tr bgcolor="#d5dce4">
                  <td>15</td>
                  <td>Rambu</td>
                  <td>:</td>
                  <td>
                  <img ng-src="{{base_url}}image/sign/{{rmb}}" ng-repeat="rmb in ews_rambus" height="50" width="50" style="margin: 5px;">
                  </td>
                </tr>
                <tr bgcolor="#acb9ca">
                  <td>16</td>
                  <td>Marka</td>
                  <td>:</td>
                  <td>{{dataumum.ews_marka}}</td>
                </tr>
                  <tr bgcolor="#d5dce4">
                  <td>17</td>
                  <td>Speed Bump / Pita Kejut</td>
                  <td>:</td>
                  <td>{{dataumum.ews_speed_bump}}</td>
                </tr>
                <tr bgcolor="#acb9ca">
                  <td>20</td>
                  <td>Tanggal Pasang</td>
                  <td>:</td>
                  <td>{{dataumum.ews_install_year | date:'dd MMM yyyy' }} </td>
                </tr>
                <tr bgcolor="#d5dce4">
                  <td>21</td>
                  <td>Umur Alat</td>
                  <td>:</td>
                  <td>{{dataumum.umur_alat}}</td>
                </tr>
              </table>

            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="modal_history" class="modal fade in">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title"><b>History</b></h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <table class="table">
                <tr>
                  <th>No.</th>
                  <th>Tahun</th>
                  <th>Pendanaan</th>
                  <th>Jenis Pelihara</th>
                </tr>
                <tr ng-repeat="his in histories">
                  <td>{{$index + 1}}</td>
                  <td>{{his.mnt_year}}</td>
                  <td>{{his.mnt_user}}</td>
                  <td>{{his.mnt_type}}</td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="modal_sensor" class="modal fade in">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title"><b>Sensor Lokasi</b></h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <div id="mapSensor" style="height: 450px;">
                disini ada maps buat show sensor lokasi
                <p align="center"><h4>Please select location !</h4></p>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<div id="modal_map" class="modal fade in">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title"><b>Lokasi Map</b></h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <div id="mapLokasi" style="height: 450px;">
                disini ada maps buat show sensor lokasi
                <p align="center"><h4>Please select location !</h4></p>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div id="modal_photo_lokasi" class="modal fade in">
    <div class="modal-dialog" style="width: 900px; height: 400px;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title"><b>Foto Lokasi</b></h4>
        </div>
        <div class="modal-body">
          {{uuu.ews_photo_desc}}
          <div class="row">
            <div class="col-sm-12" id="parent360">
              <div id="container360" ></div>
              <script type="text/javascript" charset="utf-8">
              </script>
<!--               <img ng-src="{{base_url}}image/ews/{{u.ews_location_image}}" height="100%" width="100%" style="object-fit: cover;"> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="modal_grafik" class="modal fade in">
    <div class="modal-dialog" style="width: 1000px; height: 500px;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title"><b>Grafik Baterai</b></h4>
          <i ng-show="isLoadWeek && isLoadDay" >Mengambil data ... </i>
        </div>
        <div class="modal-body">
          <div class="row" align="center">
            <div class="col-sm-12">
              <div class="col-sm-6">
                <h4>Persentase Pengisian Baterai Harian</h4>
                <div id="line-chart-day"></div>
                <i ng-show="!isDataDay && !isLoadDay"><b>Data tidak ditemukan</b></i>
                <i ng-show="!isDataDay && isLoadDay"><b>Processing...</b></i>
              </div>
              <div class="col-sm-6">
                <h4>Persentase Pengisian Baterai Mingguan</h4>
                <div id="line-chart-week"></div>
                <i ng-show="!isDataWeek && !isLoadWeek"><b>Data tidak ditemukan</b></i>
                <i ng-show="!isDataWeek && isLoadWeek"><b>Processing...</b></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="modal_grafik_pv" class="modal fade in">
    <div class="modal-dialog" style="width: 1000px; height: 500px;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title"><b>Grafik Solar Cell</b></h4>
          <i ng-show="isLoadWeek && isLoadDay" >Mengambil data ... </i>
        </div>
        <div class="modal-body">
          <div class="row" align="center">
            <div class="col-sm-12">
              <div class="col-sm-6">
                <h4>Persentase Pengisian Harian</h4>
                <div id="line-chart-day_pv"></div>
                <i ng-show="!isDataDay && !isLoadDay"><b>Data tidak ditemukan</b></i>
                <i ng-show="!isDataDay && isLoadDay"><b>Processing...</b></i>
              </div>
              <div class="col-sm-6">
                <h4>Persentase Pengisian Mingguan</h4>
                <div id="line-chart-week_pv"></div>
                <i ng-show="!isDataWeek && !isLoadWeek"><b>Data tidak ditemukan</b></i>
                <i ng-show="!isDataWeek && isLoadWeek"><b>Processing...</b></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="modal_kiri_kanan" class="modal fade in">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Kereta dari Kiri ke Kanan</b></h4>
        </div>
        <div class="modal-body">
          <div class="row" align="center" ng-if="video_isplay_kiri">
            <div class="pull-right" style="position: absolute; right: 20px; top: 70px; z-index: 999;"><h3>{{total_time_ews}}</h3></div>
            <div class="col-sm-12">

<!--               <video width="100%" height="100%" autoplay id="video_ews_kiri">
                <source src="<?php echo base_url('assets/video/KiriToKanan.mp4') ?>" type="video/mp4">
                Your browser does not support the video tag.
              </video>
 -->
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success btn-sm" ng-click="closeModal('kiri')">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div id="modal_kanan_kiri" class="modal fade in">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Kereta dari Kanan Ke Kiri</b></h4>
        </div>
        <div class="modal-body">
          <div class="row" align="center" ng-if="video_isplay_kanan">
            <div class="pull-right" style="position: absolute; right: 20px; top: 70px; z-index: 999;"><h3>{{total_time_ews}}</h3></div>
            <div class="col-sm-12">

<!--               <video width="100%" height="100%" autoplay id="video_ews_kanan">
                <source src="<?php echo base_url('assets/video/KananToKiri.mp4') ?>" type="video/mp4">
                Your browser does not support the video tag.
              </video>
 -->
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success btn-sm" ng-click="closeModal('kanan')">Close</button>
        </div>
      </div>
    </div>
  </div>

</div>
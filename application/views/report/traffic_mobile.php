<style type="text/css">
  
.outer-layer {
  width:100%;
  height:100%;
  z-index:15000;
  top:10px;
  left:0;
}

.main-body-layer {
  top:18%;
  background:#fff;
  width:100%;
  min-height:30%;
  max-height: 350px;
  overflow-y: scroll;
  height: 60%;
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
}

.img_icon {
  height: 50px;
  width: 50px;
}

.img_icon_small {
  height: 50px;
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

.ind_timer {
   font-size: 20px; 
   font-weight: bold; 
   background-color: black; 
   padding: 5px;
   margin-top: 10px;
}

.green {color: green;}
.yellow{color: yellow;}
.red{color: red;}


.modal-lg {
  width: 1000px !important ;
}

</style>


<div class="content-wrapper" ng-controller='rTfcCtrl' style="margin-top: -30px;">
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
                        <th width="50">No</th>
                        <!--th width="50"><span class="fa fa-plus"></span></th-->
                        <td align="center"><b>Serial Number</b></td>
                        <td align="center"><b>Lokasi</b></td>
                        <td align="center"><b>IP Public</b></td>
                        <td align="center"><b>Data</b></td>
                        <td align="center"><b>Data Terakhir</b></td>
                        <td align="center"><b>Pembangunan</b></td>
                        <td align="center"><b>Perawatan</b></td>
                        <td align="center" width="100"><b>Detail</b></td>
                      </tr>
                    </thead>
                    <tbody ng-if="(reports | filter:searchTable).length < 1">
                      <tr>
                        <td colspan="7"><b><i>No match data found</i></b></td>
                      </tr>
                    </tbody>
                    <tbody >
                      <tr ng-repeat-start="u in reports | filter:searchTable">
                        <td>{{$index + 1}}</td>
                        <td align="center">{{u.tfc_sn}}</td>
                        <td>{{u.lokasi}}</td>
                        <td align="center">{{u.tfc_ip}}</td>

                        <td align="center">
                          <a href="" ng-click="showDataUmumTl(u)" class="btn btn-primary btn-xs btn-block">
                            Data Umum
                          </a>
                      <a href="" ng-click="showFotoTL(u)" class="btn btn-primary btn-xs btn-block">
                            Foto Lokasi
                          </a>
                          <a href="{{u.tfc_cctv}}" ng-if="u.tfc_cctv" target="_blank" class="btn btn-primary btn-xs btn-block">
                            CCTV
                          </a>
                          <a href="{{u.tfc_cctv}}" ng-if="!u.tfc_cctv" target="_blank" class="btn btn-primary btn-xs btn-block">
                            CCTV
                          </a>
                            <!-- <img ng-if="!u.ews_cctv" ng-src="{{base_url}}image/indicator/cctv_error.gif" height="40" width="40"> -->
                          <a href="{{u.tfc_street_view}}"  target="_blank" class="btn btn-primary btn-xs btn-block">
                            Street View
                          </a>
                          <a href="" ng-click="showHistoryTfc(u.tfc_ip)" class="btn btn-primary btn-xs btn-block">
                            History
                          </a>

<!--                           <a href="" ng-click="showSensor(u)" target="_blank" class="btn btn-primary btn-xs btn-block">
                            Animasi
                          </a>
 -->
                          <br>
                          <span>Tanggal Pemasangan</span><br>
                          <b>{{u.tfc_install_date}}</b>

                          <br>
                          <br>
                          <span>Tanggal Perbaikan</span><br>
                          <b>{{u.tfc_maintenance_date}}</b>

                          <br>
                          <br>
                          <span>Life Time</span><br>
                          <b>{{u.maintenance_age}} hari</b>

                        </td>
                        <td align="center">
                          {{u.date_rpt}} <br>
                          {{u.jam_rpt}}
                        </td>
                        <td align="center"><b>{{u.tfc_install_date | date:'dd MMMM yyyy'}}</b> <br>{{u.install_age}} Hari </td>
                        <td align="center"><b>{{u.tfc_maintenance_date | date:'dd MMMM yyyy'}}</b> <br> {{u.maintenance_age}} Hari </td>
                        <td align="center">
                          <button class="btn btn-xs btn-success" ng-click="viewDetail(u)" >Details</button>
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


  <div id="modal_detail_tl_awal" class="modal fade in">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Get Reporting <b>{{ip_address}}</b></h4>
        </div>
        <div class="modal-body">
          <small><i>Select Date :</i></small>
          <p></p>
          <div class="row">
            <div class="col-sm-6">
              <div class="input-group date">
                <input type="text" name="" class="form-control input-sm datepicker" id="dateRpt">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>                  
              </div>
            </div>

            <div class="col-sm-6">
              <a href="" class="btn btn-sm btn-success" ng-click="getTlByIP(ip_address)">Submit</a>
            </div>

            <div class="col-sm-12">
              <div class="outer-layer">
                <div class="main-body-layer">
                  <div class="content-layer">

                    <div align="center" ng-show="isNoData" ng-cloak >
                      <small>No Data Available</small>
                    </div>

                    <table class="table table-condensed">
                      <tr ng-repeat="his in history">
                        <td width="80" valign="top"><h4><b>{{his.jam_rpt }}</b></h4></td>
                        <td>
                          SN : <b>{{his.tl_sn}}</b><br>
                          Password : <b>{{his.tl_password}}</b><br>
                          Sinyal Wifi : <b>{{his.tl_sinyal_wifi}}</b><br>
                          TL1 M : <small>(Timer <b>{{his.tl_1_merah_timer}}</b>, Status : <b>{{his.tl_1_merah_status}}</b></small> <br>
                          TL1 K : <small>(Timer <b>{{his.tl_1_kuning_timer}}</b>, Status : <b>{{his.tl_1_kuning_status}}</b></small> <br>
                          TL1 H : <small>(Timer <b>{{his.tl_1_hijau_timer}}</b>, Status : <b>{{his.tl_1_hijau_status}}</b></small> <br>
                          Arus AC : <b>{{his.tl_arus_ac}}</b> , Tegangan AC : <b>{{his.tl_tegangan_ac}}</b>
                        </td>
                        <td>
                          TL2 M : <small>(Timer <b>{{his.tl_2_merah_timer}}</b>, Status : <b>{{his.tl_2_merah_status}}</b></small> <br>
                          TL2 K : <small>(Timer <b>{{his.tl_2_kuning_timer}}</b>, Status : <b>{{his.tl_2_kuning_status}}</b></small> <br>
                          TL2 H : <small>(Timer <b>{{his.tl_2_hijau_timer}}</b>, Status : <b>{{his.tl_2_hijau_status}}</b></small> <br>
                          Daya AC : <b>{{his.tl_daya_ac}}</b><br> Suhu Panel : <b>{{his.tl_suhu_panel}}</b>
                        </td>
                        <td>
                          TL3 M : <small>(Timer <b>{{his.tl_3_merah_timer}}</b>, Status : <b>{{his.tl_3_merah_status}}</b></small> <br>
                          TL3 K : <small>(Timer <b>{{his.tl_3_kuning_timer}}</b>, Status : <b>{{his.tl_3_kuning_status}}</b></small> <br>
                          TL3 H : <small>(Timer <b>{{his.tl_3_hijau_timer}}</b>, Status : <b>{{his.tl_3_hijau_status}}</b></small> <br>
                          Kelembaban : <b>{{his.tl_kelembaban}}</b><br> Tegangan Batt : <b>{{his.tl_tegangan_batt}}</b>
                        </td>
                        <td>
                          TL4 M : <small>(Timer <b>{{his.tl_4_merah_timer}}</b>, Status : <b>{{his.tl_4_merah_status}}</b></small> <br>
                          TL4 K : <small>(Timer <b>{{his.tl_4_kuning_timer}}</b>, Status : <b>{{his.tl_4_kuning_status}}</b></small> <br>
                          TL4 H : <small>(Timer <b>{{his.tl_4_hijau_timer}}</b>, Status : <b>{{his.tl_4_hijau_status}}</b></small> <br>
                          Life Cycle : <b>{{his.tl_life_cycle}}</b><br> Kode Unik : <b>{{his.tl_kode_unik}}</b>
                        </td>
                      </tr>
                    </table>

                  </div>
                </div>
              </div>
            </div>

          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success btn-sm" data-dismiss="modal">Close</button>
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

 <div id="modal_data_umum_tl" class="modal fade in">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title"><b>Data Traffic Light</b></h4>
        </div>
        <div class="modal-body">
          <div class="row">

            <div class="col-sm-12">

              <table class="table">
                <tr bgcolor="#00b0f0">
                  <th>No</th>
                  <th>Data Traffic Light</th>
                  <th width="30">&nbsp;</th>
                  <th>Keterangan</th>
                </tr>
                <tr bgcolor="#d5dce4">
                  <td width="50">1</td>
                  <td width="200">SN / IP</td>
                  <td width="30">:</td>
                  <td>{{dataumum.tfc_sn}} / {{dataumum.tfc_ip}}</td>
                </tr>
                <tr bgcolor="#acb9ca">
                  <td>4</td>
                  <td>Titik Lokasi</td>
                  <td>:</td>
                  <td>{{dataumum.tfc_jalan}}</td>
                </tr>
                <tr bgcolor="#d5dce4">
                  <td>5</td>
                  <td>Jenis Persimpangan</td>
                  <td>:</td>
                  <td>{{dataumum.tfc_cross_type || 0}} persimpangan</td>
                </tr>
                <tr bgcolor="#acb9ca">
                  <td>6</td>
                  <td>Desa</td>
                  <td>:</td>
                  <td>{{dataumum.tfc_desa}}</td>
                </tr>
                <tr bgcolor="#d5dce4">
                  <td>7</td>
                  <td>Kecamatan</td>
                  <td>:</td>
                  <td>{{(dataumum.tfc_area).split(" - ")[0]}}</td>
                </tr>
                <tr bgcolor="#acb9ca">
                  <td>8</td>
                  <td>Kabupaten</td>
                  <td>:</td>
                  <td>{{(dataumum.tfc_area).split(" - ")[1]}}</td>
                </tr>
                <tr bgcolor="#d5dce4">
                  <td>9</td>
                  <td>Provinsi</td>
                  <td>:</td>
                  <td>{{(dataumum.tfc_area).split(" - ")[2]}}</td>
                </tr>
                <tr bgcolor="#acb9ca">
                  <td>10</td>
                  <td>Koordinat</td>
                  <td>:</td>
                  <td>{{dataumum.tfc_loc_lat + ',' + dataumum.tfc_loc_lon }}</td>
                </tr>
                <tr bgcolor="#d5dce4">
                  <td>11</td>
                  <td>Lebar Jalan</td>
                  <td>:</td>
                  <td>{{dataumum.tfc_road_width || 0}} m</td>
                </tr>
                  <tr bgcolor="#acb9ca">
                  <td>12</td>
                  <td>Kelas Jalan</td>
                  <td>:</td>
                  <td>{{dataumum.tfc_road_class}}</td>
                </tr>
                <tr bgcolor="#d5dce4">
                  <td>13</td>
                  <td>Jenis Jalan</td>
                  <td>:</td>
                  <td>{{dataumum.tfc_road_type}}</td>
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
                    <img ng-src="{{base_url}}image/sign/{{rmb}}" ng-repeat="rmb in tfc_rambus" height="50" width="50" style="margin: 5px;">
                  </td>
                </tr>
                <tr bgcolor="#acb9ca">
                  <td>16</td>
                  <td>Marka</td>
                  <td>:</td>
                  <td>{{dataumum.tfc_marka}}</td>
                </tr>
                  <tr bgcolor="#d5dce4">
                  <td>17</td>
                  <td>Speed Bump / Pita Kejut</td>
                  <td>:</td>
                  <td>{{dataumum.tfc_speed_bump || "Tidak Ada"}}</td>
                </tr>
                <tr bgcolor="#acb9ca">
                  <td>20</td>
                  <td>Tanggal Pasang</td>
                  <td>:</td>
                  <td>{{dataumum.tfc_install_date | date:'dd MMM yyyy' }} </td>
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

  <div id="modal_detail_tl" class="modal fade in">
    <div class="modal-dialog" style="width: 95%;">
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
              <b style="font-size: 18px;">{{header.project_title}}</b><br>
<!--               <b style="font-size: 16px;">{{header.project_sub_title}}</b><br>
              <b>{{header.project_isi}}</b><br> -->
              <b>{{header.project_name}} Provinsi {{(header.prov_name)}}</b>
            </div>

            <div class="col-sm-12 hidden-xs">
              <div class="row" style="color: white;">
                <div class="col-sm-2">
                  <img ng-src="{{base_url}}image/project/dishub.png" width="80" height="100">
                </div>

                <div class="col-sm-8" align="center">
                  <b style="font-size: 18px;">{{header.project_title}}</b><br>
                  <b style="font-size: 16px;">{{header.project_sub_title}}</b><br>
                  <b>{{header.project_isi}}</b><br>
                  <b>{{header.project_name}} Provinsi {{(header.prov_name)}}</b>
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

            <div class="col-sm-12">
              <div class="row">
                <div class="col-sm-12">
                  <br>
                  <b>Laporan Traffic Periode</b>
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
                  <td rowspan="2" align="center" valign="middle"><b>No</b></td>
                  <td rowspan="2" align="center"><b>IP Address</b></td>
                  <td rowspan="2" align="center"><b>Lokasi</b></td>
                  <!-- <td rowspan="2" align="center"><b>Data</b></td> -->
                  <td rowspan="2" align="center"><b>Waktu</b></td>
                  <td rowspan="2" align="center"><b>Pola Traffic Light</b></td>
                  <td colspan="4" align="center"><b>Indikator Lampu</b></td>
                  <td rowspan="2" align="center"><b>Indikator Kerusakan</b></td>
                  <td rowspan="2" align="center"><b>Perpanjangan</b></td>
                  <td rowspan="2" align="center"><b>Perpendekan</b></td>
                  <td rowspan="2" align="center"><b>Flashing</b></td>
                  <td rowspan="2" align="center"><b>Arus AC</b></td>
                  <td rowspan="2" align="center"><b>Suhu Kontrol</b></td>
                  <td rowspan="2" align="center"><b>Sinyal Modem</b></td>
                  <td rowspan="2" align="center"><b>Siklus ( Kode Unik )</b></td>
                </tr>
                <tr bgcolor="#8eaadb">
                  <td align="center"><b>Simpang 1</b></td>
                  <td align="center"><b>Simpang 2</b></td>
                  <td align="center"><b>Simpang 3</b></td>
                  <td align="center"><b>Simpang 4</b></td>
                </tr>
                <tr ng-repeat="his in datafilters">
                  <td align="center">{{$index+1}}</td>
                  <td style="white-space: nowrap;" align="center">
                    {{his.tfc_ip}}
                  </td>
                  <td align="center">
                    {{his.tfc_jalan}}
                  </td>

                 <!--  <td align="center">
                    <a href="" ng-click="showDataUmumTl(u)" class="btn btn-primary btn-xs btn-block">
                      Data Umum
                    </a>
                    <a href="" ng-click="showFoto(u)" class="btn btn-primary btn-xs btn-block">
                      Foto Lokasi
                    </a>
                    <a href="{{u.ews_cctv}}" ng-if="u.ews_cctv" target="_blank" class="btn btn-primary btn-xs btn-block">
                      CCTV + Voice
                    </a>
                    <a href="{{u.ews_cctv}}" ng-if="!u.ews_cctv" target="_blank" class="btn btn-primary btn-xs btn-block">
                      CCTV + Voice
                    </a>
                      <img ng-if="!u.ews_cctv" ng-src="{{base_url}}image/indicator/cctv_error.gif" height="40" width="40">
                    <a href="{{u.ews_street_view}}"  target="_blank" class="btn btn-primary btn-xs btn-block">
                      Street View
                    </a>
                    <a href="" ng-click="showSensor(u)" target="_blank" class="btn btn-primary btn-xs btn-block">
                      Animasi
                    </a>

                    <br>
                    <span>Tanggal Pemasangan</span><br>
                    <b>{{his.tfc_install_date}}</b>

                    <br>
                    <br>
                    <span>Tanggal Perbaikan</span><br>
                    <b>{{his.tfc_maintenance_date}}</b>

                    <br>
                    <br>
                    <span>Life Time</span><br>
                    <b>{{his.maintenance_age}} hari</b>

                  </td> -->

                  <td align="center">
                    {{his.date_rpt}} <br>
                    {{his.jam_rpt}}
                  </td>
                  <td align="center">
                    {{his.tl_kode_pola}}
                  </td>
                  <td align="center">
                    <img ng-if="(his.tl_1_RYG).split(';')[0] == 'ON' " class="img_icon_small" ng-src="{{base_url}}image/tfc/merah_nyala.png">
                    <img ng-if="(his.tl_1_RYG).split(';')[1] == 'ON' " class="img_icon_small" ng-src="{{base_url}}image/tfc/kuning_nyala.png">
                    <img ng-if="(his.tl_1_RYG).split(';')[2] == 'ON' " class="img_icon_small" ng-src="{{base_url}}image/tfc/hijau_nyala.png">

                    <img ng-if="(his.tl_1_RYG).split(';')[0] == 'OFF' && (his.tl_1_RYG).split(';')[1] == 'OFF' && (his.tl_1_RYG).split(';')[2] == 'OFF' " 
                    class="img_icon_small" ng-src="{{base_url}}image/tfc/abu_semua.png">
                    <img ng-if="(his.tl_1_RYG).split(';')[0] == 'ON' && (his.tl_1_RYG).split(';')[1] == 'ON' && (his.tl_1_RYG).split(';')[2] == 'ON' " 
                    class="img_icon_small" ng-src="{{base_url}}image/tfc/abu_semua.png">


                    <br><br>

                    <span ng-if="(his.tl_1_RYG).split(';')[0] == 'ON' " class="ind_timer red" >{{his.detail[0].tfc_R}}</span>
                    <span ng-if="(his.tl_1_RYG).split(';')[1] == 'ON' " class="ind_timer yellow" >3</span>
                    <span ng-if="(his.tl_1_RYG).split(';')[2] == 'ON' " class="ind_timer green" >{{his.detail[0].tfc_G}}</span>

                    <br><br>

                    {{his.detail[0].tfc_loc_desc}}

                  </td>
                  <td align="center">
                    <img ng-if="(his.tl_2_RYG).split(';')[0] == 'ON' " class="img_icon_small" ng-src="{{base_url}}image/tfc/merah_nyala.png">
                    <img ng-if="(his.tl_2_RYG).split(';')[1] == 'ON' " class="img_icon_small" ng-src="{{base_url}}image/tfc/kuning_nyala.png">
                    <img ng-if="(his.tl_2_RYG).split(';')[2] == 'ON' " class="img_icon_small" ng-src="{{base_url}}image/tfc/hijau_nyala.png">

                    <img ng-if="(his.tl_2_RYG).split(';')[0] == 'OFF' && (his.tl_2_RYG).split(';')[1] == 'OFF' && (his.tl_2_RYG).split(';')[2] == 'OFF' " 
                    class="img_icon_small" ng-src="{{base_url}}image/tfc/abu_semua.png">
                    <img ng-if="(his.tl_2_RYG).split(';')[0] == 'ON' && (his.tl_2_RYG).split(';')[1] == 'ON' && (his.tl_2_RYG).split(';')[2] == 'ON' " 
                    class="img_icon_small" ng-src="{{base_url}}image/tfc/abu_semua.png">

                    <br><br>

                    <span ng-if="(his.tl_2_RYG).split(';')[0] == 'ON' " class="ind_timer red" >{{his.detail[1].tfc_R}}</span>
                    <span ng-if="(his.tl_2_RYG).split(';')[1] == 'ON' " class="ind_timer yellow" >3</span>
                    <span ng-if="(his.tl_2_RYG).split(';')[2] == 'ON' " class="ind_timer green" >{{his.detail[1].tfc_G}}</span>

                    <br><br>

                    {{his.detail[1].tfc_loc_desc}}

                  </td>
                  <td align="center">
                    <img ng-if="(his.tl_3_RYG).split(';')[0] == 'ON' " class="img_icon_small" ng-src="{{base_url}}image/tfc/merah_nyala.png">
                    <img ng-if="(his.tl_3_RYG).split(';')[1] == 'ON' " class="img_icon_small" ng-src="{{base_url}}image/tfc/kuning_nyala.png">
                    <img ng-if="(his.tl_3_RYG).split(';')[2] == 'ON' " class="img_icon_small" ng-src="{{base_url}}image/tfc/hijau_nyala.png">

                    <img ng-if="(his.tl_3_RYG).split(';')[0] == 'OFF' && (his.tl_3_RYG).split(';')[1] == 'OFF' && (his.tl_3_RYG).split(';')[2] == 'OFF' " 
                    class="img_icon_small" ng-src="{{base_url}}image/tfc/abu_semua.png">
                    <img ng-if="(his.tl_3_RYG).split(';')[0] == 'ON' && (his.tl_3_RYG).split(';')[1] == 'ON' && (his.tl_3_RYG).split(';')[2] == 'ON' " 
                    class="img_icon_small" ng-src="{{base_url}}image/tfc/abu_semua.png">

                    <br><br>

                    <span ng-if="(his.tl_3_RYG).split(';')[0] == 'ON' " class="ind_timer red" >{{his.detail[2].tfc_R}}</span>
                    <span ng-if="(his.tl_3_RYG).split(';')[1] == 'ON' " class="ind_timer yellow" >3</span>
                    <span ng-if="(his.tl_3_RYG).split(';')[2] == 'ON' " class="ind_timer green" >{{his.detail[2].tfc_G}}</span>

                    <br><br>

                    {{his.detail[2].tfc_loc_desc}}

                  </td>
                  <td align="center">
                    <img ng-if="(his.tl_4_RYG).split(';')[0] == 'ON' " class="img_icon_small" ng-src="{{base_url}}image/tfc/merah_nyala.png">
                    <img ng-if="(his.tl_4_RYG).split(';')[1] == 'ON' " class="img_icon_small" ng-src="{{base_url}}image/tfc/kuning_nyala.png">
                    <img ng-if="(his.tl_4_RYG).split(';')[2] == 'ON' " class="img_icon_small" ng-src="{{base_url}}image/tfc/hijau_nyala.png">

                    <img ng-if="(his.tl_4_RYG).split(';')[0] == 'OFF' && (his.tl_4_RYG).split(';')[1] == 'OFF' && (his.tl_4_RYG).split(';')[2] == 'OFF' " 
                    class="img_icon_small" ng-src="{{base_url}}image/tfc/abu_semua.png">
                    <img ng-if="(his.tl_4_RYG).split(';')[0] == 'ON' && (his.tl_4_RYG).split(';')[1] == 'ON' && (his.tl_4_RYG).split(';')[2] == 'ON' " 
                    class="img_icon_small" ng-src="{{base_url}}image/tfc/abu_semua.png">

                    <br><br>

                    <span ng-if="(his.tl_4_RYG).split(';')[0] == 'ON' " class="ind_timer red" >{{his.detail[3].tfc_R}}</span>
                    <span ng-if="(his.tl_4_RYG).split(';')[1] == 'ON' " class="ind_timer yellow" >3</span>
                    <span ng-if="(his.tl_4_RYG).split(';')[2] == 'ON' " class="ind_timer green" >{{his.detail[3].tfc_G}}</span>

                    <br><br>

                    {{his.detail[3].tfc_loc_desc}}<br>

                    {{his.tl_1_RYG}}<br>
                    {{his.tl_2_RYG}}<br>
                    {{his.tl_3_RYG}}<br>
                    {{his.tl_4_RYG}}

                  </td>

                  <td align="center">
                    <img ng-if="his.tl_1_RYG == 'OFF;OFF;OFF' && his.tl_2_RYG == 'OFF;OFF;OFF' && his.tl_3_RYG == 'OFF;OFF;OFF' && his.tl_4_RYG == 'OFF;OFF;OFF' " 
                    class="img_icon_small" ng-src="{{base_url}}image/indicator/tl_rusak.gif">

                    <img class="img_icon_small" ng-src="{{base_url}}image/indicator/{{his.icon_listrik}}"><br><br>


                    {{his.tl_arus_ac}}
                  </td>

                  <td align="center"><img class="img_icon_large" ng-src="{{base_url}}image/tfc/switch_off.png"></td>
                  <td align="center"><img class="img_icon_large" ng-src="{{base_url}}image/tfc/switch_off.png"></td>
                  <td align="center"><img class="img_icon_large" ng-src="{{base_url}}image/tfc/switch_off.png"></td>

                  <td align="center">0.{{his.tl_arus_ac}} A</td>
                  <td align="center">
                    <img class="img_icon_large" ng-src="{{base_url}}image/indicator/suhu_box_panel.png"><br>
                    {{his.tl_suhu_panel / 100}}<sup>o</sup>C
                  </td>
                  <td align="center"><img class="img_icon_large" ng-src="{{base_url}}image/indicator/sinyal_modem.png"></td>
                  <td align="center">{{his.tl_life_cycle}}</td>
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

  <div id="modal_history_tfc" class="modal fade in">
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
                  <th>Jenis Pemeliharaan</th>
                </tr>
                <tr ng-repeat="his in histories">
                  <td>{{$index + 1}}</td>
                  <td>{{his.mnt_year | date:'yyyy' }}</td>
                  <td>{{his.mnt_user}}</td>
                  <td>{{his.mnt_type}}</td>
                </tr>
              </table>

            </div>

          </div>

          <div class="row">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
              <button class="btn btn-sm btn-info pull-right" data-dismiss="modal" ><i class="fa fa-remove"></i>&nbsp; Tutup</button>              
            </div>
            
          </div>

        </div>
      </div>
    </div>
  </div>

</div>







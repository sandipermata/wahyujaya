
<style type="text/css">
  
  .pos_item {
    height: 100%;
    text-align: center;
    font-size: 24px;
    border-top: 1px solid red;
    border-right: 1px solid white;
    border-bottom: 1px solid white;
  }

  .font_item {
    vertical-align: middle;
    padding-top: 20px;
    margin-left: -5px;
    position: absolute;
  }

  .bg_red {
    background-color: red;;
  }

  .bg_yellow {
    background-color: yellow;
  }

  .bg_green {
    background-color: green;
  }

  .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

.circle-green {
  height: 50px;
  width: 50px;
  font-size: 28px;
  text-align: center;
  color: white;
  border-radius: 120px;
  background-color: green;
  position: absolute;  
}

.circle-red {
  height: 50px;
  width: 50px;
  border-radius: 120px;
  background-color: red;
  position: absolute;  
}

.circle-yellow {
  height: 50px;
  width: 50px;
  font-size: 28px;
  text-align: center;
  color: red;
  border-radius: 120px;
  background-color: yellow;
  position: absolute;  
}

</style>

<div class="content-wrapper" ng-controller='dashCtrl' ng-init="map_code = 'tl'">
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
            <h3 class="box-title">Demo <a href="#" class="btn btn-success btn-sm btn-block">Report Traffic Light</a></h3> 
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
                        <option ng-repeat="kab in kabupaten" value="{{kab.city_code}}">{{kab.city_name_convert}}</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Kecamatan / Desa</label>
                      <select class="form-control select2" id="s_kec">
                        <option>&nbsp;</option>
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
                    animation= 'google.maps.Animation.DROP'
                    icon= "{{base_url}}/image/traffic-light-small.png"
                    ng-repeat="pos in posisi" position="{{pos.tfc_loc_lat}}, {{pos.tfc_loc_lon}}"
                    label="{{pos.tfc_pole}}"
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
    <div class="modal-dialog "  style="width: 50%;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Traffic Light : <b>{{data_pos.tfc_jalan}} - {{data_pos.tfc_area}}</b></h4>
        </div>
        <div class="modal-body">
          <div class="row" align="center" >
            <div ng-hide="true" class="col-sm-12" align="center" style="margin-bottom: 20px;">
              <h3>{{total_time}}</h3>
              <div class="row">
                <div class="col-sm-4">
                  <button class="btn btn-block btn-success" ng-click="changeTimer('plus', data_pos.tfc_pole)">Perpanjangan</button>
                </div>

                <div class="col-sm-4">
                  <button class="btn btn-block btn-danger" ng-click="changeTimer('minus', data_pos.tfc_pole)">Perpendekan</button>
                </div>

                <div class="col-sm-4">
                  <button class="btn btn-block btn-warning" ng-click="changeTimer('warn', data_pos.tfc_pole)">Warning</button>
                </div>                  
              </div>
            </div>


            <div class="col-sm-12">
              <div class="row" style="border: 1px solid red">
                <div class="col-sm-7" style="border: 1px solid red; height: 100%; padding: 10px;">
                  <img ng-if="!is_warning" ng-src="{{base_url}}image/tfc/{{gambar_nya}}" width="91%" height="50%">
                  <img ng-if="is_warning" ng-src="{{base_url}}image/bg/{{gambar_flash}}" width="91%" height="50%">
                </div>
                <div class="col-sm-5">
                  <div class="row" style="border-bottom: 1px solid red;">
                    <div class="col-sm-4" style="border-right: 1px solid red; padding: 5px;">
                      <label class="switch">
                        <input type="checkbox" id="flash" ng-click="changeTimer('warn', data_pos.tfc_pole)">
                        <span class="slider round"></span>
                      </label>
                      Flash ON
                    </div>
                    <div class="col-sm-4" style="border-right: 1px solid red; padding: 5px;">
                      <label class="switch">
                        <input type="checkbox" id="hold" ng-click="changeTimer('plus', data_pos.tfc_pole)">
                        <span class="slider round"></span>
                      </label>
                      Hold ON
                    </div>
                    <div class="col-sm-4" style="border-right: 1px solid red; padding: 5px;">
                      <label class="switch">
                        <input type="checkbox" id="skip" ng-click="changeTimer('minus', data_pos.tfc_pole)">
                        <span class="slider round"></span>
                      </label>
                      Skip ON
                    </div>
                  </div>

                  <div class="row" ng-hide="true">
                    <div class="col-sm-12" style="height: 30px;">
                      <b style="font-size: 26px;"> {{all_time < 10 ? '00:0' + all_time : '00:' + all_time }} </b>
                    </div>
                  </div>
                  <br>
                  <div class="row" style="margin-top: 10px; margin-right: 5px; margin-left: -5px;">
                    <div class="col-sm-3" ng-repeat='p in posisi' align="center">
                      <div ng-if="p.tfc_status == 'mati' " class="circle-red"></div>
                      <div ng-if="p.tfc_status == 'nyala'" class="circle-green">{{total_time < 10 ? '0' + total_time : total_time }}</div>
                      <div ng-if="p.tfc_status == 'kuning'" class="circle-yellow">{{total_time < 10 ? '0' + total_time : total_time }}</div>
                    </div>

                    <div class="row" style="margin-top: 100px;">
                      <div class="col-sm-2"></div>
                      <div class="col-sm-8">
                        <a href="" ng-click="showDataUmumTl(data_pos)" class="btn btn-primary btn-sm btn-block">
                          Data Umum
                        </a>

                        <a href="" ng-click="showFotoTL(data_pos)" class="btn btn-primary btn-sm btn-block">
                          Foto Lokasi
                        </a>

                        <a href="{{u.tfc_cctv}}" target="_blank" class="btn btn-primary btn-sm btn-block">
                          CCTV
                        </a>

                        <a href="" target="_blank" class="btn btn-primary btn-sm btn-block">
                          Status Alat
                        </a>

                      </div>
                      <div class="col-sm-2"></div>
                    </div>
                  </div>

                  <div class="row" ng-hide="true">
                    <h3>{{pole}} : {{total_time < 10 ? '0' + total_time : total_time }}</h3>
                    <div class="col-sm-4" ng-repeat='p in posisi' style="height: 80px;">
                      <div class="row pos_item bg_yellow" ng-if="is_warning"><span class="font_item">{{p.tfc_pole}}</span></div>
                      <div class="row pos_item bg_red" ng-if="p.tfc_status == 'mati' && !is_warning"><span class="font_item">{{p.tfc_pole}}</span></div> 
                      <div class="row pos_item bg_green" ng-if="p.tfc_status == 'nyala' && !is_warning"><span class="font_item">{{p.tfc_pole}}</span></div> 
                      <div class="row pos_item bg_yellow" ng-if="p.tfc_status == 'kuning' && !is_warning"><span class="font_item">{{p.tfc_pole}}</span></div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success btn-sm" ng-click="closeModal()">Close</button>
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
                  <td>2</td>
                  <td>Titik Lokasi</td>
                  <td>:</td>
                  <td>{{dataumum.tfc_jalan}}</td>
                </tr>
                <tr bgcolor="#d5dce4">
                  <td>3</td>
                  <td>Jenis Persimpangan</td>
                  <td>:</td>
                  <td>{{dataumum.tfc_cross_type || 0}} persimpangan</td>
                </tr>
                <tr bgcolor="#acb9ca">
                  <td>4</td>
                  <td>Desa</td>
                  <td>:</td>
                  <td>{{dataumum.tfc_desa}}</td>
                </tr>
                <tr bgcolor="#d5dce4">
                  <td>5</td>
                  <td>Kecamatan</td>
                  <td>:</td>
                  <td>{{(dataumum.tfc_area).split(" - ")[0]}}</td>
                </tr>
                <tr bgcolor="#acb9ca">
                  <td>6</td>
                  <td>Kabupaten</td>
                  <td>:</td>
                  <td>{{(dataumum.tfc_area).split(" - ")[1]}}</td>
                </tr>
                <tr bgcolor="#d5dce4">
                  <td>7</td>
                  <td>Provinsi</td>
                  <td>:</td>
                  <td>{{(dataumum.tfc_area).split(" - ")[2]}}</td>
                </tr>
                <tr bgcolor="#acb9ca">
                  <td>8</td>
                  <td>Koordinat</td>
                  <td>:</td>
                  <td>{{dataumum.tfc_loc_lat + ',' + dataumum.tfc_loc_lon }}</td>
                </tr>
                <tr bgcolor="#d5dce4">
                  <td>9</td>
                  <td>Lebar Jalan</td>
                  <td>:</td>
                  <td>{{dataumum.tfc_road_width || 0}} m</td>
                </tr>
                  <tr bgcolor="#acb9ca">
                  <td>10</td>
                  <td>Kelas Jalan</td>
                  <td>:</td>
                  <td>{{dataumum.tfc_road_class}}</td>
                </tr>
                <tr bgcolor="#d5dce4">
                  <td>11</td>
                  <td>Jenis Jalan</td>
                  <td>:</td>
                  <td>{{dataumum.tfc_road_type}}</td>
                </tr>
                <tr bgcolor="#acb9ca">
                  <td>12</td>
                  <td>PJU</td>
                  <td>:</td>
                  <td>{{dataumum.ews_pju > 0 ? "Ada (" + dataumum.ews_pju + ")" : "Tidak Ada"}}</td>
                </tr>
                <tr bgcolor="#d5dce4">
                  <td>13</td>
                  <td>Rambu</td>
                  <td>:</td>
                  <td>
                    <img ng-src="{{base_url}}image/sign/{{rmb}}" ng-repeat="rmb in tfc_rambus" height="50" width="50" style="margin: 5px;">
                  </td>
                </tr>
                <tr bgcolor="#acb9ca">
                  <td>14</td>
                  <td>Marka</td>
                  <td>:</td>
                  <td>{{dataumum.tfc_marka}}</td>
                </tr>
                  <tr bgcolor="#d5dce4">
                  <td>15</td>
                  <td>Speed Bump / Pita Kejut</td>
                  <td>:</td>
                  <td>{{dataumum.tfc_speed_bump || "Tidak Ada"}}</td>
                </tr>
                <tr bgcolor="#acb9ca">
                  <td>16</td>
                  <td>Tanggal Pasang</td>
                  <td>:</td>
                  <td>{{dataumum.tfc_install_date | date:'dd MMM yyyy' }} </td>
                </tr>
                <tr bgcolor="#d5dce4">
                  <td>17</td>
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

</div>
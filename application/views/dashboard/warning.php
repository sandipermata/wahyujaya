<div class="content-wrapper" ng-controller='dashCtrl' ng-init="map_code = 'wl'">
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

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label>Project</label>
                      <select class="form-control select2" id="s_proj">
                        <option>&nbsp;</option>
                        <option ng-repeat="proj in projects" value="{{proj.proj_id}}">{{proj.proj_name}}</option>
                      </select>
                    </div>
                  </div>

                </div>

                <div class="chart">

                  <div id="map0" style="height: 450px;" align="center">
                    <p align="center"><h4><span class="fa fa-spin fa-spinner"></span> memuat peta </h4></p>
                  </div>

<!--                   <ng-map center="[{{centerLocLat}}, {{centerLocLon}}]" scrollwheel='false' gesture-handling='greedy' style="height:450px;" zoom="{{centerZoom}}">
                    <marker
                    animation= 'google.maps.Animation.DROP'
                    icon= "{{base_url}}/image/palang-small.png"
                    ng-repeat="pos in posisi" position="{{pos.wrn_loc_lat}}, {{pos.wrn_loc_lon}}"
                    label="{{pos.wrn_pole}}"
                    on-click="showContent(event, pos)"
                    ></marker>
                  </ng-map>
 -->                </div>
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
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">WARNING LIGHT <small>{{wlIP}}</small> </h4>
          <p>
            {{data_pos[0].wl_desa}}<br>
            <small>{{data_pos[0].wl_area}}</small>
          </p>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-8" align="center">
              <div class="col-sm-3" ng-repeat='p in data_pos' align="center">
                {{p.wl_pole}}<br>
                <img ng-src="{{base_url}}{{img_pole}}" width="100" height="120" style="margin-left: -19px" >
              </div>
            </div>

            <div class="col-sm-4">
              Mode Flashing<br>
              <input type="radio" ng-click="setMode('1')" name="mode" value="normal" checked="true" > Normal<br>
              <input type="radio" ng-click="setMode('2')" name="mode" value="double"> Double Flashing<br>
              <input type="radio" ng-click="setMode('3')" name="mode" value="group"> Group<br><br>

              Frekwensi:<br>
              <div class="row">
                <div class="col-sm-12">
                  <div class="col-sm-6 row">
                    <input type="number" name="" class="input-sm form-control" ng-model="jmlIntv" >
                  </div>
                  <div class="col-sm-2 row">&nbsp;&nbsp;Hz</div>
                </div>
              </div>
              <div class="row" style="margin-top: 7px;">
                <div class="col-sm-8">
                  <button class="btn btn-sm btn-success btn-block" ng-click="startIntWl(jmlIntv)" >Setting</button>
                </div>
              </div>
            </div>

          </div>

          <div class="row" style="margin-top: 10px;">
            <div class="col-sm-12">
              <div class="col-sm-4">
                <button class="btn btn-primary btn-sm btn-block" ng-click="showDataUmumWl(wlIP)" >Data Umum</button>
              </div>
              <div class="col-sm-4">
                <button class="btn btn-primary btn-sm btn-block" ng-click="showStatusAlat(data_pos)">Status Alat</button>
              </div>
              <div class="col-sm-4">
                <button class="btn btn-primary btn-sm btn-block" ng-click="showFotoWL(data_pos)" >Foto Lokasi</button>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" ng-click="closeModal()">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div id="modal_data_umum_wl" class="modal fade in">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title"><b>Data Umum WL</b><br><small>{{data_pos[0].wl_sn}}</small></h4>
        </div>
        <div class="modal-body">
          <div class="row">

            <div class="col-sm-12">

              <table class="table">
                <tr bgcolor="#00b0f0">
                  <th>No</th>
                  <th>Data Warning Light</th>
                  <th width="30">&nbsp;</th>
                  <th>Keterangan</th>
                </tr>
                <tr bgcolor="#d5dce4">
                  <td width="50">1</td>
                  <td width="200">Serial Number</td>
                  <td width="30">:</td>
                  <td>{{datumwl.wl_sn}} / {{datumwl.wl_ip}}</td>
                </tr>
                <tr bgcolor="#acb9ca">
                  <td>2</td>
                  <td>Lokasi / ALamat Jalan</td>
                  <td>:</td>
                  <td>{{datumwl.wl_jalan}}</td>
                </tr>
                <tr bgcolor="#d5dce4">
                  <td>3</td>
                  <td>Desa / Kelurahan</td>
                  <td>:</td>
                  <td>{{datumwl.wl_desa}}</td>
                </tr>
                <tr bgcolor="#acb9ca">
                  <td>4</td>
                  <td>Kecamatan</td>
                  <td>:</td>
                  <td>{{(datumwl.wl_area).split(" - ")[0]}}</td>
                </tr>
                <tr bgcolor="#d5dce4">
                  <td>5</td>
                  <td>Kabupaten</td>
                  <td>:</td>
                  <td>{{(datumwl.wl_area).split(" - ")[1]}}</td>
                </tr>
                <tr bgcolor="#acb9ca">
                  <td>6</td>
                  <td>Provinsi</td>
                  <td>:</td>
                  <td>{{(datumwl.wl_area).split(" - ")[2]}}</td>
                </tr>
                <tr bgcolor="#d5dce4">
                  <td>7</td>
                  <td>Koordinat</td>
                  <td>:</td>
                  <td>{{datumwl.wl_loc_lat + ',' + datumwl.wl_loc_lon }}</td>
                </tr>
                <tr bgcolor="#acb9ca">
                  <td>8</td>
                  <td>Kelas Jalan</td>
                  <td>:</td>
                  <td>{{datumwl.wl_road_class}}</td>
                </tr>
                <tr bgcolor="#d5dce4">
                  <td>9</td>
                  <td>Tanggal Pasang</td>
                  <td>:</td>
                  <td>{{datumwl.wl_install_date | date:'dd MMM yyyy' }} </td>
                </tr>
                  <tr bgcolor="#acb9ca">
                  <td>10</td>
                  <td>Umur Alat</td>
                  <td>:</td>
                  <td>{{datumwl.umur_alat}}</td>
                </tr>
                <tr bgcolor="#d5dce4">
                  <td>11</td>
                  <td>Jenis Proyek</td>
                  <td>:</td>
                  <td>{{datumwl.proj_name}}</td>
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
          <h4 class="modal-title"><b>Foto Lokasi</b><br><small>{{data_pos[0].wl_loc_image}} | {{data_pos[0].wl_photo_desc}}</small></h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12" id="parent360">
              <div id="container360" ></div>
              <script type="text/javascript" charset="utf-8">
              </script>
<!--               <img ng-src="{{image_path}}" height="100%" width="100%" style="object-fit: cover;"> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="modal_status_alat" class="modal fade in">
    <div class="modal-dialog" style="width: 900px; height: 400px;">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #8eaadb;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>

          <div class="col-sm-12 row">
            <div class="col-sm-3">
              <img ng-src="{{base_url}}image/logo.png" width="80" height="80">
            </div>
            <div class="col-sm-6" align="center" style="color: white;">
              <h3>SMART MONITORING SYSTEM</h3>
              <h2>WARNING LIGHT</h2>
            </div>
            <div class="col-sm-3">
              <img class="pull-right" ng-src="{{base_url}}image/logo.png" width="80" height="80">
            </div>
          </div>
        </div>
        <div class="modal-body">

          <div class="row">

            <div class="col-sm-12">

              <table class="table">
                <tr bgcolor="#00b0f0">
                  <th>No</th>
                  <th>Waktu</th>
                  <th>Baterai</th>
                  <th>Solar Cell</th>
                  <th>Suhu</th>
                  <th>Indikator Lampu</th>
                </tr>

                <tr ng-repeat="p in rpt_alat">
                  <td>{{$index + 1}}</td>
                  <td>{{p.wl_rpt_date | date:'dd MMM yyyy'}}</td>
                  <td>
                    {{p.wl_teg_batt}}%<br>
                    <img ng-src="{{base_url}}image/indicator/baterai_{{p.wl_teg_batt}}.png" width="70" height="60" >                      
                  </td>
                  <td>
                    {{p.wl_teg_sollar}} va<br>
                    <img ng-if="p.wl_teg_sollar > 0" ng-src="{{base_url}}image/indicator/solar_cel_charging.jpg" width="70" height="60">
                    <img ng-if="p.wl_teg_sollar < 1" ng-src="{{base_url}}image/indicator/solar_cel_discharging.jpg" width="70" height="60">
                  </td>
                  <td>
                    {{p.wl_suhu}} <sup>0</sup>C<br>
                    <img ng-if="p.wl_suhu > 25" ng-src="{{base_url}}image/indicator/suhu_box_panel2.png" width="70" height="60">
                    <img ng-if="p.wl_suhu < 26" ng-src="{{base_url}}image/indicator/suhu_box_panel.png" width="70" height="60">
                  </td>
                  <td>
                    <img ng-src="{{base_url}}image/indicator/lampu_kuning_on.gif" width="70" height="80">
                  </td>
                </tr>

              </table>

            </div>
          </div>

        </div>
      </div>
    </div>
  </div>


</div>







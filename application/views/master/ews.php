<style type="text/css">
.demo_menus,
.demo_menus a,
.demo_sub_menus,
.demo_sub_menus a {
  color: #00a65a;
  list-style: none; 
}

.example {
  color: gray;
}
</style>

<div class="content-wrapper" ng-controller='mEwsCtrl'>
  <section class="content-header">
    <h1><?= $title ?> <small ng-cloak><?= $desc ?></small></h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> <?= $parent ?></a></li>
      <li class="active"><?= $title ?></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <div class="row" ng-show="s_main">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Current Ews Data</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse1"><i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove1"><i class="fa fa-times"></i></button>
            </div>
          </div>

          <div class="box-body">
            <div class="row">
              <div class="col-md-12">

                <div class="row" style="margin-bottom: 10px">
                  <div class="col-sm-2">
                    <button class="btn btn-sm btn-success btn-block" ng-click="addData()" >
                      <i class="fa fa-plus"></i>&nbsp; Tambah Data
                    </button>
                  </div>
                  <div class="col-sm-2">
                    <button class="btn btn-sm btn-success btn-block" ng-click="uploadData()" >
                      <i class="fa fa-upload"></i>&nbsp; Upload Data
                    </button>
                  </div>
                  <div class="col-sm-4 pull-right">
                    <input type="text" ng-model="searchTable" class="form-control input-sm" placeholder="Search" autofocus="">
                  </div>
                </div>

                <div class="table table-responsive">
                  <table class="table table-condensed">
                    <thead>                     
                      <tr>
                        <th width="50">No</th>
                        <th>SN</th>
                        <th>Lokasi</th>
                        <th>Koordinat</th>
                        <td align="right" width="100"><b>Aksi</b></td>
                      </tr>
                    </thead>
                    <tbody ng-if="(ewss | filter:searchTable).length < 1">
                      <tr>
                        <td colspan="5"><b><i>Data tidak ditemukan</i></b></td>
                      </tr>
                    </tbody>
                    <tbody ng-if="!ewss">
                      <tr>
                        <td colspan="5" align="center"><i class="fa fa-spinner fa-spin"></i> mengambil data</td>
                      </tr>
                    </tbody>
                    <tbody >
                      <tr ng-repeat="u in ewss | filter:searchTable">
                        <td>{{$index + 1}}</td>
                        <td>{{u.ews_ip}}</td>
                        <td>
                          {{u.ews_loc_desc}}<br>
                          <i>{{u.ews_area}}</i>
                        </td>
                        <td>{{u.ews_loc_lat + "," + u.ews_loc_lon}}</td>
                        <td align="right">
                          <button class="btn btn-xs btn-success" ng-click="editDataEws(u)" ><i class="fa fa-pencil"></i></button>
                          <button class="btn btn-xs btn-danger" ng-click="delDataEws(u)"><i class="fa fa-remove"></i></button>
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

    <div class="row" ng-show="s_input">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">{{header_tittle == 'add' ? "Tambah Data" : "Ubah Data"}}</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse1"><i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" ng-click="cancelMe()"><i class="fa fa-times"></i></button>
            </div>
          </div>

          <div class="box-body">

            <div class="form-horizontal" style="margin-bottom: 20px;">
              <div class="form-group">
                <label class="col-sm-2">SN</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control input-sm" ng-model="ews.ews_ip" ng-readonly="header_tittle != 'add' ">
                </div>

                <div class="col-sm-7">
                  <div class="pull-right col-sm-4 row">
                    <button class="btn btn-success btn-sm btn-block" ng-disabled="!ews.ews_ip" ng-click="showHistory(ews.ews_ip)" >History</button>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2">ID EWS</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control input-sm" ng-model="ews.ews_sn_alias">
                </div>

                <div class="col-sm-4">
                  <input type="text" class="form-control input-sm" ng-model="ews.ews_gsm_no" placeholder="SIM Card Number">
                </div>

              </div>

              <div class="form-group">
                <label class="col-sm-2">Area</label>
                <div class="col-sm-2">
                  <button class="btn btn-block btn-success btn-sm" ng-disabled="!ews.ews_ip" ng-click="selectArea()" ><i class="fa fa-search"></i> Cari</button>
                </div>
                <div class="col-sm-6">
                  <input type="text" class="form-control input-sm" id="ews_area" readonly >
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2">Koordinat</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control input-sm" ng-model="ews.ews_loc_lat" placeholder="Latitude" >
                </div>
                <div class="col-sm-2">
                  <input type="text" class="form-control input-sm" ng-model="ews.ews_loc_lon" placeholder="Longitude" >
                </div>
                <div class="col-sm-6">
                  <textarea class="form-control" rows="1" style="resize: none;" ng-model="ews.ews_loc_desc" placeholder="Nama daerah" ></textarea>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2">Koordinat Sensor<br><small><i class="example">ex. -6.234223,106.4374933</i></small></label>                
                <div class="col-sm-2">
                  <input type="text" class="form-control input-sm" ng-model="ews.ews_loc_sensor_L" placeholder="Kiri" >
                </div>
                <div class="col-sm-2">
                  <input type="text" class="form-control input-sm" ng-model="ews.ews_loc_sensor_C" placeholder="Tengah" >
                </div>
                <div class="col-sm-2">
                  <input type="text" class="form-control input-sm" ng-model="ews.ews_loc_sensor_R" placeholder="Kanan" >
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2">Arah Kereta</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control input-sm" ng-model="ews.ews_dir_left" placeholder="Kiri" >
                </div>
                <div class="col-sm-2">
                  <input type="text" class="form-control input-sm" ng-model="ews.ews_dir_right" placeholder="Kanan" >
                </div>
              </div>

<!--               <div class="form-group">
                <label class="col-sm-2">Status</label>
                <div class="col-sm-2">
                  <select class="form-control input-sm select2" id="ews_status">
                    <option value="">-- select --</option>
                    <option ng-repeat="ty in statstype" value="{{ty.icon_id}}">{{ty.icon_name}}</option>
                  </select>
                </div>
              </div>
 -->
            </div>

            <div class="form-horizontal" style="margin-bottom: 20px;">
              <div class="form-group">
                <label class="col-sm-2">Informasi Detil</label>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">

                <div class="form-horizontal" style="margin-bottom: 20px;">

                  <div class="form-group">
                    <label class="col-sm-4">KM Perlintasan</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control input-sm" ng-model="ews.ews_km">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-4">Lebar Jalan (m) </label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control input-sm" ng-model="ews.ews_road_width" number-format >
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-4">Kelas Jalan</label>
                    <div class="col-sm-4">
                      <select class="form-control select2" ng-model="ews.ews_road_class" id="ews_road_class" >
                        <option value="">&nbsp;</option>
                        <option value="desa">Desa</option>
                        <option value="kabupaten">Kabupaten</option>
                        <option value="propinsi">Provinsi</option>
                        <option value="nasioanal">Nasional</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-4">Tipe Jalan</label>
                    <div class="col-sm-4">
                      <select class="form-control select2" ng-model="ews.ews_road_type" id="ews_road_type" >
                        <option value="">&nbsp;</option>
                        <option value="aspal">Aspal</option>
                        <option value="beton">Beton</option>
                        <option value="batuan">Batuan</option>
                        <option value="paving">Paving</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-4">CCTV</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control input-sm" ng-model="ews.ews_cctv" >
                    </div>
                  </div>

                </div>
                
              </div>

              <div class="col-sm-6">

                <div class="form-horizontal" style="margin-bottom: 20px;">

                  <div class="form-group">
                    <label class="col-sm-2">Daop</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control input-sm" ng-model="ews.ews_daop" number-format >
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2">PJU</label>
                    <div class="col-sm-4">
                      <select class="form-control select2" id="ews_pju" >
                        <option value="">&nbsp;</option>
                        <option value="ada">Ada</option>
                        <option value="tidak">Tidak</option>
                      </select>
                    </div>
                    <div class="col-sm-4">
                      <input type="text" class="form-control input-sm" ng-model="ews.ews_pju" ng-show="pju_show" placeholder="Jumlah PJU" number-format>
                    </div>

                  </div>

                  <div class="form-group">
                    <label class="col-sm-2">Rambu</label>
                    <div class="col-sm-10">
                      <select class="form-control select2" ng-model="ews.ews_rambu" multiple="multiple" id="ews_rambu" >
                        <option ng-repeat="ty in rambuss" value="{{ty.rambu_id}}">{{ty.rambu_desc}}</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2">Marka</label>
                    <div class="col-sm-4">
                      <select class="form-control select2" ng-model="ews.ews_marka" id="ews_marka" >
                        <option value="">&nbsp;</option>
                        <option value="ada">Ada</option>
                        <option value="tidak">Tidak</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2">Speed Bump</label>
                    <div class="col-sm-4">
                      <select class="form-control select2" ng-model="ews.ews_speed_bump" id="ews_speed_bump" >
                        <option value="">&nbsp;</option>
                        <option value="ada">Ada</option>
                        <option value="tidak">Tidak</option>
                      </select>
                    </div>
                  </div>

                </div>
                
              </div>

            </div>


            <div class="row">
              <div class="col-sm-4">

                <div class="form-horizontal" style="margin-bottom: 20px;">

                  <div class="form-group">
                    <label class="col-sm-6">Tanggal Pemasangan</label>
                    <div class="col-sm-6">
                      <div class="input-group date datepicker">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control input-sm pull-right ews_install_year">
                      </div>
                    </div>
                  </div>


                  <div class="form-group">
                    <label class="col-sm-6">Tanggal Pemeliharaan</label>
                    <div class="col-sm-6">
                      <div class="input-group date datepicker">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control input-sm pull-right ews_maintenance_year">
                      </div>
                    </div>
                  </div>

                </div>

              </div>

              <div class="col-sm-8">
                <div class="form-horizontal" style="margin-bottom: 20px;">
                  <form name="myForm">
                  <div class="form-group">
                    <label class="col-sm-3">Gambar Lokasi</label>
                    <div class="col-sm-2" align="center">
                      <img ng-src="{{base_url}}image/ews/{{img_old}}" class="img-circle" width="50" height="50" >
                    </div>
                    <div class="col-sm-2">
                      <button type="file" ng-model="file" ngf-model-invalid="errorFile" name="files" ngf-max-size="2MB" class="btn btn-block btn-sm btn-success" ngf-select="" accept="image/*">
                        Pilih Photo
                      </button>
                    </div>
                    <div class="col-sm-5">
                      <input type="text" class="form-control input-sm" ng-model="file.name" readonly >
                      <i style="color: red;" ng-show="myForm.files.$error.maxSize">File terlalu besar ({{errorFile.size / 1000000|number:1}} MB) => Max 2 MB</i>
                      <i ng-show="!myForm.files.$error.maxSize">Ukuran file : {{file.size/1000000  || 0 | number:1}} MB => Max 2 MB </i>
                    </div>
                  </div>
                  </form>

                  <div class="form-group">
                    <label class="col-sm-3">&nbsp;</label>
                    <label class="col-sm-3">Keterangan Foto</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control input-sm" ng-model="ews.ews_photo_desc" >
                    </div>
                  </div>


                  <div class="form-group">
                    <label class="col-sm-3">Street View</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control input-sm" ng-model="ews.ews_street_view" >
                    </div>
                  </div>

                </div>
              </div>

            </div>


            <div class="row">
              <div class="col-sm-12">

                <div class="form-horizontal" style="margin-bottom: 20px;">

                  <div class="form-group">
                    <label class="col-sm-2">Project</label>
                    <div class="col-sm-5">
                      <select class="form-control select2" ng-model="ews.ews_project" id="ews_project" >
                        <option value="">Pilih</option>
                        <option ng-repeat="pro in projects" value="{{pro.project_code}}">{{pro.project_name}}</option>
                      </select>
                      <!--input type="text" class="form-control input-sm" ng-model="ews.ews_project" -->
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2">Catatan</label>
                    <div class="col-sm-10">
                      <textarea class="form-control input-sm" style="resize: none;" rows="3" ng-model="ews.ews_description" ></textarea>
                    </div>
                  </div>

                </div>

              </div>
            </div>

            <button ng-disabled="isLoadSave" class="btn btn-sm btn-success" ng-click="saveDataEws(ews, file)" ><i class="fa fa-check"></i>&nbsp; Simpan</button>
            <button class="btn btn-sm btn-danger" ng-click="cancelMe()" ><i class="fa fa-remove"></i>&nbsp; Batal</button>

            <div ng-show="isLoadSave">
              <i class="fa fa-spin fa-spinner"></i>
              <i>Menyimpan data ....</i>               
            </div>

          </div>

        </div>
      </div>
    </div>

  </section>
  <section class="content"></section>


  <div id="modalUpload" class="modal fade" role="modal">
    <div class="modal-dialog modal-lg">

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Upload data from .xls or .xlsx file</h4>
        </div>
        <div class="modal-body">

          <div class="row">
            <div class="col-sm-12 row">
              <div class="col-sm-2">
                <button type="file" ngf-max-size="2MB" class="btn btn-block btn-sm btn-success" ngf-select="SelectFile($file)" >Pilih Excel</button>
              </div>
              <div class="col-sm-2">
                <button ng-click="Download()" class="btn-block btn-sm btn-info">Download Format</button>
              </div>
              <div class="col-sm-2">
                <button ng-show="IsVisible" ng-click="saveExcelIntoDb()" class="btn-block btn-sm btn-info">Upload</button>
              </div>
            </div>
          </div>

          <div class="col-sm-12 row">
            {{laporan_h}} <br>
          </div>

          <div class="row">
            <hr>
            <div class="col-sm-12 table table-responsive">
              <table id="tblCustomers" class="table table-condensed"  cellpadding="0" cellspacing="0" ng-show="IsVisible">
                <tr>
                  <th style="white-space: nowrap;">IP</th>
                  <th style="white-space: nowrap;">SN</th>
                  <th style="white-space: nowrap;">GSM</th>
                  <th style="white-space: nowrap;">Prov</th>
                  <th style="white-space: nowrap;">Kab</th>
                  <th style="white-space: nowrap;">Kec</th>
                  <th style="white-space: nowrap;">Area</th>
                  <th style="white-space: nowrap;">LatLng</th>
                  <th style="white-space: nowrap;">Lokasi</th>
                  <th style="white-space: nowrap;">Sensor L</th>
                  <th style="white-space: nowrap;">Sensor C</th>
                  <th style="white-space: nowrap;">Sensor R</th>
                  <th style="white-space: nowrap;">Durasi</th>
                  <th style="white-space: nowrap;">KM</th>
                  <th style="white-space: nowrap;">Daop</th>
                  <th style="white-space: nowrap;">Lebar Jalan</th>
                  <th style="white-space: nowrap;">Kelas</th>
                  <th style="white-space: nowrap;">Tipe</th>
                  <th style="white-space: nowrap;">PJU</th>
                  <th style="white-space: nowrap;">Rambu</th>
                  <th style="white-space: nowrap;">Marka</th>
                  <th style="white-space: nowrap;">Speed Bump</th>
                  <th style="white-space: nowrap;">Tgl Pasang</th>
                  <th style="white-space: nowrap;">CCTV</th>
                  <th style="white-space: nowrap;">Street View</th>
                  <th style="white-space: nowrap;">Catatan</th>
                  <th style="white-space: nowrap;">Project</th>
                  <th style="white-space: nowrap;">Arah Kiri</th>
                  <th style="white-space: nowrap;">Arah Kanan</th>
                </tr>
                <tbody ng-repeat="m in excelRows">
                  <tr>
                    <td style="white-space: nowrap;">{{m.ip}}</td>
                    <td style="white-space: nowrap;">{{m.sn}}</td>
                    <td style="white-space: nowrap;">{{m.gsm_no}}</td>
                    <td style="white-space: nowrap;">{{m.prov}}</td>
                    <td style="white-space: nowrap;">{{m.kab}}</td>
                    <td style="white-space: nowrap;">{{m.kec}}</td>
                    <td style="white-space: nowrap;">{{m.area}}</td>
                    <td style="white-space: nowrap;">{{m.latitude}}, {{m.longitude}}</td>
                    <td style="white-space: nowrap;">{{m.lokasi}}</td>
                    <td style="white-space: nowrap;">{{m.loc_sensor_l}}</td>
                    <td style="white-space: nowrap;">{{m.loc_sensor_c}}</td>
                    <td style="white-space: nowrap;">{{m.loc_sensor_r}}</td>
                    <td style="white-space: nowrap;">{{m.durasi}}</td>
                    <td style="white-space: nowrap;">{{m.km}}</td>
                    <td style="white-space: nowrap;">{{m.daop}}</td>
                    <td style="white-space: nowrap;">{{m.lebar_jalan}}</td>
                    <td style="white-space: nowrap;">{{m.kelas_jalan}}</td>
                    <td style="white-space: nowrap;">{{m.tipe_jalan}}</td>
                    <td style="white-space: nowrap;">{{m.pju}}</td>
                    <td style="white-space: nowrap;">{{m.rambu}}</td>
                    <td style="white-space: nowrap;">{{m.marka}}</td>
                    <td style="white-space: nowrap;">{{m.speed_bump}}</td>
                    <td style="white-space: nowrap;">{{m.tanggal_pasang}}</td>
                    <td style="white-space: nowrap;">{{m.cctv}}</td>
                    <td style="white-space: nowrap;">{{m.street_view}}</td>
                    <td style="white-space: nowrap;">{{m.catatan}}</td>
                    <td style="white-space: nowrap;">{{m.project}}</td>
                    <td style="white-space: nowrap;">{{m.arah_kiri}}</td>
                    <td style="white-space: nowrap;">{{m.arah_kanan}}</td>
                  </tr>
                </tbody>
              </table>
              
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success btn-sm" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

  <div id="modalArea" class="modal fade" role="modal">
    <div class="modal-dialog modal-sm">

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Select Area</h4>
        </div>
        <div class="modal-body">

          <div class="row form-horizontal">

            <div class="col-sm-12">

              <div class="form-group">
                <div class="col-sm-12">
                  <select class="form-control select2" id="ews_prov">
                    <option value="">-- Provinsi --</option>
                    <option ng-repeat="p in provinces" value="{{p.prov_code}}">{{p.prov_name}}</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <div class="col-sm-12">
                  <select class="form-control select2" id="ews_kab">
                    <option value="">-- Kabupaten --</option>
                    <option ng-repeat="kab in kabupaten" value="{{kab.city_code}}">{{kab.city_name_convert}}</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <div class="col-sm-12">
                  <select class="form-control select2" id="ews_kec">
                    <option value="">-- Kecamatan --</option>
                    <option ng-repeat="kec in kecamatan" value="{{kec.district_code}}">{{kec.district_name}}</option>
                  </select>
                </div>
              </div> 

            </div>
              
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success btn-sm" ng-click="setArea()" >Pilih</button>
        </div>
      </div>

    </div>
  </div>


  <div id="modal_history" class="modal fade in">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title"><b>History</b></h4>
        </div>
        <div class="modal-body">

          <div class="row">
            <div class="col-sm-7">

              <div class="form-horizontal" style="margin-bottom: 20px;">

                <div class="form-group">
                  <label class="col-sm-4">SN</label>
                  <div class="col-sm-5">
                    <input type="text" class="form-control input-sm" ng-model="mnt.mnt_sn_code" readonly>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-4">Tanggal Perawatan</label>
                  <div class="col-sm-5">
                    <div class="input-group date datepicker">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control input-sm pull-right mnt_year">
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-4">Pendanaan</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control input-sm" ng-model="mnt.mnt_user">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-4">Tipe Perawatan</label>
                  <div class="col-sm-5">
                    <select class="select2 form-control input-sm mnt_type">
                      <option value="">&nbsp;</option>
                      <option value="Regular">Regular</option>
                      <option value="Peningkatan">Peningkatan</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-4">Catatan</label>
                  <div class="col-sm-7">
                    <textarea class="form-control" rows="3" style="resize: none;" ng-model="mnt.mnt_remarks" placeholder="Catatan Perawatan" ></textarea>
                  </div>
                </div>

              </div>

            </div>

            <div class="col-sm-5">
              <table class="table">
                <tr>
                  <th>No.</th>
                  <th><i class="fa fa-trash"></i></th>
                  <th>Tahun</th>
                  <th>Pendanaan</th>
                  <th>Jenis Pemeliharaan</th>
                </tr>
                <tr ng-repeat="his in histories">
                  <td>{{$index + 1}}</td>
                  <th><a href="" ng-click="delHistory(his)" class="fa fa-trash" style="color: red;" ></a></th>
                  <td><a href="" ng-click="editHistory(his)" > {{his.mnt_year | date:'yyyy' }}</a></td>
                  <td>{{his.mnt_user}}</td>
                  <td>{{his.mnt_type}}</td>
                </tr>
              </table>

            </div>

          </div>

          <div class="row">
            <div class="col-sm-6">
              <button ng-disabled="isLoadSave" class="btn btn-sm btn-success" ng-click="saveHistoryEws(mnt)" ><i class="fa fa-check"></i>&nbsp; Simpan</button>
              <button class="btn btn-sm btn-danger" ng-click="batalHistory(mnt.mnt_sn_code)" ><i class="fa fa-remove"></i>&nbsp; Batal</button>
              <div ng-show="isLoadSave">
                <i class="fa fa-spin fa-spinner"></i>
                <i>Menyimpan data ....</i>               
              </div>              
            </div>

            <div class="col-sm-6">
              <button class="btn btn-sm btn-info pull-right" ng-click="closeHistory(mnt.mnt_sn_code)" ><i class="fa fa-remove"></i>&nbsp; Selesai</button>              
            </div>
            
          </div>

        </div>
      </div>
    </div>
  </div>

</div>


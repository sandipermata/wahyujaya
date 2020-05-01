<style type="text/css">
.demo_menus,
.demo_menus a,
.demo_sub_menus,
.demo_sub_menus a {
  color: #00a65a;
  list-style: none; 
}

.circle-image {
  height: 30px;
  width: 30px;
  transition: transform .2s; /* Animation */
  border-radius: 120px;
  border: 2px solid #CCC;
  z-index: 9999;
}

.circle-image:hover {
  transform: scale(3.5);
}

.circle-image-large {
  height: 80px;
  width: 80px;
  transition: transform .2s; /* Animation */
  border-radius: 10px;
  border: 2px solid #CCC;
  z-index: 9999;
}

.circle-image-large:hover {
  transform: scale(3.5);
}

.example {
  color: gray;
}

</style>

<div class="content-wrapper" ng-controller='mTLCtrl'>
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
            <h3 class="box-title">Current Traffic Light Data</h3>
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
                        <!--td width="50" align="center"><b class="fa fa-plus"></b></td-->
                        <th>IP Address</th>
                        <th>Area</th>
                        <th>Koordinat</th>
                        <th>Persimpangan</th>
                        <th>Photo Lokasi</th>
                      </tr>
                    </thead>
                    <tbody ng-if="(traffics | filter:searchTable).length < 1">
                      <tr>
                        <td colspan="5"><b><i>No match data found</i></b></td>
                      </tr>
                    </tbody>
                    <tbody >
                      <tr ng-repeat-start="u in traffics | filter:searchTable">
                        <td>{{$index + 1}}</td>
                        <!--td width="50" align="center">
                          <span class="btn btn-sm" style="" ng-init="toggle[$index] = false" ng-click="toggle[$index] = !toggle[$index]">
                            <span class="fa fa-plus" ng-if="!toggle[$index]"></span>
                            <span class="fa fa-minus" ng-if="toggle[$index]"></span>
                          </span>
                        </td-->
                        <td><a href="" ng-click="editData(u)" >{{u.tfc_ip}}</a></td>
                        <td>{{u.tfc_area}}</td>
                        <td>{{u.tfc_loc_lat}},{{u.tfc_loc_lon}}</td>
                        <td align="center">{{u.tfc_cross_type}}</td>
                        <td align="center">
                          <img class="circle-image" ng-src="{{base_url}}image/bg/{{u.tfc_loc_image}}">
                        </td>
                      </tr>
                      <tr ng-repeat-end ng-if="toggle[$index]">
                      <!--tr ng-if="toggle[$index]"-->
                        <td colspan="4" >
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
                                  <button class="btn btn-xs btn-success" ng-click="editData(ud)" ><i class="fa fa-pencil"></i></button>
                                  <button class="btn btn-xs btn-danger" ng-click="delData(ud)"><i class="fa fa-remove"></i></button>
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

    <div class="row" ng-show="s_input">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">{{header_tittle == 'add' ? "Tambah Data" : "Edit Data"}}</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse1"><i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" ng-click="cancelMe()"><i class="fa fa-times"></i></button>
            </div>
          </div>

          <div class="box-body">

            <div class="form-horizontal" style="margin-bottom: 20px;">

              <div class="form-group">
                <label class="col-sm-2">IP Address</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control input-sm" ng-model="tl.tfc_ip" id="tfc_ip" ng-readonly="on_edit">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2">SN</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control input-sm" ng-model="tl.tfc_sn" id="tfc_sn" ng-readonly="on_edit">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2">Area</label>
                <div class="col-sm-2">
                  <button class="btn btn-block btn-success btn-sm" ng-disabled="!tl.tfc_ip" ng-click="selectArea()" ><i class="fa fa-search"></i> Cari</button>
                </div>
                <div class="col-sm-6">
                  <input type="text" class="form-control input-sm" id="tfc_area" readonly >
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2">Desa</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control input-sm" ng-model="tl.tfc_desa" placeholder="Nama Desa" >
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2">Nama Jalan</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control input-sm" ng-model="tl.tfc_jalan" placeholder="Nama Jalan" >
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2">Jenis Persimpangan</label>
                <div class="col-sm-2">
                  <input type="number" min="1" class="form-control input-sm" ng-model="tl.tfc_cross_type">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2">Koordinat<br><small><i class="example">Lok Persimpangan</i></small></label>
                <div class="col-sm-2">
                  <input type="text" class="form-control input-sm" ng-model="tl.tfc_loc_lat" placeholder="Latitude" >
                </div>
                <div class="col-sm-2">
                  <input type="text" class="form-control input-sm" ng-model="tl.tfc_loc_lon" placeholder="Longitude" >
                </div>
              </div>

              <div class="form-horizontal" style="margin-bottom: 20px;">
                <div class="form-group">
                  <label class="col-sm-2">Informasi Detil</label>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-8">

                  <div class="form-horizontal" style="margin-bottom: 20px;">

                    <div class="form-group">
                      <label class="col-sm-3">Kelas Jalan</label>
                      <div class="col-sm-4">
                        <select class="form-control select2" ng-model="tl.tfc_road_class" id="tfc_road_class" >
                          <option value="">&nbsp;</option>
                          <option value="desa">Desa</option>
                          <option value="kabupaten">Kabupaten</option>
                          <option value="propinsi">Provinsi</option>
                          <option value="nasioanal">Nasional</option>
                        </select>
                      </div>

                      <div class="col-sm-4">
                        <select class="form-control select2" ng-model="tl.tfc_road_type" id="tfc_road_type" >
                          <option value="">&nbsp;</option>
                          <option value="aspal">Aspal</option>
                          <option value="beton">Beton</option>
                          <option value="batuan">Batuan</option>
                          <option value="paving">Paving</option>
                        </select>
                      </div>

                    </div>

                    <div class="form-group">
                      <label class="col-sm-3">Rambu</label>
                      <div class="col-sm-8">
                        <select class="form-control select2" ng-model="tl.tfc_rambu" multiple="multiple" id="tfc_rambu" >
                          <option ng-repeat="ty in rambuss" value="{{ty.rambu_id}}">{{ty.rambu_desc}}</option>
                        </select>
                      </div>
                    </div>

                  </div>
                </div>

                <div class="col-sm-4">

                  <div class="form-horizontal" style="margin-bottom: 20px;">

                    <div class="form-group">
                      <label class="col-sm-4">Marka</label>
                      <div class="col-sm-8">
                        <select class="form-control select2" ng-model="tl.tfc_marka" id="tfc_marka" >
                          <option value="">&nbsp;</option>
                          <option value="ada">Ada</option>
                          <option value="tidak">Tidak</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-4">Histori</label>
                      <div class="col-sm-8">
                        <button class="btn btn-success btn-sm btn-block" ng-disabled="!tl.tfc_ip" ng-click="showHistoryTfc(tl.tfc_ip)" >Histori</button>
                      </div>
                    </div>

                  </div>

                </div>

              </div>


              <div class="row" style="margin-top: 30px;">
                <div class="col-sm-4">

                  <div class="form-horizontal" style="margin-bottom: 20px;">

                    <div class="form-group">
                      <label class="col-sm-6">Tanggal Pemasangan</label>
                      <div class="col-sm-6">
                        <div class="input-group date datepicker">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control input-sm pull-right tfc_install_year">
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
                          <input type="text" class="form-control input-sm pull-right tfc_maintenance_year">
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
                          <img ng-src="{{base_url}}image/bg/{{img_old_1}}" class="img-circle" width="50" height="50" >
                        </div>
                        <div class="col-sm-2">
                          <button type="file" ng-model="lokFile" ngf-model-invalid="errorFile" name="files" ngf-max-size="2MB" class="btn btn-block btn-sm btn-success" ngf-select="" accept="image/*">Pilih Photo
                          </button>
                        </div>
                        <div class="col-sm-5">
                          <input type="text" class="form-control input-sm" ng-model="lokFile.name" readonly >
                          <i style="color: red;" ng-show="myForm.files.$error.maxSize">File terlalu besar ({{errorFile.size / 1000000|number:1}} MB) => Max 2 MB</i>
                          <i ng-show="!myForm.files.$error.maxSize">Ukuran file : {{file.size/1000000  || 0 | number:1}} MB => Max 2 MB </i>
                        </div>
                      </div>
                    </form>

                    <div class="form-group">
                      <label class="col-sm-3">&nbsp;</label>
                      <label class="col-sm-3">Keterangan Foto</label>
                      <div class="col-sm-6">
                        <input type="text" class="form-control input-sm" ng-model="tl.tfc_photo_desc" >
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3">Street View</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control input-sm" ng-model="tl.tfc_street_view" >
                      </div>
                    </div>

                  </div>
                </div>

              </div>


              <div class="row">
                <div class="col-sm-12">

                  <div class="form-horizontal" style="margin-bottom: 20px;">

                    <div class="form-group">
                      <label class="col-sm-2">CCTV</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control input-sm" ng-model="tl.tfc_cctv" >
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2">Project</label>
                      <div class="col-sm-5">
                        <select class="form-control select2" ng-model="tl.tfc_project" id="tfc_project" >
                          <option value="">Pilih</option>
                          <option ng-repeat="pro in projects" value="{{pro.project_code}}">{{pro.project_name}}</option>
                        </select>
                        <!--input type="text" class="form-control input-sm" ng-model="ews.ews_project" -->
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2">Catatan</label>
                      <div class="col-sm-10">
                        <textarea class="form-control input-sm" style="resize: none;" rows="3" ng-model="tl.tfc_description" ></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2">Gambar Flashing</label>
                <div class="col-sm-2">
                  <img class="img-circle" height="50" width="50" ng-src="{{base_url}}image/bg/{{img_old_2}}">
                </div>
                <div class="col-sm-8">
                  <button type="file" ng-model="docfile" ngf-select="setFiles($file, $invalidFiles)" class="btn btn-success btn-sm" accept="image/*">Select Files | .jpg, .png</button>
                  <span ng-cloak ng-if="docfile">
                    [ <b>{{docfile.name}}</b> ( {{docfile.size / 1024 | number:2}} Kb ) ]
                  </span>
                </div>
              </div>

            </div>

          </div>
          <div class="box-footer">
            <div class="col-sm-12">
              <div class="pull-right">
                <div class="row">
                  <button class="btn btn-sm btn-danger" ng-click="cancelMe()" ><i class="fa fa-remove"></i>&nbsp; Cancel</button>                  
                  <button class="btn btn-sm btn-success" ng-click="saveData(tl, docfile, lokFile)" ><i class="fa fa-check"></i>&nbsp; Save &amp; Continue</button>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="row" ng-show="s_details">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">{{header_tittle == 'add' ? "Add Detail Data" : "Edit Detail Data"}}</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse1"><i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" ng-click="cancelMe()"><i class="fa fa-times"></i></button>
            </div>
          </div>

          <div class="box-body">

            <button class="btn btn-sm btn-success" ng-click="addPole()" > <i class="fa fa-plus"></i> Add Data</button>

            <table class="table table-condensed">
              <tr>
                <th width="35">&nbsp;</th>
                <th width="50">No</th>
                <th>Pole</th>
                <th>location</th>
                <th>G Duration</th>
                <th>R Duration</th>
                <th>G Image</th>
                <th>R Image</th>
<!--                 <th>Status</th> -->
                <td align="right" width="100"><b>Tools</b></td>
              </tr>
              <tr ng-repeat="ud in details">
                <td>&nbsp;</td>
                <td>{{$index + 1}}</td>
                <td>{{ud.tfc_pole}}</td>
                <td>{{ud.tfc_loc_desc}}</td>
                <td>{{ud.tfc_G}} seconds</td>
                <td>{{ud.tfc_R}} seconds</td>
                <td>
                  <img class="circle-image" ng-src="{{base_url}}image/tfc/{{ud.tfc_g_image}}">
                </td>
                <td>
                  <img class="circle-image" ng-src="{{base_url}}image/tfc/{{ud.tfc_r_image}}">
                </td>
<!--                 <td>{{ud.icon_name}}</td> -->
                <td align="right">
                  <button class="btn btn-xs btn-success" ng-click="editDataD(ud)" ><i class="fa fa-pencil"></i></button>
                  <button class="btn btn-xs btn-danger" ng-click="delData(ud)"><i class="fa fa-remove"></i></button>
                </td>
              </tr>
            </table>                            

          </div>
          <div class="box-footer">
            <div class="col-sm-12">
              <div class="pull-right">
                <div class="row">
                  <button class="btn btn-sm btn-success" ng-click="finishMe()" ><i class="fa fa-check"></i>&nbsp; Finish</button>
                </div>
              </div>
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
            {{laporan_d}}
          </div>


          <div class="row">
            <hr>
            <div class="col-sm-12 table table-responsive">
              <table id="tblCustomers" class="table table-condensed"  cellpadding="0" cellspacing="0" ng-show="IsVisible">
                <tr>
                  <th style="white-space: nowrap;">SN</th>
                  <th style="white-space: nowrap;">IP</th>
                  <th style="white-space: nowrap;">Prov</th>
                  <th style="white-space: nowrap;">Kab</th>
                  <th style="white-space: nowrap;">Kec</th>
                  <th style="white-space: nowrap;">Desa</th>
                  <th style="white-space: nowrap;">Jalan</th>
                  <th style="white-space: nowrap;">LatLng</th>
                  <th style="white-space: nowrap;">Simpang</th>
                  <th style="white-space: nowrap;">Kelas</th>
                  <th style="white-space: nowrap;">Tipe</th>
                  <th style="white-space: nowrap;">Rambu</th>
                  <th style="white-space: nowrap;">Marka</th>
                  <th style="white-space: nowrap;">Tgl Pasang</th>
                  <th style="white-space: nowrap;">CCTV</th>
                  <th style="white-space: nowrap;">Street View</th>
                  <th style="white-space: nowrap;">Project</th>
                  <th style="white-space: nowrap;">Catatan</th>
                  <th style="white-space: nowrap;">Tiang</th>
                  <th style="white-space: nowrap;">LatLng</th>
                  <th style="white-space: nowrap;">Lokasi</th>
                  <th style="white-space: nowrap;">Timer Hijau</th>
                  <th style="white-space: nowrap;">Timer Merah</th>
                </tr>
                <tbody ng-repeat="m in excelRows">
                  <tr>
                    <td>{{m.sn}}</td>
                    <td>{{m.ip}}</td>
                    <td>{{m.prov}}</td>
                    <td>{{m.kab}}</td>
                    <td>{{m.kec}}</td>
                    <td>{{m.desa}}</td>
                    <td>{{m.nama_jalan}}</td>
                    <td>{{m.latitude}}, {{m.longitude}}</td>
                    <td>{{m.persimpangan}}</td>
                    <td>{{m.kelas_jalan}}</td>
                    <td>{{m.tipe_jalan}}</td>
                    <td>{{m.rambu}}</td>
                    <td>{{m.marka}}</td>
                    <td>{{m.tgl_pasang}}</td>
                    <td>{{m.cctv}}</td>
                    <td>{{m.street_view}}</td>
                    <td>{{m.project}}</td>
                    <td>{{m.catatan}}</td>
                    <td>{{m.tiang}}</td>
                    <td>{{m.latitude_tiang}}, {{m.longitude_tiang}}</td>
                    <td>{{m.lokasi_tiang}}</td>
                    <td>{{m.timer_hijau}}</td>
                    <td>{{m.timer_merah}}</td>
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
                  <select class="form-control select2" id="tfc_prov">
                    <option value="">-- Provinsi --</option>
                    <option ng-repeat="p in provinces" value="{{p.prov_code}}">{{p.prov_name}}</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <div class="col-sm-12">
                  <select class="form-control select2" id="tfc_kab">
                    <option value="">-- Kabupaten --</option>
                    <option ng-repeat="kab in kabupaten" value="{{kab.city_code}}">{{kab.city_name_convert}}</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <div class="col-sm-12">
                  <select class="form-control select2" id="tfc_kec">
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

  <div id="modal_history_tfc" class="modal fade in">
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
              <button ng-disabled="isLoadSave" class="btn btn-sm btn-success" ng-click="saveHistoryTfc(mnt)" ><i class="fa fa-check"></i>&nbsp; Simpan</button>
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


  <div id="modal_add_pole" class="modal fade in">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title"><b>{{header_tittle == 'add' ? "Add Detail Data" : "Edit Detail Data"}}</b></h4>
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


  <div id="modal_add_detail" class="modal fade in">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title"><b>{{header_tittle == 'add' ? "Add Detail Data" : "Edit Detail Data"}}</b></h4>
        </div>
        <div class="modal-body">

          <div class="row">
            <div class="col-sm-12">
              
              <div class="form-horizontal" style="margin-bottom: 20px;">

                <div class="form-group">
                  <label class="col-sm-4">SN</label>
                  <div class="col-sm-5">
                    <input type="text" class="form-control input-sm" ng-model="tld.tfc_sn_d" readonly>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-4">Pole Name</label>
                  <div class="col-sm-2">
                    <input type="text" maxlength="2" class="form-control input-sm" ng-readonly="on_edit_d" capitalize ng-model="tld.tfc_pole" >
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-4">Coordinate</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control input-sm" ng-model="tld.tfc_loc_lat" placeholder="Latitude" >
                  </div>
                  <div class="col-sm-4">
                    <input type="text" class="form-control input-sm" ng-model="tld.tfc_loc_lon" placeholder="Longitude" >
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-4">Location</label>
                  <div class="col-sm-8">
                    <textarea class="form-control" rows="3" style="resize: none;" ng-model="tld.tfc_loc_desc" ></textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-4">Green Duration <i>(second)</i></label>
                  <div class="col-sm-4">
                    <input type="number" min="1" class="form-control input-sm" ng-model="tld.tfc_G" >
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-4">Red Duration <i>(second)</i></label>
                  <div class="col-sm-4">
                    <input type="number" min="1" class="form-control input-sm" ng-model="tld.tfc_R" >
                  </div>
                </div>

<!--                 <div class="form-group">
                  <label class="col-sm-4">Status</label>
                  <div class="col-sm-4">
                    <select class="form-control input-sm select2" id="tfc_device_sts">
                      <option value="">-- select --</option>
                      <option ng-repeat="ty in statstype" value="{{ty.icon_id}}">{{ty.icon_name}}</option>
                    </select>
                  </div>
                </div> -->

                <div class="form-group">
                  <label class="col-sm-4">Green Image</label>
                  <div class="col-sm-8">
                    <button type="file" ng-model="gfile" ngf-select="setFiles($file, $invalidFiles)" class="btn btn-success btn-sm" accept="image/*">Select Files | .jpg, .png</button>
                    <span ng-cloak ng-if="gfile">
                      [ <b>{{gfile.name}}</b> ( {{gfile.size / 1024 | number:2}} Kb ) ]
                    </span>
                    <span ng-cloak>{{errorMsgG}}</span>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-4">Yellow Image</label>
                  <div class="col-sm-8">
                    <button type="file" ng-model="rfile" ngf-select="setFiles($file, $invalidFiles)" class="btn btn-success btn-sm" accept="image/*">Select Files | .jpg, .png</button>
                    <span ng-cloak ng-if="rfile">
                      [ <b>{{rfile.name}}</b> ( {{rfile.size / 1024 | number:2}} Kb ) ]
                    </span>
                    <span ng-cloak>{{errorMsgR}}</span>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-4">
                    <button class="btn btn-sm btn-success btn-block" ng-click="saveDataD(tld, gfile, rfile)" id="bSaveD" ><i class="fa fa-plus"></i> Add</button>
                  </div>
                </div>

              </div>

            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

</div>


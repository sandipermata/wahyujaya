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

    <div class="row" ng-show="!s_main">
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
                  <!--div class="col-sm-2">
                    <button class="btn btn-sm btn-success btn-block" ng-click="uploadData()" >
                      <i class="fa fa-upload"></i>&nbsp; Upload Data
                    </button>
                  </div-->
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

    <div class="row" ng-show="s_main">
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
                  <select class="select2 form-control input-sm">
                    <option>abaa</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2">Tanggal Perawatan</label>
                <div class="col-sm-3">
                  <div class="input-group date datepicker">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control input-sm pull-right ews_install_year">
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2">User</label>
                <div class="col-sm-3">
                  <select class="select2 form-control input-sm">
                    <option>user 1</option>
                    <option>user 2</option>
                    <option>user 3</option>
                    <option>user 4</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2">Tipe Perawatan</label>
                <div class="col-sm-3">
                  <select class="select2 form-control input-sm">
                    <option>Regular</option>
                    <option>Peningkatan</option>
                    <option>eowoe</option>
                    <option>kasdask</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2">Catatan</label>
                <div class="col-sm-10">
                  <textarea class="form-control" rows="3" style="resize: none;" ng-model="ews.ews_loc_desc" placeholder="Catatan Perawatan" ></textarea>
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
    <div class="modal-dialog modal-sm">

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Upload data from .csv file</h4>
        </div>
        <div class="modal-body">
          <p>This service will be available soon</p>
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

</div>


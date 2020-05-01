<style type="text/css">
.demo_menus,
.demo_menus a,
.demo_sub_menus,
.demo_sub_menus a {
  color: #00a65a;
  list-style: none; 
}

.cat-title {
  text-transform: capitalize;
}

.icon-item {
  border:1px solid rgba(60,30,0, 0.6);
  padding: 5px 10px;
  border-radius: 5px;
  color: black;
  cursor: pointer;
}

.icon-item:hover {
  background-color: rgba(60,30,0, 0.6);
  color: white;
}
</style>

<div class="content-wrapper" ng-controller='mParamCtrl'>
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
            <h3 class="box-title">Get information here</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse1"><i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove1"><i class="fa fa-times"></i></button>
            </div>
          </div>

          <div class="box-body">
            <div class="row">
              <div class="col-md-12">

                <div class="form-horizontal">

                  <div class="form-group">
                    <div class="col-sm-4">
                      <label>Provinsi</label>
                      <select class="form-control select2" id="tfc_prov">
                        <option value="">-- Provinsi --</option>
                        <option ng-repeat="p in provinces" value="{{p.prov_code}}">{{p.prov_name}}</option>
                      </select>
                    </div>

                    <div class="col-sm-4">
                      <label>Kabupaten</label>
                      <select class="form-control select2" id="tfc_kab">
                        <option value="">-- Kabupaten --</option>
                        <option ng-repeat="kab in kabupaten" value="{{kab.city_code}}">{{kab.city_name_convert}}</option>
                      </select>
                    </div>

                    <div class="col-sm-4">
                      <label>Kecamatan</label>
                      <select class="form-control select2" id="tfc_kec">
                        <option value="">-- Kecamatan --</option>
                        <option ng-repeat="kec in kecamatan" value="{{kec.district_code}}">{{kec.district_name}}</option>
                      </select>
                    </div>
                  </div> 
                  
                </div>

              </div>

              <div class="col-md-12">

                <div class="form-group">
                  <label>Area</label>
                  <div class="input-group col-sm-8">
                    <input type="text" class="form-control input-sm" id="tfc_area">
                    <div class="input-group-addon">
                      <span ng-click="copyTexts(tfc_area)" class="input-group-text"> <i style="cursor: pointer;" class="fa fa-copy"></i> </span>
                    </div>
                  </div>                    
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

          <div class="box-body">
            <div class="row">
              <div class="col-md-12">

                <div class="form-horizontal">

                  <div class="form-group">
                    <div class="col-sm-8">
                      <label>Rambu</label>
                      <select class="form-control select2" ng-model="tl.tfc_rambu" multiple="multiple" id="tfc_rambu" >
                        <option ng-repeat="ty in rambuss" value="{{ty.rambu_id}}">{{ty.rambu_desc}}</option>
                      </select>
                    </div>

                  </div> 
                  
                </div>

              </div>

              <div class="col-md-12">

                <div class="form-horizontal">
                  <div class="form-group">
                    <div class="col-sm-8">
                      <label>Hasil</label><br>
                      <span>{{rambus}}</span>
                    </div>
                  </div>
                </div>



              </div>


            </div>

          </div>
        </div>
      </div>
    </div>    

  </section>
  <section class="content"></section>

</div>

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
<style type="text/css">
.demo_menus,
.demo_menus a,
.demo_sub_menus,
.demo_sub_menus a {
  color: #00a65a;
  list-style: none; 
}
</style>

<div class="content-wrapper" ng-controller='mPjuCtrl'>
  <section class="content-header">
    <h1><?= $title ?> <small ng-cloak><?= $desc ?></small></h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> <?= $parent ?></a></li>
      <li class="active"><?= $title ?></li>
    </ol>
  </section>

  <section class="content">

    <div class="row" ng-show="s_main">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Current PJU Data</h3>
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
                      <i class="fa fa-plus"></i>&nbsp; Add New Data
                    </button>
                  </div>
                  <div class="col-sm-2">
                    <button class="btn btn-sm btn-success btn-block" ng-click="uploadData()" >
                      <i class="fa fa-upload"></i>&nbsp; Mass Upload Data
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
                        <td width="50" align="center"><b class="fa fa-plus"></b></td>
                        <th>IP Address</th>
                        <th>Description</th>
                      </tr>
                    </thead>
                    <tbody ng-if="(pjus | filter:searchTable).length < 1">
                      <tr>
                        <td colspan="5"><b><i>No match data found</i></b></td>
                      </tr>
                    </tbody>
                    <tbody >
                      <tr ng-repeat-start="u in pjus | filter:searchTable">
                        <td>{{$index + 1}}</td>
                        <td width="50" align="center">
                          <span class="btn btn-sm" style="" ng-init="toggle[$index] = false" ng-click="toggle[$index] = !toggle[$index]">
                            <span class="fa fa-plus" ng-if="!toggle[$index]"></span>
                            <span class="fa fa-minus" ng-if="toggle[$index]"></span>
                          </span>
                        </td>
                        <td>{{u.pju_ip}}</td>
                        <td>{{u.pju_area}}</td>
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
                                <td align="right" width="100"><b>Tools</b></td>
                              </tr>
                              <tr ng-repeat="ud in u.data_child">
                                <td>&nbsp;</td>
                                <td>{{$index + 1}}</td>
                                <td>{{ud.pju_pole}}</td>
                                <td>{{ud.pju_loc_lat + "," + ud.pju_loc_lon}}</td>
                                <td>{{ud.pju_loc_desc}}</td>
                                <td>{{ud.pju_duration}} seconds</td>
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
            <h3 class="box-title">{{header_tittle == 'add' ? "Add Data" : "Edit Data"}}</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse1"><i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" ng-click="cancelMe()"><i class="fa fa-times"></i></button>
            </div>
          </div>

          <div class="box-body">

            <div class="form-horizontal" style="margin-bottom: 20px;">

              <div class="form-group">
                <label class="col-sm-2">IP Address</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control input-sm" ng-model="pju.pju_ip" >
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2">Area</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control input-sm" ng-model="pju.pju_area">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2">Pole Name</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control input-sm" ng-model="pju.pju_pole" >
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2">Coordinate</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control input-sm" ng-model="pju.pju_loc_lat" placeholder="Latitude" >
                </div>
                <div class="col-sm-2">
                  <input type="text" class="form-control input-sm" ng-model="pju.pju_loc_lon" placeholder="Longitude" >
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2">Location</label>
                <div class="col-sm-4">
                  <textarea class="form-control" rows="3" style="resize: none;" ng-model="pju.pju_loc_desc" ></textarea>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2">Green Duration <i>(second)</i></label>
                <div class="col-sm-2">
                  <input type="text" class="form-control input-sm" ng-model="pju.pju_duration" >
                </div>
              </div>

            </div>

            <button class="btn btn-sm btn-success" ng-click="saveData(pju)" ><i class="fa fa-check"></i>&nbsp; Save</button>
            <button class="btn btn-sm btn-danger" ng-click="cancelMe()" ><i class="fa fa-remove"></i>&nbsp; Cancel</button>

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
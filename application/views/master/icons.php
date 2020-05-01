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

<div class="content-wrapper" ng-controller='mIconCtrl'>
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
            <h3 class="box-title">Recent Icon List</h3>
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
                  <!--div class="col-sm-2">
                    <button class="btn btn-sm btn-success btn-block" ng-click="uploadData()" >
                      <i class="fa fa-upload"></i>&nbsp; Mass Upload Data
                    </button>
                  </div-->
                  <div class="col-sm-4 pull-right">
                    <input type="text" ng-model="searchTable" class="form-control input-sm" placeholder="Search" autofocus="">
                  </div>
                </div>

                <div class="row" style="margin-top: 20px;">

                  <div class="col-sm-12">

                    <div class="row" ng-repeat-start="ic in icons | filter:searchTable">
                      <div class="col-sm-12">
                        <h4 class="cat-title"><b>{{ic.icon_category}}</b></h4>                        
                      </div>
                    </div>

                    <div class="row" ng-repeat-end>
                      <div class="col-sm-2" ng-repeat="id in ic.data_child">
                        <div class="icon-item">
                          <img ng-src="{{base_url}}image/icons/{{id.icon_image}}" width="30" height="30">
                          <span class="pull-right">{{id.icon_name}}</span>
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
                <label class="col-sm-2">Category</label>
                <div class="col-sm-3">
                  <select class="form-control select2" id="icon_category">
                    <option value="">-- Category --</option>
                    <option value="traffic">Traffic Light</option>
                    <option value="ews">EWS</option>
                    <option value="pju">PJU</option>
                    <option value="warning">Warning</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2">Type</label>
                <div class="col-sm-3">
                  <select class="form-control select2" id="icon_type">
                    <option value="">-- Type --</option>
                    <option value="1">Normal</option>
                    <option value="2">Bergerak</option>
                    <option value="3">Error</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2">Icon Name</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control input-sm" id="icon_name" ng-keypress="avoidSpace($event)" readonly >
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2">Image / Icons</label>
                <div class="col-sm-10">
                  <button type="file" ng-model="docfile" ngf-select="setFiles($file, $invalidFiles)" class="btn btn-success btn-sm" accept="image/png">Select Files | (.png) only</button>
                  <span ng-cloak ng-if="docfile">
                    [ <b>{{docfile.name}}</b> ( {{docfile.size / 1024 | number:2}} Kb ) ]
                  </span> <small><i class="example"> Note: (Width = 20 px, Height = 40 px)</i></small>
                </div>
              </div>

            </div>

            <button class="btn btn-sm btn-success" ng-click="saveData(docfile)" ><i class="fa fa-check"></i>&nbsp; Save</button>
            <button class="btn btn-sm btn-danger" ng-click="cancelMe()" ><i class="fa fa-remove"></i>&nbsp; Cancel</button>

          </div>

          <div ng-bind-html="errorMsg"></div>

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
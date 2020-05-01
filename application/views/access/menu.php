<style type="text/css">
.demo_menus,
.demo_menus a,
.demo_sub_menus,
.demo_sub_menus a {
  color: #00a65a;
  list-style: none; 
}
</style>

<div class="content-wrapper" ng-controller='menuCtrl'>
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
            <h3 class="box-title">Current Menu List</h3>
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
                    <button class="btn btn-sm btn-success btn-block" ng-click="addUser()" >Add New Menu</button>
                  </div>
                  <div class="col-sm-4 pull-right">
                    <input type="text" ng-model="searchTable" class="form-control input-sm" placeholder="Search" autofocus="">
                  </div>
                </div>

                <div class="table table-responsive">
                  <table class="table table-bordered">
                    <thead>                     
                      <tr>
                        <th width="50">No</th>
                        <th width="50"><span class="fa fa-plus"></span></th>
                        <th>Menu Name</th>
                        <th>Description</th>
                        <th>Link</th>
                        <td align="right" width="100"><b>Tools</b></td>
                      </tr>
                    </thead>
                    <tbody ng-if="(menus | filter:searchTable).length < 1">
                      <tr>
                        <td colspan="6"><b><i>No match data found</i></b></td>
                      </tr>
                    </tbody>
                    <tbody >
                      <tr ng-repeat-start="u in menus | filter:searchTable">
                        <td>{{$index + 1}}</td>
                        <td width="50">
                          <span class="btn btn-sm" style="margin-left: -10px;" ng-init="toggle[$index] = false" ng-click="toggle[$index] = !toggle[$index]">
                            <span class="fa fa-plus" ng-if="!toggle[$index]"></span>
                            <span class="fa fa-minus" ng-if="toggle[$index]"></span>
                          </span>
                        </td>
                        <td>{{u.menu_name}}</td>
                        <td>Parent Menu with {{(u.menu_child).length}} childs</td>
                        <td>{{u.menu_link}}</td>
                        <td align="right">
                          <button class="btn btn-xs btn-success" ng-click="editUser(u)" ><i class="fa fa-pencil"></i></button>
                          <button class="btn btn-xs btn-danger" ng-click="delUser(u)"><i class="fa fa-remove"></i></button>
                        </td>
                      </tr>
                      <tr ng-repeat-end ng-if="toggle[$index]">
                      <!--tr ng-if="toggle[$index]"-->
                        <td colspan="6" >
                          <div class="col-sm-12">
                            <table class="table table-condensed">
                              <tr>
                                <th width="35">&nbsp;</th>
                                <th width="50">No</th>
                                <th width="200">Child Menu Name</th>
                                <th>Link</th>
                                <td align="right" width="100"><b>Tools</b></td>
                              </tr>
                              <tr ng-repeat="ud in u.menu_child">
                                <td>&nbsp;</td>
                                <td>{{$index + 1}}</td>
                                <td><span ng-bind-html="ud.menu_parent == '0' ? '<b>'+ ud.menu_name +'</b>' : ud.menu_name"></span></td>
                                <td>{{ud.menu_link}}</td>
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

    <div class="row" ng-show="s_input">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">{{header_tittle == 'add' ? "Add User" : "Edit User"}}</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse1"><i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" ng-click="cancelMe()"><i class="fa fa-times"></i></button>
            </div>
          </div>

          <div class="box-body">

            <div class="form-horizontal" style="margin-bottom: 20px;">

              <div class="form-group">
                <label class="col-sm-2">User Name</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control input-sm" ng-model="user.adm_name" >
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2">Level</label>
                <div class="col-sm-2">
                  <select class="form-control select2" id="admLevel">
                    <option value="">&nbsp;</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2">User Id</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control input-sm" ng-model="user.adm_code" ng-disabled="on_edit" >
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2">Password</label>
                <div class="col-sm-3">
                  <div class="input-group col-sm-12">
                    <input type="password" class="form-control input-sm" ng-model="user.adm_pass" id="pass">
                    <span class="input-group-addon" style="cursor: pointer;" ng-click="showhidepass()"><i id="pointer" class="fa fa-eye"></i></span>                    
                  </div>                  
                </div>
              </div>

            </div>

            <button class="btn btn-sm btn-success" ng-click="saveUser(user)" ><i class="fa fa-check"></i>&nbsp; Save</button>
            <button class="btn btn-sm btn-danger" ng-click="cancelMe()" ><i class="fa fa-remove"></i>&nbsp; Cancel</button>

            <div class="row" style="margin-top: 10px;" ng-show="s_details">
              <div class="col-sm-12">
                <div class="row">
                  <div class="col-sm-12">
                    <b>User Access Menu</b>&nbsp;
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <div class="col-sm-12 panel panel-info" style="padding: 10px 10px;">
                      <label>Access Menu List</label>
                      <button class="btn btn-xs btn-success pull-right" ng-click="addMenu()" ><i class="fa fa-plus"></i>&nbsp; Add Menu</button>
                      <table class="table table-condensed">
                        <tr>
                          <th width="30">No</th>
                          <th>Menu</th>
                          <th>Link</th>
                          <th>Status</th>
                          <th><i class="fa fa-remove"></i></th>
                        </tr>
                        <tr ng-repeat="mn in usermenudata">
                          <td>{{$index+1}}</td>
                          <td>{{mn.menu_name}}</td>
                          <td>{{mn.menu_link}}</td>
                          <td>{{mn.acc_active == 'Y' ? 'Enabled' : 'Disabled' }}</td>
                          <td><a href="" class="fa fa-remove text-danger" ng-click="delMenu(mn)" ></a></td>
                        </tr>
                      </table>
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="col-sm-12 panel panel-info" style="padding: 10px 10px;">
                      <label>Menu Preview</label>
                      <ul class="demo_menus" ng-bind-html="usermenu"></ul>
                    </div>
                  </div>
                </div>


              </div>
            </div>

          </div>

          <!--div class="box-footer">
            <button class="btn btn-sm btn-success" ng-click="saveUser(user)" ><i class="fa fa-check"></i>&nbsp; Save</button>
            <button class="btn btn-sm btn-danger" ng-click="cancelMe()" ><i class="fa fa-remove"></i>&nbsp; Cancel</button>
          </div-->

        </div>
      </div>
    </div>

  </section>
  <section class="content"></section>

  <div id="modal_add" class="modal fade in">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Information</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-12">
                <small><i>Select Menu :</i></small>
                <select class="form-control input-sm select2" id="pilMenu">
                  <option value="">-- select --</option>
                  <optgroup ng-repeat="gmn in menus" label="{{gmn.menu_name}}" >
                    <option ng-repeat="smn in gmn.menu_child" value="{{smn.menu_parent + ',' + smn.menu_code }}" >{{smn.menu_name}}</option>
                  </optgroup>
                </select>                
              </div>
            </div>

            <div class="row" style="margin-top: 20px;">
              <div class="col-sm-12">
                <small><i>Menu Status :</i></small>
                <select class="form-control input-sm select2" id="statMenu">
                  <option value="Y" selected >Enable</option>
                  <option value="N" >Disable</option>
                </select>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-info btn-sm" ng-click="saveMenu('F')">Add</button>
            <button type="button" class="btn btn-success btn-sm" ng-click="saveMenu('T')">Add And Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>


</div>







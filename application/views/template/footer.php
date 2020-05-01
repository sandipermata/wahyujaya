    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> <?php echo CI_VERSION ?>
      </div>
      <strong>Copyright &copy; 2018 Wantech </strong> All rights reserved.
    </footer>

  </div>

  <script src="<?php echo base_url('assets/plugins/jQuery/jquery-2.2.3.min.js')?>"></script>
  <script src="<?php echo base_url('assets/css/bootstrap/dist/js/bootstrap.min.js')?>"></script>
  <script src="<?php echo base_url('assets/plugins/select2/select2.full.min.js')?>"></script>
  <script src="<?php echo base_url('assets/dist/js/app.min.js')?>"></script>
  <script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js')?>"></script>

  <script src="<?php echo base_url('assets/plugins/input-mask/jquery.inputmask.js')?>"></script>
  <script src="<?php echo base_url('assets/plugins/input-mask/jquery.inputmask.date.extensions.js')?>"></script>
  <script src="<?php echo base_url('assets/plugins/input-mask/jquery.inputmask.extensions.js')?>"></script>

  <!-- upload -->
  <script src="<?php echo base_url('assets/js/upload/ng-file-upload-shim.js')?>"></script>
  <script src="<?php echo base_url('assets/js/upload/ng-file-upload.js')?>"></script>

  <!-- ANGULAR JS -->
  <?php $version = md5(date('YmdHis').'wantech'); ?>

  <script src="<?php echo base_url('assets/js/angular/app/app_Main_20190705.js'). "?v=" . $version; ?>"></script>
  <script src="<?php echo base_url('assets/js/angular/app/app_Controller_20200301.js'). "?v=" . $version; ?>"></script>
  <script src="<?php echo base_url('assets/js/angular/app/app_Service_20200301.js'). "?v=" . $version; ?>"></script>

  <script src="<?php echo base_url('plugins/morris/morris.min.js')?>"></script>
  <script src="<?php echo base_url('plugins/raphael/raphael-min.js')?>"></script>

  <!-- menu handler -->
  <script type="text/javascript" src="<?php echo base_url('assets/js/custom-menu-handler.js')?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js/dirPagination.js')?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js/angular/angular-sanitize-175.js')?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js/ng-csv/build/ng-csv.min.js')?>"></script>


  <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>

  <script>
    $(function () {
      $(".select2").select2({
        placeholder : "pilih"
      });
      $(".selectProv").select2({
        placeholder : "Pilih Provinsi"
      });
      $(".selectKota").select2({
        placeholder : "Pilih Kota / Kabupaten"
      });
      $(".selectKec").select2({
        placeholder : "Pilih Kecamatan"
      });
      //$('b[role="presentation"]').hide();
      //$('.select2-selection__arrow').append('<i class="fa fa-angle-down"></i>');

      alertify.set('notifier','position', 'top-right');

      $('.datepicker').datepicker({
        autoclose: true,
        format : 'yyyy-mm-dd',
      });

      $("[data-mask]").inputmask();

    });
  </script>

  <script type="text/javascript">
    $(function() {
      $(window).load(function() {
        $(".loading").fadeOut("slow");
        $(".textloading").fadeOut("slow");
      });

      //caches a jQuery object containing the header element
      var header = $("body");
      $(window).scroll(function() {
        var scroll = $(window).scrollTop();

        if (scroll >= 500) {
          //header.removeClass("fixed");
          //console.log("remove");
        } else {
          header.addClass("fixed");
          console.log("add");
        }
      });
    });
  </script>

</body>
</html>

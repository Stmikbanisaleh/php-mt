<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="<?= base_url('auth/logout') ?>">Logout</a>
            </div>
        </div>
    </div>
</div>


<footer class="site-footer">
    <?php
    $TahunSekarang = date("Y");

    ?>
    <div class="site-footer-legal">© 2019 - <?= $TahunSekarang ?> Pusat Inovasi dan Standar Penerbangan dan Antariksa </div>

</footer>
<!-- Core  -->
<script src="<?= base_url('assets/'); ?>global/vendor/babel-external-helpers/babel-external-helpers.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/jquery/jquery.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/tether/tether.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/bootstrap/bootstrap.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/animsition/animsition.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/mousewheel/jquery.mousewheel.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/asscrollbar/jquery-asScrollbar.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/asscrollable/jquery-asScrollable.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/ashoverscroll/jquery-asHoverScroll.js"></script>
<!-- Plugins -->
<script src="<?= base_url('assets/'); ?>global/vendor/switchery/switchery.min.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/intro-js/intro.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/screenfull/screenfull.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/slidepanel/jquery-slidePanel.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/skycons/skycons.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/aspieprogress/jquery-asPieProgress.min.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/jvectormap/jquery-jvectormap.min.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/jvectormap/maps/jquery-jvectormap-au-mill-en.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/matchheight/jquery.matchHeight-min.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/datatables-fixedheader/dataTables.fixedHeader.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/datatables-bootstrap/dataTables.bootstrap.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/datatables-responsive/dataTables.responsive.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/datatables-buttons/dataTables.buttons.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/datatables-buttons/buttons.html5.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/datatables-buttons/buttons.flash.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/datatables-buttons/buttons.print.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/jquery-wizard/jquery-wizard.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/raphael/raphael-min.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/morris/morris.min.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/matchheight/jquery.matchHeight-min.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/chart-js/Chart.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/jszip/jszip.min.js"></script>

<!-- Scripts -->

<script src="<?= base_url('assets/'); ?>global/js/State.js"></script>
<script src="<?= base_url('assets/'); ?>global/js/Component.js"></script>
<script src="<?= base_url('assets/'); ?>global/js/Plugin.js"></script>
<script src="<?= base_url('assets/'); ?>global/js/Base.js"></script>
<script src="<?= base_url('assets/'); ?>global/js/Config.js"></script>
<script src="<?= base_url('assets/base/assets/'); ?>js/Section/Menubar.js"></script>
<script src="<?= base_url('assets/base/assets/'); ?>js/Section/GridMenu.js"></script>
<script src="<?= base_url('assets/base/assets/'); ?>js/Section/Sidebar.js"></script>
<script src="<?= base_url('assets/base/assets/'); ?>js/Section/PageAside.js"></script>
<script src="<?= base_url('assets/base/assets/'); ?>js/Plugin/menu.js"></script>
<script src="<?= base_url('assets/'); ?>global/js/config/colors.js"></script>
<script src="<?= base_url('assets/base/assets/'); ?>js/config/tour.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/blueimp-tmpl/tmpl.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/blueimp-canvas-to-blob/canvas-to-blob.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/blueimp-load-image/load-image.all.min.js"></script>
<!--<script src="<?= base_url('assets/'); ?>global/vendor/blueimp-file-upload/jquery.fileupload.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/blueimp-file-upload/jquery.fileupload-process.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/blueimp-file-upload/jquery.fileupload-image.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/blueimp-file-upload/jquery.fileupload-audio.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/blueimp-file-upload/jquery.fileupload-video.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/blueimp-file-upload/jquery.fileupload-validate.js"></script>
<script src="<?= base_url('assets/'); ?>global/vendor/blueimp-file-upload/jquery.fileupload-ui.js"></script>-->
<script src="<?= base_url('assets/'); ?>global/vendor/dropify/dropify.min.js"></script>
<script>
    Config.set('assets', '../assets');
</script>
<!-- Page -->
<script src="<?= base_url('assets/base/assets/'); ?>js/Site.js"></script>
<script src="<?= base_url('assets/'); ?>global/js/Plugin/asscrollable.js"></script>
<script src="<?= base_url('assets/'); ?>global/js/Plugin/slidepanel.js"></script>
<script src="<?= base_url('assets/'); ?>global/js/Plugin/switchery.js"></script>
<script src="<?= base_url('assets/'); ?>global/js/Plugin/matchheight.js"></script>
<script src="<?= base_url('assets/'); ?>global/js/Plugin/jvectormap.js"></script>
<script src="<?= base_url('assets/'); ?>global/js/Plugin/datatables.js"></script>
<script src="<?= base_url('assets/base/assets/'); ?>examples/js/tables/datatable.js"></script>
<script src="<?= base_url('assets/'); ?>global/js/Plugin/asscrollable.js"></script>
<script src="<?= base_url('assets/'); ?>global/js/Plugin/slidepanel.js"></script>
<script src="<?= base_url('assets/'); ?>global/js/Plugin/switchery.js"></script>
<script src="<?= base_url('assets/'); ?>global/js/Plugin/jquery-wizard.js"></script>
<script src="<?= base_url('assets/'); ?>global/js/Plugin/matchheight.js"></script>
<!-- <script src="<?= base_url('assets/base/assets/'); ?>examples/js/forms/validation.js"></script> -->
<script src="<?= base_url('assets/'); ?>global/js/Plugin/dropify.js"></script>
<script src="<?= base_url('assets/'); ?>global/js/Plugin/bootstrap-datepicker.js"></script>
<script src="<?= base_url('assets/'); ?>global/js/Plugin/matchheight.js"></script>
</body>

</html>
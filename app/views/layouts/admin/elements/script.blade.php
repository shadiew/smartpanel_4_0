<!-- General scripts -->
<script type="text/javascript" src="<?php echo BASE; ?>assets/js/vendors/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="<?php echo BASE; ?>assets/js/vendors/jquery.sparkline.min.js"></script>
<script type="text/javascript" src="<?php echo BASE; ?>assets/js/vendors/selectize.min.js"></script>
<script type="text/javascript" src="<?php echo BASE; ?>assets/admin/vendors/autosize/autosize.min.js"></script>
<script type="text/javascript" src="<?php echo BASE; ?>assets/admin/vendors/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<!-- Core scripts -->
<script src="<?=BASE?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>


<!-- Core scripts -->
<script type="text/javascript" src="<?php echo BASE; ?>assets/js/core.js"></script>
<script type="text/javascript" src="<?php echo BASE; ?>assets/admin/dist/js/admin-core.min.js"></script>
<script type="text/javascript" src="<?php echo BASE; ?>assets/admin/dist/js/customizer.js"></script>

<!-- toast -->
<script type="text/javascript" src="<?php echo BASE; ?>assets/plugins/jquery-toast/js/jquery.toast.js"></script>
<!-- Tiny Editor -->
<script type="text/javascript" id="tinymce-js" src="<?php echo BASE; ?>assets/plugins/tinymce/tinymce.min.js"></script>
<!-- emoji picker -->
<script src="<?php echo BASE; ?>assets/plugins/emoji-picker/lib/js/config.js"></script>
<script src="<?php echo BASE; ?>assets/plugins/emoji-picker/lib/js/util.js"></script>
<script src="<?php echo BASE; ?>assets/plugins/emoji-picker/lib/js/jquery.emojiarea.js"></script>
<script src="<?php echo BASE; ?>assets/plugins/emoji-picker/lib/js/emoji-picker.js"></script>
<!-- flags icon -->
<script type="text/javascript" src="<?php echo BASE; ?>assets/plugins/flags/js/docs.js"></script>

<?php if(segment('2') == 'settings'){ ?>
    <script type="text/javascript" src="<?php echo BASE; ?>assets/plugins/jquery-upload/js/vendor/jquery.ui.widget.js"></script>
    <script type="text/javascript" src="<?php echo BASE; ?>assets/plugins/jquery-upload/js/jquery.iframe-transport.js"></script>
    <script type="text/javascript" src="<?php echo BASE; ?>assets/plugins/jquery-upload/js/jquery.fileupload.js"></script>
<?php } ?>
<?php if(segment('2') == 'statistics'){ ?>
    <script type="text/javascript" src="<?php echo BASE; ?>assets/js/chart_template.js"></script>
<?php }?>
<script type="text/javascript" src="<?php echo BASE; ?>assets/admin/vendors/js/notify.min.js"></script>
<!-- general JS -->
<script type="text/javascript" src="<?php echo BASE; ?>assets/js/process.js"></script>
<script type="text/javascript" src="<?php echo BASE; ?>assets/js/general.js"></script>
<script type="text/javascript" src="<?php echo BASE; ?>assets/admin/js/admin.js"></script>
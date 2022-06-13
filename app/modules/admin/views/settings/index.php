
<?php 
  // Page header
  echo show_page_header($controller_name, ['page-options' => '']);
?>
<div class="row settings justify-content-center">
  <div class="col-md-12 col-lg-12">
    <div class="row">
      <div class="col-md-2 col-lg-2">
        <?php include 'sidebar.php'; ?>
      </div>
      <div class="col-md-10 col-lg-10">
        <?php include "elements/$tab.php"; ?>
      </div>
    </div>
  </div>
</div>

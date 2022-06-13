<section class="page-title">
  <div class="row justify-content-md-center justify-content-between">
    <div class="col-md-12">
      <h1 class="page-title">
        <span data-toggle="modal" data-target="#install-module">
          <span class="add-new" data-toggle="tooltip" data-placement="bottom" title="<?=lang("add_new")?>" data-original-title="Add new"><i class="fa fa-plus-square text-primary" aria-hidden="true"></i>
          </span>
        </span> 
        <?=lang("Modules")?>
      </h1>
    </div>
  </div>
</section>

<div class="row m-t-10 modules-lists" id="result_ajaxSearch">
  <?php
    if (isset($_GET["error"]) && $_GET["error"] != "") {
  ?>
  <div class="col-md-8">
    <div class="payment-errors alert alert-icon alert-danger alert-dismissible">
      <i class="fe fe-alert-triangle mr-2" aria-hidden="true"></i>
      <span class="payment-errors-message"><?=base64_decode($_GET["error"])?></span>
    </div>
  </div>
  <?php }?>


  <?php 
    if (!empty($scripts)) {

  ?>
  <div class="col-md-12">
    <div class="row row-cards">
      <?php
        foreach ($scripts as $key => $row) {
          $version = $row->version;
          $purchase_exist = false;
          $check_upgrade  = false;

          foreach ($purchase_code_lists as $key => $purchase_code_item) {
            if ($row->app_id == $purchase_code_item->pid) {
              $purchase_exist = true;
              $version = $purchase_code_item->version;
              if (version_compare($row->version, $purchase_code_item->version, '>')) {
                $check_upgrade = true;
                $purchase_code = $purchase_code_item->purchase_code;
              }
            }
          }
      ?>
      <div class="col-sm-6 col-lg-4 module-item">
        <div class="card p-3">
          <a target="_blank" href="<?=$row->link?>" class="mb-3">
            <img src="<?=$row->thumbnail?>" alt="<?=$row->name?>" class="rounded">
          </a>
          <div class="d-flex align-items-center px-2">
            <div>
              <div class="product-name">
                <a href="<?=$row->link?>" target="_blank">
                  <?=$row->name?>
                </a>
              </div>
            </div>
            <div class="ml-auto text-muted">
              <small>ver<?=$version?></small>
            </div>
          </div>
          <div class="d-flex align-items-center px-2 m-t-5">
            <div>
              <div class="product-price">
                $<?=$row->price?>
              </div>
            </div>
            <div class="ml-auto text-muted">
              <?php
                if (!$purchase_exist) {
                  echo '<a href="'.$row->link.'" target="_blank" class="btn btn-pill btn-info btn-sm">'.lang('Buy_now').'</a>';
                }else{
                  if ($check_upgrade) {
                    $url = admin_url($controller_name."/ajax_install_module/".$purchase_code);
                    echo '<a href="'.$url.'" class="btn btn-pill btn-primary btn-sm ajaxUpgradeVersion"><i class="fe fe-arrow-up"></i>'.lang('Upgrade_version').$row->version.'</a>';
                  }else{
                    echo '<span class="btn btn-pill btn-gray btn-sm">'.lang('Purchased').'</span>';
                  }
                }
              ?>
            </div>
          </div>
        </div>
      </div>
      <?php }?>
    </div>
  </div>
  <?php }else{
    echo Modules::run("blocks/empty_data");
  }?>
</div>
<div class="modal-install-module">
  <div class="modal" id="install-module">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="actionForm" action="<?=admin_url($controller_name."/ajax_install_module")?>" method="POST">
          <div class="modal-header">
            <h4 class="modal-title"><i class="fe fe-plus-circle"></i> Install Module</h4>
            <button type="button" class="close" data-dismiss="modal"></button>
          </div>

          <div class="modal-body">
            <div class="form-group">
              <label>Your purchase code</label>
              <input class="form-control square" type="text" name="purchase_code">
            </div>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-primary btn-min-width mr-1 mb-1"><?=lang("Submit")?></button>
            <button type="button" class="btn btn-default btn-min-width mr-1 mb-1" data-dismiss="modal"><?=lang("Cancel")?></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
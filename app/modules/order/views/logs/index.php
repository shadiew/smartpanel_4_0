<style type="text/css">
  .order_btn_group .list-inline-item{
    margin-right: 0px!important;
  }
  .order_btn_group .list-inline-item a.btn{
    font-size: 0.9rem;
    font-weight: 400;
  }
</style>

<?php 
  $show_search_area = show_search_area($controller_name, $params, 'user');
?>
<div class="page-title m-b-20">
  <div class="row justify-content-between">
    <div class="col-md-2">
      <h1 class="page-title">
          <span class="fe fe-calendar"></span> <?=lang("order_logs")?>
      </h1>
    </div>
    <div class="col-md-4">
      <div class="d-flex">
        <a href="<?=cn("order/new_order")?>" class="ml-auto btn btn-outline-primary">
          <span class="fe fe-plus"></span>
            <?=lang("add_new")?>
        </a>
      </div>
    </div>
    <div class="col-md-12">
      <div class="row justify-content-between">
        <div class="col-md-10">
          <ul class="list-inline mb-0 order_btn_group">
            <li class="list-inline-item"><a class="nav-link btn <?=($params['filter']['status'] == 'all') ? 'btn-info' : ''?>" href="<?=cn($controller_name)?>">All</a></li>
            <?php 
              if (!empty($order_status_array)) {
                foreach ($order_status_array as $row_status) {
            ?>
              <li class="list-inline-item">
                <a class="nav-link btn <?=($params['filter']['status'] == $row_status) ? 'btn-info' : ''?>" href="<?=cn($controller_name . "?status=". $row_status)?>"><?=order_status_title($row_status)?>
                </a>
              </li>
            <?php }} ?>
          </ul>
        </div>
        <div class="col-md-2">
          <div class="d-flex search-area">
            <?php echo $show_search_area; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row" id="result_ajaxSearch">
  <?php 
    $this->load->view('child/index', ['items' => $items, 'controller_name' => $controller_name]);
  ?>
</div>

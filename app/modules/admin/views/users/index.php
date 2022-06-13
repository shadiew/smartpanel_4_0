<?php 
  // Page header
  echo show_page_header($controller_name, ['page-options' => 'add-new', 'page-options-type' => 'ajax-modal']);
  // Page header Filter
  echo show_page_header_filter($controller_name, ['items_status_count' => $items_status_count, 'params' => $params]);
?>

<div class="row">
  <?php if(!empty($items)){
  ?>
    <div class="col-md-12 col-xl-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><?=lang("Lists")?></h3>
          <div class="card-options">
            <?php echo show_bulk_btn_action($controller_name); ?>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover table-bordered table-vcenter card-table">
            <?php echo render_table_thead($columns); ?>
            <tbody>
              <?php if (!empty($items)) {
                $i = $from;
                foreach ($items as $key => $item) {
                  $i++;
                  $item_checkbox      = show_item_check_box('check_item', $item['ids']);
                  $full_name = show_high_light(esc($item['first_name']), $params['search'], 'first_name') . " " . show_high_light(esc($item['last_name']), $params['search'], 'last_name');
                  $email = show_high_light(esc($item['email']), $params['search'], 'email');
                  $custom_rate_btn    = show_item_custom_rate_btn($controller_name, $item['ids']);
                  $item_status        = show_item_status($controller_name, $item['ids'], $item['status'], 'switch');
                  $created            = show_item_datetime($item['created'], 'long');
                  $show_item_buttons  = show_item_button_action($controller_name, $item['ids']);
              ?>
                <tr class="tr_<?php echo esc($item['ids']); ?>">
                  <th class="text-center w-1"><?php echo $item_checkbox; ?></th>
                  <td class="text-center text-muted"><?=$i?></td>
                  <td>
                    <div class="title"><h6><?php echo $full_name; ?></h6></div>
                    <div class="sub text-muted"><?php echo $email; ?></small></div>
                  </td>
                  <td class="text-center w-10p"><?php echo (double)$item['balance']; ?></td></td>
                  <td class="text-center w-10p"><?php echo $custom_rate_btn; ?></td>
                  <td class="text-center text-muted w-5p"><?php echo $item['role']; ?></td>
                  <td class="text-center w-15p"><?php echo $created; ?></td>
                  <td class="text-center w-5p"><?php echo $item_status; ?></td>
                  <td class="text-center w-5p"><?php echo $show_item_buttons; ?></td>
                </tr>
              <?php }}?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <?php echo show_pagination($pagination); ?>
  <?php }else{
    echo show_empty_item();
  }?>
</div>


<div id="customRate" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"></i> Edit custom rates (ID: 1)</h4>
        <button type="button" class="close" data-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <select name="service-id" class="select-service-item" class="form-control custom-select">
                <option value='{"service_id": "1189", "rate": "0.53", "name": "Instagram Likes [100 - 3K] [Instant] [Exclusive]"}' data-rate="1" data-data='{"rate": "0.53", "name": "Instagram Likes [100 - 3K] [Instant] [Exclusive]"}'>128 - Instagram Likes [100 - 3K] [Instant] [Exclusive] [$0.18]</option>
                <option value='{"service_id": "123", "rate": "0.78", "name": "Instagram Likes [100 - 3K] [Instant] [Exclusive]"}' data-rate="1" data-data='{"rate": "0.53", "name": "Instagram Likes [100 - 3K] [Instant] [Exclusive]"}'>123 - Instagram Likes [100 - 3K] [Instant] [Exclusive] [$0.18]</option>
              </select>
            </div>
          </div>
        </div>
        
        <div class="o-auto" style="height: 20rem">
          <ul class="list-unstyled list-separated services-group-items">

            <div class="s-items">
              <li class="list-separated-item s-item">
                <div class="row align-items-center">
                  <div class="col">
                    111
                  </div>
                  <div class="col-md-7">
                    Facebook [Real Relevant Comments - Custom Comments]
                  </div>
                  <div class="col-md-1">
                    0.53
                  </div>
                  <div class="col-md-2">
                    <input type="hidden" class="form-control" value="customRates[1123][price]">
                    <input type="text" class="form-control" >
                  </div>
                  <div class="col-md-1">
                    <button class="btn btn-secondary btn-remove-item" type="button"><i class="fe fe-trash-2"></i></button>
                  </div>
                </div>
              </li>
            </div>

            <div class="s-item-more d-none">
              <li class="list-separated-item s-item" id="item__serviceID__">
                <div class="row align-items-center">
                  <div class="col">
                    __serviceID__
                  </div>
                  <div class="col-md-7">
                    __serviceName__
                  </div>
                  <div class="col-md-1">
                    __serviceRate__
                  </div>
                  <div class="col-md-2">
                    <input type="hidden" class="form-control" value="customRates[__serviceID__][rate_id]">
                    <input type="number" class="form-control" value="customRates[__serviceID__][price]">
                  </div>
                  <div class="col-md-1">
                    <button class="btn btn-secondary btn-remove-item" type="button"><i class="fe fe-trash-2"></i></button>
                  </div>
                </div>
              </li>
            </div>
            
          </ul>
        </div>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

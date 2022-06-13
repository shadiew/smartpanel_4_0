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
                  $item_checkbox      = show_item_check_box('check_item', $item['id']);
                  $item_sort          = show_item_sort($controller_name, $item['id'], $item['sort']);
                  $item_status        = show_item_status($controller_name, $item['id'], $item['status'], 'switch');
                  $show_item_buttons  = show_item_button_action($controller_name, $item['id']);
                  $answer  = show_high_light(show_content($item['answer'], 100), $params['search'], 'answer');
              ?>
                <tr class="tr_<?php echo esc($item['id']); ?>">
                  <th class="text-center w-1"><?php echo $item_checkbox; ?></th>
                  <td class="text-center text-muted"><?=$i?></td>
                  <td>
                    <h6>Q: <?php echo show_high_light(esc($item['question']), $params['search'], 'question'); ?></h6>
                    <p class="text-muted"><strong>Answer:</strong> <?php echo $answer; ?></p>
                  </td>
                  <td class="text-center"><?php echo $item_sort; ?></td>
                  <td class="text-center w-5p"><?php echo $item_status; ?></td>
                  <td class="text-center w-10p"><?php echo $item['changed'] ?></td>
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

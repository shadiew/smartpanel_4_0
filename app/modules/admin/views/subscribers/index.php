<?php 
  // Page header
  echo show_page_header($controller_name, ['page-options' => 'search', 'search_params' => $params]);
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
                  $created            = show_item_datetime($item['created'], 'long');
                  $show_item_buttons  = show_item_button_action($controller_name, $item['id']);
              ?>
                <tr class="tr_<?php echo esc($item['ids']); ?>">
                  <th class="text-center w-1"><?php echo $item_checkbox; ?></th>
                  <td class="text-center text-muted"><?=$i?></td>
                  <td>
                    <div class="title"><?php echo show_high_light(esc($item['email']), $params['search'], 'email'); ?></div>
                  </td>
                  <td class="text-center w-10p"><?php echo show_high_light(esc($item['ip']), $params['search'], 'ip'); ?></td>
                  <td class="text-center w-10p"><?php echo show_high_light(esc($item['country']), $params['search'], 'country'); ?></td>
                  <td class="text-center text-muted w-15p"><?php echo $created; ?></td>
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


<div class="col-md-12">
  <div class="title text-center text-info">
    <h3><?=lang("synchronization_results")?> (<?=$item_provider['name']?>)</h3>
  </div>
</div>
<?php if(!empty($new_services) || !empty($disabled_services)){
  $columns     =  array(
    "no"                       => ['name' => '#',           'class' =>    'text-center'],
    "id"                       => ['name' => 'Service ID',  'class' => 'text-center'],
    "provider_service_id"      => ['name' => 'Provider Service ID',  'class' => 'text-center'],
    "name"                     => ['name' => 'Name',        'class' =>    ''],
    "status"                   => ['name' => 'Status',      'class' =>    'text-center'],
  );
?>
  <?php
    if (!empty($disabled_services)) {
  ?>
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">Disabled Services</h3>
          <div class="card-options">
            <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
            <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover table-bordered table-vcenter card-table">
            <?php echo render_table_thead($columns, false, false, false); ?>
            <tbody>
              <?php
                $i = 0; 
                foreach ($disabled_services as $key => $item) {
                  $i++;
              ?>
              <tr>
                <td class="text-center w-5p"><?=$i?></td>
                <td class="text-center w-10p"><?=$item['id']?></td>
                <td class="text-center w-10p"><?=$item['api_service_id']?></td>
                <td><div class="title"><?=$item['name']?></div></td>
                <td class="text-center w-10p"><span class="btn round btn-warning btn-sm">Disable</span></td>
              </tr>
              <?php }?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  <?php } ?>

  <?php
    if (!empty($new_services)) {
  ?>
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">New Services</h3>
          <div class="card-options">
            <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
            <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover table-bordered table-vcenter card-table">
            <?php echo render_table_thead($columns, false, false, false); ?>
            <tbody>
              <?php
                $i = 0; 
                foreach ($new_services as $key => $item) {
                  $i++;
              ?>
              <tr>
                <td class="text-center w-5p"><?=$i?></td>
                <td class="text-center w-10p"><?=$item['id']?></td>
                <td class="text-center w-10p"><?=$item['api_service_id']?></td>
                <td><div class="title"><?=$item['name']?></div></td>
                <td class="text-center w-10p"><span class="btn round btn-info btn-sm">New</span></td>
              </tr>
              <?php }?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  <?php } ?>
  
<?php }else{
  echo show_empty_item();
}?>
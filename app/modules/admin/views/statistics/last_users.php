<?php
  $columns     =  [
    "users"            => ['name' => 'User Profile',    'class' => ''],
    "funds"            => ['name' => 'Balance', 'class' => 'text-center'],
    "role"             => ['name' => 'Role',    'class' => 'text-center'],
    "ip"               => ['name' => 'history IP',    'class' => 'text-center'],
    "created"          => ['name' => 'Created',  'class' => 'text-center'],
    "status"           => ['name' => 'Status',  'class' => 'text-center'],
  ];
?>
<div class="row">
  <?php if(!empty($items_last_users)){
  ?>
    <div class="col-md-12 col-xl-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Last Newest Users</h3>
        </div>
        <div class="table-responsive">
          <table class="table table-hover table-bordered table-vcenter card-table">
            <?php echo render_table_thead($columns, false, false, false, false); ?>
            <tbody>
              <?php if (!empty($items_last_users)) {
                foreach ($items_last_users as $key => $item) {
                  $full_name          = esc($item['first_name']) . " " . esc($item['last_name']);
                  $email = esc($item['email']);
                  $item_status        = show_item_status($controller_name, $item['ids'], $item['status'], '');
                  $created            = show_item_datetime($item['created'], 'long');
              ?>
                <tr class="tr_<?php echo esc($item['ids']); ?>">
                  <td>
                    <div class="title"><h6><?php echo $full_name; ?></h6></div>
                    <div class="sub text-muted"><?php echo $email; ?></small></div>
                  </td>
                  <td class="text-center w-10p"><?php echo (double)$item['balance']; ?></td></td>
                  <td class="text-center text-muted w-5p"><?php echo $item['role']; ?></td>
                  <td class="text-center text-muted w-15p"><?php echo $item['history_ip']; ?></td>
                  <td class="text-center w-15p"><?php echo $created; ?></td>
                  <td class="text-center w-5p"><?php echo $item_status; ?></td>
                </tr>
              <?php }}?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  <?php }?>
</div>
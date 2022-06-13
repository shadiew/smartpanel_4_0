<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title"><i class="fe fe-list"></i> <?=lang("Lists")?>
      </h3>
      <div class="card-options">
        <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
        <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
      </div>
    </div>

    <div class="card-body o-auto" style="height: calc(100vh - 180px);">
      
      <?php if(!empty($tickets)){?>
      <div class="ticket-lists">
        <?php
          $is_admin = get_role('admin');
          foreach ($tickets as $key => $row) {
            $short_name_user = '<i class="fe fe-user"></i>';
            if (!empty($row->first_name)) {
              $last_name_user = $row->last_name;
              $first_name_user = $row->first_name;
              $short_name_user = $first_name_user[0].$last_name_user[0];
            }
        ?>
        <div class="item tr_<?=$row->ids?>">
          <a href="<?=cn("$module/".$row->id)?>" class="p-l-5 d-flex text-decoration-none">
            <div class="media-left p-r-10">
                <span class="avatar avatar-md">
                    <span class="media-object rounded-circle text-circle text-uppercase <?=$row->status?>"><?=$short_name_user?></span>
                </span>
            </div>
            <div class="content">
              <div class="subject text-truncate <?=(isset($row->status) && $row->status == "closed") ? "text-muted" : ""?>">
                <?="#".$row->id." - ".$row->subject?>
                <?php
                  $is_unread = 0;
                  if (get_role('user')) {
                    $is_unread = $row->user_read;
                  }else{
                    $is_unread = $row->admin_read;
                  }
                ?>
                <?php if($is_unread){
                ?>
                <span class="badge badge-warning"><?=lang("Unread")?></span>
                <?php }?>
              </div>
              <div class="email"><?=$row->first_name." ".$row->last_name." - ".$row->user_email?></div>
              <div class="time">
                <small><?=convert_timezone($row->changed, 'user')?> </small>
              </div>
            </div>
          </a>

          <div class="action item-action dropdown m-t-10">
            <?php
              $button_type = "btn-info";
              if (!empty($row->status)) {
                switch ($row->status) {
                  case 'pending':
                    $button_type = "btn-info";
                    break;
                  case 'closed':
                    $button_type = "btn-gray-dark";
                    break;
                  case 'answered':
                    $button_type = "btn-gray";
                    break;
                }
              }
            ?>
            <a href="javascript:void(0)"class="m-r-5">
              <span class="btn round <?=$button_type?> btn-sm"><small><?=ticket_status_title($row->status)?></small>
              </span>
            </a>
            <?php 
            if(get_role("admin") || get_role('supporter')) {?>
            <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="javascript:void(0)" data-url="<?=cn($module."/ajax_change_status/".$row->ids)?>" data-status="new" class="ajaxChangeStatus dropdown-item"> <i class="dropdown-icon fe fe-mail"></i> <?=lang("mark_as_new")?></a>

              <a href="javascript:void(0)" data-url="<?=cn($module."/ajax_change_status/".$row->ids)?>" data-status="pending" class="ajaxChangeStatus dropdown-item"> <i class="dropdown-icon fa fa-envelope-open"></i> <?=lang("mark_as_pending")?></a>

              <a href="javascript:void(0)" data-url="<?=cn($module."/ajax_change_status/".$row->ids)?>" data-status="closed" class="ajaxChangeStatus dropdown-item"> <i class="dropdown-icon fe fe-unlock"></i> <?=lang("mark_as_closed")?></a>
              <?php 
                if (get_role('admin')) {
              ?>
              <a href="<?=cn("$module/ajax_delete_item/".$row->ids)?>" class="ajaxDeleteItem dropdown-item"> <i class="dropdown-icon fe fe-trash"></i> <?=lang("Delete")?></a>
              <?php }?>
            </div>
            <?php }?>
          </div>
          <div class="clearfix"></div>
        </div>
        <?php }?>
      </div>
      <?php }else{
        echo Modules::run("blocks/empty_data");
      }?>  
    </div>
  </div>
</div>

<script src="<?=BASE?>assets/js/core.js" type="text/javascript"></script>

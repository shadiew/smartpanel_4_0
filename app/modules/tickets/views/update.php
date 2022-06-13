<style>
  .ticket-contents .item .avatar.supporter-icon {
    height: 40px;
  }
</style>
<section class="<?=(isset($module))? $module : ''?> p-t-20">   
  <div class="row">
    <div class="col-md-4">
      <div class="card">
        <div class="card-header d-flex align-items-center">
          <h3 class="h4"><i class="fa fa-ticket"></i> <?=lang("Ticket_no")?><?=$ticket->id?></h3>
        </div>
        <div class="card-body">
          <div class="ticket-details">
            <table class="table">
              <tbody>
                <tr>
                  <td scope="row"><?=lang("Status")?></td>
                  <td>
                    <?php
                      $button_type = "info";
                      if (!empty($ticket->status)) {
                        switch ($ticket->status) {
                          case 'pending':
                            $button_type = "info";
                            break;
                          case 'closed':
                            $button_type = "gray-dark";
                            break;
                          case 'answered':
                            $button_type = "gray";
                            break;
                        }
                      }
                    ?>
                    <div class="btn-group">
                      <?php 
                        if (get_role("admin") || get_role('supporter')) {
                      ?>
                      <div class="dropdown">
                        <button  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle btn btn-<?=$button_type?> dropdown-toggle btn-sm">
                          <span class="p-r-5 p-l-5"><?=ticket_status_title($ticket->status)?> </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right has-shadow">

                          <a href="javascript:void(0)" data-url="<?=cn($module."/ajax_change_status/".$ticket->ids)?>" data-status="closed" class="ajaxChangeStatus dropdown-item"><?=lang("submit_as_closed")?></a>
                          <a href="javascript:void(0)" data-url="<?=cn($module."/ajax_change_status/".$ticket->ids)?>" data-status="pending" class="ajaxChangeStatus dropdown-item"><?=lang("submit_as_pending")?></a>
                          <a href="javascript:void(0)" data-url="<?=cn($module."/ajax_change_status/".$ticket->ids)?>" data-status="answered" class="ajaxChangeStatus dropdown-item"><?=lang("submit_as_answered")?></a>
                          <a href="javascript:void(0)" data-url="<?=cn($module."/ajax_change_status/".$ticket->ids)?>" data-status="unread" class="ajaxChangeStatus dropdown-item"><?=lang("mark_as_unread")?></a>
                        </div>

                      </div>
                      <?php }else{?>
                        <span class="btn btn-<?=$button_type?> btn-sm"><?=ticket_status_title($ticket->status)?>
                        </span>
                      <?php }?>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td scope="row"><?=lang("Name")?></td>
                  <td><?=(!empty($ticket->first_name)) ? $ticket->first_name. " ".$ticket->last_name: ""?></td>
                </tr>

                <tr>
                  <td scope="row"><?=lang("Email")?></td>
                  <td><?=(!empty($ticket->user_email)) ? $ticket->user_email: ""?></td>
                </tr>

                <tr>
                  <td scope="row"><?=lang("Created")?></td>
                  <td><?=(!empty($ticket->created)) ? convert_timezone($ticket->created, 'user'): "" ?></td>
                </tr>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-8">
      <div class="card">
        <div class="card-header d-flex align-items-center">
          <h3 class="h4 ticket-title"></i> <?=$ticket->subject?></h3>
        </div>

        <div id="frame">
          <div class="content">
            <div class="messages">
              <ul class="p-l-0">

                <?php
                  if ($ticket->uid == session('uid')) {
                    $messate_type = 'replies';
                  }else{
                    $messate_type = 'sent';
                  }
                  if (get_field(USERS, ['id' => $ticket->uid], "role") == 'user') {
                    $img_url = BASE.'assets/images/client-icon.png';
                  }else{
                    $img_url = BASE.'assets/images/support-icon.png';
                  }
                ?>
                <li class="<?php echo $messate_type; ?>">
                  <img src="<?php echo $img_url; ?>" alt="Ticket icon">
                  <div class="message">
                    <div class="msg-content">
                      <?php
                        if (!empty($ticket->description)) {
                          $desc = str_replace("\n", "<br>", $ticket->description);
                          echo $desc;
                        }else{
                          echo Modules::run("blocks/empty_data");
                        }
                      ?>
                    </div>
                    <div class="msg-footer">
                      <strong><?=(!empty($ticket->first_name)) ? $ticket->first_name. " ".$ticket->last_name: ""?></strong><span class="text-muted small"> <?=(!empty($ticket->created)) ? convert_timezone($ticket->created, 'user'): "" ?></span>
                    </div>
                  </div>
                </li>

                <?php
                  if (!empty($ticket_content)) {
                    foreach ($ticket_content as $key => $row) {
                      if ($row->uid == session('uid')) {
                        $messate_type = 'replies';
                      }else{
                        $messate_type = 'sent';
                      }

                      $is_messaged_user = (get_field(USERS, ['id' => $row->uid], "role") == 'user') ? TRUE : FALSE;
                      if ($is_messaged_user) {
                        $img_url = BASE.'assets/images/client-icon.png';
                      }else{
                        $img_url = BASE.'assets/images/support-icon.png';
                      }
                      
                ?>

                <li class="<?php echo $messate_type; ?> tr_<?=$row->ids?>">
                  <img src="<?php echo $img_url; ?>" alt="Image Icon">
                  <div class="message">
                    <div class="msg-content">
                      <?php
                        if (!empty($row->message)) {
                          $desc = str_replace("\n", "<br>", $row->message);
                          echo $desc;
                        }else{
                          echo Modules::run("blocks/empty_data");
                        }
                      ?>
                    </div>
                    <div class="msg-footer p-t-5">
                      <strong><?=(!empty($row->first_name) ? $row->first_name. " ".$row->last_name: "")?></strong>
                      <span class="text-muted small"> <?=(!empty($row->created)) ? convert_timezone($row->created, 'user'): "" ?>
                      </span>
                      <?php
                        if (!$is_messaged_user && get_role('admin') ) {
                      ?>
                      <a href="<?=cn("$module/ajax_delete_message_item/".$row->ids)?>" class="ajaxDeleteItem btn btn-sm btn-secondary" data-toggle="tooltip" data-placement="bottom"data-original-title="Delete"><i class="fe fe-trash"></i></a>
                      <?php }?>
                    </div>
                  </div>
                </li>     

                <?php }}?>

              </ul>
            </div>
          </div>
        </div>
        <?php
          if (get_role("admin") || get_role("supporter") || $ticket->status == 'pending' || $ticket->status == 'answered') {
        ?>
        <form class="card-body form actionForm m-t-20" action="<?=cn($module."/ajax_update/".$ticket->ids)?>" data-redirect="<?=cn("$module/view/".$ticket->id)?>" method="POST">
          <div class="form-group">
            <label for="userinput8"><?=lang("Message")?></label>
            <textarea rows="10" class="form-control square plugin_editor" name="message" ></textarea>
          </div>
          <button type="submit" class="btn round btn-info btn-min-width mr-1 mb-1"><?=lang("Submit")?></button>
        </form>
        <?php }?>
      </div>
    </div>

  </div>
</section>

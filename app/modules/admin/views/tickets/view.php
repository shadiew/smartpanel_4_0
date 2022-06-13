<?php 
    $item_created  = show_item_datetime($item['created'], 'long');
    $item_status        = show_item_status($controller_name, $item['id'], $item['status'], '');
?>
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h3 class="h4"><i class="fa fa-ticket"></i> Ticket #<?php echo $item['id']; ?></h3>
            </div>
            <div class="card-body">
                <div class="ticket-details">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td scope="row">Status</td><td><?php echo $item_status; ?></td></tr>
                            <tr>
                                <td scope="row">Name</td><td><?php echo $item['first_name'] . ' ' .$item['last_name']; ?></td>
                            </tr>
                            <tr>
                                <td scope="row">E-mail</td><td><?php echo $item['email']; ?></td>
                            </tr>
                            <tr>
                                <td scope="row">Created</td><td><?php echo $item_created; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php
        $form_url     = admin_url($controller_name."/store/");
        $redirect_url = admin_url($controller_name . '/view/') . @$item['id'];
        $form_attributes = ['class' => 'card-body form actionForm m-t-20', 'data-redirect' => $redirect_url, 'method' => "POST"];
        $form_hidden = ['ids' => @$item['ids']];
    ?>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h3 class="h4 ticket-title"><?php echo $item['subject']; ?></h3>
            </div>
            <?php echo form_open($form_url, $form_attributes, $form_hidden); ?>
                <div class="form-group">
                    <label for="userinput8">Message</label>
                    <textarea rows="10" class="form-control" name="message"></textarea>
                </div>
                <button type="submit" class="btn btn-info btn-min-width m-r-5">Submit</button>
                <?php echo show_view_ticket_button_group($controller_name, $item); ?>
            <?php echo form_close(); ?>
            <hr />
            <div id="frame">
                <div class="content">
                    <div class="messages">
                        <ul class="p-l-0">
                            <?php
                                if ($items_ticket_message) {
                                    foreach ($items_ticket_message as $key => $item_message) {
                                        echo show_item_ticket_message_detail($controller_name, $item_message);
                                    }
                                }
                            ?>
                            <?php
                                $item['message'] = $item['description'];
                                unset($item['description']);
                                echo show_item_ticket_message_detail($controller_name, $item);
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

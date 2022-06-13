<?php
    $item_link_detail = cn($controller_name ."/" . $item['id']);
    switch ($item['status']) {
        case 'closed':
            $class_item_status = 'btn-gray-dark';
            break;

        case 'pending':
            $class_item_status = 'btn-info';
            break;

        case 'answered':
            $class_item_status = 'btn-gray';
            break;
        
        default:
            $class_item_status = 'btn-info';
            break;
    }
    $xhtml_item_status = sprintf(
        '<span class="btn %s btn-sm">
            <small>%s</small>
        </span>', $class_item_status, ticket_status_title($item['status'])
    );

    $class_subject = ($item['status'] == "closed") ? "text-muted" : "";
    $xhtml_item_subject = "#" . $item['id']." - ". $item['subject'] . ' ';
    if ($item['user_read']) {
        $xhtml_item_subject .= '<span class="badge badge-warning">'. lang("Unread") .'</span>';
    }
    $xhtml_item_subject_content = sprintf(
        '<div class="content">
            <div class="subject %s">
                %s
            </div>
            <div class="time">
                <small>%s</small>
            </div>
        </div>', $class_subject, $xhtml_item_subject, convert_timezone($item['changed'], 'user')
    );

?>

<div class="item tr_<?=$item['ids']?>">
    <a href="<?php echo $item_link_detail; ?>" class="p-l-5 d-flex text-decoration-none">
        <div class="media-left p-r-10">
            <span class="avatar avatar-md">
                <span class="media-object rounded-circle text-circle text-uppercase <?=$item['status']?> "><i class="fe fe-user"></i></span>
            </span>
        </div>
        <?php echo $xhtml_item_subject_content; ?>
    </a>
    <div class="action item-action dropdown m-t-10">
        <?php echo $xhtml_item_status; ?>
    </div>
    <div class="clearfix"></div>
</div>
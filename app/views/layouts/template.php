<?php
  if (session('uid') && get_role('admin')) {
    require_once 'admin/main.blade.php';
  } elseif(session('uid') && get_role('user')) {
    $user_layout = get_option('user_layout', "horizontal");
    switch ($user_layout) {
      case 'vertical':
        require_once 'user/vertical/main.blade.php';
        break;

      default:
        require_once 'user/horizontal/main.blade.php';
        break;
    }
  }else{
    require_once 'user/horizontal/main.blade.php';
  }
?>
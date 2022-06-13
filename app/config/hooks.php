<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/
$hook['pre_controller'][] = array(  
    'class'    => 'AppSettingClass',
    'function' => 'GetAppSetting',
    'filename' => 'pre_controller.php',
    'filepath' => 'hooks'
);
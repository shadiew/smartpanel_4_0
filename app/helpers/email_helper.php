<?php
if (!function_exists('getEmailTemplate')) {
	function getEmailTemplate($key = ""){
		$result = (object)array();
		$result->subject = '';
		$result->content = '';
		if(!empty($key)){
			switch ($key) {

				case 'payment':
					$result->subject = "{{website_name}} -  Thank You! Deposit Payment Received";
					$result->content = "<p>Hi<strong> {{user_firstname}}! </strong></p><p>We&#39;ve just received your final remittance and would like to thank you. We appreciate your diligence in adding funds to your balance in our service.</p><p>It has been a pleasure doing business with you. We wish you the best of luck.</p><p>Thanks and Best Regards!</p>";
					return $result;
					break;

				case 'verify':
					$result->subject = "{{website_name}} - Please validate your account";
					$result->content = "<p><strong>Welcome to {{website_name}}! </strong></p><p>Hello <strong>{{user_firstname}}</strong>!</p><p> Thank you for joining! We&#39;re glad to have you as community member, and we&#39;re stocked for you to start exploring our service.  If you don&#39;t verify your address, you won&#39;t be able to create a User Account.</p><p>  All you need to do is activate your account by click this link: <br>  {{activation_link}} </p><p>Thanks and Best Regards!</p>";
					return $result;
					break;

				case 'welcome':
					$result->subject = "{{website_name}} - Getting Started with Our Service!";
					$result->content = "<p><strong>Welcome to {{website_name}}! </strong></p><p>Hello <strong>{{user_firstname}}</strong>!</p><p>Congratulations! <br>You have successfully signed up for our service - {{website_name}} with follow data</p><ul><li>Firstname: {{user_firstname}}</li><li>Lastname: {{user_lastname}}</li><li>Email: {{user_email}}</li><li>Timezone: {{user_timezone}}</li></ul><p>We want to exceed your expectations, so please do not hesitate to reach out at any time if you have any questions or concerns. We look to working with you.</p><p>Best Regards,</p>";
					return $result;
					break;

				case 'forgot_password':
					$result->subject = "{{website_name}} - Password Recovery";
					$result->content = "<p>Hi<strong> {{user_firstname}}! </strong></p><p>Somebody (hopefully you) requested a new password for your account. </p><p>No changes have been made to your account yet. <br>You can reset your password by click this link: <br>{{recovery_password_link}}</p><p>If you did not request a password reset, no further action is required. </p><p>Thanks and Best Regards!</p>                ";
					return $result;
					break;

				case 'new_user':
					$result->subject = "{{website_name}} - New Registration";
					$result->content = "<p>Hi Admin!</p><p>Someone signed up in <strong>{{website_name}}</strong> with follow data</p><ul><li>Firstname {{user_firstname}}</li><li>Lastname: {{user_lastname}}</li><li>Email: {{user_email}}</li><li>Timezone: {{user_timezone}}</li></ul> ";
					return $result;
					break;

				case 'order_success':
					$result->subject = "{{website_name}} - New Order";
					$result->content = "<p><strong>Hi Admin!</strong></p><p>Someone have already placed order successfully  in <strong>{{website_name}}</strong> with follow data:</p><ul><li>Email: <strong>{{user_email}}</strong></li><li>OrderID:    <strong>{{order_id}}</strong>  </li><li>Total Charge:  <strong>{{currency_symbol}}{{total_charge}}</strong>    </li></ul>";
					return $result;
					break;

				case 'new_manual_order':
					$result->subject = "{{website_name}} - New Manual Order";
					$result->content = "<p><strong>Hi Admin!</strong></p><p>Someone have already placed order successfully in <strong>{{website_name}}</strong> with manual order:</p><ul><li>Email: <strong>{{user_email}}</strong></li><li>OrderID:    <strong>{{order_id}}</strong>  </li></ul>";
					return $result;
					break;
					
			}
		}
		return $result;
	}
}

/**
 * Replace all merge fields and return the template for email
 * 
 *
 */
if (!function_exists('parse_merge_fields')) {

    function parse_merge_fields($content = '', $merge_fields = '', $replace_main_content = true){
        if ($replace_main_content) {
            $template = file_get_contents(APPPATH.'/libraries/PHPMailer/template.php');
        }else{
            $template = $content;
        }

        $search = array(
            "{{email_content}}" => $content,
            "{{website_logo}}"  => get_option('website_logo', BASE."assets/images/logo.png"),
            "{{website_link}}"  => PATH,
            "{{website_name}}"  => get_option("website_name", "Smartpanel PANEL"),
            "{{copyright}}"     => get_option('copy_right_content',"Copyright &copy; 2020 - SmartPanel"),
        );

        if (is_array($merge_fields)) {
            $search = array_merge($search, $merge_fields);
        }

        foreach ($search as $key => $val) {
            if (strrpos($template, $key) !== false) {
                $template = str_replace($key, $val, $template);
            }
        }
        return $template;
    }
}


?>
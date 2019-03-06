<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function send_email($from, $to, $subject, $content, $reply_to = '', $attact = ''){
	$CI = &get_instance();

	$CI->load->library('email');

    $config = array();

    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'ssl://smtp.googlemail.com';
    $config['smtp_port'] = '465';
    $config['smtp_timeout'] = '30';
    
    if(ENVIRONMENT == 'production'){
	    $config['smtp_user'] = RESERVATION_EMAIL;
	    $config['smtp_pass'] = PASSWORD_EMAIL;
    }else{  // 'testing', 'development'
	    $config['smtp_user'] = RESERVATION_EMAIL_TEST;
	    $config['smtp_pass'] = PASSWORD_EMAIL_TEST;
    }   

    //$config['protocol'] = 'mail';
    $config['charset'] = 'utf-8';
    $config['newline'] = "\r\n";
    $config['mailtype'] = 'html';

    // send to customer
    $CI->email->initialize($config);

    if(ENVIRONMENT == 'production'){
    	$CI->email->from($from, BRANCH_NAME);
    }else{  // 'testing', 'development'
    	$CI->email->from($from, BRANCH_NAME_TEST);
    }

    if (!empty($reply_to)) {
        $CI->email->to($to);
        $CI->email->reply_to($reply_to);
    } else {
        $CI->email->to($to);
    }
    
    $CI->email->subject($subject);

    $CI->email->message($content);

    if (!$CI->email->send()) {
        log_message('error', '[ERROR]Can not send email confirm to ' . $to);
        return false;
    }
    
    return true;
}
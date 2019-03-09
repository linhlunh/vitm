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
if (! function_exists('send_email_bestprice')) {
    function send_email_bestprice($from, $to, $subject, $content, $reply_to = '', $bcc = '', $pdf_name = '', $pdf_voucher = '', $email_send = RESERVATION_EMAIL, $pw_email_send = PASSWORD_EMAIL){

        $CI = &get_instance();
    
        $CI->load->library('email');
    
        $config = array();
    
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.googlemail.com';
        $config['smtp_port'] = '465';
        $config['smtp_timeout'] = '30';
        $config['smtp_user'] = $email_send;
        $config['smtp_pass'] = $pw_email_send;
    
        //$config['protocol'] = 'mail';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $config['mailtype'] = 'html';
    
        // send to customer
        $CI->email->initialize($config);
    
        $CI->email->from($from, BRANCH_NAME);
    
        $CI->email->to($to);
    
        if (!empty($reply_to)){
            $CI->email->reply_to($reply_to);
        }
    
        if (!empty($bcc)){
            $CI->email->bcc($bcc);
        }
    
        $CI->email->subject($subject);
    
        $CI->email->message($content);
    
        if (!empty($pdf_name)){
            $CI->email->attach($pdf_name);
        }
        if(is_array($pdf_voucher)){
            foreach ($pdf_voucher as $key => $value) {
                $CI->email->attach($value);
            }
        }else{
            if (!empty($pdf_voucher)){
                $CI->email->attach($pdf_voucher);
            }
        }
        
    
        $status = $CI->email->send();
    
        if (!$status) {
            log_message('error', '[ERROR]Can not send email to ' . $to);
        }
    
        return $status;
    }
}
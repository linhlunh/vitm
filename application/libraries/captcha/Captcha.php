<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Captcha
{
    public function __construct()
    {
        
        require_once APPPATH.'libraries/captcha/DayyanRandomCharactersClass.php';
        require_once APPPATH.'libraries/captcha/DayyanConfirmImageClass.php';
    }
}
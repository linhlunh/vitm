<?php
/*
Created by Mohammad Dayyan - 1387/3/2
http://www.mds-soft.persianblog.ir/
*/


class DayyanRandomCharacters
{
	private $id;
	private $key_str;
	private $Code;//Orginal string code

////////////////////////////////////////////////////////////////////////////////

	public function __construct()
	{
		$this -> create();
	}

////////////////////////////////////////////////////////////////////////////////

	public function get_code()
	{
		return $this -> Code;
	}

////////////////////////////////////////////////////////////////////////////////

	private function create()
	{
		$string = "";
		$string = md5(rand(0, microtime() * 1000000));
		$this-> id = $this->Code   = substr($string, 3, 6);
		$this-> key_str = md5(rand(0, 999));
	}

////////////////////////////////////////////////////////////////////////////////

	private function get_rnd_iv($iv_len)
	{
	    $iv = '';
	    while ($iv_len-- > 0) {
	        $iv .= chr(mt_rand() &0xff);
	    }
	    return $iv;
	}

////////////////////////////////////////////////////////////////////////////////

	public function get_id()
	{

		return urlencode($this -> md5_encrypt($this->id, $this->key_str));
	}

////////////////////////////////////////////////////////////////////////////////

	public function get_key()
	{
		return $this -> key_str;
	}

////////////////////////////////////////////////////////////////////////////////
	//encrypt id 
	private function md5_encrypt($plain_text, $password, $iv_len = 16)
	{
	    $plain_text .= "x13";
	    $n = strlen($plain_text);
	    if ($n % 16) $plain_text .= str_repeat("0", 16 - ($n % 16));
	    $i = 0;
	    $enc_text = $this -> get_rnd_iv($iv_len);
	    $iv = substr($password ^ $enc_text, 0, 512);
	    while ($i < $n)
		{
	        $block = substr($plain_text, $i, 16) ^ pack('H*', md5($iv));
	        $enc_text .= $block;
	        $iv = substr($block . $iv, 0, 512) ^ $password;
	        $i += 16;
	    }
	    return base64_encode($enc_text);
	}

////////////////////////////////////////////////////////////////////////////////

	public function md5_decrypt($enc_text, $password, $iv_len = 16)
	{
	    $enc_text = base64_decode($enc_text);
	    $n = strlen($enc_text);
	    $i = $iv_len;
	    $plain_text = '';
	    $iv = substr($password ^ substr($enc_text, 0, $iv_len), 0, 512);
	    while ($i < $n)
		{
	        $block = substr($enc_text, $i, 16);
	        $plain_text .= $block ^ pack('H*', md5($iv));
	        $iv = substr($block . $iv, 0, 512) ^ $password;
	        $i += 16;
	    }
	    return preg_replace('/\\x13\\x00*$/', '', $plain_text);
	}
}

?>
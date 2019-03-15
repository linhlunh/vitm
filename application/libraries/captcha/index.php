<?php
/*
Created by Mohammad Dayyan - 1387/3/2
http://www.mds-soft.persianblog.ir/
*/

try
{
	include_once("DayyanConfirmImageClass.php");
	include_once("DayyanRandomCharactersClass.php");

	$id = (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) ? trim($_REQUEST['id']) : exit;
	$key = (isset($_REQUEST['key']) && !empty($_REQUEST['key'])) ? trim($_REQUEST['key']) : exit;

	$DayyanRandomCharacters = new DayyanRandomCharacters();
	$ConfirmString = strtoupper($DayyanRandomCharacters -> md5_decrypt($id, $key));

	$DayyanConfirmImage = new DayyanConfirmImage($ConfirmString);
	$DayyanConfirmImage -> ShowImage();
}
catch(Exception $ex)
{
	echo 'Caught exception: ',  $ex -> getMessage(), "<br />\n";
	exit;
}


?>
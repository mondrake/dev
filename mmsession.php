<?php // mmsession.php
session_start();

include_once('/home/mondrak1/private/mondrakeNG/src/mm/MM_settings.php');

$appName = 'mondrake';

function sanitizeString($var)	{
	$var = strip_tags($var);
	$var = htmlentities($var);
	$var = stripslashes($var);
//	return MMDb::escape($var);
	return $var;
}

function destroySession()	{
	$_SESSION = array();
	if (session_id() != "" || isset($_COOKIE[session_name()]))
	    setcookie(session_name(), '', 0, '/');
	session_destroy();
}

?>

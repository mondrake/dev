<?php // mmlogout.php
require_once 'mmsession.php';

use mondrakeNG\mm\classes\MMUser;
use mondrakeNG\mm\classes\MMUserLogin;

require_once 'mmexchdl.php';

if (isset($_SESSION['mmToken']))	{
	$ulo = new MMUserLogin;
	$res = $ulo->readToken($_SESSION['mmToken']);
	if(is_null($res))	{
		// todo: logout/delete session first?

		header("Location: index.php?appenv=$appEnv"); die;
	}
	$user = new MMUSer;
	$user->read($ulo->user_id);
	$user->setSessionContext(array( 	'user' => $ulo->user_id, 
										'environment' => $ulo->environment_id, 
										'client' => $ulo->client_id,));

	$res = $ulo->removeUserLogin($_SESSION['mmToken']);

	if ($res) {
		setcookie('mmToken', $ck, 0);
		destroySession();
		$_SESSION[mmToken] = NULL;
//		$_SESSION[mmAppEnv] = NULL;
	}

	echo "<html><head><title>$appName ($_SESSION[mmAppEnv])";

	echo "</title></head><body><font face='verdana' size='2'>";
	echo "<b>$appName ($_SESSION[mmAppEnv])</b> ";

	echo "<font face='verdana'><h2>Log out</h2>";
	echo "You have been logged out. Please <a href='index.php?appenv=$_SESSION[mmAppEnv]'>click here</a> to refresh the screen.";
}
else 
	echo "You are not logged in";
?>

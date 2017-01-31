<?php // mmauth.php
require_once 'mmsession.php';
				
use mondrakeNG\mm\classes\MMUser;
use mondrakeNG\mm\classes\MMUserLogin;

require_once 'mmexchdl.php';


// get appenv
$appEnv = NULL;
if (isset($_GET['appenv']))
	$appEnv = $_GET['appenv'];
else if (isset($_POST['appenv']))
	$appEnv = $_POST['appenv'];
if(!$appEnv)
	die("Missing parameter.");

// session already authenticated, go to mmmain
if (isset($_SESSION['mmToken']))	{
	$_SESSION['mmAppEnv'] = $appEnv;
	header("Location: mmmain.php");
	die;
}

// authentication required
$mmUserLogin = new MMUserLogin;
$authParms = array();
$authParms['mmTokenSecsToExpiration'] = 8*24*3600; 
$authParms['mmClient'] = 3;

// authentication via cookie
if (isset($_COOKIE['mmToken']))	{
	$mmToken = $_COOKIE['mmToken'];
	$authParms['mmToken'] = $mmToken;
//	MMDb::beginTransaction();
	$res = $mmUserLogin->userAuthenticate($authParms);
//	MMDb::commit();
	if ($res == TRUE) {
		$_SESSION['mmAppEnv'] = $appEnv;
		$_SESSION['mmToken'] = $mmToken;
		setcookie("mmToken", $mmToken, strtotime($authParms['mmTokenExpirationTs']));
		header("Location: mmmain.php");
		die;
	}
	else	{
		$error = $authParms[authMsg]; 
	}
}

// authentication via login
if (isset($_POST['mmUser']))	{
	$user = sanitizeString($_POST['mmUser']);
	$pass = sanitizeString($_POST['mmPass']);

	if ($user == "" || $pass == "")	{
		$error[] = "Not all fields were entered";
	}
	else	{
		$authParms['mmLoginUser'] = $user;
		$authParms['mmLoginPass'] = $pass;
//		MMDb::beginTransaction();
		$res = $mmUserLogin->userAuthenticate($authParms);
//		MMDb::commit();
		if ($res == TRUE) {
			$_SESSION['mmAppEnv'] = $appEnv;
			$_SESSION['mmToken'] = $authParms['mmToken'];
			setcookie("mmToken", $authParms['mmToken'], strtotime($authParms[mmTokenExpirationTs]));
			header("Location: mmmain.php");
			die;
		}
		else	{
			$error = $authParms['authMsg'];
		}
	}
}
else	{
	$error = array("");
	$user = $pass = "";
}

echo <<<_END
<html>
	<style>
		.login { border: 1px solid #999999; font: normal 14px verdana; color:#444444; }
		.apptop { font: normal 20px verdana;  }
	</style>

	<head><title>$appName</title></head>
	<body>
		<table class="apptop" border="0" cellpadding="2" cellspacing="5">
			<th>$appName ($appEnv)</th>
		</table>
		<form method='post' action='mmauth.php'>
_END;

foreach($error as $a) print "$a<br/>";

echo <<<_END
			<input type='hidden' name='appenv' value='$appEnv'/>
			<table class="login" border="0" cellpadding="2" cellspacing="5" bgcolor="#eeeeee">
				<tr><td colspan="2" align="center">Login</td></tr>
				<tr><td>Username</td><td><input type='text' maxlength='16' name='mmUser' value='$user' /></td></tr>
				<tr><td>Password</td><td><input type='password' maxlength='16' name='mmPass' value='$pass' /></td></tr>
				<tr><td	colspan="2" align="center"><input type='submit' value='Login' /></td></tr>
			</table>
		</form>
	</body>
</form>
_END;
?>

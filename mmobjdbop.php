<?php // mmobjdbop.php
require '/home/mondrak1/private/mondrakeNG/vendor/autoload.php';

use mondrakeNG\mm\classes\MMUser;
use mondrakeNG\mm\classes\MMUserLogin;

require_once 'mmsession.php';
require_once 'mmexchdl.php';

if (isset($_SESSION['mmToken']))	{
	$ulo = new MMUserLogin;
	$ulo->readToken($_SESSION['mmToken']);

	$user = new MMUSer; 
	$user->read($ulo->user_id);
	$currEnvId = $user->currentEnvironmentId;
	$currEnvDesc = isset($user->currentEnvironment->description) ? $user->currentEnvironment->description : NULL;
	$user->setSessionContext(array( 	'user' => $ulo->user_id, 
										'environment' => $ulo->environment_id, 
										'client' => $ulo->client_id,)); 
}
else {
	header("Location: index.php"); die;
}

if (!isset($_POST['obj']))
	die("Missing parameter.");

$objName = $_POST['obj'];
$obj = new $objName;

// delete object
if($_POST['mmaction'] == 'Del') 	{
	$primaryKey = $_POST['primaryKey'];
	$obj->read(base64_decode($primaryKey));
	$ret = $obj->delete();
	header("Location: $_POST[referer]");
	die;
}

$colDets = $obj->getColumnProperties();

// add object
if($_POST['mmaction'] == 'Add') 	{
	foreach ($colDets as $a => $b)	{
		switch ($b['type'])	{
			case 'boolean':
				$obj->$a = $_POST[$a];
				if (is_null($obj->$a) or $obj->$a == 0)
					$obj->$a = 0;
				else
					$obj->$a = 1;
				break;
			default:
				if (isset($_POST[$a]) ) {
					$obj->$a = stripslashes($_POST[$a]);
			}
		}
	}
//	try	{
		$ret = $obj->create();
		header("Location: $_POST[referer]");
		die;
/*	}
	catch(Exception $e){
		$errMsg = $e->getCode() . ' - ' . $e->getMessage();
		$obj = new MMUser;
		foreach ($obj->getLog() as $msg)	{
			$errMsg .= "<br/>$msg->text";
		}
		echo "Err: $errMsg";
		die;
	}*/
}


if (!isset($_POST['obj']) or !isset($_POST['primaryKey']))
	die("<br /><br />Missing parameter.");
else	{
	$primaryKey = $_POST['primaryKey'];
	$obj->read(base64_decode($primaryKey));

	foreach ($colDets as $a => $b)	{
		switch ($b['type'])	{
			case 'boolean':
				$obj->$a = $_POST[$a];
				if (is_null($obj->$a) or $obj->$a == 0)
					$obj->$a = 0;
				else
					$obj->$a = 1;
				break;
			default:
				if (isset($_POST[$a]) ) {
					$obj->$a = stripslashes($_POST[$a]);
			}
		}
	}
//	try	{
		$ret = $obj->update();
		header("Location: $_POST[referer]");
		die;
/*	}
	catch(Exception $e){
		$errMsg = 'Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage(). '<br/><br/>';
		echo $errMsg;
		$obj = new MMUser;
		foreach ($obj->getLog() as $msg)	{
			echo "$msg->className - $msg->severity - [$msg->id] - $msg->fullText <br/>";
		}
		echo '<br/><br/>';
		$trace = $e->getTrace();
		print_r($trace);
		die;
	}*/
}
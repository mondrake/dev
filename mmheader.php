<?php // mmheader.php
require '/home/mondrak1/private/mondrakeNG/vendor/autoload.php';

use mondrakeNG\dbol\DbConnection;
use mondrakeNG\mm\classes\MMUser;
use mondrakeNG\mm\classes\MMUserLogin;

require_once 'mmsession.php';
require_once 'mmexchdl.php';

if (isset($_SESSION['mmToken']))	{ 
	$ulo = new MMUserLogin;
	$res = $ulo->readToken($_SESSION['mmToken']);
	if(is_null($res))	{
		// todo: logout/delete session first?
		header("Location: index.php?appenv={$_SESSION['mmAppEnv']}"); die;
	}
	$user = new MMUSer;
	$user->read($ulo->user_id);
	$currEnvId = $user->currentEnvironmentId;
	$currEnvDesc = $user->currentEnvironment->environment_short . ' ' . $user->currentEnvironment->environment_desc;
	$DBALVersion = DbConnection::getDBALVersion() . '/' . DbConnection::getDBALDriver('MM') . '/' . DbConnection::getDbServerName('MM') . '/' . DbConnection::getDbServerVersion('MM');
	$user->setSessionContext(array( 	'user' => $ulo->user_id, 
										'environment' => $ulo->environment_id, 
										'client' => $ulo->client_id,));
}
else {
	header("Location: index.php?appenv={$_SESSION['mmAppEnv']}"); die;
}
header('Content-Type: text/html; charset=utf-8');

echo "<html><head><title>$appName ({$_SESSION['mmAppEnv']})";

echo "</title></head><body><font face='verdana' size='2'>";
echo "<b>$appName ({$_SESSION['mmAppEnv']})</b> ";

if ($_SESSION['mmAppEnv'] == 'dev01')	{
	echo "| User: $user->name $user->surname | Environment: $currEnvDesc | 
			 <a href='mmmain.php'>Main</a> |
			 <a href='mmobjbrowser.php'>Object browser</a> |
			 <a href='mmrefresh.php'>Refresh</a> |
			 <a href='testxyxy.php'>Test script</a> |
			 <a href='mmrunsql.php'>SQL deck</a> |
			 <a href='services/cash07_svr.php'>XML-RPC</a> |
			 <a href='dpobjbrowser.php'>Drupal browser</a> |
			 <a href='dpbcap.php'>Browscap</a> |
			 <a href='mmlogout.php'>Log out</a> | DBAL: $DBALVersion<br /><br />";
}

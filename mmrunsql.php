<?php // mmrunsql.php

use mondrakeNG\mm\classes\MMUser;

require_once 'mmheader.php';

if (!isset($_POST['sqlstmt']))
	$sqlq = null;
else
	$sqlq = stripslashes($_POST['sqlstmt']);

$retTo = $_SERVER['HTTP_REFERER'];

if (!is_null($sqlq))	{
	try	{
		$obj = new MMUser;
		$rows = $obj->query($sqlq);
	}
	catch(Exception $e){
		$errMsg = $e->getCode() . ' - ' . $e->getMessage();
		$obj = new MMUser;
		foreach ($obj->getLog() as $msg)	{
			$errMsg .= "<br/>$msg->text";
		}
	}
}
echo <<<_END

<!-- The HTML section -->

<style>.signup { border: 1px solid #999999;
	font: normal 12px verdana; color:#444444; }</style>
<style>.signup1 { border: 1px solid #999999;
	font: normal 10px verdana; color:#444444; }</style>
</head><body>

<form method='post' action='mmrunsql.php'>
	<table class="signup" >
		<tr>
			<td>SQL:</td>
			<td><textarea class='signup' name='sqlstmt' cols='180' rows='15'>$sqlq</textarea></td>
		</tr>
		<tr>
			<td/><td><input type='submit' value='Execute' /></td>
		</tr>
_END;

if(!is_null($errMsg))	{
echo"   <tr>
			<td>Err:</td>
			<td>$errMsg</td>
		</tr>";
}

echo "</table></form><table class='signup1' border=1 cellpadding='2' cellspacing='0' bgcolor='#eeeeee'>";

echo "<tr><td/>";
foreach ($rows[0] as $a => $b) {
	echo "<td>$a</td>";  
} 
echo "</tr>";
$j = 1;
foreach ($rows as $a => $b) {
	echo "<tr><td><b>$j</b></td>";
	foreach ($b as $c => $d)	{
		echo "<td>$d</td>";
	}
	echo "</tr>";	
	$j++;
}

echo <<<_END
</table>
_END;


?>
<?php // mmobjedit.php

use mondrakeNG\mm\classes\MMClass;

require_once 'mmheader.php';

if (!isset($_GET['obj']))
	die("<br /><br />Missing parameter.");

$objName = $_GET['obj'];

$cls = new MMClass;
$cls->read($objName);

$obj = new $objName;
$colDets = $obj->getColumnProperties();

if (isset($_GET['view']))	{
	$primaryKey = $_GET['view'];
	$obj->read(base64_decode($primaryKey));
}

$retTo = $_SERVER['HTTP_REFERER'];

echo <<<_END

<!-- The HTML section -->

<style>.signup { border: 1px solid #999999;
	font: normal 12px verdana; color:#444444; }</style>
</head><body>

<form method='post' action='mmobjdbop.php'>
	<table>
		<td>$cls->mm_class_desc</td>
		<td>
			<input type='submit' value='Delete' />
			<input type='hidden' name='obj' value='$objName'/>
			<input type='hidden' name='mmaction' value='Del'/>
			<input type='hidden' name='primaryKey' value='$primaryKey'/>
			<input type='hidden' name='referer' value='$retTo'/>
		</td>
	</table>
</form>

<table class="signup" border="0" cellpadding="2" cellspacing="2" bgcolor="#eeeeee">
	<form method='post' action='mmobjdbop.php'>
		<input type='hidden' name='obj' value='$objName'/>
		<input type='hidden' name='primaryKey' value='$primaryKey'/>
		<input type='hidden' name='referer' value='$retTo'/>

_END;

if ($_GET['mmaction'] == 'Update')
	echo"<input type='hidden' name='mmaction' value='Upd'/>";
else
	echo"<input type='hidden' name='mmaction' value='Add'/>";

foreach ($colDets as $a => $b)	{
	$tmp = $obj->$a;
	echo "<tr><td>$a</td>";
	switch ($b['type'])	{
		case 'boolean':
			echo "<td>{$b['type']}</td>";
			if ($b['editable'])	{
				if ($obj->$a) $isChecked = 'checked'; else $isChecked = '';
				echo "<td><input type='checkbox' name='$a' value='1' $isChecked/></td>";
			}
			else	{
				echo "<td>$tmp</td>";
			}
			break;
		case 'integer':
		case 'time':
		case 'date':
			echo "<td>{$b['type']}</td>";
			if ($b['editable'])	{
				echo "<td><input class='signup' type='text' size='12' name='$a' value='$tmp' /></td>";
			}
			else	{
				echo "<td>$tmp</td>";
			}
			break;
		case 'timestamp':
			echo "<td>{$b['type']}</td>";
			if ($b['editable'])	{
				echo "<td><input class='signup' type='text' size='22' name='$a' value='$tmp' /></td>";
			}
			else	{
				echo "<td>$tmp</td>";
			}
			break; 
		case 'text':
			if ($b['editable'])	{
				if($b['length']) {
					$size = ($b['length'] > 60) ? 60 : $b['length'];
					echo "<td>{$b['type']}/{$b['length']}</td>";
					echo "<td><input class='signup' type='text' size='$size' maxlength='{$b['length']}' name='$a' value='$tmp' /></td>";
				}
				else	{
					echo "<td>{$b['type']}</td>";
					echo "<td><textarea class='signup' name='$a' cols='100' rows='15'>$tmp</textarea></td>";
				}
			}
			else	{
				echo "<td>{$b['type']}</td><td>$tmp</td>";
			}
			break;
		default:
			echo "<td>{$b['type']}/{$b['length']}</td>";
			if ($b['editable'])	{
				$size = ($b['length'] > 60) ? 60 : $b['length'];
				echo "<td><input class='signup' type='text' size='$size' maxlength='{$b['length']}' name='$a' value='$tmp' /></td>";
			}
			else	{
				echo "<td>$tmp</td>";
			}
	}
	echo"</tr>";
}

echo <<<_END

</tr><tr><td colspan="3" align="center">
	<input type="submit" value='{$_GET['mmaction']}' />
</tr></form></table>
	
_END;
?>
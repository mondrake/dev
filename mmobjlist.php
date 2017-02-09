<?php // mmobjlist.php

use mondrakeNG\mm\classes\MMClass;

require_once 'mmheader.php';

if (!isset($_GET['obj']))
	die("Missing parameter.");

$objName = $_GET['obj'];

$cls = new MMClass;
$cls->read($objName);

$obj = new $objName;
$colDets = $obj->getColumnProperties();
$objs = $obj->listAll(NULL, 1000, NULL);

echo <<<_END
<!-- The HTML section -->

<form method='post' action='mmobjedit.php?obj=$objName&mmaction=Add'>
	<table>
		<td>$cls->mm_class_desc_plural</td>
		<td><input type='submit' value='Add record' /></td>
	</table>
</form>

<style>.signup { border: 1px solid #999999;
	font: normal 10px verdana; color:#444444; }</style>
<style>.vertical 
{
				/* IE-only DX filter */
			writing-mode: tb-rl;
			filter: flipv fliph;
			
			/* Safari/Chrome function */
			-webkit-transform: rotate(270deg);
			
			
			-moz-transform: rotate(270deg);
}
</style>
</head><body>
<table class="signup" border="1" cellpadding="2"
	cellspacing="0" bgcolor="#eeeeee">
	
_END;

echo "<tr><td />";
foreach ($colDets as $c => $d)	{
	if (strlen($c) > 20)
		$colName = substr($c, 0, 18) . '..';
	else
		$colName = $c;
//	echo "<td class='vertical'>$colName</td>";
	echo "<td><img src='" . TEXTIMAGE_URL . "/$c.png' alt='$c'/></td>";
}
echo "</tr>";
$j = 1;
foreach ($objs as $a => $b) {
	$enc = base64_encode($b->primaryKeyString);
	echo "<tr><td><b><a href='mmobjedit.php?obj=$objName&mmaction=Update&view=$enc'>$j</a></b></td>";
	foreach ($colDets as $c => $d)	{
		$tmp = $b->$c;
		echo "<td>$tmp</td>";
	}
	echo "</tr>";	
	$j++;
}


?>

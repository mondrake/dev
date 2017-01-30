<?php 
require_once 'mmheader.php';
require_once 'DP_settings.php';

use mondrakeNG\dbol\DbConnection;

$tables = DbConnection::fetchAllTables(DBOL_CONNECTION_NAME);

echo <<<_END

<!-- The HTML section -->

<style>.signup { border: 1px solid #999999;
	font: normal 10px verdana; color:#444444; }</style>
</head><body>
<table class="signup" border="1" cellpadding="2"
	cellspacing="0" bgcolor="#eeeeee">
	
_END;

echo "<tr><td />";
echo "<td>Table</td>";
echo "<td>Description</td>";
echo "<td>Rows</td>";
echo "<td>Collation</td>";
echo "<td>Engine</td>";
echo "</tr>";

$j = 1;
foreach ($tables as $a => $b) {
	echo "<tr><td>$j</td>";
	echo "<td><b><a href='dpobjlist.php?obj=$a'>$a</a></b></td>";
	echo "<td>$b[description]</td>";
	echo "<td>$b[rows]</td>";
	echo "<td>$b[collation]</td>";
	echo "<td>$b[storageMethod]</td>";
	echo "</tr>";	
	$j++;
}

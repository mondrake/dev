<?php // mmobjbrowser.php

use mondrakeNG\mm\classes\MMClass;

require_once 'mmheader.php';

$obj = new MMClass;

$colDets = $obj->getColumnProperties();
$objs = $obj->listAll(NULL, NULL, NULL);

echo <<<_END

<!-- The HTML section -->

<style>.signup { border: 1px solid #999999;
	font: normal 10px verdana; color:#444444; }</style>
</head><body>
<table class="signup" border="1" cellpadding="2"
	cellspacing="0" bgcolor="#eeeeee">
	
_END;

echo "<tr><td />";
echo "<td>Class</td>";
echo "<td>Description</td>";
echo "<td>DB Table</td>";
echo "</tr>";

$j = 1;
foreach ($objs as $a => $b) {
	echo "<tr><td>$j</td>";
	echo "<td><b><a href='mmobjlist.php?obj=$b->mm_class_name'>$b->mm_class_name</a></b></td>";
	echo "<td>$b->mm_class_desc_plural</td>";
	echo "<td>$b->db_table_name</td>";
	echo "</tr>";	
	$j++;
}


?>

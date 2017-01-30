<?php // mmrefresh.php

use mondrakeNG\mm\core\MMDiag;
use mondrakeNG\mm\classes\MMEnvironment;

require_once 'mmheader.php';

$env = new MMEnvironment;
$env->read($user->currentEnvironmentId);
$ret = $env->updateBalances(true);

//print_r($ret); 
//foreach ($env->getLog() as $msg)	{
//	print $msg->time . ' ' . $msg->fullText . "<br/>";
//}

echo <<<_END

<!-- The HTML section -->

<style>.signup { border: 1px solid #999999;
	font: normal 12px verdana; color:#444444; }</style>
</head><body>
<table class="signup" border="1" cellpadding="2"
	cellspacing="0" bgcolor="#eeeeee">

<tr>
	<th>Class</th>
	<th>Time</th>
	<th>Severity</th>
	<th>Id</th>
	<th>Message</th>
	<th>Elapsed</th>
</tr>
	
_END;

	$obj = new MMDiag;
	foreach ($env->getLog() as $msg)	{
		echo "<tr>";
		echo "<td>$msg->className</td>";
		echo "<td>$msg->time</td>";
		echo "<td align=center><img src='resources/$msg->severity.png' alt='$msg->severity'/></td>";
		echo "<td>$msg->id</td>";
		echo "<td>$msg->fullText</td>";
        $roundElapsed = $msg->elapsed ? round($msg->elapsed, 5) : '-';
		echo "<td>$roundElapsed</td>";
		echo "</tr>";	
	}

	echo <<<_END

</table><br/><br/>
_END;

die("Done.");



<?php // mmexchdl.php

use mondrakeNG\mm\core\MMDiag;

function exception_handler($exception) {
	$errMsg = 'Code: ' . $exception->getCode() . ' - Message: ' . $exception->getMessage(). '<br/><br/>';
	echo $errMsg;

	echo <<<_END

<!-- The HTML section -->

<style>.signup { border: 1px solid #999999;
	font: normal 10px verdana; color:#444444; }</style>
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
	foreach ($obj->get() as $msg)	{
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
<table class="signup" border="1" cellpadding="2"
	cellspacing="0" bgcolor="#eeeeee">
<tr>
	<th>#</th>
	<th>Function</th>
	<th>File</th>
	<th>Line</th>
	<th>Args</th>
</tr>
	
_END;
	
	$trace = $exception->getTrace();
	foreach ($trace as $n => $msg)	{
//print_r($msg);	
//		echo "$msg->className - $msg->severity - [$msg->id] - $msg->fullText <br/>";
		echo "<tr>";
		echo "<td>$n</td>";
		echo "<td>$msg[class]$msg[type]$msg[function]</td>";
//		echo "<td>$msg[type]</td>";
//		echo "<td>$msg[function]</td>";
		echo "<td>$msg[file]</td>";
		echo "<td>$msg[line]</td>";
		echo "<td>.</td>";
		echo "</tr>";	
	}
//	print_r($trace);
	die;
//  echo "Uncaught exception: " , $exception->getMessage(), "\n";
}

set_exception_handler('exception_handler');

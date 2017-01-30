<?php // mmaccbalperiods.php

use mondrakeNG\mm\classes\AXAccountPeriodBalance;
use mondrakeNG\mm\classes\AXAccount;

require_once 'mmheader.php';

if (!isset($_GET['acc']))
	die("Missing parameter.");

$acc = $_GET['acc'];

$account = new AXAccount;
$account->read($acc);

$obj = new AXAccountPeriodBalance;
$colDets = $obj->getColumnProperties();
$objs = $obj->readMulti("account_id = $acc", "period_year desc, period desc");

echo <<<_END
<!-- The HTML section -->

<table>
	<td>$account->account_short - $account->account_desc</td>
	<tr/><tr/><tr/>
</table>

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

echo "<tr>";
echo "<td>Year</td>";
echo "<td>Period</td>";
echo "<td align=right>Opening</td>";
echo "<td align=right>+</td>";
echo "<td align=right>-</td>";
echo "<td align=right><b>Period</b></td>";
echo "<td align=right><b>Current</b></td>";
echo "<td align=right>uv Opening</td>";
echo "<td align=right>uv +</td>";
echo "<td align=right>uv -</td>";
echo "<td align=right><b>uv Period</b></td>";
echo "<td align=right><b>uv Current</b></td>";
echo "<td align=right>Period avg</td>";
echo "</tr>";

foreach ($objs as $a => $b) {
	echo "<tr>";
	echo "<td>$b->period_year</td>";
	echo "<td>$b->period</td>";
	echo "<td align=right>";echo(round($b->period_opening_balance,2));echo"</td>";
	echo "<td align=right>";echo(round($b->period_dt_amount,2));echo"</td>";
	echo "<td align=right>";echo(round($b->period_ct_amount,2));echo"</td>";
	echo "<td align=right><b>";echo(round($b->period_balance,2));echo"</b></td>";
	echo "<td align=right><b>";echo(round($b->period_closing_balance,2));echo"</b></td>";
	echo "<td align=right>";echo(round($b->period_uv_opening_balance,2));echo"</td>";
	echo "<td align=right>";echo(round($b->period_uv_dt_amount,2));echo"</td>";
	echo "<td align=right>";echo(round($b->period_uv_ct_amount,2));echo"</td>";
	echo "<td align=right><b>";echo(round($b->period_uv_balance,2));echo"</b></td>";
	echo "<td align=right><b>";echo(round($b->period_uv_closing_balance,2));echo"</b></td>";
	if ($account->accountClass->is_daily_balance_req)	{
		echo "<td align=right>";echo(round($b->period_avg_balance,2));echo"</td>";
	}
	else
		echo "<td/>";
	echo "</tr>";	
}
?>

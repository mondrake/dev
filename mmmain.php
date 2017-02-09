<?php // mmmain.php

use mondrakeNG\mm\classes\MMEnvironment;

require_once 'mmheader.php';

$env = new MMEnvironment;
$env->read($user->currentEnvironmentId); 
//print_r($env);die;
$env->loadAccounts();
$env->loadAccountStats();

echo <<<_END

<!-- The HTML section -->

<style>.signup { border: 1px solid #999999;
	font: normal 10px verdana; color:#444444; }</style>
<style>.redcell { border: 1px solid #999999;
	font: normal 10px verdana; color:red; }</style>
</head><body>

<!-- Main Table(You can define padding accordingly) -->
<table width="100%" border="0" cellspacing="0" cellpadding="5">
<tr>

_END;
 

$aCCuT = null;
$aCCuTy = null;
$isFirstPane = true;
foreach($env->accounts as $a => $acc)	{

	$ac = $acc->accountClass;
	$as = $acc->accountStats;

	if ($aCCuTy <> $ac->account_class_type)	{
		if(!$isFirstPane)
			echo "</table></td>";
			if ($ac->account_class_type == 'G') die;
		else
			$isFirstPane = false;
		echo <<<_END
		<td width="50%" valign="top">
		<table class="signup" border="1" cellpadding="2"
			cellspacing="0" bgcolor="#eeeeee">
		<tr>
		<td>Key</td>
		<td>Description</td>
		<td align=right>Opening</td>
		<td align=right>+</td>
		<td align=right>-</td>
		<td align=right>Period</td>
		<td align=right><b>Current</b></td>
		<td align=right><b>Curr.non v</b></td>
		<td align=right><b>Future</b></td>
		</tr>

_END;
		$aCCuTy = $ac->account_class_type;
	}
 
	if($aCCuT <> $ac->account_class_desc) {
		echo "<tr><td colspan=9><b>$ac->account_class_desc</b></td></tr>";
		$aCCuT = $ac->account_class_desc;
	} 
	if ($acc->accountCtl->is_balance_calc_req )
		$c = "redcell";
	else
		$c = "signup";
	echo "<tr class=$c>";
	echo "<td><a href='mmaccbalperiods.php?acc=$acc->account_id&period_type=1'>$acc->account_short</a></td>";
	echo "<td>$acc->account_desc</td>";
	if ($ac->account_class_type == 'F')		{
		echo "<td align=right>";echo(round($as->period_opening_balance,2));echo"</td>";
		echo "<td align=right>";echo(round($as->period_dt_amount,2));echo"</td>";
		echo "<td align=right>";echo(round($as->period_ct_amount,2));echo"</td>";
		echo "<td align=right>";echo(round($as->period_balance,2));echo"</td>";
		echo "<td align=right><b>";echo(round($as->period_closing_balance,2));echo"</b></td>";
		if ($acc->is_validation_req)	{
			echo "<td align=right><b>";echo(round($as->period_uv_closing_balance,2));echo"</b></td>";
		}
		else
			echo "<td/>";
		echo "<td align=right><b>";echo(round($as->period_future_balance,2));echo"</b></td>";
	}
	if ($ac->account_class_type == 'E')		{
		echo "<td/>";
		echo "<td align=right>";echo(round($as->period_dt_amount,2));echo"</td>";
		echo "<td align=right>";echo(round($as->period_ct_amount,2));echo"</td>";
		echo "<td align=right><b>";echo(round($as->period_balance,2));echo"</b></td>";
		echo "<td/>";
		if ($acc->is_validation_req)	{
			echo "<td align=right><b>";echo(round($as->period_uv_balance,2));echo"</b></td>";
		}
		else
			echo "<td/>";
		echo "<td align=right><b>";echo(round($as->period_future_balance,2));echo"</b></td>";
	}
	echo "</tr>";	
}


?>

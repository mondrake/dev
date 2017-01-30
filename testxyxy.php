<?php

use mondrakeNG\mm\core\MMUtils;

include_once 'mmheader.php';

//include_once 'epavl.php';
//include_once 'epavl_utils.php';

require_once 'MMClass.php';
require_once 'MMUser.php';
require_once 'MMSetting.php';
require_once 'MMSettingValue.php'; 
require_once 'MMEnvironment.php';
require_once 'AMPeriod.php';
require_once 'AMPeriodDate.php';
//require_once 'MMCountry.php';
require_once 'AXDoc.php';
require_once 'AXDocItem.php';
require_once 'AXAccountDailyBalance.php';
require_once 'AXAccountPeriodBalance.php';
require_once 'AXAccount.php';
require_once 'AXPortfolio.php';
require_once 'AXAccountCtl.php';
require_once 'MMSqlStatement.php';


echo"<font face='verdana' size='1'>";

chdir('/home3/mondrak1/public_html/lab05/core');
$rtn = shell_exec("php core/scripts/run-tests.php PHPUnit");
echo"$rtn";

die("<br /><br />Nothing else.");


$rtn = "";
//chdir('/home3/mondrak1/public_html/lab05/core');
$cmd = './vendor/bin/phpunit --version';
//$cmd = 'ls ./vendor/bin';
$cmd = 'ls';

$p = proc_open(@$cmd, array(1 => array('pipe', 'w'), 2 => array('pipe', 'w')), $io);

// Read output sent to stdout.
while (!feof($io[1])) {
  $rtn .= htmlspecialchars(fgets($io[1]), ENT_COMPAT, 'UTF-8');
}
// Read output sent to stderr.
while (!feof($io[2])) {
  $rtn .= htmlspecialchars(fgets($io[2]), ENT_COMPAT, 'UTF-8');
}

fclose($io[1]);
fclose($io[2]);
proc_close($p);
echo"$rtn";

// ------------------------------------------------------------------
//  dates
// ------------------------------------------------------------------
//date_default_timezone_set ('UTC');

/*$dt = strtotime('2002-12-29');
list($dd, $pPeriod, $pYear) = explode(' ', date('Y-m-d W o', $dt));

$dt = strtotime('2002-12-30');
list($dd, $period, $year) = explode(' ', date('Y-m-d W o', $dt));
$iPeriod = null;
while ($dd < '2016-09-01') {
    if (!$iPeriod or $iPeriod <> $period) {
        if ($per) {
            $per->last_period_date = $lDate;
            $per->next_period_seq = $year . $period;
            print_r($per);print("<br/>");
            $per->create();
            $pYear = $lYear;
            $pPeriod = $lPeriod;
        }
        $per = new AMPeriod;
        $per->period_type_id = 3;
        $per->period_year = $year;
        $per->period = $period;
        $per->period_seq = $year . $period;
        $per->prev_period_seq = $pYear . $pPeriod;
        $per->first_period_date = $dd;
        $iPeriod = $period;
    }
    $lDate = $dd;
    $lYear = $year;
    $lPeriod = $period;
    $dt += 3600*24;
    list($dd, $period, $year) = explode(' ', date('Y-m-d W o', $dt));
}*/

/*$per = new AMPeriod;
$mx = $per->listAll('period_type_id = 3');
foreach($mx as $period) {
    $dd = $period->first_period_date;
    while ($dd <= $period->last_period_date) {
        $date = new AMPeriodDate;
        $date->period_type_id = 3;
        $date->period_year = $period->period_year;
        $date->period = $period->period;
        $date->period_date = $dd;
        $dd = MMUtils::dateOffset($dd, +1);
        $date->create();
        print_r($date);print("<br/>");
    }
}

die;*/

// ------------------------------------------------------------------
//  new account balance process
// ------------------------------------------------------------------
/*$env = new MMEnvironment(1);
$env->read();
$acc = new AXAccount(4);
$x = $acc->read();
if($x) {
    $acc->updateBalance($env, '2011-11-25', '2041-11-25', 3);
}

die;*/

// ------------------------------------------------------------------
// jQuery
// ------------------------------------------------------------------
/*echo  <<<_END
<script src="http://mondrake.org/lab02/sites/all/modules/jquery_update/replace/jquery/jquery.min.js"></script>
<script src="http://mondrake.org/lab02/sites/all/modules/custom/mondrake/jquery.tablednd_0_5.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    // Initialise the table
    $("#table-1").tableDnD();
});
</script>

<table id="table-1" cellspacing="0" cellpadding="2">
    <tr id="1"><td>1</td><td>One</td><td>some text</td></tr>
    <tr id="2"><td>2</td><td>Two</td><td>some text</td></tr>
    <tr id="3"><td>3</td><td>Three</td><td>some text</td></tr>
    <tr id="4"><td>4</td><td>Four</td><td>some text</td></tr>
    <tr id="5"><td>5</td><td>Five</td><td>some text</td></tr>
    <tr id="6"><td>6</td><td>Six</td><td>some text</td></tr>
</table>
_END;*/

// clear cache
//$tx = new MMSqlStatement; 
//$tx->executeSql("TRUNCATE TABLE `mm_db_cache`");die;
// ----------- 


/*
$sqlq = new MMSqlStatement;
$sqlq->read('xx1');
$a = array();
$a = $sqlq->sql_text;
print_r(unserialize($a));
die;
*/

//try	{
/*	$cmd = array();
	$src = new AXDoc;
	$src->arrayToDoc($cmd);*/
//}
//catch(Exception $e){
//	print"error";
//}
//die;


/*MMDb::executeSql('ALTER TABLE `mm_db_repl_pk_maps`
  ADD CONSTRAINT `mm_db_repl_pk_maps_acr` FOREIGN KEY (`create_by`) REFERENCES `mm_users` (`user_id`),
  ADD CONSTRAINT `mm_db_repl_pk_maps_aup` FOREIGN KEY (`update_by`) REFERENCES `mm_users` (`user_id`);');*/
/*MMDb::executeSql('ALTER TABLE `ax_accounts` DROP COLUMN `is_day_landmark_locked`');
MMDb::executeSql('ALTER TABLE `ax_accounts` DROP COLUMN `day_watermark`');
MMDb::executeSql('ALTER TABLE `ax_accounts` DROP COLUMN `is_balance_calc_req`');*/
//MMDb::executeSql('ALTER TABLE `ax_doc_items` MODIFY `doc_item_account_currency_amount` double(20,10) NOT NULL');
/*MMDb::executeSql('ALTER TABLE `ax_docs` MODIFY `doc_date` DATE NOT NULL ');
MMDb::executeSql('ALTER TABLE `ax_docs` MODIFY `doc_type_id` int(10) NOT NULL ');*/
//MMDb::executeSql("ALTER TABLE `ax_entity_period_stats`
//  ADD CONSTRAINT `ax_entity_period_stats_01` FOREIGN KEY (`period_type_id`, `period_year`, `period`) REFERENCES `am_periods` (`period_type_id`, `period_year`, `period`)
//");
//die;


//ALTER TABLE `ax_accounts` CHANGE `req_only_validated_items_in_bal` `has_only_validated_items_in_bal` INT( 10 ) NOT NULL 

//MMDb::executeSql('ALTER TABLE `ax_accounts_ctl` DROP COLUMN `day_landmark` ');
//MMDb::executeSql('ALTER TABLE `ax_accounts_ctl` DROP COLUMN `is_day_landmark_locked` ');
//MMDb::executeSql('ALTER TABLE `ax_accounts_ctl` ADD `day_first_future_item` date default null AFTER `day_watermark` ');
//MMDb::executeSql('ALTER TABLE `ax_accounts` ADD `valid_from` date NOT null DEFAULT "2003-01-01" AFTER `is_validation_req` ');
//MMDb::executeSql('ALTER TABLE `ax_accounts` ADD `valid_to` date DEFAULT null AFTER `valid_from` ');
//MMDb::executeSql('ALTER TABLE `ax_doc_items` ADD `validation_ts` datetime default null AFTER `is_doc_item_validated` ');
//MMDb::executeSql('ALTER TABLE `ax_doc_items` DROP COLUMN `validation_ts` ');
//MMDb::executeSql('ALTER TABLE `am_doc_types` ADD `is_reco_doc` bool DEFAULT FALSE AFTER `is_portfolio_related` ');
//MMDb::executeSql('ALTER TABLE `mm_db_repl_tables` ADD `replication_seq` int(11) DEFAULT NULL AFTER `download_method` ');
//MMDb::executeSql('ALTER TABLE `mm_db_repl_pk_maps` ADD `is_deleted_on_server` BOOLEAN DEFAULT 0 AFTER `is_client_aligned` ');
//MMDb::executeSql('TRUNCATE TABLE `mm_db_repl_pk_maps` ');
//die;
/*MMDb::executeSql('ALTER TABLE `mm_db_repl_columns` ADD `lookup_table` varchar(100) DEFAULT NULL AFTER `on_update` ');
MMDb::executeSql('ALTER TABLE `mm_db_repl_columns` ADD `lookup_column` varchar(100) DEFAULT NULL AFTER `lookup_table` ');
MMDb::executeSql('ALTER TABLE `mm_db_repl_columns` ADD `lookup_filter_column` varchar(100) DEFAULT NULL AFTER `lookup_column` ');
MMDb::executeSql('ALTER TABLE `mm_db_repl_columns` ADD `lookup_filter_value` varchar(100) DEFAULT NULL AFTER `lookup_filter_column` ');
die;*/
//MMDb::executeSql('ALTER TABLE `mm_environments` CHANGE `environment_short` `environment_short` varchar(10) not null');
//MMDb::executeSql('ALTER TABLE `mm_environments` ADD `environment_short` varchar(10) after `environment_id`');
//$ulo->executeSql('ALTER TABLE `mm_db_field_audit_log` ADD `db_delta_algorithm` int(2) DEFAULT 0 AFTER `db_column` ');


//$res = $user->getDbColumnDetails();
/*$user->name = 'Alberto';
$user->surname = 'Maniacco';
$user->country_id = 'IT';
$user->update();
/*
$user->setSessionUser($user->user_id);
*/

/*$user->getUser(4);
$user->login_pass = 'w';
$user->update();
$user->getUser(5);
$user->login_pass = 'mm';
$user->update();
*/
 
// ------------------------------------------------------------------
// execute sql query
// ------------------------------------------------------------------
/*list($usec, $sec) = explode(" ", microtime());
print (date('Y-m-d H:i:s', $sec) . strstr($usec, '.'));echo"<br/>";

		$params = array(
							"#period_year#" => 2003,
							"#period#" => 1,
							"#account_id#" => 2,
							"#period_type_id#" => 1
				);
				$sqlq = MMDB::retrieveSqlStatement("PeriodAccBalanceUpdMxAggreg", $params);
				$rows = MMDb::query($sqlq);
echo <<<_END

<!-- The HTML section -->

<style>.signup { border: 1px solid #999999;
	font: normal 10px verdana; color:#444444; }</style>
</head><body>
<table class="signup" border="1" cellpadding="2"
	cellspacing="0" bgcolor="#eeeeee">
	
_END;

echo "<tr><td />";
foreach ($rows[0] as $a => $b)	{
	echo "<td>$a</td>";
}
echo "</tr>";

$j = 1;
foreach ($rows as $row) {
	echo "<tr><td>$j</td>";
	foreach ($row as $fld)	{
		echo "<td>$fld</td>";
	}
	echo "</tr>";	
	$j++;
}

list($usec, $sec) = explode(" ", microtime());
print (date('Y-m-d H:i:s', $sec) . strstr($usec, '.'));echo"<br/>";
die;
*/
// ------------------------------------------------------------------
// manage sequences
// ------------------------------------------------------------------
//MMDb::createSequence('seq_update_id', 10000);
//print MMDb::nextId('seq_update_id');
// ------------------------------------------------------------------
// create user
// ------------------------------------------------------------------

/*$newUser = new MMUser;
$newUser->name = 'Ciccio';
$newUser->surname = 'Ingrassia';
$newUser->login_id = 'ciccio';
$newUser->login_pass = md5('ciccio');
$newUser->is_login_enabled = FALSE;
$newUser->country_id = 'IT';
print_r($newUser); echo "<br />";
$newUser->create();*/

/*print_r($newUser); echo "<br />";
$newUser->name = 'Ciccio D\'Aquino';
$newUser->surname = 'Ingrassiagg';
$newUser->country_id = 'GB';
$newUser->update();
print_r($newUser); echo "<br />";
$newUser->delete();
unset($newUser);
*/

//echo "<img src='../icons/flags_iso/48/$user->country_id.png' align='left' />"


/*$x = new AXAccount;
$y = new AXAccountDailyBalance;
$z = new AXAccountPeriodBalance;
$newDate = 	date('Y-m-d');
$accs = array();
$accs = $x->readAll();
foreach($accs as $a => $acc)	{
	if ($acc->accountClass->is_daily_balance_req) {
		$acc->day_watermark =  $acc->day_landmark; 
//		$acc->day_watermark =  '2010-08-31'; 
		$acc->update();
	}
}*/

// ------------------------------------------------------------------
// manage tables
// ------------------------------------------------------------------

//$sqlq = "DELETE FROM mm_db_field_audit_log WHERE db_table = 'mm_sql_stmts' and db_primary_key = 'xxxx'";
//MMDb::executeSql($sqlq);
/*$sqlq = "DELETE FROM mm_db_field_audit_log WHERE db_audit_log_id  < 30000";
MMDb::executeSql($sqlq);
$sqlq = "DELETE FROM mm_db_audit_log WHERE db_audit_log_id < 30000";
MMDb::executeSql($sqlq);*/ 

//$sqlq = "DELETE FROM mm_db_repl_pk_maps WHERE is_deleted_on_server = 1";
//MMDb::executeSql($sqlq);



/*$sqlq = "DELETE FROM mm_db_audit_log WHERE db_audit_log_id < 10000";
MMDb::executeSql($sqlq);
$sqlq = "DELETE FROM mm_db_field_audit_log WHERE db_audit_log_id < 10000";
MMDb::executeSql($sqlq);*/
/*$sqlq = "DELETE FROM mm_db_query_perf_logs WHERE db_query_perf_log_id < 380";
MMDb::executeSql($sqlq);*/

//$sqlq = "DELETE FROM mm_db_repl_pk_maps WHERE update_id < 13610";
//MMDb::executeSql($sqlq);

//$sqlq = "DELETE FROM ax_account_daily_balances WHERE account_id = 72";
//MMDb::executeSql($sqlq);
//$sqlq = "DELETE FROM ax_account_period_balances WHERE account_id = 72";
//MMDb::executeSql($sqlq);
//$sqlq = "DELETE FROM mm_db_query_perf_logs";
//MMDb::executeSql($sqlq);


/*$sqlq = "TRUNCATE TABLE `mm_db_repl_init_chunks`";
MMDb::executeSql($sqlq);*/
//die;
 
/*$sqlq = "

CREATE OR REPLACE VIEW `ax_account_daily_balances` AS
 SELECT
  `environment_id`,
  `entity_id` 			as `balance_type`,
  `entity_key_01`		as `account_id`,
  `period_type_id` 		,
  `period_date` 		,
  `stat_01` 			as `day_dt_amount`,
  `stat_02` 			as `day_ct_amount`,
  `stat_03` 			as `day_balance`,
  `stat_04` 			as `period_dt_amount`,
  `stat_05` 			as `period_ct_amount`,
  `stat_06` 			as `period_balance`,
  `stat_07` 			as `running_balance`,
  `stat_08` 			as `period_uv_dt_amount`,
  `stat_09` 			as `period_uv_ct_amount`,
  `stat_10` 			as `period_uv_balance`,
  `stat_11` 			as `running_uv_balance`,
  `create_by` 			,
  `create_ts` 			,
  `update_by` 			,
  `update_ts` 			,
  `update_id` 			
  FROM ax_entity_day_stats
  WHERE entity_id = 'ACC'
  WITH CHECK OPTION
";
MMDb::executeSql($sqlq);*/
/*$sqlq = "ALTER TABLE `mm_clients_ctl`
  ADD CONSTRAINT `mm_clients_ctl_acr` FOREIGN KEY (`create_by`) REFERENCES `mm_users` (`user_id`),
  ADD CONSTRAINT `mm_clients_ctl_aup` FOREIGN KEY (`update_by`) REFERENCES `mm_users` (`user_id`);

";
MMDb::executeSql($sqlq);
die;*/
/*$sqlq = "

CREATE TABLE `mm_db_cache` (
  `cache_id` varchar(255) not NULL, 
  `data` blob,
  `is_serialized` boolean,
  `expiration` datetime,
  `create_by` int(11) not NULL,
  `create_ts` datetime NOT null	,
  `update_by` int(11) not NULL,
  `update_ts` datetime NOT null	,
  `update_id` int(11) not NULL,			
    PRIMARY KEY  (`cache_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

";
$tx->executeSql($sqlq);
$sqlq = "ALTER TABLE `mm_db_cache`
  ADD CONSTRAINT `mm_db_cache_acr` FOREIGN KEY (`create_by`) REFERENCES `mm_users` (`user_id`),
  ADD CONSTRAINT `mm_db_cache_aup` FOREIGN KEY (`update_by`) REFERENCES `mm_users` (`user_id`);

";

$tx->executeSql($sqlq);
die;*/
// ------------------------------------------------------------------
// classes
// ------------------------------------------------------------------

/*require_once 'services/MMClass.php';
$x = new MMClass;
MMDb::setDbSessionUser(2);
$x->mm_class_name = "MMEnvironmentUser";
$x->mm_class_desc = "User's environment";
$x->mm_class_desc_plural = "User's environments";
$x->db_table_name = "mm_environment_users";
$x->db_table_audit_log_level = 2;
$x->create(); 
*/

// ------------------------------------------------------------------
// update mm_db_repl_tables
// ------------------------------------------------------------------
/*require_once 'MMDbReplicaTable.php';
$obj = new MMClass;
$objs = $obj->listAll(NULL, NULL, NULL);
foreach ($objs as $a => $b) {
	$repTab = new MMDbReplicaTable;
	$ret = $repTab->read("7|$b->db_table_name");
	if (is_null($ret))	{
		$repTab->client_type_id = 7;
		$repTab->db_table = $b->db_table_name;
		$repTab->create();
	}
}*/

// ------------------------------------------------------------------
// update AXAccountPeriodBalance
// ------------------------------------------------------------------
/*$obj = new AXAccountCtl;
$objs = $obj->readMulti("day_watermark <> 'NULL'");
foreach ($objs as $a => $b) {
	print($b->account_id.'<br/>');
	$b->day_watermark = null;
	$b->is_balance_calc_req = true;
	$b->update();
}*/

// ------------------------------------------------------------------
// update ax_items
// ------------------------------------------------------------------
/*require_once 'AXPortfolioItem.php';
require_once 'AXItem.php';
$obj = new AxPortfolioItem;
$objs = $obj->listAll(NULL, NULL, NULL);
foreach ($objs as $a => $b) {
	$itm = new AXItem;
	$ret = $itm->read($b->portfolio_item_id);
	if (is_null($ret))	{
		$itm->environment_id = $b->environment_id;
		$itm->entity_id = 'PFI';
		$itm->item_id = $b->portfolio_item_id;
		$itm->item_short = $b->portfolio_item_short;
		$itm->item_desc = $b->portfolio_item_desc;
		$itm->valid_from = '2004-10-01';
		$itm->valid_to = NULL;
		$itm->currency_id = 'EUR';
		$itm->create();
	}
}*/

// ------------------------------------------------------------------
// update portfolio docs
// ------------------------------------------------------------------
/*$sqlq = "select doc_id from ax_docs where doc_desc like '%[rec]%'";
$res=MMDb::query($sqlq);
foreach ($res as $a => $b) {
	$doc = new AXDoc;
	$doc->read($b[doc_id]); 
	print("$doc->doc_desc ");
	$doc->doc_desc = str_replace("[rec]","",$doc->doc_desc);
	print("$doc->doc_desc<br/>");
	$doc->update();
}*/

// ------------------------------------------------------------------
// update missing audit fields
// ------------------------------------------------------------------
/*$obj = new MMClass;
$objs = $obj->listAll(NULL, NULL, NULL);
foreach ($objs as $a => $b) {
	try {
		$sqlq = "UPDATE $b->db_table_name SET create_by = 1 WHERE create_by is null or create_by = 0";
		MMDb::executeSql($sqlq);
	}
	catch(Exception $e){
		print $e->getMessage() . " - " . $e->getCode() . "<br/>";
	}
	try {
		$sqlq = "UPDATE $b->db_table_name SET create_ts = '2009-01-01' WHERE create_ts is null";
		MMDb::executeSql($sqlq);
	}
	catch(Exception $e){
		print $e->getMessage() . " - " . $e->getCode() . "<br/>";
	}
	try {
		$sqlq = "UPDATE $b->db_table_name SET update_by = 1 WHERE update_by is null or update_by = 0";
		MMDb::executeSql($sqlq);
	}
	catch(Exception $e){
		print $e->getMessage() . " - " . $e->getCode() . "<br/>";
	}
	try {
		$sqlq = "UPDATE $b->db_table_name SET update_ts = '2009-01-01' WHERE update_ts is null";
		MMDb::executeSql($sqlq);
	}
	catch(Exception $e){
		print $e->getMessage() . " - " . $e->getCode() . "<br/>";
	}
}*/
/*$obj = new AXAccount;
$objs = $obj->listAll(NULL, NULL, NULL);
foreach ($objs as $a => $b) {
	$ctl = new AXAccountCtl;
	$ctl->environment_id = $b->environment_id;
	$ctl->account_id = $b->account_id;
	$ctl->day_landmark = $b->day_landmark;
	$ctl->is_day_landmark_locked = $b->is_day_landmark_locked;
	$ctl->day_watermark = $b->day_watermark;
	$ctl->is_balance_calc_req = $b->is_balance_calc_req;
	$ctl->create();
}
die;*/

// ------------------------------------------------------------------
// update daily balances
// ------------------------------------------------------------------
 
/*$listAcc = new AXAccountCtl;

$res = $listAcc->readMulti();
foreach ($res as $a)	{
	if (!empty($a->day_watermark))	{
		$a->day_watermark = '2011-05-01';
		$a->is_balance_calc_req = true;
		$a->update();
	}
}*/
//print_r($res); 

//MMDb::executeSql("delete from ax_account_daily_balances where account_id = 4");
//die("<br /><br />Nothing else.");

 
//$x = new AXAccount;

/*$env = new MMEnvironment;
$env->read($user->currentEnvironmentId);
$ret = $env->updateBalances();
foreach ($ret as $msg)	{
	print $msg . "<br/>";
}

echo "<br/>";*/

/*
$pof = new AXPortfolio;
$pof->read(1);
$docs = new AXDoc;
$res = $docs->readMulti("doc_type_id = 4 and doc_date >= '2010-01-01' and doc_date < '2011-01-01'");
foreach ($res as $doc)	{
	$pof->dayValuation(1, $doc->doc_id);
	$ret = $pof->getMsgs();
	foreach ($ret as $msg)	{
		print $msg . "<br/>";
	}
	flush();
} */

//$envWatermark = new MMSettingValue;
//$res = $envWatermark->read('ENV|1|ENV_BAL_WATERMARK_DATE|0');
//if(!is_null($res->setting_value))	{
//	$envWatermark->setting_value = $newDate;
	//print_r($envWatermark);
//	$envWatermark->update();
//}
//else	{
//	$envWatermark->entity_id = 'ENV';
//	$envWatermark->id = '1';
//	$envWatermark->setting_id = 'ENV_BAL_WATERMARK_DATE';
//	$envWatermark->setting_instance = 0;
//	$envWatermark->setting_value = $newDate;
//	$envWatermark->create();
//}
//MMDb::commit();


//$x = MMDb::query("select account_id, count(*) from ax_account_period_balances group by account_id");
//print_r($x); echo "<br />";

//-------------
// test su rounding
//-------------
/*$qh = MMDb::getQueryHandle("select doc_id from ax_docs order by doc_id desc");
while ($r = $qh->fetchRow(MDB2_FETCHMODE_ASSOC))	{
	$e = new AXDoc;
	$e->read($r['doc_id']);
	$tot = 0; $maxSeq = 0;
	//print_r($b);
	foreach ($e->docItems as $c => $d)	{
//		$dObj = $d->getDbObj();
//print_r($dObj);
		$maxSeq = $d->seqno > $maxSeq ? $d->seqno : $maxSeq;
		$tot += $d->doc_item_account_currency_amount;
	}
	if(abs($tot) > 1E-10)	{
		print "$e->doc_id $e->doc_desc $e->currency_id $tot $maxSeq<br/>";
		$itm = new AXDocItem;
		$itm->environment_id = $e->environment_id;
		$itm->doc_id = $e->doc_id;
		$itm->account_id = 74;
		$itm->seqno = $maxSeq + 10;
		$itm->doc_item_date = $e->doc_date;
		$itm->doc_item_desc = $e->doc_desc;
		$itm->doc_item_type = $tot > 0 ? 'A' : 'D';
		$itm->doc_item_currency_amount = -$tot;
		$itm->currency_id = 'EUR';
		$itm->doc_item_account_currency_amount = -$tot;
		$itm->is_doc_item_validated = false;
		$itm->has_reco_item = false;
		$itm->create(); 
	}
}
*/


//-------------
// xml
//-------------
/*function assocArrayToXML($root_element_name,$ar) 
{ 
    $xml = new SimpleXMLElement("<?xml version=\"1.0\"?><{$root_element_name}></{$root_element_name}>"); 
    $f = create_function('$f,$c,$a',' 
            foreach($a as $k=>$v) { 
                if(is_array($v)) { 
                    $ch=$c->addChild($k); 
                    $f($f,$ch,$v); 
                } else { 
                    $c->addChild($k,$v); 
                } 
            }'); 
    $f($f,$xml,$ar);  
    return $xml->asXML(); 
} 

$obj = new MMClass;
$objs = $obj->listAll(NULL, NULL, NULL);
$a = array();
$a[www] = $objs;
print_r(assocArrayToXML("test",$a));echo"<br/>";*/


//--------------
// diff
//--------------
/*$sqlq = "select * from mm_db_field_audit_log where db_field_audit_log_id = 159346";
$res=MMDb::query($sqlq);

$a = $res[0]['db_old_value'];
$b = $res[0]['db_new_value'];*/

/*$ax = explode("\n", $res[0]['db_old_value']);
$bx = explode("\n", $res[0]['db_new_value']);
$diff     = new Text_Diff('auto', array($ax, $bx));
$renderer = new Text_Diff_Renderer_unified();
$rendererI = new Text_Diff_Renderer_inline();
$rendererC = new Text_Diff_Renderer_context();
$rende = new Text_Diff_Renderer();*/

//$diff = MMUtils::diff($a, $b);
/*print("a:<br/>$a<br/>b:<br/>$b<br/>");
$diff = xdiff_string_diff($a, $b, 0);
print"<br/><br/>";
print_r($diff);  
print"<br/><br/>";*/

/*print("a:<br/>$a<br/>b:<br/>$b<br/>diff: Unified<br/>");
echo $renderer->render($diff);
print("<br/>diff: Inline<br/>");
echo $rendererI->render($diff);
print("<br/>diff: Context<br/>");
echo $rendererC->render($diff);
print("<br/>diff: <br/>");
echo $rende->render($diff);*/

/*$from_string = implode("\n", $a); 
$to_string = implode("\n", $b);
print("a:<br/>$from_string<br/>b:<br/>$to_string<br/>");*/
/* Diff the two strings and convert the result to an array. */
//$diff = xdiff_string_diff($from_string, $to_string); //, count($to_lines));
//        $diff = explode("\n", $diff);

/*$engine = extension_loaded('xdiff') ? 'xdiff' : 'native';
print"<br/><br/>";
print $engine; 
print"<br/><br/>";*/

//$engine = get_loaded_extensions();
//print_r($engine); 
//print"<br/><br/>";

//$pippo = new MMObj;

//--------------
// retrofit 
//--------------
/*$tx = new MMSqlStatement; 

print_r($tx->fetchAllTables());

print("<br/><b>Current:</b><br/>");
$tx->read('xxxx');
//print_r($tx);  
print("sql_text:  $tx->sql_text");
print("<br/>");


$sqlq = "select * from mm_db_audit_log where db_table = 'mm_sql_stmts' and db_primary_key = 'xxxx' and db_operation = 'U' and db_audit_log_id >= 172477 order by db_audit_log_id desc";
$res = $tx->query($sqlq);

foreach ($res as $a => $b)	{
	print("<br/>");
	print("<br/>Change by <b>$b[db_audit_log_id]</b>");
	$sqlq = "select * from mm_db_field_audit_log where db_audit_log_id = $b[db_audit_log_id]";
	$flog = $tx->query($sqlq);
	foreach ($flog as $c => $d)	{
//		print("<br/><b>$d[db_column]</b> old: $d[db_old_value] new: $d[db_new_value]");
		if ($d[db_delta_algorithm] == 1)	{
//			$r = strlen($tx->$d[db_column]);
//			if ($r == 0)	{
//				$tx->$d[db_column] = "\n\n\n";
//			}
//			else	{
//				if (substr($tx->$d[db_column], -1) != "\n")	{
//					$tx->$d[db_column] .= "\n\n\n";
//				} 
//			}
			$tx->$d[db_column] = xdiff_string_patch($tx->$d[db_column], $d[db_old_value]);
		}
		else	{
			$tx->$d[db_column] = $d[db_old_value];
		}
	}
	print("<br/>");
print("sql_text:  $tx->sql_text");
//	print_r($tx);  
	print("<br/>");
}

print("<br/>");
print("<br/>");
print("<br/>");
print("<br/>");
print("<br/>");
print(MMUtils::generateToken(20));
*/

die("<br /><br />Nothing else.");


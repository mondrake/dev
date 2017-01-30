<?php
// ------------- TESTING FUNCTIONS BELOW
use mondrakeNG\mm\core\MMDiag;
use mondrakeNG\mm\core\MMUtils;
use mondrakeNG\rbppavl\RbppavlTraverser;
use mondrakeNG\rbppavl\RbppavlTree;
use mondrakeNG\rbppavl\RbppavlCbInterface;
use mondrakeNG\rbppavl\RbppavlTraverser;

function return_bytes ($size_str)
{
    switch (substr ($size_str, -1))
    {
        case 'M': case 'm': return (int)$size_str * 1048576;
        case 'K': case 'k': return (int)$size_str * 1024;
        case 'G': case 'g': return (int)$size_str * 1073741824;
        default: return $size_str;
    }
}

function test_traverser($tree, $dsp)    {
    print("<br/>Traverser<br/>");
    $trav = new RbppavlTraverser($tree);
    $r = $trav->first();
    $ctr=0;
    while ($r != NULL)    {
        $xa = testCBC::dump($r);
        print("$ctr: $xa");print("<br/>");
        $r = $trav->next();
        $ctr++;
    }
}

function display_tree_structure($tree, $maxLev)    {

    $a = $tree->debugLevelOrderToArray($maxLev);
    $cbc = new testCBC;

    echo <<<_END
    <html>
        <style>
            .login { border: 1px solid #999999; font: normal 10px verdana; color:#444444; }
            .apptop { font: normal 20px verdana;  }
        </style>

        <body>
                <table class="login" border="0" cellpadding="2" cellspacing="5" bgcolor="#eeeeee">
                    
_END;

    for ($i = 0; $i <= $maxLev; $i++)    {
        echo "<tr><td align='center'><b>L$i:</b></td>";
        for ($j = 0; $j < pow(2, $i); $j++)    {
            if (isset($a[$i][$j])) {
                $xx = $cbc->dump($a[$i][$j][0]) . '<br/>h:' . $a[$i][$j][1] . ' (' .  $a[$i][$j][2] . ')';
            } else {
                $xx = null;
            }
            if ($xx == NULL) $xx = "*";
            $span = pow(2, $maxLev - $i);
            echo "<td colspan='$span' align='center'>$xx</td>";
        }
        echo "</tr>";
    }
                        
    echo <<<_END
                </table>
        </body>
    </html>
_END;

}        

function diag_walker() {

    $obj = new MMDiag;
    $headerSet = false;
    foreach ($obj->get(true) as $msg)    {

        if(!$headerSet)    {
            echo <<<_END
<!-- The HTML section -->
<style>.signup { border: 1px solid #999999;
    font: normal 10px verdana; color:#444444; }</style>
</head><body>
<table class="signup" border="1" cellpadding="2"
    cellspacing="0" bgcolor="#eeeeee">
<tr>
    <th>Class</th>
    <th>.</th>
    <th>Time</th>
    <th>Id</th>
    <th>Message</th>
</tr>
_END;
            $headerSet = true;
        }
        echo "<tr>";
        echo "<td>$msg->className</td>";
        echo "<td>$msg->severity</td>";
        echo "<td>$msg->time.$msg->uTime</td>";
        echo "<td>$msg->id</td>";
        echo "<td>$msg->fullText</td>";
        echo "</tr>";    
    }
}


// --------------- SIMPLE TESTING 
require_once "/home/mondrak1/private/mondrake/core/MMDiag.php";

class testClA {
    public $q;
}

class testCBC implements RbppavlCbInterface    {
    private $diag = null;

    public function __construct() {    
        $this->diag = new MMDiag;
    }

    function compare($a, $b)    {
        if ($a->q == $b->q) {
            return 0;
        }
        return ($a->q < $b->q) ? -1 : 1;
    }

    function dump($a)    {
        return $a->q;
    }

    public function diagnosticMessage($severity, $id, $text, $params, $qText, $className = null) {
        $params['#text'] = $text;
        if (empty($className))    {
            $className = get_class($this);
        }
        $this->diag->sLog($severity, $className, $id, $params);
    }

    public function errorHandler($id, $text, $params, $qText, $className = null) {
    }
}


// play around with the variable values below to change behaviour of tests
$testChangeDiagnosticMessages = false; 
$testDeletes = false; 
$verbose = true;
$displayTree = array( 'atEndOfInserts' => true, );
$displayHowManyLevels = 7;
$logMemoryStatus = false;
$memoryThreshold = '100k'; 
$howManyCycles = 1;
$howManyNodes = 15;
$fromBalanceFactor = 1;
$toBalanceFactor = 3;
$maxIntValueInNode = 5000;

$diag = new MMDiag;

// Memory limit
if ($logMemoryStatus) {
    $diag->sLog(1, 'test script', 0, array( '#text' => "Memory limit (Mb): " . return_bytes(ini_get('memory_limit'))/1024/1024, )); 
}

// Test change diagnostic messages
if ($testChangeDiagnosticMessages) {
    $tree = new RbppavlTree("testCBC"); 
    $msgs = $tree->getMessages();
    $msgs[3] = array(RBPPAVL_DEBUG,   'inserito nodo *radice* %node; contatore: %count');
    $tree->setMessages($msgs);
}

for ($tx = 1; $tx <= $howManyCycles; $tx++) {
//$qres = array (0,1,2,12,34,14,32,12,3, 38,46,54,12,35,43,27,28,29,30,55);
//$qres = array (0,1,2,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20);
//$qres = array (20,19,18,17,16,15,14,13,12,11,10,9,8,7,6,5,4,3,2,1,0);
    for ($i = 0; $i < $howManyNodes; $i++)    {  
        $qres[$i] = rand(0, $maxIntValueInNode);
    }
    
    for ($i = $fromBalanceFactor; $i <= $toBalanceFactor; $i++)    {   
        print("<br/>");
        $diag->sLog(1, 'test script', 0, array( '#text' => "Cycle: $tx, Balance factor: $i", )); 

        // ********* INSERTS *************

        if ($logMemoryStatus) {
            $diag->sLog(1, 'test script', 0, array( '#text' => "Memory at start inserts (Mb): " . round((memory_get_usage()/1024/1024), 2))); 
        }
        $tree = new RbppavlTree("testCBC", $i, $verbose, $memoryThreshold);
        $ctr=0;
        foreach ($qres as $r)    {
//        for (;;)    {
            $nai = new testClA;
            $nai->q = $r;
//            $nai->q = rand(0,5000000);
            $t = $tree->insert($nai); 
//            $tree->redus;
            if ($tree->getStatusLevel() <= RBPPAVL_WARNING) {
                break;
            }
            if (fmod($ctr, 1000) == 0)    {
//                $diag->sLog(1, null, 1, array( '#text' => (memory_get_usage()), )); 
//                $diag->sLog(1, null, 1, array( '#text' => memory_get_usage(), ));  
                set_time_limit(30);
            }
            //$diag->wipe();
            //diag_walker(); 
            //print("<br/><br/>");
            //display_tree_structure($tree, $displayHowManyLevels);
            $ctr++;
        }
    //    $diag->wipe();


//        $diag->wipe();
        $failingNode = $tree->debugValidate();
        $stats = $tree->getStatistics();
        if ($logMemoryStatus) {
            $diag->sLog(1, 'test script', 0, array( '#text' => "Memory at end inserts (Mb): " . round((memory_get_usage()/1024/1024), 2))); 
        }
        //$diag->wipe();
        diag_walker(); 
        if ($displayTree['atEndOfInserts']) {
            display_tree_structure($tree, $displayHowManyLevels); 
        }
//        $diag->wipe();
        test_traverser($tree, "dsp_r");


        
        // ********* DELETES *************

        //$qres = array (3,12,46,34,35,28,32,43,38,54,2,1,0,1,29);
        //$qres = array (3,38,12,46,34,35,27,28,32,43,38,54,27,55,14,0,2,29,1,30,45);
        
/*        $ctr=0;
        foreach ($qres as $r)    {
//        while ($tree->count() > 0)    {
//            $trav = new RbppavlTraverser($tree);
//            $r = $trav->first();
//            $rnd = rand(0, ($tree->count() - 1));
//            for ($x = 0; $x < $rnd; $x++)    {
//                $r = $trav->next();
//            }
            //print_r($r);
            $nai = new testClA;
            //$nai->q = $r->q;
            $nai->q = $r;
            //$t = $tree->find($nai);
            $t = $tree->delete($nai); 
//            if (fmod($ctr, 500) == 0)    {
//                $diag->sLog(1, null, 1, array( '#text' => "Memory at $ctr: " . (memory_get_usage()/1024), )); 
    //            $diag->sLog(1, null, 1, array( '#text' => memory_get_usage(), ));  
                set_time_limit(30);
                if ($tree->root())    {
                    $tree->debugValidate(); 
                }
//            }
//            $diag->wipe(2);
//            diag_walker(); 
//            print("<br/><br/>");
            //display_tree_structure($tree, $displayHowManyLevels);
            $ctr++;
        }
        $diag->wipe(2);
        $stats = $tree->getStatistics();
        $diag->sLog(1, null, 0, array( '#text' => "Memory: " . (memory_get_usage()/1024), )); 
        diag_walker(); 

        //print("<br/>");*/

        $tree = null; 
    }
}




// --------------- SIMPLE TESTING END
/*
class testRepl {
    public $replicationSeq;
    public $table;
    public $primaryKey;
    public $operation;
    public $updateId;
    public $environmentId;
    public $clientId;
}

class testCBC    {
    private $diag = null;

    public function __construct() {    
        $this->diag = new MMDiag;
    }

    function compare($a, $b)    {
        if ($a->replicationSeq > $b->replicationSeq) 
            return 1;
        elseif ($a->replicationSeq < $b->replicationSeq)    
            return -1;

        if ($a->table > $b->table) 
            return 1;
        elseif ($a->table < $b->table)    
            return -1;

        if ($a->primaryKey > $b->primaryKey) 
            return 1;
        elseif ($a->primaryKey < $b->primaryKey)    
            return -1;
        else    
            return 0;
    }

    function dump($a)    {
        return $a->replicationSeq . "->" . $a->table . "->" . $a->primaryKey . "->" . $a->operation;
    }

    public function logDiagnostic($severity, $id, $params, $className = null) {
        if (empty($className))    {
            $className = get_class($this);
        }
        $this->diag->sLog($severity, $className, $id, $params);
    }

    public function errorException($id, $params) {
    }
}

include_once('/home/mondrak1/private/mondrake/MM_settings.php');
require_once 'MMSqlStatement.php';
require_once 'MMUtils.php';

$params = array(
    "#idFrom#" => 181404,
    "#idTo#" => 181446,
    "#clientTypeId#" => 7,
    "#environmentId#" => 1
);

$x = new MMSqlStatement;
$sqlq = MMUtils::retrieveSqlStatement("getReplicationChunk", $params);
$qres = MMObj::query($sqlq);

$tree =    new RbppavlTree("testCBC", 4, $debugMode = true);
$ctr=0;
foreach ($qres as $r)    {
    $nai = new testRepl;
    $nai->replicationSeq = $r[replication_seq];
    $nai->table = $r[db_table];
    $nai->primaryKey = $r[db_primary_key];
    $nai->operation = $r[db_operation];
    $nai->updateId = $r[db_audit_log_id];
    $nai->environmentId = $r[environment_id];
    $nai->clientId = $r[client_id];

    $t = $tree->insert($nai); 
    print("$ctr: ");
    diag_walker(); 
    if ($t != NULL)    { 
        print(" --> ");
        if ($nai->operation == 'D' && $t->operation == 'I')    {         // DELETE after INSERT in same log --> no replica op
print(" D/I");
            $x = $tree->delete($t);
            print(" --> " . $tree->debugMsg);
            if ($x != NULL)
                unset($x);
        }
        elseif ($nai->operation == 'D' && $t->operation == 'U')    {    // DELETE after UPDATE in same log --> DELETE prevails
print(" D/U");
            $t->operation = 'D';
            $t->updateId = $nai->updateId;
        }
        elseif ($nai->operation == 'I' && $t->operation == 'D')    {    // INSERT after DELETE in same log --> INSERT prevails
print(" I/D");
            $t->operation = 'I';
            $t->updateId = $nai->updateId;
        }
        elseif ($nai->operation == 'U' && $t->operation == 'U')    {    // UPDATE after UPDATE in same log --> update id
print(" U/U");
            $t->updateId = $nai->updateId;
        }
        elseif ($nai->operation == 'U' && $t->operation == 'D')    {    // UPDATE after DELETE in same log --> impossible
print(" U/D");
            throw new Exception("UPDATE after DELETE in same log --> impossible");
        }
        elseif ($nai->operation == 'U' && $t->operation == 'I')    {    // UPDATE after INSERT in same log --> INSERT prevails
print(" U/I");
            $t->operation = 'I';
            $t->updateId = $nai->updateId;
        }
        elseif ($nai->operation == 'I' && $t->operation == 'U')    {    // INSERT after UPDATE in same log --> impossible
print(" I/U");
            throw new Exception("INSERT after UPDATE in same log --> impossible");
        }
    }
    print("<br/>");
    $ctr++;
}
$failingNode = $tree->debugValidate();
$stats = $tree->getStatistics();print_r($stats);
diag_walker(); 
display_tree_structure($tree, $displayHowManyLevels);
test_traverser($tree, "dsp_r");
*/
<?php 
/*require_once 'mmheader.php';
require_once 'drupalTableObj.php';



$obj = new drupalTableObj('lab02browscap');
$colDets = $obj->getColumnProperties();
$objs = $obj->listAll();
*/
$ua = $_SERVER['HTTP_USER_AGENT'];


echo $ua . '<br/><br/><br/>';
//print_r(php_get_browser($ua));

$tm = microtime(TRUE);
$yu = array(); 
$brows = parse_ini_file("browscap_mondrake.org.ini", true, INI_SCANNER_RAW); 
foreach ($brows as $k => $t) {  
  $yu[$k]['data'] = $t;
  $yu[$k]['pattern'] = x_pattern($k);
  if (!isset($yu[$k]['childs'])) {
    $yu[$k]['childs'] = 0;
  }
  if (isset($t['Parent'])) {
    $yu[$t['Parent']]['childs'] = isset($yu[$t['Parent']]['childs']) ? $yu[$t['Parent']]['childs'] + 1 : 1; 
  }
}
$brows = NULL;
echo (microtime(TRUE) - $tm) . '<br/>';

// masters 
/*echo "<br/><br/>MASTERS <br/>";
foreach ($yu as $a => $b) {
  if ($b['childs']) {
    $n = $b['childs'];
    echo "$a - childs #$n <br/>";
  }
}*/

// patterns
/*echo "<br/><br/>PATTERNS <br/>";
$filter = array();
foreach ($yu as $a => $b) {
  $filter[] = '/^' . $b['pattern'] . '$/i';
/*  if (!$b['childs']) {
    //echo $a . ' - ' . $b['pattern'] . '<br/>';
    $filter[] = $b['pattern'];
  } 
}*/
//echo $super_pattern . '<br/>';
//print_r($filter);
/*$m = preg_filter($filter, $filter, array($ua));
print_r($m);*/

// matches
echo "<br/><br/>MATCHES <br/>";
foreach ($yu as $a => $b) {
  $match = preg_match('/^' . $b['pattern'] . '$/i', $ua); 
  if ($match) {
    echo $a . '<br/>'; 
    //echo x_fnmatch($a, $ua) . '<br/>';  
    print_r($yu[$a]);
    echo '<br/>';
  }
}
echo (microtime(TRUE) - $tm) . '<br/>';

function x_fnmatch($pattern, $string) {
    for ($op = 0, $npattern = '', $n = 0, $l = strlen($pattern); $n < $l; $n++) {
        switch ($c = $pattern[$n]) {
            case '\\':
                $npattern .= '\\' . @$pattern[++$n];
            break;
            case '/': case '.': case '+': case '^': case '$': case '(': case ')': case '{': case '}': case '=': case '!': case '<': case '>': case '|':
                $npattern .= '\\' . $c;
            break;
            case '?': case '*':
                $npattern .= '.' . $c;
            break;
            case '[': case ']': default:
                $npattern .= $c;
                if ($c == '[') {
                    $op++;
                } else if ($c == ']') {
                    if ($op == 0) return false;
                    $op--;
                }
            break;
        }
    }

    if ($op != 0) return false;
    
    $ret = preg_match('/^' . $npattern . '$/i', $string);
    if ($ret) {
      echo 'pattern - ' . $npattern . '<br/>'; 
    }

    return $ret;
}

function x_pattern($pattern) {
    for ($op = 0, $npattern = '', $n = 0, $l = strlen($pattern); $n < $l; $n++) {
        switch ($c = $pattern[$n]) {
            case '\\':
                $npattern .= '\\' . @$pattern[++$n];
            break;
            case '/': case '.': case '+': case '^': case '$': case '(': case ')': case '{': case '}': case '=': case '!': case '<': case '>': case '|':
                $npattern .= '\\' . $c;
            break;
            case '?': case '*':
                $npattern .= '.' . $c;
            break;
            case '[': case ']': default:
                $npattern .= $c;
                if ($c == '[') {
                    $op++;
                } else if ($c == ']') {
                    if ($op == 0) return false;
                    $op--;
                }
            break;
        }
    }

    if ($op != 0) return false;
    
    return $npattern;
}

?>

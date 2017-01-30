<?php // mmlogindetails.php

require_once 'mmheader.php';

//	echo("Logged in via token $x->mm_trust_token <br />");
echo("Login time: $ulo->last_login_ts <br />");
echo("IP Address: $ulo->remote_addr <br />");
echo("HttpUserAgent: $ulo->http_user_agent<br />");
?>

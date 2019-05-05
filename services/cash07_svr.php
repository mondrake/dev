<?php
require_once '../mmsession.php';

use mondrakeNG\mm\core\MondrakeRpcServer;
use PhpXmlRpc\Server;

$s = new Server(
array(
  "mondrake_rpc.setLink" => ["function" => MondrakeRpcServer::class . "::setLink"],
  "mondrake_rpc.authenticate" => ["function" => MondrakeRpcServer::class . "::authenticate"],
  "mondrake_rpc.download" => ["function" => MondrakeRpcServer::class . "::download"],
  "mondrake_rpc.uploadDocs" => ["function" => MondrakeRpcServer::class . "::uploadDocs"],
  "mondrake_rpc.ackLastUpdate" => ["function" => MondrakeRpcServer::class . "::ackLastUpdate"],
), false);
$s->exception_handling = 1;
$s->service();

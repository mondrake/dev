<?php
require_once '../mmsession.php';

use mondrakeNG\mm\core\MondrakeRpcServer;
use PhpXmlRpc\Server;

$options = array(
    'prefix' => 'mondrake_rpc.', // we define a sort of "namespace" for the server
//    'input' => new XML_RPC2_Server_Input_PhpInput(),
);

/* try {
  // build the server object
  $server = XML_RPC2_Server::create(MondrakeRpcServer::class, $options);
  $server->handleCall();
} catch (XML_RPC2_FaultException $e) {
  // The XMLRPC server returns a XMLRPC error
  die('Exception #' . $e->getFaultCode() . ' : ' . $e->getFaultString());
} catch (Exception $e) {
  // Other errors (HTTP or networking problems...)
  die('Exception : ' . $e->getMessage());
}*/

  $s = new Server(
    array(
      "mondrake_rpc.setLink" => ["function" => MondrakeRpcServer::class . "::setLink"],
      "mondrake_rpc.authenticate" => ["function" => MondrakeRpcServer::class . "::authenticate"],
      "mondrake_rpc.download" => ["function" => MondrakeRpcServer::class . "::download"],
      "mondrake_rpc.uploadDocs" => ["function" => MondrakeRpcServer::class . "::uploadDocs"],
    ), false);
  $s->exception_handling = 1;
  $s->service();

<?php
require_once '../mmsession.php';

use mondrakeNG\mm\core\MondrakeRpcServer;

$options = array(
    'prefix' => 'mondrake_rpc.', // we define a sort of "namespace" for the server
    'input' => new XML_RPC2_Server_Input_PhpInput(),
);

try {
  // build the server object
  $server = XML_RPC2_Server::create(MondrakeRpcServer::class, $options);
  $server->handleCall();
} catch (XML_RPC2_FaultException $e) {
  // The XMLRPC server returns a XMLRPC error
  die('Exception #' . $e->getFaultCode() . ' : ' . $e->getFaultString());
} catch (Exception $e) {
  // Other errors (HTTP or networking problems...)
  die('Exception : ' . $e->getMessage());
}

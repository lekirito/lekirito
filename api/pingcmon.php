<?php

error_reporting(E_ERROR | E_PARSE); // Add this line to remove warning by 000webhost

$pingresult = shell_exec("start /b ping 124.217.249.93 -n 1");
$dead = "Request timed out.";
$deadoralive = strpos($dead, $pingresult);

if ($deadoralive == false){
    http_response_code(200);
    echo json_encode(array("success" => true, "message" => "CONNECTION_OK"));
} else {
    http_response_code(404);
    echo json_encode(array("success" => false, "message" => "CONNECTION_FAILED"));
}

?>
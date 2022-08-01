<?php

// Default timezone
date_default_timezone_set('Asia/Kuala_Lumpur');

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

// Include database and object files
include_once '../config.php';
include_once 'build.php';
  
// Get database connection and prepare build object
$database = new Database();
$db = $database->getConnection();
$build = new Build($db);
  
// Get posted data
$data = json_decode(file_get_contents("php://input"));

// Make sure data is not empty
if (
    !empty($data->appID) &&
    !empty($data->appName) &&
    !empty($data->appPackageName)
) {
    // Set build property values
    $build->appID = $data->appID;
    $build->appName = $data->appName;
    $build->appPackageName = $data->appPackageName;
    $build->appUpdatedAt = date('Y-m-d H:i:s');
    // Create the build record
    if ($build->update()) {
        // Set response code - 201 created
        http_response_code(201);
        // Tell the user
        $result = array("success" => true, "message" => "APP_UPDATED");
        echo json_encode($result);
    }
    // If unable to create the build, tell the user
    else {
        // Set response code - 503 service unavailable
        http_response_code(503);
        // Tell the user
        $result = array("success" => false, "message" => "APP_ERROR");
        echo json_encode($result);
    }
} // Tell the user data is incomplete 
else {
    // Set response code - 400 bad request
    http_response_code(400);
    // Tell the user
    $result = array("success" => false, "message" => "INSUFFICIENT_DATA");
    echo json_encode($result);
}

?>
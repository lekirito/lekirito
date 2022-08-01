<?php

// Default timezone
date_default_timezone_set('Asia/Kuala_Lumpur');

// Required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
// Include database and object files
include_once '../config.php';
include_once 'build.php';

// Get database connection and prepare build object
$database = new Database();
$db = $database->getConnection();
$build = new Build($db);
  
// Set ID property of record to read
$build->appID = isset($_GET['appID']) ? $_GET['appID'] : die();
  
if ($build->appID != null) {
    // Read the details of product to be edited
    if ($build->readSingle()) {
        // Create array
        $app_item = array(
            "appName" => $build->appName,
            "appPackageName" => $build->appPackageName,
            "appLatestBuild" => $build->appLatestBuild,
            "appUpdatedAt" => $build->appUpdatedAt
        );
        // Set response code - 200 OK
        http_response_code(200);
        // Make it json format
        $result = array("success" => true, "data" => $app_item);
        echo json_encode($result);
    } else {
        // Set response code - 404 Not found
        http_response_code(404);
        // Tell the user that the build does not exist
        $result = array("success" => false, "error" => "APP_NOT_FOUND");
        echo json_encode($result);
    }
} else {
    // Set response code - 400 Bad Request
    http_response_code(400);
    // Tell the user that the build ID does not exist
    $result = array("success" => false, "error" => "NO_APP_ID");
    echo json_encode($result);
}

?>
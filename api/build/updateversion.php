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
    // Get the current build number of the app
    $query = "SELECT appLatestBuild FROM tbl_danialtech_builds WHERE appID = ?";
    // Prepare query statement and execute it
    $stmt = $db->prepare($query);
    $stmt->bindParam(1, $build->appID);
    $stmt->execute();
    $build->appLatestBuild = $stmt->fetchColumn() + 1;
    $build->appUpdatedAt = date('Y-m-d H:i:s');
    if ($build->updateVersion()) {
        // Set response code - 200 OK
        http_response_code(200);
        // Make it json format
        $result = array("success" => true, "message" => "APP_UPDATED");
        echo json_encode($result);
    } else {
        // Set response code - 404 Not found
        http_response_code(404);
        // Tell the user that the build does not exist
        $result = array("success" => false, "message" => "APP_ERROR");
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
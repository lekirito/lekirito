<?php

// Default timezone
date_default_timezone_set('Asia/Kuala_Lumpur');

// Required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// Include database and object files
include_once '../config.php';
include_once 'build.php';
  
// Instantiate database and menu object
$database = new Database();
$db = $database->getConnection();
$build = new Build($db);
  
// Query Menu
$stmt = $build->read();
$num = $stmt->rowCount();
  
// Check if more than 0 record found
if ($num > 0) {
    // build array
    $app_arr = array();
    // Retrieve our table contents
    // fetch() is faster than fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Extract row, this will make $row['name'] to just $name only
        extract($row);
        $app_item = array(
            "appID" => $appID,
            "appName" => $appName,
            "appPackageName" => $appPackageName,
            "appLatestBuild" => $appLatestBuild,
            "appUpdatedAt" => $appUpdatedAt
        );
        array_push($app_arr, $app_item);
    }
    // Set response code - 200 OK
    http_response_code(200);
    // Show build data in json format
    $result = array("success" => true, "data" => $app_arr);
    echo json_encode($result);
} else {
    // Set response code - 404 Not found
    http_response_code(404);
    // Tell the user no build found
    $result = array("success" => false, "error" => "SPPS_NOT_FOUND");
    echo json_encode($result);
}

?>
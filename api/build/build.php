<?php

class Build {

    // Database connection and table name
    private $conn;
    private $tableName = "tbl_danialtech_builds";

    // Object properties
    public $appID;
    public $appName;
    public $appPackageName;
    public $appLatestBuild;
    public $appUpdatedAt;

    // Constructor with $db as database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Read All Builds
    function read() {
        // Select all query
        $query1 = "SELECT * FROM " . $this->tableName;
        // Prepare query statement
        $stmt1 = $this->conn->prepare($query1);
        // Execute query
        $stmt1->execute();
        return $stmt1;
    }

    // Read Single Build
    function readSingle() {
        // Query to read single event
        $query2 = "SELECT * FROM " . $this->tableName . " WHERE appID = ?";
        // Prepare query statement
        $stmt2 = $this->conn->prepare($query2);
        // Bind ID of product to be updated
        $stmt2->bindParam(1, $this->appID);
        // Execute query
        $stmt2->execute();
        // Get retrieved row
        $row = $stmt2->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            // Set values to object properties
            $this->appName = $row['appName'];
            $this->appPackageName = $row['appPackageName'];
            $this->appLatestBuild = $row['appLatestBuild'];
            $this->appUpdatedAt = $row['appUpdatedAt'];
            return true;
        } else {
            return false;
        }
    }

    // Create New Build
    function create() {
        // Query to Create Single Build
        $query3 = "INSERT INTO " . $this->tableName . " SET appID=:appID, appName=:appName, appPackageName=:appPackageName, appLatestBuild=:appLatestBuild, appUpdatedAt=:appUpdatedAt";
        // Prepare query
        $stmt3 = $this->conn->prepare($query3);
        // Sanitize
        $this->appID = htmlspecialchars(strip_tags($this->appID));
        $this->appName = htmlspecialchars(strip_tags($this->appName));
        $this->appPackageName = htmlspecialchars(strip_tags($this->appPackageName));
        $this->appLatestBuild = htmlspecialchars(strip_tags($this->appLatestBuild));
        $this->appUpdatedAt = htmlspecialchars(strip_tags($this->appUpdatedAt));
        // Bind values
        $stmt3->bindParam(':appID', $this->appID);
        $stmt3->bindParam(':appName', $this->appName);
        $stmt3->bindParam(':appPackageName', $this->appPackageName);
        $stmt3->bindParam(':appLatestBuild', $this->appLatestBuild);
        $stmt3->bindParam(':appUpdatedAt', $this->appUpdatedAt);
        // Execute query
        if ($stmt3->execute()) {
            return true;
        }
        return false;
    }

    // Update Existing Build
    function update() {
        // Query to Update Build
        $query4 = "UPDATE " . $this->tableName . " SET appName=:appName, appPackageName=:appPackageName, appUpdatedAt=:appUpdatedAt WHERE appID=:appID";
        // Prepare query
        $stmt4 = $this->conn->prepare($query4);
        // Sanitize
        $this->appID = htmlspecialchars(strip_tags($this->appID));
        $this->appName = htmlspecialchars(strip_tags($this->appName));
        $this->appPackageName = htmlspecialchars(strip_tags($this->appPackageName));
        $this->appUpdatedAt = htmlspecialchars(strip_tags($this->appUpdatedAt));
        // Bind values
        $stmt4->bindParam(':appID', $this->appID);
        $stmt4->bindParam(':appName', $this->appName);
        $stmt4->bindParam(':appPackageName', $this->appPackageName);
        $stmt4->bindParam(':appUpdatedAt', $this->appUpdatedAt);
        // Execute query
        if ($stmt4->execute()) {
            return true;
        }
        return false;
    }

    // Update Existing Build Version
    function updateVersion() {
        // Query to Update Build Version
        $query5 = "UPDATE " . $this->tableName . " SET appLatestBuild=:appLatestBuild, appUpdatedAt=:appUpdatedAt WHERE appID=:appID";
        // Prepare query
        $stmt5 = $this->conn->prepare($query5);
        // Sanitize
        $this->appID = htmlspecialchars(strip_tags($this->appID));
        $this->appLatestBuild = htmlspecialchars(strip_tags($this->appLatestBuild));
        $this->appUpdatedAt = htmlspecialchars(strip_tags($this->appUpdatedAt));
        // Bind values
        $stmt5->bindParam(':appID', $this->appID);
        $stmt5->bindParam(':appLatestBuild', $this->appLatestBuild);
        $stmt5->bindParam(':appUpdatedAt', $this->appUpdatedAt);
        // Execute query
        if ($stmt5->execute()) {
            return true;
        }
        return false;
    }

}

?>
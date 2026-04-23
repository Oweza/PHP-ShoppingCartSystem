<?php
// inc_OnlineStoreDB.php
$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "gosselin"; // from your SQL file

$DBConnect = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($DBConnect->connect_errno) {
    die("<p>Database connection failed: " . $DBConnect->connect_error . "</p>");
}
?>

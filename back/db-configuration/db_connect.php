<?php
header ("Access-Control-Allow-Origin: *");
header ("Access-Control-Allow-Headers: Content-Type");
header ("Content-Type: application/json; charset=utf-8");
header ("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

include "config.php";

$conn = new mysqli($db_config["host"], $db_config["user"], $db_config["password"], $db_config["db"]);

if($conn -> connect_error){
    die(json_encode(["Error" => "Connection failed:" . $conn -> connect_error]));
}

$conn ->set_charset("utf8");

?>
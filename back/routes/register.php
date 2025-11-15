<?php
require_once __DIR__ . "/../controllers/AuthController.php";

$data = json_decode(file_get_contents("php://input"), true);

echo AuthController::register($data);

?>
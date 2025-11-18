<?php 
require_once "./helpers/Response.php";
require_once __DIR__ . "/db-configuration/db_connect.php";
include __DIR__ . "/routes/apis.php";
$base_dir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (strpos($request, $base_dir) === 0) {
    $request = substr($request, strlen($base_dir));
}

if ($request == '') {
    $request = '/';
}


if (isset($apis[$request])) {
    $controller_name = $apis[$request]['controller']; 
    $method = $apis[$request]['method'];
    require_once "controllers/{$controller_name}.php";
    
    $controller = new $controller_name();
    if (method_exists($controller, $method)) {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);
        echo $controller->$method($data);
    } else {
        echo Response::error("Error: Method {$method} not found in {$controller_name}", 500);
    }
} else {
    echo Response::error("Route Not Found", 404);
}
<?php

require_once __DIR__ . "/Response.php";
class AuthMiddleware{
    // checks if no session is running, and starting one
    public static function startSession(){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
    }

    // checks if theres a current user logged in
    public static function requireLogin(){
        AuthMiddleware::startSession();

        if(!isset($_SESSION["user_id"])){
            echo Response::error("Unauthorized", 401);
            exit();
        }
    }

    // checks if the current user is an admin
    public static function requireAdmin(){
        AuthMiddleware::startSession();

        if(!isset($_SESSION["role"]) || $_SESSION !== "admin"){
            echo Response::error("Not Admin", 403);
            exit();
        }
    }

    public static function getUserID(){
        AuthMiddleware::startSession();

        return $_SESSION["user_id"] ?? null;
    }

    public static function getRole(){
        AuthMiddleware::startSession();

        return $_SESSION["role"] ?? null;
    }
}

?>
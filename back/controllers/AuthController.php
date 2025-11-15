<?php
require_once __DIR__ . "/../helpers/AuthMiddleware.php";
require_once __DIR__ . "/../helpers/Response.php";
require_once __DIR__ . "/../helpers/Validator.php";
require_once __DIR__ . "/../models/User.php";

class AuthController{
    public static function register($data){
        if(!Validator::required($data["name"] ?? null)){
            return Response::error("Name is required", 400);
        }

        if(!Validator::required($data["email"] ?? null)){
            return Response::error("Email is required", 400);
        }

        if(!Validator::email($data)){
            return Response::error("Invalid email format", 400);
        }

        if(!Validator::required($data["password"] ?? null)){
            return Response::error("Password cant be empty", 400);
        }

        if(!Validator::minLength($data["password"], 8)){
            return Response::error("Password cant be less than 8 characters", 400);
        }

        $existingUser = User::findByEmail($data);
        if($existingUser){
            return Response::error("Email is already registered", 400);
        }

        $hashedPassword = password_hash($data["password"], PASSWORD_DEFAULT);

        $userId = User::create($data["name"], $data["email"], $hashedPassword);

        return Response::success("User registered successfully!", ["user_id" => $userId], 201);
    }
}




?>
<?php
require_once __DIR__ . "/../helpers/Response.php";
require_once __DIR__ . "/../helpers/Validator.php";
require_once __DIR__ . "/../models/User.php";

class AuthController{
    public function register($data){
        if(!Validator::required($data["name"] ?? null)){
            return Response::error("Name is required", 400);
        }

        if(!Validator::required($data["email"] ?? null)){
            return Response::error("Email is required", 400);
        }

        if(!Validator::email($data["email"])){
            return Response::error("Invalid email format", 400);
        }

        if(!Validator::required($data["password"] ?? null)){
            return Response::error("Password cant be empty", 400);
        }

        if(!Validator::minLength($data["password"], 8)){
            return Response::error("Password cant be less than 8 characters", 400);
        }

        $existingUser = User::findByEmail($data["email"]);
        if($existingUser){
            return Response::error("Email is already registered", 409);
        }

        $hashedPassword = password_hash($data["password"], PASSWORD_DEFAULT);

        $userId = User::create($data["name"], $data["email"], $hashedPassword);

        return Response::success("User registered successfully!", ["user_id" => $userId], 201);
    }

    public function login($data){

        if(!Validator::required($data["email"] ?? null)){
            return Response::error("Email is required", 400);
        }

        if(!Validator::email($data)){
            return Response::error("Invalid email format", 400);
        }

        if(!Validator::required($data["password"] ?? null)){
            return Response::error("Password cant be empty", 400);
        }

        $user = User::findByEmail($data["email"]);
        if(!$user){
            return Response::error("Email or password are invalid", 401);
        }

        if(!password_verify($data["password"], $user["password_hash"])){
            return Response::error("Email or password are invalid", 401);
        }

        return Response::success("LogIn Successful", [
            "user_id" => $user["id"],
            "user_name" => $user["name"],
            "user_email" => $user["email"],
            "user_role" => $user["role"]
        ]);
    }

    public function logout(){
        return Response::success("Logged out successfully");
    }
}

?>
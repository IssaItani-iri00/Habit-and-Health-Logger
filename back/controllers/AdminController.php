<?php
require_once __DIR__ . "/../helpers/Response.php";
require_once __DIR__ . "/../helpers/Validator.php";
require_once __DIR__ . "/../models/User.php";

class AdminController{
    private function requireAdmin($admin_user_id){
        if(!Validator::required($admin_user_id)){
            return Response::error("Admin ID is required", 400);
        }

        $admin_user_id = (int)$admin_user_id;
        $admin = User::findById($admin_user_id);

        if(!$admin){
            return Response::error("Admin user not found", 404);
        }

        if(($admin["role"] ?? "user") !== "admin"){
            return Response::error("Forbidden, Only admins are allowed!", 403);
        }

        return true;
    }

    public function getAllUsers($data){
        $adminCheck = $this->requireAdmin($data["admin_user_id"] ?? null);
        
        if($adminCheck !== true){
            return $adminCheck;
        }

        $users = User::getAllUsers();
        return Response::success("Users fetched successfully", 200, ["users" => $users]);
    }

    public function deleteUser($data){

        if(!Validator::required($data["user_id"])){
            return Response::error("User ID is required", 400);
        }

        $adminCheck = $this->requireAdmin($data["admin_user_id"] ?? null);
        
        if($adminCheck !== true){
            return $adminCheck;
        }

        if((int)$data["admin_user_id"] === (int)$data["user_id"]){
            return Response::error("You cannot delete your own account", 403);
        }

        $deleted = User::deleteUserById($data["user_id"]);

        if(!$deleted){
            return Response::error("Failed to delete User", 500);
        }

        return Response::success("User successfully deleted", 200);

    }
}


?>
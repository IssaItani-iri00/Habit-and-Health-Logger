<?php
require_once __DIR__ . "/../helpers/Response.php";
require_once __DIR__ . "/../helpers/Validator.php";
require_once __DIR__ . "/../models/Habit.php";

class HabitController{
    public function create($data){
        if(!Validator::required($data["name"] ?? null)){
            return Response::error("Name is required", 400);
        }

        if(!Validator::required($data["user_id"] ?? null)){
            return Response::error("User ID is required", 400);
        }

        $user_id = (int) $data["user_id"];
        $name = $data["name"];
        $type = $data["type"] ?? null;
        $unit = $data["unit"] ?? null;

        $target_value = null;

        if(isset($data["target_value"]) && $data["target_value"] !== ""){
            $target_value = (float) $data["target_value"];
        }
        
        $habit = Habit::create($user_id, $name, $type, $unit, $target_value);

        if($habit){
            return Response::success("Habit created successfully :)", 201);
        }
        else{
            return Response::error("Error creating a habit :(", 500);
        }
    }

    public function getAllUserHabits($data){
        if(!Validator::required($data["user_id"]) ?? null){
            return Response::error("User ID is required", 400);
        }

        $user_id = (int) $data["user_id"];
        $habits = Habit::getAllByUserId($user_id);

        if($habits){
            return Response::success("Habits fetched successfully ", 200, [
                "habits" => $habits
            ]);
        }
    }

    public function deleteHabit($data){
        if(!Validator::required($data["id"]) ?? null){
            return Response::error("ID is required", 400);
        }

        if(!Validator::required($data["user_id"]) ?? null){
            return Response::error("User ID is required", 400);
        }

        $user_id = (int) $data["user_id"];
        $habit_id = (int) $data["id"];

        $deleted_habit = Habit::deleteById($habit_id, $user_id);

        if(!$deleted_habit){
            return Response::error("Error deleting the habit :(", 500);
        }
        else{
            return Response::success("Habit deleted successfully :)");
        }
    }
}



?>
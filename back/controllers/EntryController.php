<?php
require_once __DIR__ . "/../helpers/Response.php";
require_once __DIR__ . "/../helpers/OpenAIClient.php";
require_once __DIR__ . "/../helpers/Validator.php";
require_once __DIR__ . "/../models/Entry.php";

class EntryController{
    public function create($data){
        if(!Validator::required($data["user_id"] ?? null)){
            echo Response::error("User ID is required", 400);
            return;
        }

        if(!Validator::required($data["raw_text"] ?? null)){
            echo Response::error("Entry is required", 400);
            return;
        }

        if(!Validator::required($data["entry_date"] ?? null)){
            echo Response::error("Entry date is required", 400);
            return;
        }

        $user_id = (int) $data["user_id"];
        $raw_text = $data["raw_text"];
        $entry_date = $data["entry_date"];
        $ai = OpenAIClient::parseText($raw_text);

        $walking_minutes = isset($ai["walking_minutes"]) ? (int) $ai["walking_minutes"] : null;
        $coffee_cups = isset($ai["coffee_cups"]) ? (int) $ai["coffee_cups"] : null;
        $water_cups = isset($ai["water_cups"]) ? (int) $ai["water_cups"] : null;
        $sleep_time = $ai["sleep_time"] ?? null;
        $sleep_duration_minutes = isset($ai["sleep_duration_minutes"]) ? (int) $ai["sleep_duration_minutes"] : null;
        $mood = $ai["mood"] ?? null;
        $estimated_calories = isset($ai["estimated_calories"]) ? (int) $ai["estimated_calories"] : null;
        $meal_suggestion = $ai["meal_suggestion"] ?? null;
        $nutrition = null;

        if(isset($ai["nutrition"]) && is_array($ai["nutrition"])){
            $nutrition = json_encode($ai["nutrition"]);
        }

        $entry = Entry::createEntry(
            $user_id,
            $raw_text,
            $entry_date,
            $walking_minutes,
            $coffee_cups,
            $water_cups,
            $sleep_time,
            $sleep_duration_minutes,
            $mood,
            $estimated_calories,
            $meal_suggestion,
            $nutrition
        );

        if (!$entry) {
            echo Response::error("Failed to create entry", 500);
            return;
        }

        echo Response::success("Entry created successfully",201, ["ai" => $ai]);
    }

    public function getEntriesByUser(){
        $data = json_decode(file_get_contents("php://input"), true);

        if (!Validator::required($data["user_id"] ?? null)) {
            echo Response::error("User ID is required", 400);
            return;
        }

        $user_id = (int)$data["user_id"];
        $entries = Entry::getEntriesByUserId($user_id);

        echo Response::success("Entries fetched successfully", 200, ["entries" => $entries]);
    }

    public function getEntriesByDate(){
        $data = json_decode(file_get_contents("php://input"), true);

        if (!Validator::required($data["user_id"] ?? null)) {
            echo Response::error("User ID is required", 400);
            return;
        }

        if (!Validator::required($data["entry_date"] ?? null)) {
            echo Response::error("Entry date is required", 400);
            return;
        }

        $user_id = (int)$data["user_id"];
        $entry_date = $data["entry_date"];

        $entries = Entry::getEntriesByDate($user_id, $entry_date);

        echo Response::success("Entries fetched successfully", 200, ["entries" => $entries]);
    }

    public function deleteEntry(){
        $data = json_decode(file_get_contents("php://input"), true);

        if (!Validator::required($data["user_id"] ?? null)) {
            echo Response::error("User ID is required", 400);
            return;
        }

        if (!Validator::required($data["id"] ?? null)) {
            echo Response::error("Entry ID is required", 400);
            return;
        }

        $user_id = (int)$data["user_id"];
        $entry_id = (int)$data["id"];

        $deleted = Entry::deleteEntry($entry_id, $user_id);

        if (!$deleted) {
            echo Response::error("Failed to delete entry", 500);
            return;
        }

        echo Response::success("Entry deleted successfully");
    }
}


?>
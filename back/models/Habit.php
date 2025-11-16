<?php
require_once __DIR__ . "/../db-configuration/db_connect.php";

class Habit{
    public static function create($user_id, $name, $type = null, $unit = null, $target_value = null){
        global $conn;
        
        $sql = "INSERT INTO habits (user_id, name, type, unit, target_value) VALUES (?, ?, ?, ?, ?)";
        $query = $conn -> prepare($sql);
        $query -> bind_param("isssd", $user_id, $name, $type, $unit, $target_value);

        return $query -> execute();
    }

    public static function getAllByUserId($user_id){
        global $conn;

        $sql = "SELECT * FROM habits WHERE user_id = ?";
        $query = $conn -> prepare($sql);
        $query -> bind_param("i", $user_id);
        $query -> execute();

        $result = $query -> get_result();
        $habits = [];

        while($row = $result -> fetch_assoc()){
            $habits[] = $row;
        }

        return $habits;
    }

    public static function getHabitById($id){
        global $conn;

        $sql = "SELECT * FROM habits WHERE id = ?";
        $query = $conn -> prepare($sql);
        $query -> bind_param("i", $id);
        $query -> execute();
        $habit = $query -> get_result();

        return $habit; 

    }

    public static function deleteById($id, $user_id){
        global $conn;

        $sql = "DELETE FROM habits WHERE id = ? AND user_id = ?";
        $query = $conn -> prepare($sql);
        $query -> bind_param("ii", $id, $user_id);

        return $query -> execute();
    }
}


?>
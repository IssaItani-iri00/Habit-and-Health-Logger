<?php

class Entry{
    public static function createEntry($user_id, $raw_text, $entry_date,
    $walking_minutes = null,
    $coffee_cups = null,
    $sleep_time = null,
    $sleep_duration_minutes = null,
    $estimated_calories = null,
    $meal_suggestion = null,
    $nutrition = null
    ){
        global $conn;

        $sql = "INSERT INTO entries (user_id, raw_text, entry_date, walking_minutes, coffee_cups, sleep_time,
        sleep_duration_minutes, estimated_calories, meal_suggestion, nutrition) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $query = $conn -> prepare($sql);
        $query -> bind_param("issiisiiss", $user_id, $raw_text, $entry_date, $walking_minutes, $coffee_cups, $sleep_time, $sleep_duration_minutes,
        $estimated_calories, $meal_suggestion, $nutrition);

        return $query -> execute();
    }

    public static function getEntriesByUserId($user_id){
        global $conn;

        $sql = "SELECT * FROM entries WHERE user_id = ?";
        $query = $conn -> prepare($sql);
        $query -> bind_param("i", $user_id);
        $query -> execute();

        $result = $query -> get_result();
        $entries = [];

        while($row = $result -> fetch_assoc()){
            $entries[] = $row;
        }

        return $entries;
    }

    public static function getEntriesByDate($user_id, $entry_date){
        global $conn;

        $sql = "SELECT * FROM entries WHERE user_id = ? AND entry_date = ?";
        $query = $conn -> prepare($sql);
        $query -> bind_param("is", $user_id, $entry_date);
        $query->execute();

        $result = $query->get_result();
        $entries = [];

        while ($row = $result->fetch_assoc()) {
            $entries[] = $row;
        }

        return $entries;
    }

    public static function deleteEntry($entry_id, $user_id){
        global $conn;

        $sql = "DELETE FROM entries WHERE id = ? AND user_id = ?";
        $query = $conn -> prepare($sql);
        $query -> bind_param("ii", $entry_id, $user_id);
        $query -> execute();

        return $query -> affected_rows > 0;
    }
}

?>
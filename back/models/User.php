<?php
require_once __DIR__ . "/../db-configuration/db_connect.php";

class User{
    public static function findByEmail($email){
        global $conn;

        $sql = "SELECT * FROM users WHERE email = ?";
        $query = $conn -> prepare($sql);
        $query -> bind_param("s", $email);
        $query->execute();

        $result = $query -> get_result();
        $result = $result ->fetch_assoc();

        return $result;
    }

    public static function create($name, $email, $passwordHash){
        global $conn;

        $role = "user";

        $sql = "INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)";
        $query = $conn -> prepare($sql);
        $query -> bind_param("ssss", $name, $email, $passwordHash, $role);

        if($query -> execute()){
            return $conn -> insert_id;
        }
        else{
            return false;
        }
    }

    public static function findById($id){
        global $conn;

        $sql = "SELECT * FROM users WHERE id = ?";
        $query = $conn -> prepare($sql);
        $query -> bind_param("i", $id);
        $query->execute();

        $result = $query -> get_result();
        $result = $result -> fetch_assoc();

        return $result;
    }
}

?>
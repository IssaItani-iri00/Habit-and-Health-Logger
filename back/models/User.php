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

    public static function getAllUsers(){
        global $conn;

        $sql = "SELECT * FROM users";
        $query = $conn -> prepare($sql);
        $query -> execute();
        $result = $query -> get_result();
        $users = [];

        while ($row = $result -> fetch_assoc()){
            $users[] = $row;
        }

        return $users;
    }

    public static function deleteUserById($id){
        global $conn;

        $sql = "DELETE FROM users WHERE id = ?";
        $query = $conn-> prepare($sql);
        $query -> bind_param("i", $id);

        return $query -> execute();
    }
}

?>
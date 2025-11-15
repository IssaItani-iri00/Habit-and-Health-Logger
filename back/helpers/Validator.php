<?php

class Validator{

    public static function required($data){
        return isset($data) && trim($data) !== "";
    }

    public static function email($data){
        return filter_var($data["email"], FILTER_VALIDATE_EMAIL);
    }

    //checks minimum length given a certain number
    public static function minLength($data, $min){
        return strlen(trim($data)) >= $min;
    }
}


?>
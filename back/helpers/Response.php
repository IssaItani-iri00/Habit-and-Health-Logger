<?php

class Response{
    
    public static function success($message = "Success", int $status = 200, $data = null){
        $payload = ["message" => $message];

        if($data !== null){
            $payload["data"] = $data;
        }

        $result = json_encode([
            "status" => $status,
            "data" => $payload
        ]);

        return $result;
    }

    public static function error($message = "Error", int $status = 400){
        $result = json_encode([
            "status" => $status,
            "error" => $message
        ]);

        return $result;
    }
}


?>
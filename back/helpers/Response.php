<?php

class Response{

    public static function json($data, int $status = 200){
        return json_encode([
            "status" => $status,
            "data" => $data
        ]);
    }

    public static function success($message = "Success", int $status = 200, $data = null){
        $payload = ["message" => $message];

        if($data !== null){
            $payload["data"] = $data;
        }

        return json_encode([
            "status" => $status,
            "data" => $payload
        ]);
    }

    public static function error($message = "Error", int $status = 400){
        return json_encode([
            "status" => $status,
            "error" => $message
        ]);
    }
}


?>
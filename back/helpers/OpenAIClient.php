<?php
require_once __DIR__ . "/../db-configuration/openAI-config.php";

class OpenAIClient{
    public static function parseText($raw_text){
        global $api_url;
        global $api_key;
        $prompt = [
            "model" => "gpt-4o-mini",
            "messages" => [
                [
                    "role" => "system",
                    "content" => 'You are a health and habit assistant. Extract structured data from text and return STRICT JSON: {
                        "walking_minutes": number or null,
                        "coffee_cups": number or null,
                        "water_cups": number or null,
                        "sleep_time": string in "HH:MM:SS" format (24-hour) or null,
                        "sleep_duration_minutes": number or null,
                        "mood": string or null,
                        "estimated_calories": number or null,
                        "meal_suggestion": string or null,
                        "nutrition": {
                            "protein": number or null,
                            "carbs": number or null,
                            "fat": number or null
                        }
                    }
                    Important: 
                    - sleep_time must be in 24-hour format like "19:00:00" for 7pm, "22:30:00" for 10:30pm, etc.
                    - When food/meals are mentioned, ALWAYS estimate nutrition values (protein, carbs, fat in grams) based on typical portion sizes.
                    - If meals are described, populate the nutrition object with reasonable estimates. Do not leave nutrition null when food is mentioned.'
                ],
                ["role" => "user", "content" => $raw_text]
            ],
            "response_format" => ["type" => "json_object"]
        ];

        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json", "Authorization: Bearer " . $api_key
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($prompt));

        $response = curl_exec($ch);
        curl_close($ch);

        $aiResult = json_decode($response, true);

        return json_decode($aiResult["choices"][0]["message"]["content"] ?? "{}", true);

    }
}


?>
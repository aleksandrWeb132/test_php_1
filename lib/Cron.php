<?php

namespace lib;

class Cron {
    function get($url): array {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        if (curl_errno($ch)) {
            return [
                "code" => 404,
                "message" => "Ошибка cURL",
                "body" => $ch
            ];
        }
        else {
            return [
                "code" => 1,
                "message" => "Ответ от сервера",
                "body" => json_decode($response, true)
            ];
        }
    }
}
<?php

require 'vendor/autoload.php';
require 'config.php';

use Google\Client;

function sendNotification($title, $body)
{
    global $conn;

    $client = new Client();

    $client->setAuthConfig(__DIR__ . "/smartposture-fd189-firebase-adminsdk-fbsvc-420f32b9e4.json");

    $client->addScope("https://www.googleapis.com/auth/firebase.messaging");

    $token = $client->fetchAccessTokenWithAssertion();

    if (!isset($token["access_token"])) {
        return;
    }

    $accessToken = $token["access_token"];

    $result = $conn->query("SELECT token FROM device_tokens");

    while ($row = $result->fetch_assoc()) {

        $message = [
            "message" => [
                "token" => $row["token"],
                "notification" => [
                    "title" => $title,
                    "body" => $body
                ]
            ]
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,
            "https://fcm.googleapis.com/v1/projects/smartposture-fd189/messages:send");

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer ".$accessToken,
            "Content-Type: application/json"
        ]);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));

        curl_exec($ch);

        curl_close($ch);
    }
}
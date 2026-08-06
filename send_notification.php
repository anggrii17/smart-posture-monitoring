<?php

require 'vendor/autoload.php';
require 'config.php';

use Google\Client;

function sendNotification($title, $body)
{
    global $conn;

    // Ambil JSON dari Railway Variables
    $json = getenv("FIREBASE_CREDENTIALS");

    if (!$json) {
        error_log("FIREBASE_CREDENTIALS tidak ditemukan.");
        return;
    }

    // Simpan sementara ke file
    $tempFile = sys_get_temp_dir() . "/firebase.json";
    file_put_contents($tempFile, $json);

    $client = new Client();
    $client->setAuthConfig($tempFile);
    $client->addScope("https://www.googleapis.com/auth/firebase.messaging");

    $token = $client->fetchAccessTokenWithAssertion();

    if (!isset($token["access_token"])) {
        error_log("Gagal mendapatkan Access Token.");
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

        curl_setopt(
            $ch,
            CURLOPT_URL,
            "https://fcm.googleapis.com/v1/projects/smartposture-fd189/messages:send"
        );

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . $accessToken,
            "Content-Type: application/json"
        ]);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            error_log(curl_error($ch));
        } else {
            error_log($response);
        }

        curl_close($ch);
    }

    // Hapus file sementara
    @unlink($tempFile);
}
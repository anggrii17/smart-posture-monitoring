<?php

include "config.php";

header("Content-Type: application/json");

$token = $_POST['token'] ?? '';

if (empty($token)) {
    echo json_encode([
        "success" => false,
        "message" => "Token kosong"
    ]);
    exit;
}

// Cek apakah token sudah ada
$stmt = $conn->prepare("SELECT id FROM device_tokens WHERE token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $stmt = $conn->prepare("INSERT INTO device_tokens (token) VALUES (?)");
    $stmt->bind_param("s", $token);
    $stmt->execute();
}

echo json_encode([
    "success" => true,
    "message" => "Token berhasil disimpan"
]);

$conn->close();
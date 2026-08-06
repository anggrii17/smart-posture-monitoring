<?php

include "config.php";
require_once "send_notification.php";

$pitch  = $_POST['pitch'] ?? null;
$status = $_POST['status'] ?? null;

if ($pitch === null || $status === null) {

    echo json_encode([
        "success" => false,
        "message" => "Data POST kosong"
    ]);

    exit;
}

// Cek apakah sudah ada data
$cek = $conn->query("SELECT id, status FROM current_posture LIMIT 1");

$statusLama = "";

if ($cek->num_rows > 0) {

    $row = $cek->fetch_assoc();

    $id = $row['id'];
    $statusLama = $row['status'];

    $sql = "UPDATE current_posture
            SET
                pitch='$pitch',
                status='$status',
                timestamp=NOW(),
                last_update=NOW()
            WHERE id=$id";

} else {

    $sql = "INSERT INTO current_posture
            (pitch,status,timestamp,last_update)
            VALUES
            ('$pitch','$status',NOW(),NOW())";

}

if ($conn->query($sql)) {

    // Kirim notifikasi hanya saat berubah menjadi Tidak Ergonomis
    if ($status == "Tidak Ergonomis" && $statusLama != "Tidak Ergonomis") {

        sendNotification(
            "Smart Posture",
            "Postur tubuh Anda tidak ergonomis. Segera perbaiki posisi duduk."
        );

    }

    echo json_encode([
        "success" => true,
        "message" => "Current posture updated"
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => $conn->error
    ]);

}

$conn->close();

?>
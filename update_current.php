<?php

include "config.php";

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
$cek = $conn->query("SELECT id FROM current_posture LIMIT 1");

if ($cek->num_rows > 0) {

    // Jika sudah ada -> UPDATE
    $row = $cek->fetch_assoc();

    $id = $row['id'];

    $sql = "UPDATE current_posture
            SET
                pitch='$pitch',
                status='$status',
                timestamp=NOW(),
                last_update=NOW()
            WHERE id=$id";

} else {

    // Jika tabel kosong -> INSERT
    $sql = "INSERT INTO current_posture
            (pitch,status,timestamp,last_update)
            VALUES
            ('$pitch','$status',NOW(),NOW())";

}

if ($conn->query($sql)) {

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
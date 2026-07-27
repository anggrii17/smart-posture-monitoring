<?php

include "config.php";

$sql = "SELECT *
        FROM posture_logs
        ORDER BY timestamp DESC
        LIMIT 20";

$result = $conn->query($sql);

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Jangan dibalik lagi
echo json_encode($data);

$conn->close();

?>
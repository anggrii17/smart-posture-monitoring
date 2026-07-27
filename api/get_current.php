<?php

include "config.php";

$sql = "SELECT * FROM current_posture WHERE id=1";

$result = $conn->query($sql);

$data = $result->fetch_assoc();

echo json_encode($data);

$conn->close();

?>
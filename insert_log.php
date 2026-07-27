<?php

include "config.php";

$pitch  = $_POST['pitch'];
$status = $_POST['status'];

$sql = "INSERT INTO posture_logs
(pitch,status,timestamp)

VALUES

('$pitch','$status',DATE_ADD(NOW(), INTERVAL 7 HOUR))";


if($conn->query($sql)){
    echo json_encode([
        "success"=>true
    ]);
}else{
    echo json_encode([
        "success"=>false,
        "message"=>$conn->error
    ]);
}

$conn->close();

?>
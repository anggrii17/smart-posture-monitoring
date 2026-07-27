<?php

include "config.php";

$pitch  = $_POST['pitch'];
$status = $_POST['status'];

$sql = "UPDATE current_posture
        SET
        pitch='$pitch',
        status='$status',
        timestamp=DATE_ADD(NOW(), INTERVAL 7 HOUR)
        WHERE id=1";


if($conn->query($sql)){
    echo json_encode([
        "success"=>true,
        "message"=>"Current posture updated"
    ]);
}else{
    echo json_encode([
        "success"=>false,
        "message"=>$conn->error
    ]);
}

$conn->close();

?>
<?php

include "config.php";

$pitch  = $_POST['pitch'];
$status = $_POST['status'];

$sql = "UPDATE current_posture
        SET
        pitch='$pitch',
        status='$status',
        timestamp=NOW()
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
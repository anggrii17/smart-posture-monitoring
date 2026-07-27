<?php

include "config.php";

$pitch  = $_POST['pitch'] ?? null;
$status = $_POST['status'] ?? null;


if ($pitch === null || $status === null) {

    echo json_encode([
        "success"=>false,
        "message"=>"Data POST kosong"
    ]);

    exit;
}


$sql = "UPDATE current_posture
        SET
        pitch='$pitch',
        status='$status',
        timestamp=NOW(),
        last_update=NOW()
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
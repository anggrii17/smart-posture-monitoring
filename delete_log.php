<?php

include "config.php";

$id = $_POST['id'];

$sql = "DELETE FROM posture_logs WHERE id='$id'";


if($conn->query($sql)){

    echo json_encode([
        "success"=>true,
        "message"=>"Data berhasil dihapus"
    ]);

}else{

    echo json_encode([
        "success"=>false,
        "message"=>$conn->error
    ]);

}

$conn->close();

?>
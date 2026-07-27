<?php

include "config.php";

$pitch = $_POST['pitch'];
$status = $_POST['status'];
$respondent_id = $_POST['respondent_id'];

$sql = "INSERT INTO training_data
(respondent_id, pitch, status)
VALUES
('$respondent_id','$pitch','$status')";

if($conn->query($sql)){
    echo json_encode(["success"=>true]);
}else{
    echo json_encode(["success"=>false]);
}

$conn->close();

?>
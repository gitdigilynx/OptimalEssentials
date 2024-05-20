<?php
require_once("../../inc/db_connect.php");
require_once("../header.php");


$question_id = $_GET['question_id'];

$sql= "DELETE FROM question_hard WHERE id=$question_id";
if ($conn->query($sql) === TRUE) {
   
    $delete_answer = "DELETE FROM answers WHERE question_id=$question_id";
    if ($conn->query($delete_answer) === TRUE) {
        echo 'record Deleted';
    }else {
        echo "Error deleting record: " . $conn->error;
      }

  } else {
    echo "Error deleting record: " . $conn->error;
  }
  
  $conn->close();

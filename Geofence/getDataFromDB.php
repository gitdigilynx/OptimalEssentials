<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$servername = "localhost";
$username = "admin988";
$password = "w=i6O)TZ~qKU";
$dbname = "elderlysupplements2";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
$request_body = file_get_contents('php://input');
$data = json_decode($request_body, true);
// print_r($data);exit();
    $query = "SELECT * FROM geo_json";
    $result = $conn->query($query);
    $array = [];
    while ($row = $result->fetch_assoc()) {
        array_push($array,$row);
    }
    // $array = array_map(function($arr) {
    //     $arr['center'] = json_encode($arr['center']);
    // },$array);
    echo json_encode($array);

<?php

//oop
$conn = new mysqli("localhost", "root", "", "myproject");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



//procedural
// $con =mysqli_connect("localhost", "root", "","myproject");
// if(! $con){
//     die("Connection failed: ". mysqli_connect_error());
// }
?>


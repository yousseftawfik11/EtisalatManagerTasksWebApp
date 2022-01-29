<?php


// Set the variables 
$servername = "localhost";
$username = "root";
$password = "";




// Select the databse
$conn = new mysqli($servername,$username,$password,"taskssys");

if ($conn->connect_error) {
    die("Connection failed: " . mysqli_connect_error());
  }else{
      // echo "conn successfully";
  }


?>
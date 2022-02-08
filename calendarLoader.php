<?php
session_start();
if(!isset($_SESSION["username"])||$_SESSION["username"]!=5000){
    echo '
    <script>
    window.location.href="index.php";
    </script>
  ';
}
    include("db.php");//Includes the database file that makes the connection
    $timetable = mysqli_query($conn, "SELECT Task_title, due FROM tasks");//Loading events for the calendar
    $myArray = array();
    if ($timetable->num_rows > 0) {
        // To output the data of each row
        while($row = $timetable->fetch_assoc()) {
            $myArray[] = $row;
        }
    } 
    echo json_encode($myArray);
?>
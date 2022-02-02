<?php
include("db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members Page</title>
</head>
<body>
    
    <table>
        <tr>
            <th>Title</th>
            <th>Task Details</th>
            <th>Start Date</th>
            <th>Due Date</th>
            <th>Status</th>
            <th>Priority</th>
            <th>Attachment</th>
        </tr>
        <?php
        $sql="SELECT task_id,Task_title,Content,start_Date,due,status,priority,attachment_name FROM tasks WHERE status='0'";
        if($result= mysqli_query($conn,$sql)){
            if(mysqli_num_rows($result)>0){
            
            }}
        
        
        ?>


    </table>





</body>
</html>
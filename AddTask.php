<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>
    <script src="sweetalert2.min.js"></script>
<link rel="stylesheet" href="sweetalert2.min.css">
</head>
<body class="backgroundimage">
    
</body>
</html>

<?php
include('sendmail.php');

if(isset($_POST["submit"])){

    // if(empty($_POST["check_list_member"])){
    //     echo "<script>Swal.fire({
    //         icon: 'error',
    //         title: 'Try Again!',
    //         text: 'Failed to create task, please choose members'
    //       })</script>";
    // }else  //removed making the members selection required
    if(empty($_POST["check_list_leader"])){
        echo "<script>Swal.fire({
            icon: 'error',
            title: 'Try Again!',
            text: 'Failed to create task, please choose leaders'
          })</script>";
    }else{

        if(empty($_POST["check_list_member"])){
            $memberslist= [];
        }else{
            $memberslist= $_POST["check_list_member"];
        }
 
   
        $leaderslist= $_POST["check_list_leader"];
    

    $pname = rand(1000,100000)."-".$_FILES["file"]["name"];
    $tname = $_FILES["file"]["tmp_name"];
    $uploads_dir= 'C:/xampp/htdocs/taskSys/uploads';

    move_uploaded_file($tname, $uploads_dir.'/'.$pname);

    $title= mysqli_real_escape_string($conn,$_POST['TaskTitle']);
    $info = mysqli_real_escape_string($conn, $_POST['TaskInfo']);
    $due = mysqli_real_escape_string($conn, $_POST['TaskDue']);
    $priority = mysqli_real_escape_string($conn,$_POST["priority"]);
   

    $addTask = "INSERT INTO tasks(Task_title,Content,due,manager_id,status,priority,attachment_name) 
    VALUES ('$title','$info','$due','5000','0','$priority','$pname')";

    $query = mysqli_query($conn, $addTask);

    if ($query) {

    echo "<script>Swal.fire({
        title: 'Task Created Successfully!',
        icon: 'success',
        confirmButtonColor: '#38a53e',
        confirmButtonText: 'OK'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href='TasksView.php';
      
        }
      })</script>";

    } else {
        echo "<script>Swal.fire({
            icon: 'error',
            title: 'Try Again!',
            text: 'Failed to create task, please contact website admin',
            confirmButtonColor: '#f27474',
            confirmButtonText: 'OK'
          })</script>";
    }

    $getTaskID= "SELECT MAX(task_id) FROM tasks";
    $result= mysqli_query($conn, $getTaskID);
    $value= mysqli_fetch_row($result);




 

    for($i=0; $i<sizeof($memberslist); $i++){

        $QueryMembersTasksTable="INSERT INTO task_members(member_id, task_id) VALUES('".$memberslist[$i]."','$value[0]')" ;
        $query = mysqli_query($conn, $QueryMembersTasksTable);
        
        $getEmail="SELECT email FROM team_members WHERE member_id=".$memberslist[$i];
        $Emailexexcute= mysqli_query($conn, $getEmail);
        while($row = mysqli_fetch_array($Emailexexcute)){
            sendMailMember($row['email'],$_POST['TaskInfo'],$_POST['TaskDue']);
    }

        
    }

    for($i=0; $i<sizeof($leaderslist); $i++){

        $QueryMembersTasksTable="INSERT INTO task_leaders(leader_id, task_id) VALUES('".$leaderslist[$i]."','$value[0]')" ;
        $query = mysqli_query($conn, $QueryMembersTasksTable);

        $getEmail="SELECT email FROM team_members WHERE member_id=".$memberslist[$i];
        $Emailexexcute= mysqli_query($conn, $getEmail);
        while($row = mysqli_fetch_array($Emailexexcute)){
            sendMailLeader($row['email'],$_POST['TaskInfo'],$_POST['TaskDue']);
    }
        
    }

    $getEmail="SELECT email FROM managers WHERE M_ID= '5000'";
    $Emailexexcute= mysqli_query($conn, $getEmail);
    while($row = mysqli_fetch_array($Emailexexcute)){
        sendMailManager($row['email'],$_POST['TaskInfo'],$_POST['TaskDue']);
}
    //echo mysqli_error($conn); 

    }

}


?>
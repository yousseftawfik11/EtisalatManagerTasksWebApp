
<?php

if(isset($_POST["submit"])){

  

    $pname = rand(1000,100000)."-".$_FILES["file"]["name"];
    $tname = $_FILES["file"]["tmp_name"];
    $uploads_dir= 'C:/xampp/htdocs/taskSys/uploads';

    move_uploaded_file($tname, $uploads_dir.'/'.$pname);

    $title= mysqli_real_escape_string($conn,$_POST['TaskTitle']);
    $info = mysqli_real_escape_string($conn, $_POST['TaskInfo']);
    $due = mysqli_real_escape_string($conn, $_POST['TaskDue']);
    $priority = mysqli_real_escape_string($conn,$_POST["priority"]);
   

    $addTask = "INSERT INTO tasks(Task_title,Content,due,manager_id,status,priority,attachment_name) 
    VALUES ('$title','$info','$due','1234','0','$priority','$pname')";

    $query = mysqli_query($conn, $addTask);

    if ($query) {
        echo "<script>alert('Enrolled Successfully, payment can be made from the Payment page.');</script>";
    } else {
        echo "<script>alert('Failed to Enroll, please fill the enrollment form again.');</script>";
    }

    $getTaskID= "SELECT MAX(task_id) FROM tasks";
    $result= mysqli_query($conn, $getTaskID);
    $value= mysqli_fetch_row($result);
    echo $value[0];



    $memberslist= $_POST["check_list_member"];
 
   
    $leaderslist= $_POST["check_list_leader"];

    for($i=0; $i<sizeof($memberslist); $i++){

        $QueryMembersTasksTable="INSERT INTO task_members(member_id, task_id) VALUES('".$memberslist[$i]."','$value[0]')" ;
        $query = mysqli_query($conn, $QueryMembersTasksTable);

        if ($query) {
            echo " team members added";
        } else {
            
        }
        
    }

    for($i=0; $i<sizeof($leaderslist); $i++){

        $QueryMembersTasksTable="INSERT INTO task_leaders(leader_id, task_id) VALUES('".$leaderslist[$i]."','$value[0]')" ;
        $query = mysqli_query($conn, $QueryMembersTasksTable);

        if ($query) {
            echo " team members added";
        } else {
            
        }
        
    }
    //echo mysqli_error($conn); 

}

?>
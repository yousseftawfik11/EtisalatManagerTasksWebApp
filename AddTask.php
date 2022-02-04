
<?php

if(isset($_POST["submit"])){

    if(empty($_POST["check_list_member"])){
        echo '<script>
        alert("Failed to create task, please choose members")
        </script>';
    }elseif(empty($_POST["check_list_leader"])){
        echo '<script>
        alert("Failed to create task, please choose leaders")
        </script>';
    }else{

        $memberslist= $_POST["check_list_member"];
 
   
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
        echo "<script>alert('Task created successfully');</script>";
        echo '
        <script>
        window.location.href="TasksView.php";
        </script>
      ';

    } else {
        echo "<script>alert('Failed to create task, please contact website admin');</script>";
    }

    $getTaskID= "SELECT MAX(task_id) FROM tasks";
    $result= mysqli_query($conn, $getTaskID);
    $value= mysqli_fetch_row($result);
    echo $value[0];



 

    for($i=0; $i<sizeof($memberslist); $i++){

        $QueryMembersTasksTable="INSERT INTO task_members(member_id, task_id) VALUES('".$memberslist[$i]."','$value[0]')" ;
        $query = mysqli_query($conn, $QueryMembersTasksTable);
        
    }

    for($i=0; $i<sizeof($leaderslist); $i++){

        $QueryMembersTasksTable="INSERT INTO task_leaders(leader_id, task_id) VALUES('".$leaderslist[$i]."','$value[0]')" ;
        $query = mysqli_query($conn, $QueryMembersTasksTable);
        
    }
    //echo mysqli_error($conn); 

    }
}


?>
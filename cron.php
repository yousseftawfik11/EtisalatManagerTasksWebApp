<?php
include('db.php');
include('mailer.php');

$date=  date("Y-m-d", strtotime($date. ' + 2 days'));

echo $date;

// $query="SELECT task_id, task_title FROM tasks WHERE due='$date'";
// if($result= mysqli_query($conn,$query)){
//     if(mysqli_num_rows($result)>0){
//         while($row1 = mysqli_fetch_array($result)){

//             $memberid="(SELECT member_id FROM task_members WHERE task_id = ".$row1['task_id'].")
//             UNION(SELECT leader_id FROM task_leaders WHERE task_id = ".$row1['task_id'].")";

//             $mailArray=[];

//             if($result= mysqli_query($conn,$memberid)){
//                 if(mysqli_num_rows($result)>0){
//                     while($row2 = mysqli_fetch_array($result)){
//                         $getEmail="SELECT email FROM team_members WHERE member_id=".$row2["member_id"];
//                         $Emailexexcute= mysqli_query($conn, $getEmail);
//                         while($row2 = mysqli_fetch_array($Emailexexcute)){
//                             array_push($mailArray,$row2['email']);
//                         }
//                         dueMail($mailArray,$row1['task_title']);
//                     }

//                 }
//             }
//         }
//     }
// }else{
//     echo "error";
// }

// echo mysqli_error($conn); 

?>

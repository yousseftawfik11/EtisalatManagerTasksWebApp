<?php

function sendMailMember($email,$content,$due){

    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = "announcements@tornadoteam.website";
    $to = $email;
    $subject = "New Task Assigned as Member";
    $message = $content.". With a due of '$due'";
    $headers = "From:" . $from;
    if(mail($to,$subject,$message, $headers)) {
        //echo "The email message was sent.";
    } else {
        echo "The email message was not sent.";
    }

}

function sendMailLeader($email,$content,$due){

    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = "announcements@tornadoteam.website";
    $to = $email;
    $subject = "New Task Assigned as Owner";
    $message = $content.". With a due of '$due'";
    $headers = "From:" . $from;
    if(mail($to,$subject,$message, $headers)) {
        //echo "The email message was sent.";
    } else {
        echo "The email message was not sent.";
    }

}



function sendMailManager($email,$content,$due){

    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = "announcements@tornadoteam.website";
    $to = $email;
    $subject = "You created a new task";
    $message = $content.". With a due of '$due'";
    $headers = "From:" . $from;
    if(mail($to,$subject,$message, $headers)) {
        //echo "The email message was sent.";
    } else {
        echo "The email message was not sent.";
    }

}

?>
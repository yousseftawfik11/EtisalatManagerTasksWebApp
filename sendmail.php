<?php

function sendMailMember($email,$title,$content,$due){

    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = "announcements@tornadoteam.website";
    $to = $email;
    $subject = "New Task Assigned as Member";
    $message = $title.": ".$content.". With a due of '$due'";
    $headers = "From:" . $from;
    if(mail($to,$subject,$message, $headers)) {
        //echo "The email message was sent.";
    } else {
        echo "The email message was not sent.";
    }

}


function sendMailMemberModify($email,$title,$content,$priority,$due){

    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = "announcements@tornadoteam.website";
    $to = $email;
    $subject = "Content of Task Was Modified";
    switch($priority){
        case 1:
            $message = $title.": ".$content.". With a due of ".$due.", Priority: Low";
            break;
        case 2:
            $message = $title.": ".$content.". With a due of ".$due.", Priority: Medium";
            break;
        case 3:
            $message = $title.": ".$content.". With a due of ".$due.", Priority: High";
            break;
        case 4:
            $message = $title.": ".$content.". With a due of ".$due.", Priority: Very High";
            break;
        default:
        $message = $title.": ".$content.". With a due of ".$due;

    }
    $headers = "From:" . $from;
    if(mail($to,$subject,$message, $headers)) {
        //echo "The email message was sent.";
    } else {
        echo "The email message was not sent.";
    }

}


function sendMailLeader($email,$title,$content,$due){

    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = "announcements@tornadoteam.website";
    $to = $email;
    $subject = "New Task Assigned as Owner";
    $message = $title.": ".$content.". With a due of '$due'";
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
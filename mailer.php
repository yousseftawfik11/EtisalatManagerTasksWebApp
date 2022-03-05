<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


function sendMember($Useremail,$info,$due){

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);


try {
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'tornadoteam.website';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'announcements@tornadoteam.website';                     //SMTP username
    $mail->Password   = 'Ymtk_Ymtk11';                               //SMTP password
   // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('announcements@tornadoteam.website', 'Tornado Team');
    foreach ($Useremail as $mailers)  {
        $mail->addAddress($mailers, 'Tornado Team Member');     //Add a recipient

    }
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'New Task Created';
    $mail->Body    = '<pre>'.$info.'</pre><br>The due date for this task is '.$due;
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}


function sendOwner($UseremailLeader,$info,$due){
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    
    
    try {
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'tornadoteam.website';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'announcements@tornadoteam.website';                     //SMTP username
        $mail->Password   = 'Ymtk_Ymtk11';                               //SMTP password
       // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('announcements@tornadoteam.website', 'Tornado Team');
        foreach ($UseremailLeader as $mailers)  {
            $mail->addAddress($mailers, 'Tornado Team Leader');     //Add a recipient
    
        }
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addBCC('bcc@example.com');
    
        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'New Task Created and you own it';
        $mail->Body    = '<pre>'.$info.'</pre><br>The due date for this task is '.$due;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    }

    
function sendModify($UseremailLeader,$info,$due,$title,$priority){
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    
    
    try {
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'tornadoteam.website';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'announcements@tornadoteam.website';                     //SMTP username
        $mail->Password   = 'Ymtk_Ymtk11';                               //SMTP password
       // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('announcements@tornadoteam.website', 'Tornado Team');
        foreach ($UseremailLeader as $mailers)  {
            $mail->addAddress($mailers, 'Tornado Team');     //Add a recipient
    
        }
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addBCC('bcc@example.com');
    
        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Content of task was modified';

        switch($priority){
            case 1:
                $mail->Body    = 'New Content: <pre>'.$info.'</pre><br>New Due Date: '.$due.'<br>New Priority: Low';
                break;
            case 2:
                $mail->Body    = 'New Title: '.$title.'<br>New Content: <pre>'.$info.'</pre><br>New Due Date: '.$due.'<br>New Priority: Medium';
                break;
            case 3:
                $mail->Body    = 'New Title: '.$title.'<br>New Content: <pre>'.$info.'</pre><br>New Due Date: '.$due.'<br>New Priority: High';
                break;
            case 4:
                $mail->Body    = 'New Title: '.$title.'<br>New Content: <pre>'.$info.'</pre><br>New Due Date: '.$due.'<br>New Priority: Very High';
                break;
            default:
            $mail->Body    = 'New Title: '.$title.'<br>New Content: <pre>'.$info.'</pre><br>New Due Date: '.$due;

        }

        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    }








    function dueMail($Useremail,$title){

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        
        
        try {
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'tornadoteam.website';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'announcements@tornadoteam.website';                     //SMTP username
            $mail->Password   = 'Ymtk_Ymtk11';                               //SMTP password
           // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom('announcements@tornadoteam.website', 'Tornado Team');
            foreach ($Useremail as $mailers)  {
                $mail->addAddress($mailers, 'Tornado Team Member');     //Add a recipient
        
            }
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addBCC('bcc@example.com');
        
            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = '2 Days Left Alert';
            $mail->Body    = $title.' task has two days left until its deadline';
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        }

        function SendVer($email, $code){
            $mail = new PHPMailer(true);
        
        
        try {
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'tornadoteam.website';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'announcements@tornadoteam.website';                     //SMTP username
            $mail->Password   = 'Ymtk_Ymtk11';                               //SMTP password
           // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom('announcements@tornadoteam.website', 'Tornado Team');

                $mail->addAddress($email, 'Tornado Team Member');     //Add a recipient
        
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addBCC('bcc@example.com');
        
            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Verification Code';
            $mail->Body    = 'Your verification code is '.$code;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        } 
        }

?>
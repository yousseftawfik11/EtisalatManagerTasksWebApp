<?php
session_start();
if(!isset($_SESSION["username"])||$_SESSION["username"]!=5000){
  echo '
  <script>
  window.location.href="index.php";
  </script>
';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Montserrat:wght@300&display=swap" rel="stylesheet">
 

    <link rel="stylesheet" href="css/styles.css">

    
    <!--Libraries for Calendar-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script>
          $(document).ready(function(){
            $('#calendar').fullCalendar({
                editable:false,//Prevents user from moving around events
                height:550,
                header:{
                left:'prev, next today',
                center:'title',
                right:'month, agendaWeek, agendaDay'
                },
                //events: 'loadCalendarEvents.php'
                events: function(start,end, timezone, callback){
                  $.ajax({
                    url: 'calendarLoader.php',
                    dataType: 'json',
                    data: {
                    },
                    success: function(data){
                      var events = [];
                  
                      for (var i=0; i<data.length; i++){
                        events.push({
                          title: data[i]['Task_title'],
                          start: data[i]['due'],
                          end: data[i]['due'],
                        });
                      }
                      //adding the callback
                      callback(events);
                    }
                  });
                }
            });
        });
    </script>
    <title>Calendar</title>
</head>
<body class="backgroundimage">
<nav class="navbar navbar-expand-lg navbar-light bg-light navBar-color">
<a class="navbar-brand navBar-color" href="#"><img class="logosize" src='images/horse.svg'><br><span class="logoText">Tornado</span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav  ml-auto">
      <a class="nav-item nav-link navBar-color" href="ManagerHome.php">Create Tasks </a>
      <a class="nav-item nav-link navBar-color" href="TasksView.php">View Tasks</a>
      <a class="nav-item nav-link navBar-color" href="modifyTask.php">Modify Tasks</a>
      <a class="nav-item nav-link navBar-color" href="TasksHistory.php">History Tasks</a>
      <a class="nav-item nav-link navBar-color active" href="DueCalendar.php">Calendar</a>
      <a class="nav-item nav-link navBar-color" href="newUser.php">Add User</a>
      <a class="nav-item nav-link navBar-color" href="logout.php">Log Out <img src="images/logout.svg"  class="logoutAni"></a>
    </div>
  </div>
</nav>
    <!--Calendar-->
    <div class="container" style="margin-top: 50px;">
        <div id="calendar"></div>
    </div>




</body>
</html>

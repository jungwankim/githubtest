<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        $_SESSION['msg'] = "Log in first";
        header('Location: ../../login.php');
    }
    
    include "../../include/function.php";
    include "calapp.php";
    
    if(!isset($_SESSION['year'])){
        $calendar = new Calendar();
    }
    else {
        $calendar = new Calendar(intval($_SESSION['month']), intval($_SESSION['year']));
    }
    
    $cont = new CalendarController($calendar);
    $view = new CalendarView($calendar);
    
    if(isset($_GET['action'])) {
        $cont->{$_GET['action']}($_POST);
    }
   
    $_SESSION['year'] = $calendar->year;
    $_SESSION['month'] = $calendar->month;

?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="author" content="wan">
        <meta name="robots" content="noindex">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
        
        <link rel = "stylesheet" type="text/css" href="calendar.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <title> personal calendar</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.js"></script>
    </head>
    <body>
        <div class= "wrapper">
            <div class = "sidenav">
                <div class = "closer">
                     <a href = "../../login.php" class = "homebtn"><i class="material-icons" style="font-size: 45px; color:white;">home</i></a>
                     <a href = "JavaScript:void(0)" class ="navbtn"><i class="material-icons" style="font-size: 45px; color:white;">menu</i></a>
                </div>
                <div class = "title-wrapper">
                    <h2>Calendar</h2>
                </div>
            </div>
            <?php $view ->output(); ?>
            <div class = "nav">
                <form action = "calendar.php?action=today" method = get>
                    <input type= "submit" name = "action" value= "today"></input>
                </form>
            </div>
        </div>
        <script>
            var season = "<?php echo $calendar->getSeason();?>" + ".jpg";
            $(document).ready(function() {
                $(".month").css("background", "url("+season+")");
                $(".month").css("background-size", "100% 100%");
                <?php
                    if($calendar->isToday()) {
                        echo   "var t = $(\"td\");
                                var today = new Date();
                                for (i=0, max = t.length; i < max; i++) {
                                    if (t[i].innerText == (\"\" +today.getDate())) {
                                        t[i].setAttribute(\"class\", \"today\");
                                        t[i].setAttribute(\"id\", \"today\");
                                    }
                                }";
                    }  
                 ?>  
            });
        </script>
    </body>
</html>



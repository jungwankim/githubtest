<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        $_SESSION['msg'] = "Log in first";
        header('Location: ../../login.php');
    }
    if (isset($_POST['text'])) {
        $_SESSION['file'] =  "../../txt/".$_POST['text'];
    }
    // if counter is not set, set to zero
    if(!isset($_SESSION[$_SESSION['file']])) {
        $_SESSION[$_SESSION['file']] = 1;
    }
 
    // if button is pressed, increment counter
    if(isset($_POST['previous'])) {
        $_SESSION[$_SESSION['file']] = $_SESSION[$_SESSION['file']] - 2;
    }    

    // reset counter
    if(isset($_POST['next'])) {
        $_SESSION[$_SESSION['file']] = $_SESSION[$_SESSION['file']] + 2;
    }
 
    if(isset($_POST['page'])) {
        $_SESSION[$_SESSION['file']] = $_POST['page'];
    }
    $lines = 20;
    
    include "../../include/function.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="author" content="wan">
        <meta name="robots" content="noindex">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
        <link rel = "stylesheet" type="text/css" href="textviewer.css">
        <title> personal text viewer</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.js"></script>
    </head>
    <body>
        <div id = "leftM" class = "nav">
            <form class = "myForm" action = "<? echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input class = "pre" type="submit" name="previous" value="Pre"/>
            </form>
        </div>
        <div id = "rightM" class = "nav">
             <form class = "myForm" action = "<? echo $_SERVER['PHP_SELF']; ?>" method="POST">
             <input class = "nex" type="submit" name="next" value="Next" />
             </form>
        </div>
       
        <div class = "cont">
        <div id = "page1" class = "page">
            <p>
                <?php retrieveText($_SESSION['file'], $_SESSION[$_SESSION['file']]*$lines-($lines-1),$_SESSION[$_SESSION['file']]*$lines);?> 
            </p>
            <div class = "pageNum">
                <?php echo $_SESSION[$_SESSION['file']]; ?>
            </div>
        </div>
        <div id = "page2" class = "page">
            <p>
            <?php retrieveText($_SESSION['file'],($_SESSION[$_SESSION['file']]+1)*$lines-($lines-1), ($_SESSION[$_SESSION['file']]+1)*$lines); ?>
            </p>
            <div class = "pageNum">
                <?php echo $_SESSION[$_SESSION['file']]+1; ?>
            </div>
        </div>
        </div>
        <div class = "footer">
            <form class = "foForm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                <input class = "jump" type="text" placeholder="jump to page" name = "page">
                <input class = "jump" type="submit" name="jump" value="Jump">
                <a href = "textview.php"> home </a>
            </form>
            
        </div>
    </body>
</html>



<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        $_SESSION['msg'] = "Log in first";
        header('Location: ../../login.php');
    }
    
    include "../../include/function.php";
    $allfiles = scandir("../../txt");
    $files = array_diff($allfiles, array('.', '..','.htaccess'));
    $msg = "";
    
    

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $target_dir = "../../txt/";
        $target_file = $target_dir.basename($_FILES["file"]["name"]);
        $upload = 1;
        $ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $extallowed = array('txt');
        if(!in_array($ext, $extallowed)) {
            $upload = 0;
            $msg = "wrong extension";
        }
 
        if($upload) {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $msg = "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
            } else {
                $msg = "Sorry, there was an error uploading your file.";
            }
        }
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="author" content="wan">
        <meta name="robots" content="noindex">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
        
        <link rel = "stylesheet" type="text/css" href="textview.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <title> personal text viewer</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.js"></script>
    </head>
    <body>
        <div class= "wrapper">
            <h1 class= "title">
                JKwan's Textviewer
            </h1>
            </h3>
            <form class = "text" action = "textviwer.php" method = "POST">
            <select name = "text" onchange = "sendData();">
                <option> select text</option>
                <?php
                foreach($files as $value) {
                    echo "<option value = \"".$value."\">".$value."</option>";
                } ?>               
            </select>
            </form>
            <div class = "nav">
                <a href = "../../login.php"><i class="material-icons" style="font-size: 3em; color:white;">home</i></a>
                <?php
                if(isset($_SESSION['pri'])) {
                    if($_SESSION['pri'] === "1" ) {
                        echo '
                        <a href = "JavaScript:void(0);" onclick = "uploadFile();"><i class="material-icons" style="font-size: 3em; color:white;">add_circle_outline</i></a>
                        <span class = "file-name"></span>
                        <form class = "upload" action= "textview.php" method="post" enctype="multipart/form-data" style="display: none;">
                            <input type="file" name="file" id="fileToUpload">
                            <input type="submit" value="Upload Image" name="submit">
                        </form> 
                        ';            
                    }
                }
                ?>
            </div>
            <div class = "msg">
                <h3><?php echo $msg;?></h3>
            </div>
        </div>
        <script>
    
            function sendData() {
                $('.text').submit();
            }
            
            function uploadFile() {
                var x = document.getElementById("fileToUpload");
                x.click();      
            }
            
            $(document).ready(function () {
                var x = document.getElementById("fileToUpload");
                x.addEventListener("change", function () {
                    $("input[type=\"submit\"]").click();                        
                });
            });
            
        </script>
    </body>
</html>



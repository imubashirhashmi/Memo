<?php
    session_start();
    $con = mysqli_connect("localhost", "root", "");
    if(!$con)
    {
        die ("couldn't establish connection");
    } 



    if(isset($_POST['title']))
    { 
            $uid = $_SESSION['id'];
            $title = $_POST['title'];
            $story = $_POST['story'];
            $bgcolor = $_POST['bgcolor'];
            $fgcolor = $_POST['fgcolor'];

            $sqlquery = "INSERT INTO `memo`.`memos` (`uid`, `title`, `story`, `bgcolor`, `fgcolor`, `datec`, `dateu`) 
            VALUES ('$uid', '$title', '$story', '$bgcolor', '$fgcolor', NULL, NULL)";
        
            try {
                if($con->query($sqlquery))
                {

                } else {
                    echo 'error';
                }
            } catch (Exception $ex) {
            echo "".$ex."";
            }
    } else {
        echo json_encode("empty");
        exit();
    }

    echo json_encode($con->insert_id);
    $con->close();
?>
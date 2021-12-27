<?php
    session_start();
    $con = mysqli_connect("localhost", "root", "");

    if(!$con)
    {
        die ("couldn't establish connection");
    }

    if(isset($_POST['title']))
    {
        $uid=$_SESSION['id'];
        $id=$_POST['id'];
        $title=$_POST['title'];
        $story=$_POST['story'];
        $bgcolor=$_POST['bgcolor'];
        $fgcolor=$_POST['fgcolor'];

        $sqlquery = "UPDATE `memo`.`memos` SET `title`='$title', `story`='$story', `bgcolor`='$bgcolor',
        `fgcolor`='$fgcolor' WHERE `id` = '$id' AND `uid`='$uid'";

        if(!$con->query($sqlquery))
        {
            echo json_encode("error occured!");
        } else {
            echo json_encode("done");
        }

    }
    
    $con->close();
?>
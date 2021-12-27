<?php
    $con = mysqli_connect("localhost", "root", "");
    
    if(!$con)
    {
        die ("couldn't establish connection!");
    }

    if(isset($_POST['id']))
    {
        $id = $_POST['id'];
        $sqlquery = "DELETE FROM `memo`.`memos` WHERE `id`='$id'";

        if(!$con->query($sqlquery))
        {
            echo "error occured while deleting..";
        } else {
            echo json_encode("done");
        }
    } else {
        echo json_encode("empty");
    }

    $con->close();
?>
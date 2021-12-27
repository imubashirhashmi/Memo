<?php 
    session_start();
    if(!isset($_SESSION['id']))
    {
        echo json_encode("user-404");
        exit();
    }

    $con = mysqli_connect("localhost", "root", "");
    if(!$con)
    {
        die("Connection error: ". mysqli_connect_error());

    }
    $uid = $_SESSION['id'];

    $select = "SELECT * FROM `memo`.`memos` WHERE `uid`='$uid' ORDER BY `id` DESC";
    $result = $con->query($select);

    $datum = array();
    
    if($result->num_rows>0)
    {
            while ($row = $result->fetch_assoc()) {

                $datum[] = $row;
            }
        
    } else {
        echo json_encode("404");
        exit();
    }

    echo json_encode($datum);
    $con->close();
?>
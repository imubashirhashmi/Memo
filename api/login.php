<?php
    session_start();

    $con = mysqli_connect("localhost", "root", "");

    if(!$con)
    {
        echo json_encode("error");
        unsetAll();
        exit();
    }

    if(isset($_POST['password']))
    {
        if($_POST['password']!="")
        {
            $password = $_POST['password'];
        } 
        else  {
            echo json_encode("empty");
            unsetAll();
            exit();
        }

        if(isset($_POST['username']))
        {
            $username = $_POST['username'];
            $sqlquery = "SELECT * FROM `memo`.`user` WHERE `username`='$username' AND `password`='$password'";
        }
        else if(isset($_POST['email'])) 
        {
            if($_POST['email']!="")
            {
                $email = $_POST['email'];
                $sqlquery = "SELECT * FROM `memo`.`user` WHERE `email`='$email' AND `password`='$password'";
            } else {
                echo json_encode("empty");
                unsetAll();
                exit();
            }
        } else {
            echo json_encode("empty");
            unsetAll();
            exit();
        }

        $result = $con->query($sqlquery);

        if($result->num_rows==1)
        {
            $data = $result->fetch_assoc();
            $_SESSION['id']=$data['id'];
            $_SESSION['name']=$data['name'];
            $_SESSION['email']=$data['email'];
            $_SESSION['username']=$data['username'];
            $_SESSION['dp']=$data['dp'];
            echo json_encode("logged in");
            unsetAll();
            exit();
        } else {
            echo json_encode("404");
        }
    } else {
            echo json_encode("empty");
    }

    unsetAll();

    function unsetAll()
    {
        unset($_POST['username'], $_POST['email'], $_POST['password']);
    }
?>
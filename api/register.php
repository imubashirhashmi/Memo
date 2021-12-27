<?php
    session_start();

    $con = mysqli_connect("localhost", "root", "");

    if(!$con)
    {
        echo json_encode("error");
        exit();
    }

    if(isset($_POST['email'], $_POST['username'], $_POST['password1'],
     $_POST['password2'], $_POST['firstName'], $_POST['lastName']))
     {
         if($_POST['email']=="" || $_POST['username']=="" || $_POST['password1']=="" 
         || $_POST['password2']=="" || $_POST['firstName']=="" || $_POST['lastName']=="")
         {
            echo json_encode("empty");
            exit();
         }

         if($_POST['password1']!=$_POST['password2'])
         {
            echo json_encode("mismatch");
            exit();
         }

         $name = $_POST['firstName']." ".$_POST['lastName'];
         $username = $_POST['username'];
         $email = $_POST['email'];
         $password = $_POST['password2'];

         $result = $con->query("SELECT * FROM `memo`.`user` WHERE `username`='$username'");
         if($result->num_rows>0)
         {
            echo json_encode("usernameExistsAlready");
            exit();
         }

         $result = $con->query("SELECT * FROM `memo`.`user` WHERE `email`='$email'");
         if($result->num_rows>0)
         {
            echo json_encode("emailExistsAlready");
            exit();
         }

         $sqlquery = "INSERT INTO `memo`.`user` (`name`, `username`, `email`, `password`) 
                        VALUES ('$name', '$username', '$email', '$password')";

         if(!$con->query($sqlquery))
         {
            echo "error occured while inserting...";
            exit();
         } else {
             echo json_encode("done");
         }
     } else {
        echo json_encode("empty");
        exit();
     }

?>
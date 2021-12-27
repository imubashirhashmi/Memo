<?php
    session_start();
    unset($_SESSION['id'],$_SESSION['name'],$_SESSION['email'],$_SESSION['username'],$_SESSION['dp']);
    echo json_encode("logged out");
?>
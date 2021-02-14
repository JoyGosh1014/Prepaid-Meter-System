<?php
include ('server.php') ;

if (!isset($_SESSION['username'])) {
        header('location: login.php');
    }
elseif ((isset($_SESSION['username'])) and ($_SESSION['role'] == "admin")){
        header('location: adindex.php');
    }
    

if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header("location: login.php");
    }


    $username = $_SESSION['username'];

    $result5 = $collection3->findOne(array('username' => $username));

    if($result5){
        $mood = $result5["mood"];
    }

    echo "Connection: ", $mood;
?>
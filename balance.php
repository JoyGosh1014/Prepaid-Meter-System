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
    $result19 = $collection7->findOne(array('username' => $username));

    if($result5){
        $total_balance = $result5["balance"];
    }

    if($result19){
        $total_unit = $result19["unit_minute"];
    }

    $balance = ((double)$total_balance - ((double)$total_unit * 0.83)); 

    if($balance > 0){
        echo "Your balance is ", $balance, "tk";
    }else{
        echo "Your balance is 0tk";
    }

    
?>
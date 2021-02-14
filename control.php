<?php
include ('server.php') ;
//session_start();

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


if (isset($_GET['username']) and $_GET['port']) {
        $username = $_GET['username'];
        $port = $_GET['port'];

        $result12 = $collection3->findOne(array('username' => $username));

        if($port == 'switch1'){
            if($result12['switch_1'] == 0){
                $collection3->updateOne(['username' => $username],
                    ['$set' => ['switch_1' => 1]]);
            }
            else{
                $collection3->updateOne(['username' => $username],
                    ['$set' => ['switch_1' => 0]]);
            }
        }

        if($port == 'switch2'){
            if($result12['switch_2'] == 0){
                $collection3->updateOne(['username' => $username],
                    ['$set' => ['switch_2' => 1]]);
            }
            else{
                $collection3->updateOne(['username' => $username],
                    ['$set' => ['switch_2' => 0]]);
            }
           
        }
        header('location: index.php');
    }

    echo '
    <button type="button" class="btn btn-light"><a href="control.php?username='.$username.'&port=switch1">Switch 1</a></button>

    <button type="button" class="btn btn-light"><a href="control.php?username='.$username.'&port=switch2">Switch 2</a></button>
    ';

?>
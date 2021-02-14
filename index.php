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

    $result2 = $collection1->findOne(array('username' => $username));

    if($result2){
        
            $name = $result2["name"];
            $mobile_number = $result2["mobile_number"];
            $location = $result2["location"];
            $meter_number = $result2["meter_number"];
    }

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
    }

    if (isset($_GET['username'])) {
        $username = $_GET['username'];

        $result31 = $collection3->findOne(array('username' => $username));

            if($result31['loan'] == '1'){
                $balance = (double)$result31['balance'];
                $balance = $balance + 50;

                $collection3->updateOne(['username' => $username],
                  ['$set' => ['balance' => $balance, 'loan' => '0']]);
               }

               header('location: index.php');
    }
?>
<!doctype html>

<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <link rel="stylesheet" href="css/style.css">

    <title>Dashboard</title>
  </head>
  <body id="user_index">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container-fluid">
                <h4>
                    <a href="index.php" class="navbar-brand">Prepaid Meter</a>
                </h4>
                <button type="button" class="navbar-toggler btn-sm" data-toggle="collapse" data-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="menu" class="collapse navbar-collapse">
                    <ul class="navbar-nav ml-auto">
                      <li class="nav-item"><a href="index.php?logout='1'" class="nav-link" >Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <section id="user_panel">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="border border-primary rounded-pill shadow p-1 mb-2 bg-white rounded font-weight-bolder text-center text-primary text-capitalize">
                                 <?php echo "Name - ", $name; ?> </div>

                    <div class="border border-primary rounded-pill shadow p-1 mb-2 bg-white rounded font-weight-bolder text-center text-primary">
                                <?php echo "Mobile Number - ", $mobile_number; ?></div>

                    <div class="border border-primary rounded-pill shadow p-1 mb-2 bg-white rounded font-weight-bolder text-center text-primary">
                                <?php echo "Username - ", $username; ?> </div>

                    <div class="border border-primary rounded-pill shadow p-1 mb-2 bg-white rounded font-weight-bolder text-center text-primary text-capitalize">
                                 <?php echo "Location - ", $location; ?> </div>

                    <div class="border border-primary rounded-pill shadow p-1 mb-2 bg-white rounded font-weight-bolder text-center text-primary">
                                <?php echo "Meter Number - ", $meter_number; ?></div>

                    <div id="mood" class="border border-primary rounded-pill shadow p-1 mb-2 bg-white rounded font-weight-bolder text-center text-primary text-capitalize"></div>

                    <div id="balance" class="border border-primary rounded-pill shadow p-1 mb-2 bg-white rounded font-weight-bolder text-center text-primary"></div>

                    <div id="loan" class="border border-primary rounded-pill shadow p-1 mb-2 rounded font-weight-bolder text-center"><a class="text-white" href="index.php?username=<?php echo $_SESSION['username']; ?>">Take Loan</a></div>

                   
                    <div class="border border-primary rounded-pill shadow p-1 mb-2 bg-white rounded font-weight-bolder text-center text-primary"><a href="change_password.php">Change Password</a></div>

                     <div id="control" class="border border-primary rounded-pill shadow p-1 mb-2 bg-white rounded font-weight-bolder text-center">
                        <p class="font-weight-bolder text-primary">Control Board</p>
                        <?php

                            echo '
                            <button type="button" class="btn" id="s1"><a href="control.php?username='.$username.'&port=switch1" class=text-white>Switch 1</a></button>
                            <button type="button" class="btn" id="s2"><a href="control.php?username='.$username.'&port=switch2" class=text-white>Switch 2</a></button>

                            
                            ';
                            
                        ?>
                    </div>

                </div>
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-sm-3half unit">
                            <a href="user_unit.php">
                                <i class="fas fa-bolt"></i>
                                <div class="text">
                                    <p>Unit</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-3half billing">
                            <a href="user_billing.php">
                                <i class="far fa-money-bill-alt"></i>
                                <div class="text">
                                    <p>Billing</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-3half payment">
                            <a href="user_payment.php">
                                <i class="far fa-credit-card"></i>
                                <div class="text">
                                    <p>Make Payment</p>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-sm-3half announcement">
                            <a href="user_announcement.php">
                                <i class="fas fa-bullhorn"></i>
                                <div class="text">
                                    <p>Announcement</p>
                                </div>
                            </a>
                        </div>
                        
                    </div>
                </div>
            </div>
            

        </div>
    </section>

            


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->

    <?php
$result13 = $collection3->findOne(array('username' => $username));

                        
                            if($result13['switch_1'] == 0){
                                echo "<script>
                                    $(document).ready(function(){
                                      $('#s1').addClass('btn-success');
                                    });
                                    </script>";
                            }
                            else{
                                 echo "<script>
                                    $(document).ready(function(){
                                      $('#s1').addClass('btn-danger');
                                    });
                                    </script>";
                            }

                
                            if($result13['switch_2'] == 0){
                                echo "<script>
                                    $(document).ready(function(){
                                      $('#s2').addClass('btn-success');
                                    });
                                    </script>";
                            }
                            else{
                                 echo "<script>
                                    $(document).ready(function(){
                                      $('#s2').addClass('btn-danger');
                                    });
                                    </script>";
                            }

                            if($result13['loan'] == '0'){
                                echo "<script>
                                    $(document).ready(function(){
                                      $('#loan').addClass('bg-danger text-white');
                                      $('#loan').text('You can not take loan');
                                    });
                                    </script>";
                            }
                            else{
                                 echo "<script>
                                    $(document).ready(function(){
                                      $('#loan').addClass('bg-success');
                                    });
                                    </script>";
                            }
    ?>

    <script>
        $(document).ready( function () {
            setInterval(function () {
                $('#mood').load('connection_mood.php');
                refresh();
            }, 1000);

            setInterval(function () {
                $('#balance').load('balance.php');
                refresh();
            }, 1000);
        });
    </script>
  </body>
</html>
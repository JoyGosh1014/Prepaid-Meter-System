<?php
include ('server.php') ;
//session_start();

if (!isset($_SESSION['username'])) {
        header('location: login.php');
    }
elseif ((isset($_SESSION['username'])) and ($_SESSION['role'] == "user")){
        header('location: index.php');
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

    <title>Admin Panel</title>
  </head>
  <body id="admin_index">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container-fluid">
                <h4>
                    <a href="adindex.php" class="navbar-brand">Prepaid Meter</a>
                </h4>
                <button type="button" class="navbar-toggler btn-sm" data-toggle="collapse" data-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="menu" class="collapse navbar-collapse">
                    <ul class="navbar-nav ml-auto">
                      <li class="nav-item"><a href="adindex.php?logout='1'" class="nav-link" >Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <section id="admin_panel">
        <div class="container">
            <div class="row">
                        <div class="col-sm-3half connection">
                            <a href="add_user.php">
                                <i class="fas fa-user-plus"></i>
                                <div class="text">
                                    <p>Add User</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-3half unit">
                            <a href="user_list.php">
                                <i class="fas fa-address-book"></i>
                                <div class="text">
                                    <p>User List</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-3half billing">
                            <a href="payment_list.php">
                                <i class="fas fa-file-invoice"></i>
                                <div class="text">
                                    <p>Payment List</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-3half control">
                            <a href= "#" data-toggle="modal" data-target="#addpaymentModal">
                                <i class="fas fa-money-check-alt"></i>
                                <div class="text">
                                    <p>Add Payment</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-3half payment">
                            <a href="announcement.php">
                                <i class="fas fa-comment-dots"></i>
                                <div class="text">
                                    <p>Announcement List</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-3half balance">
                            <a href="#" data-toggle="modal" data-target="#makeannouncementModal">
                                <i class="fas fa-comment-medical"></i>
                                <div class="text">
                                    <p>Make Announcement</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-3half info">
                            <a href="unit_list.php">
                                <i class="fas fa-charging-station"></i>
                                <div class="text">
                                    <p>Unit</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-3half info">
                            <a href="#" type="button" data-toggle="modal" data-target="#addlocationModal">
                                <i class="fas fa-map-marker-alt"></i>
                                <div class="text">
                                    <p>Add New Location</p>
                                </div>
                            </a>
                        </div>
                </div>
            </div>
    </section>


    <div class="modal fade" id="addpaymentModal" tabindex="-1" aria-labelledby="addpaymentModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <p class="modal-title h5 text-center" id="addpaymentModalLabel">Add Payment</p>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="adindex.php">
                                <?php include('errors.php'); ?>

                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" placeholder="Enter Username" name="username">
                                </div>

                                <div class="form-group">
                                    <label for="money_recipt">Money Recipt Number:</label>
                                    <input type="text" class="form-control" id="money_recipt" placeholder="Enter Money Recipt Number" name="money_recipt">
                                </div>

                                <div class="form-group">
                                    <label for="amount">Amount:</label>
                                    <input type="text" class="form-control" id="amount" placeholder="Enter Amount" name="amount">
                                </div>
                                
                                <button type="submit" name = "add_payment" class="btn btn-primary">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


    <div class="modal fade" id="makeannouncementModal" tabindex="-1" aria-labelledby="makeannouncementModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <p class="modal-title h5" id="makeannouncementModalLabel">Make Announcement</p>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="adindex.php">
                                <?php include('errors.php'); ?>

                                <div class="form-group">
                                    <label for="date">Enter Date</label>
                                    <input type="date" class="form-control" id="date" name="date">
                                </div>

                                <div class="form-group">
                                    <label for="subject">Subject:</label>
                                    <input type="text" class="form-control" id="subject" placeholder="Enter Subject" name="subject">
                                </div>

                                <div class="form-group">
                                    <label for="notification">Enter Message</label>
                                    <textarea class="form-control" id="notification" 
                                    name="message" rows="4" placeholder="Enter Message"></textarea>
                                </div>
                                <button type="submit" name = "add_notification" class="btn btn-primary">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

    <div class="modal fade" id="addlocationModal" tabindex="-1" aria-labelledby="addlocationModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <p class="modal-title h5" id="addlocationModalLabel">Add Location</p>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="adindex.php">
                                <?php include('errors.php'); ?>

                                <div class="form-group">
                                    <label for="add_location">Enter Location</label>
                                    <input type="text" class="form-control" id="add_location" name="location" placeholder="Add New Location">
                                </div>

                                <button type="submit" name = "add_location" class="btn btn-primary">
                                Add Location</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

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
        

          if (count($notification_errors) > 0){
              echo "<script type='text/javascript'>
              $('#makeannouncementModal').modal('show');
              </script>";
            }
    ?>
 
    
  </body>
</html>
<?php 
include ('server.php') ;
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

    $result3 = $collection2->find();

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <link rel="stylesheet" href="css/style.css">
    <title>Add User</title>
</head>
<body id="add_user">
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
                      <li class="nav-item"><a href="add_user.php?logout='1'" class="nav-link" >Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
            <div class="row justify-content-center">
                <div class = "col-sm-5">
                    <!-- notification message -->
                    
                    <div class="card ">
                       <div class="card-header bg-primary text-center font-weight-bolder text-white">
                        <h1>Add User</h1>
                        </div>
                        <div class="card-body">
                            <form method="post" action="add_user.php">
                                <?php include('errors.php'); ?>

                                <div class="form-group">
                                    <label for="location">Select Location:</label>
                                    <?php 
                                        echo "<select id=location name=location class='form-control text-capitalize'>";

                                        foreach ($result3 as $loc){//Array or records stored in $row

                                        echo "<option class='text-capitalize' value=$loc[_id]>$loc[location]</option>"; 

                                        }

                                         echo "</select>";// Closing of list box
                                    ?> 
                                </div>

                                <div class="form-group">
                                    <label for="meter_number">Meter Number:</label>
                                    <input type="text" class="form-control" id="meter_number" placeholder="Enter Meter Number" name="meter_number" value="<?php echo $meter_number; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="name">Name:</label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" value="<?php echo $name; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="mobile_number">Mobile Number:</label>
                                    <input type="text" class="form-control" id="mobile_number" placeholder="Enter Mobile Number" name="mobile_number" value="<?php echo $mobile_number; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="NID">NID No:</label>
                                    <input type="text" class="form-control" id="NID" 
                                    placeholder="Enter National ID Card Number" name="NID" value="<?php echo $nid; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" 
                                    placeholder="Enter Email Address" name="email" value="<?php echo $email; ?>">
                                </div>
                                
                                <button type="submit" name = "add" class="btn btn-primary">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
  </body>
</html>
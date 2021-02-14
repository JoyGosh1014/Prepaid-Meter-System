<?php 
include('server.php');
//$reset_out = 0;

if (isset($_SESSION['username'])){
        header('location: index.php');
    }

    $user = $_SESSION['user'];


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
    <title>Reset Password</title>
</head>
<body id="change">
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
                      <li class="nav-item"><a href="login.php" class="nav-link" >Sign IN</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
            <div class="row justify-content-center">
                <div class = "col-sm-5">
                    <div class="card ">
                       <div class="card-header bg-primary text-center font-weight-bolder text-white "><h1>
                            Reset Password</h1>
                        </div>
                        <div class="card-body">
                            <form method="post" action="reset_password.php">

                                 <?php include('errors.php'); ?>
                                 <?php 
                                if($reset_out == 1){
                                    echo '<div class="alert alert-success">
                                    <p>Password Reset Successfully. Goto <a href="login.php">Login Page</a></p>
                                    </div>'; 
                                    $reset_out = 0;
                                } ?>


                                <div class="form-group">
                                    <label for="new_password_1">New Password:</label>
                                    <input type="password" class="form-control" id="new_password_1" placeholder="Enter New Password" name="new_password_1">
                                </div>


                                <div class="form-group">
                                    <label for="new_password_2">Retype Password:</label>
                                    <input type="password" class="form-control" id="new_password_2" placeholder="Retype New Password" name="new_password_2">
                                </div>
                                <input type="hidden" name="user" value="<?php echo $user;?>">
                                <input type="button" class="btn btn-light" value="Go Back" onClick="history.go(-1);">
                                <button type="submit" name = "reset_password" class="btn btn-primary">Reset</button>
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
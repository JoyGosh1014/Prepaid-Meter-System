<?php 
include('server.php');

if (isset($_SESSION['username'])){
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

    <link rel="stylesheet" href="css/style.css">
    <title>Forget Password</title>
</head>
<body id="forget">
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
                      <li class="nav-item active"><a href="login.php" class="nav-link" >Sign IN</a></li>
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
                            Match OTP</h1>
                        </div>
                        <div class="card-body">
                            <form method="post" action="forget_password.php">

                                 <?php include('errors.php'); ?>

                                <div class="form-group">
                                    <label for="user">Username:</label>
                                    <input type="text" class="form-control" id="user" placeholder="Enter username" name="user" 
                                    value="<?php echo $user;?>" >
                                </div>
                                
                                <button type="submit" name = "sendotp" class="btn btn-primary btn-block">Send OTP</button>
                            </form>
                            <br>
                            <?php 
                                if($otp_out == 1){
                                    echo '<div class="alert alert-success"> AN OTP is send to your mail. Please check your mail.</div>'; 
                                    $otp_out = 0;
                                } ?>
                            <br>
                            <form method="POST" action="forget_password.php">

                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Enter OTP" name="otp">
                                </div>
                                <input type="hidden" name="user" value="<?php echo $user;?>">
                             
                                <button type="submit" name="verifyotp" class="btn btn-info btn-block">Verify</button>
                                <input type="button" class="btn btn-light btn-block" value="Go Back" onClick="history.go(-1);">
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
<?php
include ('server.php') ;
//session_start();

if (!isset($_SESSION['username'])) {
    header('location: login.php');
} elseif ((isset($_SESSION['username'])) and ($_SESSION['role'] == "admin")) {
    header('location: adindex.php');
}


if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
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

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    

    <link rel="stylesheet" href="css/style.css">

    <title>Make Payment</title>
</head>

<body id="user_payment">
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
                        <li class="nav-item"><a href="user_payment.php?logout='1'" class="nav-link">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <section id="payment_nav">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <p class="h3">Instruction</p>
                    <p>There are <strong>Two Method</strong> for payment</p>
                    <div class="card">
                        <div class="card-header">
                            <strong>Method 1: Cash</strong>
                        </div>
                        <div class="card-body">
                            <ol>
                                <li>For cash paying you have to come in our office.</li>
                                <li>Give money to the counter.</li>
                                <li>Take recipt from the counter.</li>
                            </ol>
                        </div>
                    </div>
                    <br>
                    <div class="card">
                        <div class="card-header">
                            <strong>Method 2: Bkash</strong>
                        </div>
                        <div class="card-body">
                            <div class="card">
                                <div class="card-header">
                                    <strong>Procedure 1</strong>
                                </div>
                                <div class="card-body">
                                    <ol>
                                        <li>Login your Bkash app or dial *247# from your mobile.</li>
                                        <li>Go to <strong>Send Money</strong> option.</li>
                                        <li>Enter our Bkash account number 01XXX-XXXXXX</li>
                                        <li>Enter Amount</li>
                                        <li>You have to recharge minimum 300tk</li>
                                        <li>In refernce section you have to write your <strong>Meter Number</strong></li>
                                        <li>After send money you will get a <strong>Transaction ID</strong></li>
                                    </ol>
                                </div>
                            </div>
                            <br>
                            <div class="card">
                                <div class="card-header">
                                    <strong>Procedure 2</strong>
                                </div>
                                <div class="card-body">
                                    <ol>
                                        <li>Login to our <a href="#">Website</a> and goto <strong>Make Payment</strong> page.</li>
                                        <li>Enter Bkash Account Number from which number you send money</li>
                                        <li>Enter Amount which you have send</li>
                                        <li>Enter the <strong>Transaction ID</strong> you recvied from Bkash</li>
                                        <li>After complete this form, click <strong>Submit</strong> button.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 form">
                    <div class="card">
                        <div class="card-header">
                            <strong>Payment Info</strong>
                        </div>
                        <div class="card-body">
                            <form method="post" action="user_payment.php">

                                 <?php include('errors.php'); ?>
                                <div class="form-group">
                                    <label for="bkash_number">Bkash Number</label>
                                    <input type="text" class="form-control" id="bkash_number" 
                                    placeholder="Enter Bkash Number" name="bkash_number">
                                </div>
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="text" class="form-control" id="amount" 
                                    placeholder="Enter Amount" name="amount">
                                </div>
                                <div class="form-group">
                                    <label for="trx_id">Transaction ID</label>
                                    <input type="text" class="form-control" id="trx_id" 
                                    placeholder="Enter Transaction ID" name="trx_id">
                                </div>
                                <input type="hidden" name="username" 
                                value="<?php echo $_SESSION['username']; ?>">
                                <button type="submit" name = "user_add_payment" class="btn btn-primary">Submit Request</button>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>

    

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>


    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
</body>

</html>
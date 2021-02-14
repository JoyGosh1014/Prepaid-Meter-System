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

if (isset($_GET['id']) and $_GET['req'] and $_GET['amount'] and $_GET['username']) {
    $id = $_GET['id'];
    $req = $_GET['req'];
    $amount = $_GET['amount'];
    $username = $_GET['username'];
    if($req == 'acpt'){
        

            $amount = (double)$amount;

            $demand_charge = 15;
            $meter_rent = 40;
            $service_charge = 10;

            $percentage = ($amount * 5)/100;

            $query = array('$and' => array(array("username" => $username), 
                array("year" => $current_year), array("month" => $current_month), array("status" => "accepted")));

            if($collection4->findOne($query)){
                $amount = $amount - $percentage;
            }
            else{
                $amount = $amount - ($percentage + $demand_charge + $service_charge + $meter_rent);
            }

            $result6 = $collection3->findOne(array('username' => $username));
                $balance = (double)$result6['balance'];
                $loan_status = $result6['loan'];

                if($loan_status == '0'){
                    $amount = $amount - 50;
                    $collection3->updateOne(['username' => $username],
                  ['$set' => ['loan' => '1']]);
                }

                
                $balance = $balance + $amount;

                $collection3->updateOne(['username' => $username],
                  ['$set' => ['balance' => $balance]]);
                    
                    

$collection4->updateOne(['_id' => new MongoDB\BSON\ObjectId("$id")],
      ['$set' => ['status' => 'accepted']]);

 $query2 = $collection1->findOne(array('username' => $username));

$to_email = $query2['email'];
$subject = "Premaid Meter Payment Message";
$body = "Dear User, your payment request is accepted and ".$amount."tk is added to your account";
$headers = "From: sender email";

mail($to_email, $subject, $body, $headers);



header('location: payment_list.php');
    
    }

    if($req == 'dlt'){
        if($collection4->updateOne(['_id' => new MongoDB\BSON\ObjectId("$id")],
      ['$set' => ['status' => 'deleted']])){
             $query2 = $collection1->findOne(array('username' => $username));

    $to_email = $query2['email'];
    $subject = "Premaid Meter Payment Message";
    $body = "Dear User your payment request is delete please contact with admin";
    $headers = "From: sender email";

    mail($to_email, $subject, $body, $headers);
      header('location: payment_list.php');
    }
    }
    
  }


$result8 = $collection4->find(array('status' => "accepted"));

$result9 = $collection4->find(array('status' => "pending"));

$result10 = $collection4->find(array('status' => "deleted"));

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

    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="css/style.css">

    <title>Payment List</title>
</head>

<body id="payment_list">
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
                        <li class="nav-item"><a href="payment_list.php?logout='1'" class="nav-link">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <section id="payment_nav">
        <div class="container">
          <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs nav-fill" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="admin_approved-tab" data-toggle="tab" href="#admin_approved" role="tab" aria-controls="admin_approved" aria-selected="true">Approved</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " id="admin_pending-tab" data-toggle="tab" href="#admin_pending" role="tab" aria-controls="admin_pending" aria-selected="true">Pending</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " id="admin_deleted-tab" data-toggle="tab" href="#admin_deleted" role="tab" aria-controls="admin_deleted" aria-selected="true">Deleted</a>
                    </li>
                </ul>
            </div>
            
                            
                    
            <div class="card-body">           
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="admin_approved" role="tabpanel" aria-labelledby="admin_approved-tab">
                        <div class="p-3">
                            <table class="table text-center table-bordered table-striped table-primary table-responsive-sm" id="admin_approvedTable">
                                <thead class="thead-light ">
                                    <tr>
                                        <th>Username</th>
                                        <th>Mobile Number</th>
                                        <th>Payment Type</th>
                                        <th>Money Recipt No/ Trx ID</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                    foreach ($result8 as $data) {
                                        echo '
                                        <tr>
                                      <td>'.$data["username"].'</td>
                                      <td class=text-uppercase>'.$data["mobile_number"].'</td>
                                      <td>'.$data["type"].'</td>
                                      <td class=text-lowercase>'.$data["recipt"].'</td>
                                      <td>'.$data["amount"].'</td>
                                      <td>'.$data["date"].'</td>
                                      
                                    </tr>'  ;  
                                    }

                                         
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade " id="admin_pending" role="tabpanel" aria-labelledby="admin_pending-tab">
                        <div class="p-3">
                            <table class="table text-center table-bordered table-striped table-primary table-responsive-sm" id="admin_pendingTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Username</th>
                                        <th>Bkash Account No</th>
                                        <th>Trx ID</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                  
                                <tbody>
                                    <?php  
                                    foreach ($result9 as $data) {
                                        echo '
                                        <tr>
                                      <td>'.$data["username"].'</td>
                                      <td class=text-uppercase>'.$data["mobile_number"].'</td>
                                      <td class=text-lowercase>'.$data["recipt"].'</td>
                                      <td>'.$data["amount"].'</td>
                                      <td>'.$data["date"].'</td>
                                      <td>
                                      <button type="button" class="btn btn-sm btn-success"><a class="text-white" href="payment_list.php?id='.$data["_id"].'&req=acpt&amount='.$data["amount"].'&username='.$data["username"].'">Accept</a></button> <button type="button" class="btn btn-sm btn-danger"><a class="text-white" href="payment_list.php?id='.$data["_id"].'&req=dlt&amount='.$data["amount"].'&username='.$data["username"].'">Delete</a></button>
                                      </td>
                                    </tr>'  ;  
                                    }

                                         
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="admin_deleted" role="tabpanel" aria-labelledby="admin_deleted-tab">
                        <div class="p-3">
                            <table class="table text-center table-bordered table-striped table-primary table-responsive-sm" id="admin_deletedTable">
                                <thead class="thead-light ">
                                    <tr>
                                        <th>Username</th>
                                        <th>Bkash Account No</th>
                                        <th>Trx ID</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php  
                                    foreach ($result10 as $data) {
                                        echo '
                                        <tr>
                                      <td>'.$data["username"].'</td>
                                      <td class=text-uppercase>'.$data["mobile_number"].'</td>
                                      <td class=text-lowercase>'.$data["recipt"].'</td>
                                      <td>'.$data["amount"].'</td>
                                      <td>'.$data["date"].'</td>
                                      
                                    </tr>'  ;  
                                    }

                                         
                                    ?>
                                </tbody>
                            </table>
                        </div>
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

    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

    

    <script type="text/javascript">
        $(document).ready( function () {
            $('#admin_approvedTable').DataTable();
            $('#admin_pendingTable').DataTable();
            $('#admin_deletedTable').DataTable();
            
        } );
    </script>

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
</body>

</html>
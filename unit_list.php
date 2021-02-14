<?php
include ('server.php') ;
include ('ml.php') ;
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

    /*$collection6->updateMany(['date' => '13/01/2021'],
                ['$set' =>
                    ['date' => '2021-01-13']
                ]);*/

     $result18 = $collection2->find();

     $yesterday = date("Y-m-d",strtotime("yesterday"));

     $allCorp1 = array( '$match' =>  array('date' => $yesterday));
$theVisible1 = array( '$group' => array( "_id" => '$location', 'total_unit' => array( '$sum' => '$unit')));
        
        $result27 = $collection6->aggregate([$allCorp1, $theVisible1]);

        $allCorp2 = array( '$match' =>  array('month' => $current_month, 'year' => $current_year, 
            'date' => [ '$ne' => $current_date]));
$theVisible2 = array( '$group' => array( "_id" => array('location' => '$location', 
    'date' =>'$date'), 'total_unit' => array( '$sum' => '$unit')));
        
        $result28 = $collection6->aggregate([$allCorp2, $theVisible2]);

        $allCorp3 = array( '$match' =>  array('year' => $current_year, 'date' => [ '$ne' => $current_date]));
$theVisible3 = array( '$group' => array( "_id" => array('location' => '$location', 
    'month' =>'$month'), 'total_unit' => array( '$sum' => '$unit')));
        
        $result29 = $collection6->aggregate([$allCorp3, $theVisible3]);

        $allCorp4 = array( '$match' =>  array('date' => [ '$ne' => $current_date]));

$theVisible4 = array( '$group' => array( "_id" => array('location' => '$location', 
    'year' =>'$year'), 'total_unit' => array( '$sum' => '$unit')));
        
        $result30 = $collection6->aggregate([$allCorp4, $theVisible4]);
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

    <title>Unit Usage</title>
</head>

<body id="unit_list">
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
                        <li class="nav-item"><a href="unit_list.php?logout='1'" class="nav-link">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <section id="unit_nav">
        <div class="container">

            <button type="button" class="btn btn-primary mb-5" data-toggle="modal" data-target="#predictionModal">See Prediction</button>
            <?php 
            if($ml_out == 1){
                echo '<div class="alert alert-success">Need '.$output.' unit on '.$date.' at '.$location.'</div>'; 
            } ?>
            <div class="modal fade" id="predictionModal" tabindex="-1" aria-labelledby="predictionModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="predictionModalLabel">Information for Prediction</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form method="post" action="unit_list.php">
                                <?php include('errors.php'); ?>

                                <div class="form-group">
                                    <label for="date">Enter Date</label>
                                    <input type="date" class="form-control" id="date" name="date">
                                </div>

                                <div class="form-group">
                                    <label for="location">Select Location:</label>
                                    <?php 
                                        echo "<select id=location name=location class='form-control text-capitalize'>";

                                        foreach ($result18 as $loc){//Array or records stored in $row

                                        echo "<option class=text-capitalize value=$loc[_id]>$loc[location]</option>"; 

                                        /* Option values are added by looping through the array */ 

                                        }

                                         echo "</select>";// Closing of list box
                                    ?> 
                                </div>

                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" name = "check_prediction" class="btn btn-primary">Check</button>
                            </form>
                    
                  </div>
                </div>
              </div>
            </div>

          <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs nav-fill" id="unitTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="yesterday-tab" data-toggle="tab" href="#yesterday" role="tab" aria-controls="yesterday" aria-selected="true">Last Day</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " id="month-tab" data-toggle="tab" href="#month" role="tab" aria-controls="month" aria-selected="true">This Month</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " id="year-tab" data-toggle="tab" href="#year" role="tab" aria-controls="year" aria-selected="true">This Year</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="true">All</a>
                    </li>
                </ul>
            </div>
            
                            
                    
            <div class="card-body">           
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="yesterday" role="tabpanel" aria-labelledby="yesterday-tab">
                        <div class="p-3">
                            <table class="table text-center table-bordered table-striped table-primary table-responsive-sm" id="yesterdayTable">
                                <thead class="thead-light ">
                                    <tr>
                                        <th>Area</th>
                                        <th>Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                    foreach ($result27 as $data) {
                                        echo '
                                        <tr>
                                      <td class="text-capitalize">'.$data["_id"].'</td>
                                      <td>'.$data["total_unit"].'</td>
                                    </tr>'  ;  
                                    }

                                         
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade " id="month" role="tabpanel" aria-labelledby="month-tab">
                        <div class="p-3">
                            <table class="table text-center table-bordered table-striped table-primary table-responsive-sm" id="monthTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Area</th>
                                        <th>Unit</th>
                                    </tr>
                                </thead>
                                  
                                <tbody>
                                    <?php  
                                    foreach ($result28 as $data2) {
                                       
                                        
                                        echo '
                                        <tr>
                                      
                                      <td>'.$data2["_id"]["date"].'</td>
                                      <td class="text-capitalize">'.$data2["_id"]["location"].'</td>
                                      <td>'.$data2["total_unit"].'</td>
                                      
                                    </tr>'  ;  
                                    }

                                         
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="year" role="tabpanel" aria-labelledby="year-tab">
                        <div class="p-3">
                            <table class="table text-center table-bordered table-striped table-primary table-responsive-sm" id="yearTable">
                                <thead class="thead-light ">
                                    <tr>
                                        <th>Month</th>
                                        <th>Area</th>
                                        <th>Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                    foreach ($result29 as $data3) {
                                        echo '
                                        <tr>
                                      <td>'.$data3["_id"]["month"].'</td>
                                      <td class="text-capitalize">'.$data3["_id"]["location"].'</td>
                                      <td>'.$data3["total_unit"].'</td>
                                    </tr>'  ;  
                                    }

                                         
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="all" role="tabpanel" aria-labelledby="all-tab">
                        <div class="p-3">
                            <table class="table text-center table-bordered table-striped table-primary table-responsive-sm" id="allTable">
                                <thead class="thead-light ">
                                    <tr>
                                        <th>Year</th>
                                        <th>Area</th>
                                        <th>Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <?php  
                                    foreach ($result30 as $data4) {
                                        echo '
                                        <tr>
                                      <td>'.$data4["_id"]["year"].'</td>
                                      <td class="text-capitalize">'.$data4["_id"]["location"].'</td>
                                      <td>'.$data4["total_unit"].'</td>
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
            $('#yesterdayTable').DataTable();
            $('#monthTable').DataTable();
            $('#yearTable').DataTable();
            $('#allTable').DataTable();
        } );
    </script>

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
</body>

</html>
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

//$collection6->deleteMany(['date' => ""]);


//$result23 = $collection6->find(array('username' => $_SESSION['username']))  
//, array('month' => $current_month)));

$query2 = array('$and' => array(array("username" => $_SESSION['username']), 
                array("date" => $current_date)));

$result23 = $collection6->find($query2);

$allCorp1 = array( '$match' =>  array('username' => $_SESSION['username'], 'month' => $current_month, 'year' => $current_year));
$theVisible1 = array( '$group' => array( "_id" => '$date', 'total_unit' => array( '$sum' => '$unit')));
        
        $result24 = $collection6->aggregate([$allCorp1, $theVisible1]);

$allCorp2 = array( '$match' =>  array('username' => $_SESSION['username'], 'year' => $current_year));
$theVisible2 = array( '$group' => array( "_id" => '$month', 'total_unit' => array( '$sum' => '$unit')));
        
        $result25 = $collection6->aggregate([$allCorp2, $theVisible2]);

$allCorp3 = array( '$match' =>  array('username' => $_SESSION['username']));
$theVisible3 = array( '$group' => array( "_id" => '$year', 'total_unit' => array( '$sum' => '$unit')));
        
        $result26 = $collection6->aggregate([$allCorp3, $theVisible3]);

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

    <title>Unit</title>
</head>

<body id="user_unit">
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
                        <li class="nav-item"><a href="user_unit.php?logout='1'" class="nav-link">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <section id="unit_nav">
        <div class="container">
          <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs nav-fill" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="today-tab" data-toggle="tab" href="#today" role="tab" aria-controls="today" aria-selected="true">Today</a>
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
                    <div class="tab-pane fade show active" id="today" role="tabpanel" aria-labelledby="today-tab">
                        <div class="p-3">
                            <table class="table text-center table-bordered table-striped table-primary table-responsive-sm" id="todayTable">
                                <thead class="thead-light ">
                                    <tr>
                                        <th>Date</th>
                                        <th>Hour</th>
                                        <th>Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                    foreach ($result23 as $data) {
                                        echo '
                                        <tr>
                                      <td>'.$data["date"].'</td>
                                      <td>'.$data["time"].'</td>
                                      <td>'.$data["unit"].'</td>
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
                                        <th>Unit</th>
                                    </tr>
                                </thead>
                                  
                                <tbody>
                                    <?php  
                                    foreach ($result24 as $data2) {
                                        echo '
                                        <tr>
                                      <td>'.$data2["_id"].'</td>
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
                                        <th>Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  
                                    foreach ($result25 as $data) {
                                        echo '
                                        <tr>
                                      <td>'.$data["_id"].'</td>
                                      <td>'.$data["total_unit"].'</td>
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
                                        <th>Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <?php  
                                    foreach ($result26 as $data) {
                                        echo '
                                        <tr>
                                      <td>'.$data["_id"].'</td>
                                      <td>'.$data["total_unit"].'</td>
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
            $('#todayTable').DataTable();
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
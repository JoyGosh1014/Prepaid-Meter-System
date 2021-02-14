<?php
include 'server.php';
include 'offday.php';
require 'vendor/autoload.php';

$ml_out = 0;

if (isset($_POST['check_prediction'])) {
		// receive all input values from the form
		$date = $_POST['date'];
		$location_id = $_POST['location'];
		
		$result4 = $collection2->findOne(array('_id' => new MongoDB\BSON\ObjectId("$location_id")));

		$location = $result4['location'];



		// form validation: ensure that the form is correctly filled
		if (empty($date)) { array_push($errors, "Date is required"); }
		if (empty($location)) { array_push($errors, "Location is required"); }


		if ($date < $current_date) {
			array_push($errors, "You can't use previous date");
		}


		$filename = "test.csv";
		$f = fopen($filename, 'w');
		$fields = array('DayofWeek', 'Weekend', 'Holiday', 'Unit');
		fputcsv($f, $fields);

		$allCorp = array( '$match' => array('location' => $location));
		$theVisible = array( '$group' => array( "_id" => '$date', 'total_unit' => array( '$sum' => '$unit')));
		
		$result21 = $collection6->aggregate([$allCorp, $theVisible]);

			foreach ($result21 as $data) {
				//$db_date = strtotime($data['_id']);
				$holiday = holiday($data['_id']);
				//$month = $db_date->format('m');
				$dayOfWeek = date("N", strtotime($data['_id']));
				if($dayOfWeek == 5)
					$weekend = 1;
				else
					$weekend = 0;

				$lineData = array($dayOfWeek, $weekend, $holiday, $data['total_unit']);
				fputcsv($f, $lineData);

			}
			
				$holiday = holiday($date);
				//$month = $date->format('m');
				$dayOfWeek = date("N", strtotime($date));
				if($dayOfWeek == 5)
					$weekend = 1;
				else
					$weekend = 0;

				$lineData = array($dayOfWeek, $weekend, $holiday);
				fputcsv($f, $lineData);
				fclose($f);

		$command = escapeshellcmd('ml.py');
		$output = shell_exec($command);
		$output = floatval($output);
		$output = number_format($output, 2);
		$ml_out = 1;
		
		// $output = floatval($output);
		// $output = number_format($output, 2);
		// $output = floatval($output);
		
		//echo $output;
		//echo '<div class="alert alert-success">'.$output.'</div>';
		}
	
?>
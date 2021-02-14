<?php

session_start();

// connect to database

	require 'vendor/autoload.php';
	$client = new MongoDB\Client('mongodb+srv://Abir_Das:abir1048@cluster0-lpt7x.mongodb.net/test?retryWrites=true&w=majority');

	$db = $client->pms;
	$collection1 = $db->user;
	$collection2 = $db->location;
	$collection3 = $db->connection;
	$collection4 = $db->payment;
	$collection5 = $db->notification;
	$collection6 = $db->unit;
	$collection7 = $db->unitminute;

	$tz = 'Asia/Dhaka';
    $tz_obj = new DateTimeZone($tz);
    $now = new DateTime("now", $tz_obj);
    $current_date = $now->format('Y-m-d');
    $current_time = $now->format('H:i');
    $current_month = $now->format('m');
    $current_year = $now->format('Y');
	
	// variable declaration
	$location = "";
	$location_id = "";
	$meter_number = "";
	$username = "";
	$user = "";
	$name = "";
	$mobile_number = "";
	$nid = "";
	$email = "";
	$role = "";
	$errors = array();
	$successes = array();
	$notification_errors = array();
	$notification_successes = array();

	$reset_out = 0;
	$otp_out = 0;

	if (isset($_POST['add'])) {
		// receive all input values from the form
		$name = strtolower($_POST['name']);
		$mobile_number = strtolower($_POST['mobile_number']);
		$meter_number = strtolower($_POST['meter_number']);
		$location_id = $_POST['location'];
		$nid = $_POST['NID'];
		$email = $_POST['email'];

	
		// form validation: ensure that the form is correctly filled
		if (empty($name)) { array_push($errors, "Name is required"); }
		if (empty($mobile_number)) { array_push($errors, "Mobile Number is required"); }
		if (empty($meter_number)) { array_push($errors, "meter_number is required"); }
		if (empty($location_id)) { array_push($errors, "Location is required"); }
		if (empty($nid)) { array_push($errors, "NID is required"); }
		if (empty($email)) { array_push($errors, "Email is required"); }

		$result4 = $collection2->findOne(array('_id' => new MongoDB\BSON\ObjectId("$location_id")));

		$location = $result4['location'];
		
		$username = $location.$meter_number;

		$username = str_replace(' ', '', $username);

		//

		if ($collection1->findOne(array('username' => $username))) {
			array_push($errors, "Meter Number already exists");
		}

		// register user if there are no errors in the form
		if (count($errors) == 0) {
			
			$password = md5("123456");//encrypt the password before saving in the database
			

			$document1 = array( 
      			"name" => $name, 
      			"mobile_number" => $mobile_number,
      			"meter_number" => $meter_number,
      			"location" => $location,
      			"username" => $username,
      			"nid" => $nid,
      			"email" => $email,
      			"role" => "user",
      			"password" => $password
      			);

			$document2 = array( 
      			"username" => $username,
      			"balance" => 0,
      			"mood" => "under construction",
      			"loan" => '1',
      			"switch_1" => 1,
      			"switch_2" => 1
      			);
			$document3 = array( 
      			"username" => $username,
      			"unit_minute" => 0,
      			);

			
			if($collection1->insertOne($document1)){
				$collection3->insertOne($document2);
				$collection7->insertOne($document3);
				array_push($successes, "User ".$username." added successfully ");
			}
		}
	}

	if (isset($_POST['login'])) {
		$username = strtolower($_POST['username']);
		$password = $_POST['password'];

		if (empty($username)) {
			array_push($errors, "username is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

		if (count($errors) == 0) {

				$password = md5($password);
			


			$query1 = array('$and' => array(array("username" => $username), 
				array("password" => $password)));

			$result1 = $collection1->findOne($query1);

			if($result1){
				$_SESSION['role'] = $result1["role"];
				$_SESSION['username'] = $result1["username"];
					if($_SESSION['role'] == "user"){
						
						header('location: index.php');
					}
					elseif ($_SESSION['role'] == "admin") {
						header('location: adindex.php');
					}
				
		}
			else {
				array_push($errors, "Wrong meter number number/password combination");
			}
				

		}
	}

	if (isset($_POST['add_location'])) {
		// receive all input values from the form
		$location = strtolower($_POST['location']);


		// form validation: ensure that the form is correctly filled
		if (empty($location)) { array_push($errors, "Location is required"); }

		$location = strtolower($location);

		if ($collection2->findOne(array('location' => $location))) {
			array_push($errors, "Location already inserted");
		}

		// register user if there are no errors in the form
		if (count($errors) == 0) {
			

			$document = array( 
      			"location" => $location
      			);

			
			if($collection2->insertOne($document)){
				array_push($successes, "Location ".$location." added successfully ");
			}
		}
	}

	if (isset($_POST['add_payment'])) {
		// receive all input values from the form
		$username = strtolower($_POST['username']);
		$amount = strtolower($_POST['amount']);
		$recipt = strtolower($_POST['money_recipt']);


		// form validation: ensure that the form is correctly filled
		if (empty($username)) { array_push($errors, "Username is required"); }
		if (empty($amount)) { array_push($errors, "Amount is required"); }
		if (empty($recipt)) { array_push($errors, "Recipt No is required"); }


		if ($collection4->findOne(array('recipt' => $recipt))) {
			array_push($errors, "Recipt No already inserted");
		}

		// register user if there are no errors in the form
		if (count($errors) == 0) {

			$amount = (double)$amount;

			$demand_charge = 15;
			$meter_rent = 40;
			$service_charge = 10;

			$percentage = ($amount * 5)/100;
 			

			$document = array( 
      			"username" => $username,
      			"amount" => (double)$amount,
      			"recipt" => $recipt,
      			"date" => $current_date,
      			"month" => $current_month,
      			"year" => $current_year,
      			"mobile_number" => "n/a",
      			"type" => "cash",
      			"status" => "accepted"
      			);

			$query = array('$and' => array(array("username" => $username), 
				array("year" => $current_year), array("month" => $current_month), array("status" => "accepted")));

			if($collection4->findOne($query)){
				$amount = $amount - $percentage;
			}
			else{
				$amount = $amount - ($percentage + $demand_charge + $service_charge + $meter_rent);
			}

			
			if($collection4->insertOne($document)){
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

				array_push($successes, "Payment added successfully ");
			}
		}
	}

	if (isset($_POST['user_add_payment'])) {
		// receive all input values from the form
		$username = strtolower($_POST['username']);
		$mobile_number = strtolower($_POST['bkash_number']);
		$amount = strtolower($_POST['amount']);
		$recipt = strtolower($_POST['trx_id']);


		// form validation: ensure that the form is correctly filled
		if (empty($mobile_number)) { array_push($errors, "Bkash Number is required"); }
		if (empty($amount)) { array_push($errors, "Amount is required"); }
		if (empty($recipt)) { array_push($errors, "Transaction ID is required"); }


		if ($collection4->findOne(array('recipt' => $recipt))) {
			array_push($errors, "Transaction ID already inserted");
		}

		$amount = (double)$amount;
		if ($amount < 300){
			array_push($errors, "You have to recharge minimum 300tk");
		}

		// register user if there are no errors in the form
		if (count($errors) == 0) {
			

			$document = array( 
      			"username" => $username,
      			"amount" => $amount,
      			"recipt" => $recipt,
      			"date" => $current_date,
      			"month" => $current_month,
      			"year" => $current_year,
      			"mobile_number" => $mobile_number,
      			"type" => "bkash",
      			"status" => "pending"
      			);

			
			if($collection4->insertOne($document)){
				header('location: user_billing.php');
			}
		}
	}


	if (isset($_POST['add_notification'])) {
		// receive all input values from the form
		$date_for = ($_POST['date']);
		$subject = strtolower($_POST['subject']);
		$message = strtolower($_POST['message']);


		// form validation: ensure that the form is correctly filled
		if (empty($date_for)) { array_push($notification_errors, "Date is required"); }
		if (empty($subject)) { array_push($notification_errors, "Subject is required"); }
		if (empty($message)) { array_push($notification_errors, "Message is required"); }


		if ($date_for < $current_date) {
			array_push($notification_errors, "You can't use previous date");
		}

		// register user if there are no errors in the form
		if (count($notification_errors) == 0) {
			

			$document = array( 
      			"date_for" => $date_for,
      			"subject" => $subject,
      			"message" => $message,
      			"posted_date" => $current_date,
      			);

			
			if($collection5->insertOne($document)){
				header('location: announcement.php');
			}
		}
	}

	if (isset($_POST['update'])) {
		// receive all input values from the form
		$username = strtolower($_POST['username']);
		$name = strtolower($_POST['name']);
		$mobile_number = strtolower($_POST['mobile_number']);
		$nid = $_POST['NID'];
		$email = $_POST['email'];


		// form validation: ensure that the form is correctly filled
		if (empty($username)) { array_push($errors, "Username is required"); }
		if (empty($name)) { array_push($errors, "Name is required"); }
		if (empty($mobile_number)) { array_push($errors, "Mobile Number is required"); }
		if (empty($nid)) { array_push($errors, "NID is required"); }
		if (empty($email)) { array_push($errors, "Email is required"); }



		// register user if there are no errors in the form
		if (count($errors) == 0) {
			
			if($collection1->updateOne(['username' => $username],
			    ['$set' =>
			    	['name' => $name,
			    	'mobile_number' => $mobile_number,
			    	'nid' => $nid,
			    	'email' => $email
			    ]
			    ])){
				header('location: user_list.php');
			}

				
			}
		}

		if (isset($_POST['change_password'])) {
		// receive all input values from the form
		$username = strtolower($_POST['username']);
		$current_password = $_POST['current_password'];
		$new_password_1 = $_POST['new_password_1'];
		$new_password_2 = $_POST['new_password_2'];


		// form validation: ensure that the form is correctly filled
		
		if (empty($current_password)) { array_push($errors, "Current Password is required"); }
		if (empty($new_password_1)) { array_push($errors, "Please Enter New Password"); }
		if (empty($new_password_2)) { array_push($errors, "Please Retype New Password"); }

		if ($new_password_1 != $new_password_2) {
			array_push($errors, "The two passwords do not match");
		}

		$current_password = md5($current_password);
		$new_password = md5($new_password_1);

		$result22 = $collection1->findOne(array('username' => $username));

		if($result22['password'] != $current_password) {
			array_push($errors, "Current Password doesn't match");
		}



		// register user if there are no errors in the form
		if (count($errors) == 0) {
			
			if($collection1->updateOne(['username' => $username],
			    ['$set' =>
			    	['password' => $new_password]
			    ])){
				header('location: index.php');
			}

				
			}
		}

		if(isset($_POST['sendotp'])) {


                $user = strtolower($_POST['user']);

                if (empty($user)) { array_push($errors, "Username is required"); }

                $result = $collection1->findOne(array('username' => $user));

                if(!$result) {
                    array_push($errors, "Invalid Username");
                }else{
                    $email = $result['email'];
                    $name = $result['name'];
                }
                if (count($errors) == 0) {
                    $otp = mt_rand(10000, 99999);

                    $to_email = $email;
                    $subject = "OTP for reset password";
                    $body = "Dear $name, you requested for a OTP password. Here is your OTP: $otp";
                    $headers = "From: sender email";

                    setcookie('otp', $otp);
                    if(mail($to_email, $subject, $body, $headers)){
                         $otp_out = 1;
                    }
                }
                
            }
            if(isset($_POST['verifyotp'])) { 
            	$user = $_POST['user'];
                $otp = $_POST['otp'];
                if( $_COOKIE['otp'] == $otp) {
                    $_SESSION['user'] = $user;
                    header('location: reset_password.php');
                } else {
                    array_push($errors, "OTP Doesn't match");
                }
            }

		if (isset($_POST['reset_password'])) {
		// receive all input values from the form
		$user = strtolower($_POST['user']);
		$new_password_1 = $_POST['new_password_1'];
		$new_password_2 = $_POST['new_password_2'];


		// form validation: ensure that the form is correctly filled
		
		if (empty($new_password_1)) { array_push($errors, "Please Enter New Password"); }
		if (empty($new_password_2)) { array_push($errors, "Please Retype New Password"); }

		if ($new_password_1 != $new_password_2) {
			array_push($errors, "The two passwords do not match");
		}

		$new_password = md5($new_password_1);


		// register user if there are no errors in the form
		if (count($errors) == 0) {
			
			if($collection1->updateOne(['username' => $user],
			    ['$set' =>['password' => $new_password]])){
				session_destroy();
        		unset($_SESSION['user']);
				$reset_out = 1;
			}

				
			}
		}

		

?>
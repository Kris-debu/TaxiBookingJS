<?php

function check_form_pattern($var, $pattern, $name){
	
	if ((isset($var)) && ($var != "")){
	
		if (preg_match($pattern, $var)){
		} else {$GLOBALS['error_text'] .= "$name - invalid input <br>";}
	} else {$GLOBALS['error_text'] .= "$name - not filled out <br>";}
}
function check_form($var, $name){
	if ((isset($var)) && ($var != "")){
	} else {$GLOBALS['error_text'] .= "$name - not filled out <br>";}
}
$name = $_POST['name'];
$phone = $_POST['phone'];
$pickupSuburb = $_POST['pickupSuburb'];
$pickupStreetName = $_POST['pickupStreetName'];
$pickupStreetNumber = $_POST['pickupStreetNumber'];
$pickupUnitNumber = $_POST['pickupUnitNumber'];
$pickupDate = $_POST['pickupDate'];
$pickupTime = $_POST['pickupTime'];

$dropoffSuburb = $_POST['dropoffSuburb'];
$dropoffStreetName = $_POST['dropoffStreetName'];
$dropoffStreetNumber = $_POST['dropoffStreetNumber'];
$bookingDate = date("d/m/y");
$bookingTime = date("h:i:sa");

$error_text = "";
check_form_pattern($name,'/^[A-Za-z ]*$/',"Name");
check_form_pattern($phone,'/^[0-9]/',"Phone");
check_form_pattern($pickupStreetName,'/^[A-Za-z ]*$/',"Pick up street name");
check_form_pattern($pickupStreetNumber, '/^[0-9]/',"Pick up street number");
check_form($pickupDate,"Date");
check_form($pickupTime,"Time");
check_form_pattern($dropoffStreetName,'/^[A-Za-z ]*$/',"Drop off street name");
check_form_pattern($dropoffStreetNumber, '/^[0-9]/',"Drop off street number");


// check if the pickup date is not before the current date
$month = substr($pickupDate,5,2);
$day = substr($pickupDate,8,2);

if ($month == date("m")){
	if ($day == date("d")){
		$hour = substr($pickupTime,0,2);
		$current_hour = date("h");
		if ($current_hour < 12){$current_hour += 12;}
		if ($hour < 12){$hour += 12;}	

		if ($hour < $current_hour){
			$GLOBALS['error_text'] .= "The time you are wishing to book has already passed (change the HOUR)";
			
		} else if ($hour == $current_hour){

			$minute = substr($pickupTime,3,2);
			
			if ($minute <= date("i")){
				$GLOBALS['error_text'] .= "The time you are wishing to book has already passed (change the MINUTE)";
			} else {
			}
		} 
		
	} else if ($day < date("d")){
		$GLOBALS['error_text'] .= "The date you are wishing to book has already passed (change the DAY) ";
	}
}
if (!$error_text == ""){
	echo $error_text;
} 
else
{
	require_once('/home/tfm6325/public_html/assign 2/conf/settings.php');
	$connect = mysqli_connect($host,$user,$pswd,$dbnm) or die('Failed to connect to server');
	if (!$connect) {
		echo "Database connection error";
	} else {
		$table_exists = mysqli_query($connect,"SELECT * FROM taxi;");
		if (!$table_exists) {
                                echo "CREATE TABLE taxi (
				booking_no INT(4) PRIMARY KEY AUTO_INCREMENT, 
				name VARCHAR(20),
				phone VARCHAR(12),
				pickupSuburb VARCHAR(10),
				pickupstreetName VARCHAR(100),
				pickupStreetNumber VARCHAR(5),
				pickupUnitNumber VARCHAR(5),
				pickupDate DATE,
				pickupTime TIME,
				dropoffSuburb VARCHAR(10),
				dropoffStreetName VARCHAR(100),
				dropoffStreetNumber VARCHAR(5),
				status VARCHAR(100),
				bookingDate DATE,
				bookingTime TIME);";
 		} else {
			$db_date = date("y/m/d");
			$add_to_db = "INSERT INTO taxi(name,phone,pickupSuburb,pickupStreetName,pickupStreetNumber,pickupUnitNumber,
			pickupDate,pickupTime,dropoffSuburb,dropoffStreetName,dropoffStreetNumber,status,bookingDate,bookingTime) 
			VALUES ('$name','$phone','$pickupSuburb','$pickupStreetName','$pickupStreetNumber','$pickupUnitNumber','$pickupDate',
			'$pickupTime','$dropoffSuburb','$dropoffStreetName','$dropoffStreetNumber','Unassigned','$db_date','$bookingTime');";
					
			$result = mysqli_query($connect,$add_to_db);
			if ($result == true){
				$query = "SELECT MAX(booking_no) FROM taxi;";
				$get_reference_no = mysqli_query($connect,$query);
				
				if ($get_reference_no == true){
				
					$query = mysqli_fetch_array($get_reference_no);
					$reference_no = $query[0];
					
					$format_date = "$day-$month-2021";
					
					echo "\nYour booking have been received!
					<br> Your reference number is: $reference_no
					<br> You will be picked up from: $pickupStreetNumber $pickupStreetName at $pickupTime on the $format_date.";
					
				}
				
			} else {
				echo "Error, cannot book a taxi!";
			}

		}
	}	
	mysqli_free_result($result);
	mysqli_close($connect);
	
}
?>
<?php
require_once('/home/tfm6325/public_html/assign 2/conf/settings.php');
$connect = mysqli_connect($host,$user,$pswd,$dbnm) or die('Error - Failed to connect to server');
if (!$connect) {
	echo "Error - Database connection failure";
} else {
	$table_exists = mysqli_query($connect,"SELECT * FROM taxi;");
	if (!$table_exists) {
		echo "Error - Database does not exist.";
	} else {
		$todays_date = date("y/m/d");
		if (date("a") == "pm"){
			$two_hours_from_now = date("h")+14 . date(":i:s");
			$current_time = date("h")+12 . date(":i:s");
		} else {
			$two_hours_from_now = date("h:i:sa", strtotime('+2 hours'));
			$current_time = date("h:i:s");
			
			if (strpos($two_hours_from_now,"pm")==true){
				$two_hours_from_now = date("h")+2 . date(":i:s");
			}
		}
		$pickup_query = "SELECT * FROM taxi WHERE (pickupDate = '$todays_date' AND pickupTime >= '$current_time' AND pickupTime <= '$two_hours_from_now' AND status = 'Unassigned');";	
		$results = mysqli_query($connect,$pickup_query);
		if ($results==true){
			while($row = mysqli_fetch_array($results)){
				echo $row['booking_no'] . "#";
				echo $row['bookingTime'] . "#";
				echo $row['name'] . "#";
				echo $row['phone'] . "#";
				echo $row['pickupSuburb'] . "#";
				echo $row['pickupStreetName'] . "#";
				echo $row['pickupStreetNumber'] . "#";
				echo $row['pickupUnitNumber'] . "#";
				echo $row['pickupDate'] . "#";
				echo $row['pickupTime'] . "#";
				echo $row['dropoffStreetName'] . "#";
				echo $row['dropoffStreetNumber'] . "#";
				echo $row['bookingDate'] . "#$";
			}
		}
	}
}
mysqli_free_result($result);
mysqli_close($connect);
	
?>
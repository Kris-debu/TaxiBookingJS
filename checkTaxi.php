<?php
$input = $_POST['input'];

require_once('/home/tfm6325/public_html/assign 2/conf/settings.php');
$connect = mysqli_connect($host,$user,$pswd,$dbnm) or die('Failed to connect to server');
if ($input != ""){
	if (!$connect) {
		echo "Database connection failure";
	} else {
		$table_exists = mysqli_query($connect,"SELECT * FROM taxi;");
		if (!$table_exists) {
		} else {
			// if table exists
			$query = "SELECT * from taxi WHERE (booking_no = '$input');";
			$result = mysqli_query($connect,$query);
			if ($result == true){
				$query = mysqli_fetch_array($result);
				$status = $query['status'];
					
				if ($status==""){
					echo "There are no reference numbers '$input'.";
					
				} else if ($status == 'Assigned'){
					
					echo "This booking has already been assigned.";
					
				} else {
					
					$query = "UPDATE taxi SET status='Assigned' WHERE (booking_no='$input');";
					$result = mysqli_query($connect,$query);
					
					if ($result == true){
						echo "Booking request $input has been successfully assigned!";
					} else {
						echo "Error, this record remains Unassigned";
					}
				}
			} else {
				echo "Error, cannot assign taxi!";
			}
		}	
	mysqli_free_result($result);
	mysqli_close($connect);
		
	}

}

?>
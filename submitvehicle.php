<?php

if(isset($_POST['submit']))
{    
     $vehicle_no = $_POST['vehicleNo'];
     $vehicle_simNo = $_POST['vehicleSIM'];
     $vehicle_type = $_POST['vehicleType'];
     $sql = "INSERT INTO vehicleinfo (vehicle_no, vehicle_simNo, vehicle_type)
     VALUES ('$vehicle_no','$vehicle_simNo','$vehicle_type')";
     if (mysqli_query($conn, $sql)) {
        echo "New vehicle record has been added successfully !";
     } else {
        echo "Error: " . $sql . ":-" . mysqli_error($conn);
     }
     mysqli_close($conn);
}

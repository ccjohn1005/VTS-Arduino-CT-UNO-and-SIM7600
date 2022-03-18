<?php
    require_once('./config/config.php');
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
} 

if (isset($_POST['updatedata']))
{
    $vehicleID = $_POST['vehicle_id'];
    $vehicleno = $_POST['vehicleno1'];
    $vehiclesim = $_POST['vehiclesim1'];
    $vehicletype = $_POST['vehicletype1'];
    $vehicleemail = $_POST['drvemail1'];

    $query = "UPDATE vehicleinfo SET vehicle_no='$vehicleno', vehicle_simNo='$vehiclesim', vehicle_type='$vehicletype', vehicle_email='$vehicleemail' WHERE id = '$vehicleID' ";
    $query_run = mysqli_query($link, $query);
    
    if($query_run)
    {

        header("location: vehicleinfo.php");
        echo '<script> alert("Date Updated"); </script>';
    } else {
        echo '<script> alert("Date Not Updated"); </script>';
    }

}

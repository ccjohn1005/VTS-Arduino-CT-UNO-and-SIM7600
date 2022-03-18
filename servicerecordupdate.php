<?php
    require_once('./config/config.php');
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
} 

if (isset($_POST['updatedata1']))
{
    $serviceid =  $_POST['service_id'];
    $vehicleno = $_POST['vehicleno12'];
    $serviceMileage = $_POST['intervalMileage12'];
    $servicefrom  = $_POST['from_Odometer12'];
    // $serviceto  = $_POST['to_Odometer12'];

    $query = "UPDATE serviceRecord SET vehicle_no='$vehicleno', intervalMileage='$serviceMileage', from_Odometer='$servicefrom' WHERE serviceid = '$serviceid' ";
    $query_run = mysqli_query($link, $query);
    
    if($query_run)
    {
        echo '<script> alert("Date Updated"); </script>';
        header("location: servicerecord.php");
    } else {
        echo '<script> alert("Date Not Updated"); </script>';
    }

}

<?php
    require_once('./config/config.php');
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
} 

if (isset($_POST['updatedata1']))
{
    $fid =  $_POST['fid1'];
    $vehicleno =  $_POST['vehicleno1'];
    $tripmeter = $_POST['trip_Odometer1'];
    $fuelLitre = $_POST['fuelLitre1'];
    $fuelprice = $_POST['fuelPrice1'];
    $date  = $_POST['filled_on1'];

    $query = "UPDATE fueltracker SET vehicle_no='$vehicleno', trip_Odometer='$tripmeter', fuelLitre = '$fuelLitre',  fuelPrice='$fuelprice',  filled_on= '$date' WHERE fid = '$fid' ";
    $query_run = mysqli_query($link, $query);
    
    if($query_run)
    {

        header("location: fueltrack.php");
        echo '<script> alert("Date Updated"); </script>';
    } else {
        echo '<script> alert("Date Not Updated"); </script>';
    }

}
?>


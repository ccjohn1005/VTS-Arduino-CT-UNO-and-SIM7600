<?php
    require_once('./config/config.php');
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
} 

if (isset($_POST['deletedata']))
{
    $id = $_POST['delete_id'];

    $query = "DELETE FROM serviceRecord WHERE serviceid = '$id' ";
    $query_run = mysqli_query($link, $query);
    
    if($query_run)
    {
        header("location: servicerecord.php");
        echo '<script> alert("Date Deleted"); </script>';

    } else {
        echo '<script> alert("Date Not Deleted"); </script>';
    }

}

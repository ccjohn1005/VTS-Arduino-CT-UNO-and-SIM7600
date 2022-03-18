<?php
    require_once('./config/config.php');
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
} 

if (isset($_POST['deletedata']))
{
    $id = $_POST['delete_id'];

    $query = "DELETE FROM users_vts WHERE id = '$id' ";
    $query_run = mysqli_query($link, $query);
    
    if($query_run)
    {
        header("location: manageuser.php");
        echo '<script> alert("Date Deleted"); </script>';

    } else {
        echo '<script> alert("Date Not Deleted"); </script>';
    }

}

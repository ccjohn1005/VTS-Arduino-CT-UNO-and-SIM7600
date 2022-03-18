<?php
    require_once('./config/config.php');
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
} 

if (isset($_POST['updatedata1']))
{
    $id =  $_POST['id'];
    $name = $_POST['name1'];
    $admin = $_POST['admin1'];

    $query = "UPDATE users_vts SET id='$id', name='$name', admin='$admin' WHERE id = '$id' ";
    $query_run = mysqli_query($link, $query);
    


    
    if($query_run)
    {
        header("location: manageuser.php");
        echo '<script> alert("Date Updated"); </script>';

    } else {
        echo '<script> alert("Date Not Updated"); </script>';
    }

}

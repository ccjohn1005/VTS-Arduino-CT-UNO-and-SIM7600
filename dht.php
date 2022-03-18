<?php
class dht11
{
    public $link;
    function __construct($vehicleno, $latitude, $longtitude)
    {
        $this->connect();
        $this->storeInDB($vehicleno, $latitude, $longtitude);
    }

    function connect()
    {
        $this->link = mysqli_connect('HOSTSERVER', 'DB_USER', 'DB_PSSWD') or die('Cannot connect to the DB');
        mysqli_select_db($this->link, 'DB_NAME') or die('Cannot select the DB');
    }

    function storeInDB($vehicleno, $latitude1, $longtitude1)
    {
        $query = "INSERT INTO vehiclestatus (vehicle_no, latitude, longtitude) values ('$vehicleno','$latitude1', '$longtitude1')";

        $result = mysqli_query($this->link, $query) or die('Errant query:  ' . $query);
    }
}
if ($GET_['vehicleno'] and $_GET['latitude'] != '' and  $_GET['longtitude'] != '') {
    $dht11 = new dht11($GET_['vehicleno'], $_GET['latitude'], $_GET['longtitude']);
}

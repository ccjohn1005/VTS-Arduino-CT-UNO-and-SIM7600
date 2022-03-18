<?php
    require_once "./config/config.php";
$output = '';

if(isset($_POST["query"]))
{
 $search = mysqli_real_escape_string($link, $_POST["query"]);
 $query = "
  SELECT * FROM vehiclestatus 
  WHERE vehicle_no LIKE '%".$search."%'
 ";
}
else
{
    $query = "
     SELECT * FROM vehiclestatus ORDER BY vehicle_no
    ";
   }
   $result = mysqli_query($link, $query);
   if(mysqli_num_rows($result) > 0)
   {
    $output .= '
    <table class="table table-bordered"><thead>
     <tr>
         <th>VID</th>
         <th>Vehicle Plate No.</th>
         <th>Latitude</th>
         <th>Longtitude</th>
         <th>Date/Time</th>
         <th>Location (Maps)</th>
     </tr></thead>';
     $i = 1;
     while($row = mysqli_fetch_array($result))
     {
      $output .= '
      <tbody>
      <tr>
      <td>' . $i . '</td>
      <td>' . $row["vehicle_no"] . '</td>
      <td>' . $row["latitude"] . '</td>
      <td>' . $row["longtitude"] . '</td>
      <td>' . $row["created_on"] . '</td>
      <td id="floating-panel">
      <a href=./viewmap.php?ID='.$i.'&vehicleno='.$row["vehicle_no"].'&latitude='.$row["latitude"].'&longtitude='.$row["longtitude"].'&Date='.$row["created_on"].'> <input id="submit" class="btn btn-primary" type="button" value="View on map" />
      </td>
  </tr>
    
     
  ';
  $i++;
}
$output .='
</tbody>
</table>
';
     echo $output;
    }
    else
    {
        echo 'Vehicle Not Found.';
    }
?>
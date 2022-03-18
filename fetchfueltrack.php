<?php
    require_once "./config/config.php";
    $output = '';


if(isset($_POST["query"]))
{
 $search = mysqli_real_escape_string($link, $_POST["query"]);
 $query = "
 SELECT FID, vehicle_no, trip_Odometer, fuelLitre, fuelPrice, ROUND(fuelLitre * fuelPrice, 2) AS fuelCost, ROUND(trip_Odometer / fuelLitre, 2) AS `fuel_Consumption`, filled_on FROM fueltracker
  WHERE vehicle_no LIKE '%".$search."%' 
 ";
}
else
{
    $query = "SELECT FID, vehicle_no, trip_Odometer, fuelLitre, fuelPrice, ROUND(fuelLitre * fuelPrice, 2) AS fuelCost, ROUND(trip_Odometer / fuelLitre, 2) AS `fuel_Consumption`, filled_on FROM fueltracker";
   }
   $result = mysqli_query($link, $query);
   if(mysqli_num_rows($result) > 0)
   {
    $output .= '
    <table class="table table-bordered"><thead>
     <tr>
        <th>Fuel ID</th>
        <th>Vehicle Plate No.</th>
        <th>Trip Odometer</th>
        <th>Total Refueling Litres</th>
        <th>Fuel Price (Per Litre)</th>
        <th>Total Fuel Cost</th>
        <th>Fuel Consumption</th>
        <th>Refueling Date</th>
        <th>Action</th>
     </tr></thead>';
     $i = 1;

     while($row = mysqli_fetch_array($result))
     {
      $output .= '
      <tbody>
      <tr>
      ';
        $output .='
        <td hidden>' . $row["FID"] . '</td>
        <td>' . $i . '</td>
        <td>' . $row["vehicle_no"] . '</td>
        <td>' . $row['trip_Odometer'] . ' KM'. ' </td>
        <td>' . $row['fuelLitre'] . ' Litres'.'</td>
        <td>' .'RM ' . $row['fuelPrice'] . '</td>
        <td>' .'RM '. $row['fuelCost'] . '</td>
        <td>' . $row['fuel_Consumption'] . ' KM/Litre'. '</td>
        <td>' . $row['filled_on'] . '</td>

      <td>
      <button type="button" class="btn btn-info editbtn mr-4">EDIT</button>
      <button type="button" class="btn btn-danger deletebtn ">DELETE</button>
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

<script>
    $(document).ready(function () {
        $('.deletebtn').on('click', function (){
            $('#deletemodal').modal('show');
                $tr=$(this).closest('tr');
                var data = $tr.children("td").map(function(){
                    return $(this).text();
                }).get();

                console.log(data);
                $('#delete_id').val(data[0]);
        });
    })
    </script>

    <script>
    $(document).ready(function () {
        $('.editbtn').on('click', function (){
            $('#editmodal').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map (function (){
                    return $(this).text();
                }).get();

                console.log(data);

                $('#fid1').val(data[0]);
                $('#vehicleno1').val(data[2]);
                $('#trip_Odometer1').val(data[3].slice(0, -4));
                $('#fuelLitre1').val(data[4].slice(0, -7));
                $('#fuelPrice1').val(data[5].slice(2, 7));
                $('#filled_on1').val(data[8]);
        });
    })
    </script>

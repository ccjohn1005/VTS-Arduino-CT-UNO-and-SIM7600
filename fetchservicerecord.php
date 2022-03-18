<?php
    require_once "./config/config.php";
    $output = '';

    function customize_today_date($format){
        $dt = new DateTime($format);
        return $dt->format('Y-m-d');
    }

if(isset($_POST["query"]))
{
 $search = mysqli_real_escape_string($link, $_POST["query"]);
 $query = "
  SELECT *, (intervalMileage + from_Odometer) AS 'to_Odometer' , DATE_ADD(created_on, interval 6 month) as 'service_date' FROM servicerecord 
  WHERE vehicle_no LIKE '%".$search."%' 
 ";
}
else
{
    $query = "SELECT serviceID, vehicle_no, intervalMileage, from_Odometer, (intervalMileage + from_Odometer) AS 'to_Odometer', created_on, DATE_ADD(created_on, interval 6 month) as 'service_date' from servicerecord";
   }
   $result = mysqli_query($link, $query);
   if(mysqli_num_rows($result) > 0)
   {
    $output .= '
    <table class="table table-bordered"><thead>
     <tr>
         <th>Service ID</th>
         <th>Vehicle Plate No.</th>
         <th>Interval Mileage</th>
         <th>From Odometer</th>
         <th>To Odometer</th>
         <th>Date of Service</th>
         <th>Date of Next Service</th>
         <th>Action</th>
     </tr></thead>';
     $i = 1;

     while($row = mysqli_fetch_array($result))
     {
      $output .= '
      <tbody>
      <tr>
      ';
      $ser_date = customize_today_date($row['service_date']); 
      $created_date = customize_today_date($row["created_on"]);
        $output .='
        <td hidden>' . $row["serviceID"] . '</td>
        <td>' . $i . '</td>
        <td>' . $row["vehicle_no"] . '</td>
        <td>' . $row['intervalMileage'] .' KM'. '</td>
        <td>' . $row['from_Odometer'] . ' KM'.'</td>
        <td>' . $row['to_Odometer'] . ' KM' .'</td>
        <td>' . $created_date . '</td>
        <td>' . $ser_date . '</td>

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

                $('#service_id').val(data[0]);
                $('#vehicleno12').val(data[2]);
                $('#intervalMileage12').val(data[3].slice(0, -3 ));
                $('#from_Odometer12').val(data[4].slice(0, -3));
        });
    })
    </script>

<?php
require_once "./config/config.php";
$output = '';

if (isset($_POST["query"])) {
    $search = mysqli_real_escape_string($link, $_POST["query"]);
    $query = "
  SELECT * FROM vehicleinfo 
  WHERE vehicle_no LIKE '%" . $search . "%' 
  OR vehicle_email LIKE '%" . $search . "%' 
  OR vehicle_simNo LIKE '%" . $search . "%'
 ";
} else {
    $query = "
     SELECT * FROM vehicleinfo ORDER BY vehicle_no
    ";
}
$result = mysqli_query($link, $query);
if (mysqli_num_rows($result) > 0) {
    $output .= '
    <table class="table table-bordered"><thead>
     <tr>
         <th hidden>ID</th>
         <th>ID</th>
         <th>Vehicle Plate No.</th>
         <th>Vehicle Sim No.</th>
         <th>Type of Vehicle</th>
         <th>Driver"s Email Address</th>
         <th>Date/Time</th>
         <th>Action</th>
     </tr></thead>';
    $i = 1;
    while ($row = mysqli_fetch_array($result)) {
        $output .= '
      <tbody>
      <tr>
      <td hidden>' . $row["id"] . '</td>
      <td>' . $i . '</td>
      <td>' . $row["vehicle_no"] . '</td>
      <td>' . $row['vehicle_simNo'] . '</td>
      <td>' . $row['vehicle_type'] . '</td>
      <td>' . $row['vehicle_email'] . '</td>
      <td>' . $row['inserted_on'] . '</td>
      <td>
      <button type="button" class="btn btn-info editbtn mr-4">EDIT</button>
      <button type="button" class="btn btn-danger deletebtn ">DELETE</button>
      </td>
  </tr>
    
     
  ';
        $i++;
    }
    $output .= '
</tbody>
</table>
';
    echo $output;
} else {
    echo 'Vehicle Not Found.';
}





?>
<script>
    $(document).ready(function() {
        $('.editbtn').on('click', function() {
            $('#editmodal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            console.log(data);

            $('#vehicle_id').val(data[0]);
            $('#vehicleno1').val(data[2]);
            $('#vehiclesim1').val(data[3]);
            $('#vehicletype1').val(data[4]);
            $('#drvemail1').val(data[5]);
        });
    })
</script>

<script>
    $(document).ready(function() {
        $('.deletebtn').on('click', function() {
            $('#deletemodal').modal('show');
            $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            console.log(data);
            $('#delete_id').val(data[0]);
        });
    })
</script>
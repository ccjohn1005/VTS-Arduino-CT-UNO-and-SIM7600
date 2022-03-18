<?php
include 'inc/header.php'
?>
<script src="js/map.js"></script>


<?php
// logout
if (isset($_POST['but_logout'])) {
  session_destroy();
  header('Location: login.php');
}
?>

</head>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Sidebar -->
    <?php
    include 'inc/sidebar.php';
    ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
          <!-- Topbar Navbar -->
          <?php
          include 'inc/topbar.php';
          ?>
          <!-- End of Topbar -->

          <!-- Begin Page Content -->
          <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
              <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            </div>

            <!--The div element for the map -->
            <div id="map" style="height: 550px; margin-bottom: 10px "></div>




            <?php
            require_once "./config/config.php";
            $sql = "SELECT * FROM vehiclestatus order by created_on DESC, VSID Limit 1";
            if ($result = mysqli_query($link, $sql)) {

              if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_array($result)) {

                  echo "<h4 id='lat'hidden >" . $row['latitude'] . "</h4>";
                  echo "<h4 id='log'hidden >" . $row['longtitude'] . "</h4>";
                  echo "<h4>Vehicle Plate No: $row[vehicle_no] &nbsp Date/Time : $row[created_on]</h4>";
                  echo "<div class='' id='floating-panel'>";

                  echo "<input class='mb-3' id='latlng' type='text' value='$row[latitude], $row[longtitude]' />";

                  echo "</div>";
                }
                mysqli_free_result($result);
              } else {
                echo "No records matching your query were found.";
              }
            } else {
              echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
            }

            // Close connection
            mysqli_close($link);
            ?>

            <div id="result">Address</div>
          </div>
          <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php
      include 'inc/footer.php';
      ?>
      <!-- End of Footer -->


      <!-- Bootstrap core JavaScript-->
      <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

      <!-- Core plugin JavaScript-->
      <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

      <!-- Custom scripts for all pages-->
      <script src="js/sb-admin-2.min.js"></script>
      <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
      <script src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap&libraries=&v=weekly" async></script>


</body>

</html>

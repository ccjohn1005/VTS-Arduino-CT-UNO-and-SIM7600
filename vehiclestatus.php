<?php
include 'inc/header.php'
?>

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
                    <?php
                    include 'inc/topbar.php';
                    ?>
                    <!-- End of Topbar -->

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h2 mb-0 text-gray-800">Vehicle Status</h1>


                            <form class="form-inline ">
                                <input class="form-control " name="search_text" id="search_text" type="search" placeholder="Search vehicle" aria-label="Searching">
                            </form>

                        </div>



                        <?php
                        require_once "./config/config.php";

                        // Attempt select query execution
                        $sql = "SELECT VSID, vehicle_no, latitude, longtitude, created_on FROM vehiclestatus ORDER BY VSID DESC";
                        if ($result = mysqli_query($link, $sql)) {

                            if (mysqli_num_rows($result) > 0) {

                                echo '<table id="vehiclelist" class="table table-bordered" ><thead>';
                                echo "<tr>";
                                echo "<th>VID</th>";
                                echo "<th>Vehicle Plate No.</th>";
                                echo "<th>Latitude</th>";
                                echo "<th>Longtitude</th>";
                                echo "<th>Date/Time (Latest on top)</th>";
                                echo "<th>Location (Maps)</th>";
                                echo "</tr>";
                                echo '</thead>';
                                $i = 1;
                                while ($row = mysqli_fetch_array($result)) {
                                    echo '<tbody>';
                                    echo "<tr>";
                                    echo "<td>" . $i . "</td>";
                                    echo "<td>" . $row['vehicle_no'] . "</td>";
                                    echo "<td>" . $row['latitude'] . "</td>";
                                    echo "<td>" . $row['longtitude'] . "</td>";
                                    echo "<td>" . $row['created_on'] . "</td>";
                                    echo "<td id='floating-panel'>";
                                    // echo "<input class='mb-3' id='latlng' type='text' value='$row[latitude], $row[longtitude]' />";
                                    echo "<a href='./viewmap.php?ID=$i&vehicleno=$row[vehicle_no]&latitude=$row[latitude]&longtitude=$row[longtitude]&Date=$row[created_on]'> <input id='submit' class='btn btn-primary' type='button' value='View on map' /> ";
                                    echo "</td>";

                                    echo "</tr>";
                                    $i++;
                                }
                                echo '</tbody>';
                                echo "</table>";

                                // Free result set
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
                        <div id="search_result"></div>
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


            <script>
                $(document).ready(function() {

                    // load_data();

                    function load_data(query) {
                        $.ajax({
                            url: "fetchvehiclestatus.php",
                            method: "POST",
                            data: {
                                query: query
                            },
                            success: function(data) {
                                $('#search_result').html(data);
                            }
                        });
                    }
                    $('#search_text').keyup(function() {
                        var search = $(this).val();
                        if (search != '') {
                            load_data(search);
                            $('#vehiclelist').hide();
                        } else {
                            //   load_data();

                        }
                    });
                });
            </script>

</body>

</html>
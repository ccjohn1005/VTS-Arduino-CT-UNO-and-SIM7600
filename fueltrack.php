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
                            <h1 class="h2 mb-0 text-gray-800">Fuel Tracking</h1>


                            <div id="upload" class="mt-1 d-flex justify-content-end">
                                <form class="form-inline  ">
                                    <input class="form-control " name="search_text" id="search_text" type="search" placeholder="Search vehicle" aria-label="Searching">
                                </form>
                                <button class="btn btn-success ml-5" data-toggle="modal" data-target="#uploadmodal" type="submit">NEW</button>
                            </div>
                        </div>


                        <!-- Modal INSERT-->
                        <div class="modal fade" id="uploadmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Add Fuel Record</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="uploadForm" action="./fueltrackinsert.php" method="POST">
                                            <div class="form-group" hidden>
                                                <label for="inputid">ID</label>
                                                <input type="text" class="form-control" id="fid" name="fid" hidden>
                                            </div>

                                            <?php
                                            require_once "./config/config.php";
                                            $query = "SELECT vehicle_no FROM vehicleinfo";
                                            if ($result = mysqli_query($link, $query)) {
                                                if (mysqli_num_rows($result) > 0) {
                                                    echo "<div class='form-group'>";
                                                    echo "<label for='vehicleno'>Vehicle Plate No.</label>";
                                                    echo "<select id='vehicleno' name='vehicleno' class='form-control'>";

                                                    echo "<option selected>Choose a Vehicle Plate No.:</option>";
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        echo "<option value='$row[vehicle_no]'>" . $row['vehicle_no'] . "</option>";
                                                    }
                                                    echo "</select>";
                                                    echo "</div>";

                                                    mysqli_free_result($result);
                                                } else {
                                                    echo "No records matching your query were found.";
                                                }
                                            } else {

                                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                                            }
                                            ?>

                                            <label for="trip_Odometer">Trip Odometer</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="trip_Odometer" name="trip_Odometer" placeholder="Enter trip Odometer">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">Kilometers</span>
                                                </div>
                                            </div>

                                            <label for="fuelLitre">Total Refueling Litre</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="fuelLitre" name="fuelLitre" placeholder="Enter Total Litre">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">Litres</span>
                                                </div>
                                            </div>

                                            <label for="fuelPrice">Fuel Price</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">RM</span>
                                                </div>
                                                <input type="text" class="form-control" id="fuelPrice" name="fuelPrice" placeholder="Enter Fuel Price">
                                            </div>

                                            <div class="form-group">
                                                <label for="inputtype">Date</label>
                                                <input type="date" date-format="dd-mm-yyyy" class="form-control" id="filled_on" name="filled_on" placeholder="Enter Date">
                                            </div>

                                    </div>

                                    <div class="modal-footer ">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" id="submitTitle" class="btn btn-primary" value="submit" data-dismiss="#accordion">Add</button>

                                    </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal UPDATE -->
                        <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Update Fuel Track Record</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="uploadForm" action="./fueltrackupdate.php" method="POST">
                                        <div class="modal-body">
                                            <div class="form-group" hidden>
                                                <label for="inputid">ID</label>
                                                <input type="text" class="form-control" id="fid1" name="fid1" hidden>
                                            </div>
                                            <!-- <div class="form-group">
                                                <label for="inputid">Vehicle No.</label>
                                                <input type="text" class="form-control" id="vehicleno1"
                                                    name="vehicleno1" placeholder="Enter Vehicle No.">
                                            </div> -->

                                            <?php
                                            require_once "./config/config.php";
                                            $query = "SELECT vehicle_no FROM vehicleinfo";
                                            if ($result = mysqli_query($link, $query)) {
                                                if (mysqli_num_rows($result) > 0) {
                                                    echo "<div class='form-group'>";
                                                    echo "<label for='vehicleno'>Vehicle Plate No.</label>";
                                                    echo "<select id='vehicleno1' name='vehicleno1' class='form-control'>";

                                                    echo "<option selected>Choose a Vehicle Plate No.:</option>";
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        echo "<option value='$row[vehicle_no]'>" . $row['vehicle_no'] . "</option>";
                                                    }
                                                    echo "</select>";
                                                    echo "</div>";

                                                    mysqli_free_result($result);
                                                } else {
                                                    echo "No records matching your query were found.";
                                                }
                                            } else {

                                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                                            }
                                            ?>
                                            <label for="trip_Odometer1">Trip Odometer</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="trip_Odometer1" name="trip_Odometer1" placeholder="Enter trip Odometer">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">Kilometers</span>
                                                </div>
                                            </div>

                                            <label for="fuelLitre1">Total Refueling Litre</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="fuelLitre1" name="fuelLitre1" placeholder="Enter Total Litre">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">Litres</span>
                                                </div>
                                            </div>

                                            <label for="fuelPrice1">Fuel Price</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">RM</span>
                                                </div>
                                                <input type="text" class="form-control" id="fuelPrice1" name="fuelPrice1" placeholder="Enter Fuel Price">
                                            </div>

                                            <div class="form-group">
                                                <label for="inputtype">Date</label>
                                                <input type="date" date-format="dd-mm-yyyy" class="form-control" id="filled_on1" name="filled_on1" placeholder="Enter Date">
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" id="updatedata1" name="updatedata1" class="btn btn-primary" data-dismiss="#accordion">Save Changes</button>

                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>


                        <!-- Modal DELETE -->
                        <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Delete Fuel Record</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="uploadForm" action="./fueltrackdelete.php" method="POST">
                                        <div class="modal-body">
                                            <input type="hidden" name="delete_id" id="delete_id">
                                            <label for="inputvehicle">Do you want to DELETE this record?
                                        </div>

                                        <div class="modal-footer ">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" id="deletedata" name="deletedata" class="btn btn-primary" data-dismiss="#accordion">Delete</button>

                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>



                        <?php
                        require_once "./config/config.php";

                        // Attempt select query execution
                        $sql = "SELECT FID, vehicle_no, trip_Odometer, fuelLitre, fuelPrice, ROUND(fuelLitre * fuelPrice, 2) AS fuelCost, ROUND(trip_Odometer / fuelLitre, 2) AS `fuel_Consumption`, filled_on FROM fueltracker ";
                        if ($result = mysqli_query($link, $sql)) {

                            if (mysqli_num_rows($result) > 0) {
                                echo '<table id="vehiclefueltrack" class="table table-bordered "><thead>';
                                // echo "<table>";
                                echo "<tr>";
                                echo "<th>Fuel ID</th>";
                                echo "<th>Vehicle Plate No.</th>";
                                echo "<th>Trip Odometer</th>";
                                echo "<th>Total Refueling Litres</th>";
                                echo "<th>Fuel Price (Per Litre)</th>";
                                echo "<th>Total Fuel Cost</th>";
                                echo "<th>Fuel Consumption</th>";
                                echo "<th>Refueling Date</th>";
                                echo "<th>Action</th>";
                                echo "</tr>";
                                echo '</thead>';
                                $i = 1;
                                while ($row = mysqli_fetch_array($result)) {
                                    echo '<tbody>';
                                    echo "<tr>";
                                    echo "<td hidden>" . $row['FID'] . "</td>";
                                    echo "<td>" . $i . "</td>";
                                    echo "<td>" . $row['vehicle_no'] . "</td>";
                                    echo "<td>" . $row['trip_Odometer'] . ' KM' . " </td>";
                                    echo "<td>" . $row['fuelLitre'] . ' Litres' . "</td>";
                                    echo "<td>" . 'RM ' . $row['fuelPrice'] . "</td>";
                                    echo "<td>" . 'RM ' . $row['fuelCost'] . "</td>";
                                    echo "<td>" . $row['fuel_Consumption'] . ' KM/Litre' . "</td>";
                                    echo "<td>" . $row['filled_on'] . "</td>";

                                    echo "<td>";
                                    echo '<button type="button" class="btn btn-info editbtn mr-4">EDIT</button>';
                                    echo '<button type="button" class="btn btn-danger deletebtn ">DELETE</button>';
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

            <script>
                $(document).ready(function() {
                    $('.editbtn').on('click', function() {
                        $('#editmodal').modal('show');

                        $tr = $(this).closest('tr');

                        var data = $tr.children("td").map(function() {
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


            <script>
                $(document).ready(function() {



                    function load_data(query) {
                        $.ajax({
                            url: "fetchfueltrack.php",
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
                            $('#vehiclefueltrack').hide();
                        } else {
                            //   load_data();

                        }
                    });
                });
            </script>

</body>

</html>
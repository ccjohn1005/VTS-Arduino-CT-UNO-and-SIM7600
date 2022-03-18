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
                            <h1 class="h2 mb-0 text-gray-800">Vehicle Service Records</h1>


                            <div id="upload" class="mt-1 d-flex justify-content-end">
                                <form class="form-inline ">
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
                                        <h5 class="modal-title" id="exampleModalLongTitle">Add Service Record</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <form id="uploadForm" action="./servicerecordinsert.php" method="POST">

                                            <div class="form-group" hidden>
                                                <label for="inputid">Service ID</label>
                                                <input type="text" class="form-control" id="sid" name="sid" placeholder="Enter Service ID" hidden>
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

                                            <!-- <div class="form-group">
                                                <label for="inputsim">Interval Mileage</label>
                                                <input type="text" class="form-control" id="intervalMileage"
                                                    name="intervalMileage" placeholder="Enter Mileage">
                                            </div> -->

                                            <label for="intervalMileage">Interval Mileage</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="intervalMileage" name="intervalMileage" placeholder="Enter Mileage">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">Kilometers</span>
                                                </div>
                                            </div>


                                            <label for="from_Odometer">From Odometer</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="from_Odometer" name="from_Odometer" placeholder="Enter From Odometer">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">Kilometers</span>
                                                </div>
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
                                        <h5 class="modal-title" id="exampleModalLongTitle">Update Service Record</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <form id="uploadForm" action="./servicerecordupdate.php" method="POST">

                                        <div class="modal-body">
                                            <input type="text" id="service_id" name="service_id" hidden>
                                            <?php
                                            require_once "./config/config.php";
                                            $query = "SELECT vehicle_no FROM vehicleinfo";
                                            if ($result = mysqli_query($link, $query)) {
                                                if (mysqli_num_rows($result) > 0) {
                                                    echo "<div class='form-group'>";
                                                    echo "<label for='vehicleno1'>Vehicle Plate</label>";
                                                    echo "<select id='vehicleno12' name='vehicleno12' class='form-control'>";

                                                    echo "<option selected>Choose a Vehicle Plate No.:</option>";
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        echo "<option value='$row[vehicle_no]'>" . $row['vehicle_no'] . "</option>";
                                                        // echo "<option value="'disease'"  ><?php echo($row['Disease']);</option>
                                                        // 
                                                    }


                                                    // <option value="CAR">CAR</option>
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

                                            <label for="intervalMileage12">Interval Mileage</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="intervalMileage12" name="intervalMileage12" placeholder="Enter Interval Mileage">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">Kilometers</span>
                                                </div>
                                            </div>

                                            <label for="from_Odometer">From Odometer</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="from_Odometer12" name="from_Odometer12" placeholder="Enter From Odometer">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">Kilometers</span>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="modal-footer ">
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
                                        <h5 class="modal-title" id="exampleModalLongTitle">Delete Record</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="uploadForm" action="./servicerecorddelete.php" method="POST">
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
                        // $sql = "SELECT serviceID, vehicle_no, intervalMileage, from_Odometer, to_Odometer, created_on FROM servicerecord ";
                        $sql = "SELECT serviceID, vehicle_no, intervalMileage, from_Odometer, (intervalMileage + from_Odometer) AS `to_Odometer`, created_on, DATE_ADD(created_on, interval 6 month) as service_date from servicerecord";
                        if ($result = mysqli_query($link, $sql)) {

                            if (mysqli_num_rows($result) > 0) {
                                echo '<table id="vehicleservicerecord" class="table table-bordered "><thead>';
                                // echo "<table>";
                                echo "<tr>";
                                echo "<th>Service ID</th>";
                                echo "<th>Vehicle Plate No.</th>";
                                echo "<th>Interval Mileage</th>";
                                echo "<th>From Odometer</th>";
                                echo "<th>To Odometer</th>";
                                echo "<th>Date of Service</th>";
                                echo "<th>Date of Next Service</th>";
                                echo "<th>Action</th>";
                                echo "</tr>";
                                echo '</thead>';
                                $i = 1;
                                function customize_today_date($format)
                                {
                                    $dt = new DateTime($format);
                                    return $dt->format('Y-m-d');
                                }
                                while ($row = mysqli_fetch_array($result)) {
                                    echo '<tbody>';
                                    echo "<tr>";
                                    $ser_date = customize_today_date($row["service_date"]);
                                    $created_date = customize_today_date($row["created_on"]);
                                    echo "<td hidden>" . $row['serviceID'] . "</td>";
                                    echo "<td>" . $i . "</td>";
                                    echo "<td>" . $row['vehicle_no'] . "</td>";
                                    echo "<td>" . $row['intervalMileage'] . ' KM' . "</td>";
                                    echo "<td>" . $row['from_Odometer'] . ' KM' . "</td>";
                                    echo "<td>" . $row['to_Odometer'] . ' KM' . "</td>";
                                    echo "<td>" . $created_date . "</td>";
                                    echo "<td>" . $ser_date . "</td>"; // Every 6 months service one time 

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

                        $('#service_id').val(data[0]);
                        $('#vehicleno12').val(data[2]);
                        $('#intervalMileage12').val(data[3].slice(0, -3));
                        $('#from_Odometer12').val(data[4].slice(0, -3));
                    });
                })
            </script>


            <script>
                $(document).ready(function() {
                    function load_data(query) {
                        $.ajax({
                            url: "fetchservicerecord.php",
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
                            $('#vehicleservicerecord').hide();
                        } else {
                           

                        }
                    });
                });
            </script>

</body>

</html>
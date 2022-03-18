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
                            <h1 class="h2 mb-0 text-gray-800">Vehicle Info List</h1>



                            <div id="upload" class="mt-1 d-flex justify-content-end">
                                <form class="form-inline  ">
                                    <input class="form-control " name="search_text" id="search_text" type="search" placeholder="Search vehicle, email, simNo." aria-label="Searching">
                                </form>
                                <button class="btn btn-success ml-5" data-toggle="modal" data-target="#uploadmodal" type="submit">NEW</button>

                            </div>

                        </div>

                        <!-- Modal INSERT-->
                        <div class="modal fade" id="uploadmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Add Vehicle Info</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <form id="uploadForm" action="./vehicleinfoinsert.php" method="POST">
                                            <div class="form-group">
                                                <label for="inputid">Vehicle Plate No.</label>
                                                <input type="text" class="form-control" id="vehicleno" name="vehicleno" placeholder="Enter Vehicle Plate No.">
                                            </div>

                                            <div class="form-group">
                                                <label for="inputsim">Vehicle SIM No.</label>
                                                <input type="text" class="form-control" id="vehiclesim" name="vehiclesim" placeholder="Enter Vehicle Sim No.">
                                            </div>

                                            <div class="form-group">
                                                <label for="vehicletype1">Type of Vehicle</label>
                                                <select id="vehicletype" name="vehicletype" class="form-control">
                                                    <option selected>Choose a Vehicle Type:</option>
                                                    <option value="CAR">CAR</option>
                                                    <option value="TRUCK">TRUCK</option>
                                                    <option value="VAN">VAN</option>
                                                    <option value="BUS">BUS</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputsim">Driver's Email Address</label>
                                                <input type="text" class="form-control" id="drvemail" name="drvemail" placeholder="Enter Email Address">
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
                                        <h5 class="modal-title" id="exampleModalLongTitle">Update Vehicle Info</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="uploadForm" action="./vehicleinfoupdate.php" method="POST">
                                        <div class="modal-body">
                                            <input type="text" id="vehicle_id" name="vehicle_id" hidden>
                                            <div class="form-group">
                                                <label for="inputid">Vehicle Plate No.</label>
                                                <input type="text" class="form-control" id="vehicleno1" name="vehicleno1" placeholder="Enter Vehicle Plate No.">
                                            </div>

                                            <div class="form-group">
                                                <label for="inputsim">Vehicle SIM No.</label>
                                                <input type="text" class="form-control" id="vehiclesim1" name="vehiclesim1" placeholder="Enter Vehicle Sim No.">
                                            </div>

                                            <div class="form-group">
                                                <label for="vehicletype1">Type of Vehicle</label>
                                                <select id="vehicletype1" name="vehicletype1" class="form-control">
                                                    <option selected>Choose a Vehicle Type:</option>
                                                    <option value="CAR">CAR</option>
                                                    <option value="TRUCK">TRUCK</option>
                                                    <option value="VAN">VAN</option>
                                                    <option value="BUS">BUS</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputemail">Driver's Email Address</label>
                                                <input type="text" class="form-control" id="drvemail1" name="drvemail1" placeholder="Enter Email Address">
                                            </div>
                                        </div>

                                        <div class="modal-footer ">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" id="updatedata" name="updatedata" class="btn btn-primary" data-dismiss="#accordion">Save Changes</button>

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
                                        <h5 class="modal-title" id="exampleModalLongTitle">Delete Vehicle Info</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form id="uploadForm" action="./vehicleinfodelete.php" method="POST">
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
                        $sql = "SELECT * FROM vehicleinfo ";
                        if ($result = mysqli_query($link, $sql)) {

                            if (mysqli_num_rows($result) > 0) {
                                echo '<table id="vehicleinfolist" class="table table-bordered "><thead>';
                                echo "<tr>";
                                echo "<th hidden>ID</th>";
                                echo "<th>ID</th>";
                                echo "<th>Vehicle Plate No.</th>";
                                echo "<th>Vehicle Sim No.</th>";
                                echo "<th>Type of Vehicle</th>";
                                echo "<th>Driver's Email Address</th>";
                                echo "<th>Date/Time</th>";
                                echo "<th>Action</th>";
                                echo "</tr>";
                                echo '</thead>';
                                $i = 1;
                                while ($row = mysqli_fetch_array($result)) {
                                    echo '<tbody>';
                                    echo "<tr>";
                                    echo "<td hidden>" . $row['id'] . "</td>";
                                    echo "<td>" . $i . "</td>";
                                    echo "<td>" . $row['vehicle_no'] . "</td>";
                                    echo "<td>" . $row['vehicle_simNo'] . "</td>";
                                    echo "<td>" . $row['vehicle_type'] . "</td>";
                                    echo "<td>" . $row['vehicle_email'] . "</td>";
                                    echo "<td>" . $row['inserted_on'] . "</td>";
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
            // include 'controller/vehicleinfo/update.php'
            ?>
            <!-- End of Footer -->


            <!-- Bootstrap core JavaScript-->
            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin-2.min.js"></script>

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



                    function load_data(query) {
                        $.ajax({
                            url: "fetchvehicleinfo.php",
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
                            $('#vehicleinfolist').hide();
                        } else {
                            //   load_data();

                        }
                    });
                });
            </script>

</body>

</html>
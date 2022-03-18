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
                            <h1 class="h2 mb-0 text-gray-800">User Management</h1>

                            <!-- Modal UPDATE -->
                            <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Update Users Information</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="uploadForm" action="./manageuserupdate.php" method="POST">
                                            <div class="modal-body">
                                                <input type="text" id="id" name="id" hidden>
                                                <div class="form-group">
                                                    <label for="inputid">Name: </label>
                                                    <input type="text" class="form-control" id="name1" name="name1" placeholder="Enter Name">
                                                </div>
                                                <?php require_once "./config/config.php";
                                                // Check connection
                                                if ($link === false) {
                                                    die("ERROR: Could not connect. " . mysqli_connect_error());
                                                }

                                                // Attempt select query execution
                                                $sql = "SELECT  admin FROM users_vts WHERE username = '$_SESSION[username]'";
                                                if ($result = mysqli_query($link, $sql)) {
                                                    if (mysqli_num_rows($result) > 0) {
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            if ($row['admin'] == 1) {
                                                                echo "<div class='form-group'>";
                                                                echo "  <label for='inputadmin'>Admin: </label>";
                                                                echo "<br>";
                                                                echo "<input type='checkbox' name='admin1' value='1'> Administrator<br />";
                                                                echo "<input type='checkbox' name='admin1' value='0'> Power-User<br />     ";
                                                                echo "<br>";
                                                                echo "<sup>**Checked is Administrator</sup><br>";
                                                                echo "<sup>**Unchecked is Power-User</sup>    ";
                                                                echo "</div>";
                                                            }
                                                        }
                                                        mysqli_free_result($result);
                                                    }
                                                } else {
                                                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                                                }

                                                ?>
                                            </div>

                                            <div class="modal-footer ">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" id="updatedata1" name="updatedata1" class="btn btn-primary" data-dismiss="#accordion">Save Changes</button>

                                            </div>

                                        </form>
                                    </div>
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
                                    <form id="uploadForm" action="./manageuserdelete.php" method="POST">
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

                        // Check connection
                        if ($link === false) {
                            die("ERROR: Could not connect. " . mysqli_connect_error());
                        }

                        // Attempt select query execution
                        $sql = "SELECT id, UPPER(username), UPPER(name), admin, created_at, admin FROM users_vts";
                        if ($result = mysqli_query($link, $sql)) {

                            if (mysqli_num_rows($result) > 0) {
                                echo '<table class="table table-bordered "><thead>';
                                // echo "<table>";
                                echo "<tr>";
                                echo "<th>ID</th>";
                                echo "<th>Username</th>";
                                echo "<th>Name</th>";
                                echo "<th>Date of Created</th>";
                                echo "<th>Is Admin</th>";
                                echo "<th>Action</th>";
                                echo "</tr>";
                                echo '</thead>';
                                $i = 1;
                                while ($row = mysqli_fetch_array($result)) {
                                    echo '<tbody>';
                                    echo "<tr>";
                                    echo "<td hidden>" . $row['id'] . "</td>";
                                    echo "<td>" . $i . "</td>";
                                    echo "<td>" . $row['UPPER(username)'] . "</td>";
                                    echo "<td>" . $row['UPPER(name)'] . "</td>";
                                    echo "<td>" . $row['created_at'] . "</td>";
                                    if ($row['admin'] == 1) {
                                        echo "<td>" . 'TRUE' . "</td>";
                                    } else {
                                        echo "<td>" . 'FALSE' . "</td>";
                                    }
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

                        $('#id').val(data[0]);
                        $('#name1').val(data[2]);
                        $('#admin1').val(data[4]);
                    });
                })
            </script>

</body>

</html>
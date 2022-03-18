<?php
require_once "./config/config.php";

// Define variables and initialize with empty values
$vehicleno = "";
$trip_Odometer = "";
$fuelPrice = "";
$fuelLitre = "";
$filled_on = "";
$vehicleno_err = "";
$trip_Odometer_err = "";
$fuelPrice_err = "";
$fuelLitre_err = "";
$filled_on_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate vehicleno
    if (empty(trim($_POST["vehicleno"]))) {
        $vehicleno_err = "Please enter a Vehicle No.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["vehicleno"]))) {
        $vehicleno_err = "Vehicle No. can only contain letters, numbers, and underscores.";
    } else {
        // Prepare a select statement
        $sql = "SELECT vehicle_no FROM vehicleinfo WHERE vehicle_no = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_vehicleno);

            // Set parameters
            $param_vehicleno = trim($_POST["vehicleno"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 0) {
                    echo $vehicleno_err = "This Vehicle Plate No. not found. .";
                } else {
                    $vehicleno = trim($_POST["vehicleno"]);
                }
            } else {
                echo "0. Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }


    if (empty(trim($_POST["trip_Odometer"]))) {
        $trip_Odometer_err = "Please enter";
    } else {
        // Prepare a select statement
        $sql = "SELECT fid FROM fuelTracker WHERE trip_Odometer = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_trip_Odometer);

            // Set parameters
            $param_trip_Odometer = trim($_POST["trip_Odometer"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                $trip_Odometer = trim($_POST["trip_Odometer"]);
            } else {
                echo "0. Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    if (empty(trim($_POST["fuelPrice"]))) {
        $fuelPrice_err = "Please enter ";
    } else {
        // Prepare a select statement
        $sql = "SELECT fid FROM fueltracker WHERE fuelPrice = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_fuelPrice);

            // Set parameters
            $param_fuelPrice = trim($_POST["fuelPrice"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);
                $fuelPrice = trim($_POST["fuelPrice"]);
            } else {
                echo "0. Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }


    if (empty(trim($_POST["fuelLitre"]))) {
        $fuelLitre_err = "Please enter ";
    } else {
        // Prepare a select statement
        $sql = "SELECT fid FROM fueltracker WHERE fuelLitre = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_fuelLitre);

            // Set parameters
            $param_fuelLitre = trim($_POST["fuelLitre"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);
                $fuelLitre = trim($_POST["fuelLitre"]);
            } else {
                echo "0. Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    if (empty(trim($_POST["filled_on"]))) {
        $filled_on_err = "Please enter ";
    } else {
        // Prepare a select statement
        $sql = "SELECT fid FROM fueltracker WHERE filled_on = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_filled_on);

            // Set parameters
            $param_filled_on = trim($_POST["filled_on"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);
                $filled_on = trim($_POST["filled_on"]);
            } else {
                echo "0. Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }


    // Check input errors before inserting in database
    if (empty($vehicleno_err) && empty($trip_Odometer_err) && empty($fuelPrice_err) && empty($fuelLitre_err) && empty($filled_on_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO fuelTracker (vehicle_no, trip_Odometer, fuelPrice, fuelLitre, filled_on  ) VALUES (?, ?,?,?,?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_vehicleno, $param_trip_Odometer, $param_fuelPrice, $param_fuelLitre, $param_filled_on);

            // Set parameters
            $param_vehicleno = $vehicleno;
            $param_trip_Odometer = $trip_Odometer;
            $param_fuelPrice = $fuelPrice;
            $param_fuelLitre = $fuelLitre;
            $param_filled_on = $filled_on;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: fueltrack.php");
                echo "OK";
            } else {
                echo "3. Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}

<?php
    require_once "./config/config.php";

    // Define variables and initialize with empty values
$vehicleno = ""; $vehiclesim = ""; $vehicletype = ""; $vehicleemail = "";
$vehicleno_err = ""; $vehiclesim_err = ""; $vehicletype_err = ""  ; $vehicleemail_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["vehicleno"]))){
        $vehicleno_err = "Please enter a Vehicle No.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["vehicleno"]))){
        $vehicleno_err = "Vehicle No. can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM vehicleinfo WHERE vehicle_no = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_vehicleno);
            
            // Set parameters
            $param_vehicleno = trim($_POST["vehicleno"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $vehicleno_err = "This Vehicle No. is already taken.";
                } else{
                    $vehicleno = trim($_POST["vehicleno"]);
                }
            } else{
                echo "0. Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    if(empty(trim($_POST["vehiclesim"]))){
        $vehicleno_err = "Please enter a Vehicle SIM No.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM vehicleinfo WHERE vehicle_simNo = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_vehiclesim);
            
            // Set parameters
            $param_vehiclesim = trim($_POST["vehiclesim"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $vehiclesim_err = "This Vehicle SIM No. is already taken.";
                } else{
                    $vehiclesim = trim($_POST["vehiclesim"]);
                }
            } else{
                echo "0. Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    if(empty(trim($_POST["vehicletype"]))){
        $vehicleno_err = "Please enter a Vehicle Type";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM vehicleinfo WHERE vehicle_type = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_vehicletype);
            
            // Set parameters
            $param_vehicletype = trim($_POST["vehicletype"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                $vehicletype = trim($_POST["vehicletype"]);
                
            } else{
                echo "0. Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    if(empty(trim($_POST["drvemail"]))){
        $vehicleemail_err = "Please enter a Driver's Email Address";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM vehicleinfo WHERE vehicle_email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_vehicleemail);
            
            // Set parameters
            $param_vehicleemail = trim($_POST["drvemail"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                $vehicleemail = trim($_POST["drvemail"]);
                
            } else{
                echo "0. Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Check input errors before inserting in database
    if(empty($vehicleno_err) && empty($vehiclesim_err) && empty($vehicletype_err) && empty($vehicleemail_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO vehicleinfo (vehicle_no, vehicle_simno, vehicle_type, vehicle_email ) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ssss", $param_vehicleno, $param_vehiclesim, $param_vehicletype, $param_vehicleemail);
            
            // Set parameters
            $param_vehicleno = $vehicleno;
            $param_vehiclesim = $vehiclesim;
            $param_vehicletype = $vehicletype;
            $param_vehicleemail = $vehicleemail; 
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: vehicleinfo.php");
                echo "OK";
            } else{
                echo "3. Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}

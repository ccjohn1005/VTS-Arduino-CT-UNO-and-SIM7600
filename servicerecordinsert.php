<?php
    require_once "./config/config.php";

    // Define variables and initialize with empty values
$vehicleno = ""; $intervalMileage = ""; $from_Odometer = ""; 
$vehicleno_err = ""; $intervalMileage_err = ""; $from_Odometer_err = ""  ; ;

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate vehicleno
    if(empty(trim($_POST["vehicleno"]))){
        $vehicleno_err = "Please enter a Vehicle No.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["vehicleno"]))){
        $vehicleno_err = "Vehicle No. can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT vehicle_no FROM vehicleinfo WHERE vehicle_no = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_vehicleno);
            
            // Set parameters
            $param_vehicleno = trim($_POST["vehicleno"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 0){
                    echo $vehicleno_err = "This Vehicle Plate No. not found. .";
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


    if(empty(trim($_POST["intervalMileage"]))){
        $intervalMileage_err = "Please enter";
    } else{
        // Prepare a select statement
        $sql = "SELECT vehicle_no FROM servicerecord WHERE intervalMileage = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_intervalMileage);
            
            // Set parameters
            $param_intervalMileage = trim($_POST["intervalMileage"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                $intervalMileage = trim($_POST["intervalMileage"]);
                
            } else{
                echo "0. Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    if(empty(trim($_POST["from_Odometer"]))){
        $vehicleno_err = "Please enter ";
    } else{
        // Prepare a select statement
        $sql = "SELECT vehicle_no FROM servicerecord WHERE from_Odometer = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_from_Odometer);
            
            // Set parameters
            $param_from_Odometer = trim($_POST["from_Odometer"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                    $from_Odometer = trim($_POST["from_Odometer"]);
                
            } else{
                echo "0. Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }



    // Check input errors before inserting in database
    if(empty($vehicleno_err) && empty($intervalMileage_err) && empty($from_Odometer_err)  ){
        
        // Prepare an insert statement
        $sql = "INSERT INTO servicerecord (vehicle_no, intervalMileage, from_Odometer ) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sss", $param_vehicleno , $param_intervalMileage, $param_from_Odometer);
            
            // Set parameters
            $param_vehicleno = $vehicleno;
            $param_intervalMileage = $intervalMileage;
            $param_from_Odometer = $from_Odometer;  
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: servicerecord.php");
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

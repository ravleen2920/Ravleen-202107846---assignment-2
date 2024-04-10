<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$festivals_name = $date = $location = "";
$festivals_name_err = $date_err = $location_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate product_name
    $input_festivals_name = trim($_POST["festivals_name"]);
    if (empty($input_festivals_name)) {
        $festivaks_name_err = "Please enter a pfestival name.";
    } else {
        $festivals_name = $input_festivals_name;
    }

    // Validate quantity
    $input_date = trim($_POST["date"]);
    if (empty($input_date)) {
        $date_err = "Please enter the date.";
    //} elseif (!ctype_digit($input_date)) {
      //  $date_err = "Please enter a positive integer value for date.";
    } else {
        $date = $input_date;
    }

    // Validate location
    $input_location = trim($_POST["location"]);
    if (empty($input_location)) {
        $location_err = "Please enter the location.";
    } else {
        $location = $input_location;
    }

    // Check input errors before inserting in database
    if (empty($festivals_name_err) && empty($date_err) && empty($location_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO festivals_name (festivals_name, date, location) VALUES (?, ?, ?)";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(1, $param_festivals_name);
            $stmt->bindParam(2, $param_date);
            $stmt->bindParam(3, $param_location);

            // Set parameters
            $param_festivals_name = $festivals_name;
            $param_date = $date;
            $param_location = $location;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        unset($stmt);
    }

    // Close connection
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create festivals Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create festivals Record</h2>
                    <p>Please fill this form and submit to add an inventory record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>festivals Name</label>
                            <input type="text" name="festivals_name" class="form-control <?php echo (!empty($festivals_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $festivals_name; ?>">
                            <span class="invalid-feedback"><?php echo $festivals_name_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>date</label>
                            <input type="text" name="date" class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date; ?>">
                            <span class="invalid-feedback"><?php echo $date_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Location</label>
                            <input type="text" name="location" class="form-control <?php echo (!empty($location_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $location; ?>">
                            <span class="invalid-feedback"><?php echo $location_err; ?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$festivals_name = $date = $location = "";
$festivals_name_err = $date_err = $location_err = "";

// Processing form data when form is submitted
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // Get hidden input value
    $id = $_POST["id"];

    // Validate product_name
    $input_festivals_name = trim($_POST["festivals_name"]);
    if (empty($input_festivals_name)) {
        $festivals_name_err = "Please enter a product name.";
    } else {
        $festivalst_name = $input_festivals_name;
    }

    // Validate quantity
    $input_date = trim($_POST["date"]);
    if (empty($input_quantity)) {
        $date_err = "Please enter the date.";
    } elseif (!ctype_digit($input_date)) {
        $date_err = "Please enter a positive integer value.";
    } else {
        $date = $input_date;
    }

    // Validate location
    $input_location = trim($_POST["location"]);
    if (empty($input_location)) {
        $location_err = "Please enter a location.";
    } else {
        $location = $input_location;
    }

    // Check input errors before inserting in database
    if (empty($festivals_name_err) && empty($date_err) && empty($location_err)) {
        // Prepare an update statement
        $sql = "UPDATE inventory SET festivals_name=?, date=?, location=? WHERE id=?";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(1, $festivals_name);
            $stmt->bindParam(2, $date);
            $stmt->bindParam(3, $location);
            $stmt->bindParam(4, $id);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        unset($stmt);
    }
} else {
    // Check existence of id parameter before processing further
    if (!isset($_GET["id"]) || empty(trim($_GET["id"]))) {
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
    
    // Prepare a select statement
    $sql = "SELECT * FROM inventory WHERE id = ?";
    if ($stmt = $pdo->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(1, $param_id);

        // Set parameters
        $param_id = trim($_GET["id"]);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // Retrieve individual field value
                $festivals_name = $row["festivals_name"];
                $date = $row["date"];
                $location = $row["location"];
            } else {
                // URL doesn't contain valid id. Redirect to error page
                header("location: error.php");
                exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    unset($stmt);
}

// Close connection
unset($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Festivals Record</title>
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
                    <h2 class="mt-5">Update Festivals Record</h2>
                    <p>Please edit the input values and submit to update the inventory record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Festivals Name</label>
                            <input type="text" name="product_name" class="form-control <?php echo (!empty($festivals_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $product_name; ?>">
                            <span class="invalid-feedback"><?php echo $product_name_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Date</label>
                            <input type="text" name="date" class="form-control <?php echo (!empty($quantity_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date; ?>">
                            <span class="invalid-feedback"><?php echo $quantity_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Location</label>
                            <input type="text" name="location" class="form-control <?php echo (!empty($location_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $location; ?>">
                            <span class="invalid-feedback"><?php echo $location_err; ?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


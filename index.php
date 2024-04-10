<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Festivals Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- External stylesheet -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        /* Move the inline styles to an external stylesheet (styles.css) */
    </style>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>
    
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">Festivals Details</h1>
                    <a href="create.php" class="btn btn-success mb-3"><i class="fa fa-plus"></i> Add New Item</a>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Festivals Name</th>
                                <th>Date</th>
                                <th>location</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
    // Include config file
    require_once "config.php";

    // Attempt select query execution
    $sql = "SELECT * FROM festivals_name";
    if ($stmt = $pdo->prepare($sql)) {
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch()) {
                    echo "<tr>";
                    // Output the 'id' field if it exists
                    if (isset($row['id'])) {
                        echo "<td>" . $row['id'] . "</td>";
                    } else {
                        echo "<td>Error: ID not found</td>";
                    }
                    // Output other table data
                    // Modify this part to include other fields as needed
                    echo "<td>" . $row['festivals_name'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td>" . $row['location'] . "</td>";
                    // Add action buttons here if needed
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No items found</td></tr>";
            }
        }
    }
?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
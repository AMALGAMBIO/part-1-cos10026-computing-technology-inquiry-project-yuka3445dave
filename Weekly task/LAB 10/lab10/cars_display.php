<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="COS10026 Lab 10">
    <meta name="author" content="LE TIEN DUNG">
    <title>Retrieving records from MySQL</title>
</head>
<body>
    <h1>Car Listings</h1>

    <?php
    require_once "settings.php"; // Include database settings

    // Establish database connection
    $conn = mysqli_connect($host, $user, $pwd, $sql_db);
    if (!$conn) {
        die("<p>Database connection failure: " . mysqli_connect_error() . "</p>");
    }

    // Query to select car records
    $sql_table = "cars";
    $query = "SELECT make, model, price, yom FROM $sql_table ORDER BY make, model";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "<p>Error executing query: " . mysqli_error($conn) . "</p>";
    } else {
        // Check if the table has records
        if (mysqli_num_rows($result) > 0) {
            echo "<table border='1'>";
            echo "<tr>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Price ($)</th>
                  </tr>";

            while ($record = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($record["make"]) . "</td>";
                echo "<td>" . htmlspecialchars($record["model"]) . "</td>";
                echo "<td>" . htmlspecialchars($record["yom"]) . "</td>";
                echo "<td>$" . number_format($record["price"], 2) . "</td>";
                echo "</tr>";
            }
            echo "</table>";

            mysqli_free_result($result);
        } else {
            echo "<p>No cars available.</p>";
        }
    }

    // Close database connection
    mysqli_close($conn);
    ?>
</body>
</html>

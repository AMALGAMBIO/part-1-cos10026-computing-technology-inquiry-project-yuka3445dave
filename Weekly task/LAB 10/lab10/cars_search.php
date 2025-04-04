<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="COS10026 Lab 10">
    <meta name="author" content="LE TIEN DUNG">
    <title>Search Results</title>
</head>
<body>
    <h1>Search Results</h1>
    
    <?php
    require_once "settings.php"; // Include database settings

    // Establish database connection
    $conn = mysqli_connect($host, $user, $pwd, $sql_db);
    if (!$conn) {
        die("<p>Database connection failure: " . mysqli_connect_error() . "</p>");
    }

    // Function to sanitize user input
    function sanitise_input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $make = sanitise_input($_POST["carmake"]);
        $model = sanitise_input($_POST["carmodel"]);
        $price = sanitise_input($_POST["price"]);
        $yom = sanitise_input($_POST["yom"]);

        // Prepare the SQL query with filters
        $sql_table = "cars";
        $conditions = [];
        $params = [];
        $types = "";

        if (!empty($make)) {
            $conditions[] = "make LIKE ?";
            $params[] = "%" . $make . "%";
            $types .= "s";
        }
        if (!empty($model)) {
            $conditions[] = "model LIKE ?";
            $params[] = "%" . $model . "%";
            $types .= "s";
        }
        if (!empty($price) && is_numeric($price)) {
            $conditions[] = "price <= ?";
            $params[] = $price;
            $types .= "d";
        }
        if (!empty($yom) && is_numeric($yom)) {
            $conditions[] = "yom = ?";
            $params[] = $yom;
            $types .= "i";
        }

        $query = "SELECT * FROM $sql_table";
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        // Use prepared statements for security
        $stmt = mysqli_prepare($conn, $query);
        if (!empty($params)) {
            mysqli_stmt_bind_param($stmt, $types, ...$params);
        }

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (!$result) {
            echo "<p>Query error: " . mysqli_error($conn) . "</p>";
        } elseif (mysqli_num_rows($result) > 0) {
            echo "<table border='1'>";
            echo "<tr>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Price ($)</th>
                    <th>Year</th>
                  </tr>";
            while ($record = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($record["make"]) . "</td>";
                echo "<td>" . htmlspecialchars($record["model"]) . "</td>";
                echo "<td>$" . number_format($record["price"], 2) . "</td>";
                echo "<td>" . htmlspecialchars($record["yom"]) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No matching cars found.</p>";
        }

        mysqli_stmt_close($stmt);
    } else {
        header("Location: searchcar.html"); // Redirect if accessed incorrectly
    }

    mysqli_close($conn);
    ?>
</body>
</html>

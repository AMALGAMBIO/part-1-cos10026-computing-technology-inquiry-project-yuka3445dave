<?php
require_once "settings.php"; // Ensure correct filename

// Establish database connection
$conn = mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
    die("<p>Database connection failure: " . mysqli_connect_error() . "</p>");
}

// Function to sanitize user input
function sanitise_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $make = sanitise_input($_POST["carmake"]);
    $model = sanitise_input($_POST["carmodel"]);
    $price = sanitise_input($_POST["price"]);
    $yom = sanitise_input($_POST["yom"]);

    // Validate numeric values
    if (!is_numeric($price) || !is_numeric($yom)) {
        echo "<p class='wrong'>Price and Year of Manufacture must be numbers.</p>";
    } else {
        // Use prepared statements to prevent SQL injection
        $query = "INSERT INTO cars (make, model, price, yom) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssdi", $make, $model, $price, $yom);

        if (mysqli_stmt_execute($stmt)) {
            echo "<p class='ok'>Successfully added new car record.</p>";
            header("Location: cars_display.php"); // Redirect to display page
            exit();
        } else {
            echo "<p class='notok'>Error: " . mysqli_stmt_error($stmt) . "</p>";
        }

        mysqli_stmt_close($stmt);
    }
} else {
    header("Location: addcar.html"); // Redirect if accessed directly
}

// Close connection
mysqli_close($conn);
?>

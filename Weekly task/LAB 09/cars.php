<?php 
require_once 'settings.php'; // Ensure the correct filename

// Establish database connection
$dbconn = new mysqli($host, $user, $pwd, $sql_db);

if (!$dbconn) {
    echo "<p>Database connection failure</p>";
} else {
    $query = "SELECT * FROM cars";
    $result = mysqli_query($dbconn, $query);

    if (!$result) {
        echo "<p>Something is wrong with the query: $query</p>";
    } else {
        if (mysqli_num_rows($result) > 0) { // Check if there are any records
            echo "<table border=\"1\">";
            echo "<tr>
                    <th scope=\"col\">Car ID</th>
                    <th scope=\"col\">Make</th>
                    <th scope=\"col\">Model</th>
                    <th scope=\"col\">Year</th>
                    <th scope=\"col\">Price</th>
                  </tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["car_id"] . "</td>";
                echo "<td>" . $row["make"] . "</td>";
                echo "<td>" . $row["model"] . "</td>";
                echo "<td>" . $row["yom"] . "</td>";  // Ensure this matches the table column
                echo "<td>$" . number_format($row["price"], 2) . "</td>"; // Format price with 2 decimals
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>There are no cars to display.</p>";
        }
        
        mysqli_free_result($result);
    }
    
    mysqli_close($dbconn);
}
?>

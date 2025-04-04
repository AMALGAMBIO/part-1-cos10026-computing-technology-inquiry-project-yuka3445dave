<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.html");
    exit();
}

$username = $_SESSION["user"];
$movies = $_SESSION["movies"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Welcome Page">
    <title>Welcome</title>
</head>
<body>

<?php include 'header.php'; ?>

<h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
<h3>Your Favorite Movies:</h3>
<table border="1">
    <tr>
        <th>#</th>
        <th>Movie Name</th>
    </tr>
    <?php foreach ($movies as $index => $movie): ?>
        <tr>
            <td><?php echo $index + 1; ?></td>
            <td><?php echo htmlspecialchars($movie); ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<p><a href="logout.php">Logout</a></p>

<?php include 'footer.php'; ?>

</body>
</html>

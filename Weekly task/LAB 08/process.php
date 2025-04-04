<?php
session_start();

// Users and their passwords
$users = [
    "LeTienDung" => "104977412", 
    "JohnDoe" => "12345678" 
];

$my_movies = ["Inception", "Interstellar", "The Matrix", "Avengers: Endgame", "Spirited Away"];
$friend_movies = ["Titanic", "The Dark Knight", "Forrest Gump", "The Godfather", "Gladiator"];

if (isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (array_key_exists($username, $users) && $users[$username] === $password) {
        $_SESSION["user"] = $username;

        $_SESSION["movies"] = ($username === "YourName") ? $my_movies : $friend_movies;

        header("Location: welcome.php");
        exit();
    } else {
        echo "<script>alert('Invalid login!'); window.location.href='login.html';</script>";
        exit();
    }
} else {
    header("Location: login.html");
    exit();
}
?>

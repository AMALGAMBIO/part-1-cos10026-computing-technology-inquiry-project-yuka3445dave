<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function sanitise_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Redirect if accessed directly
if (!isset($_POST["firstname"])) {
    header("location: register.html");
    exit();
}

// Sanitize Input
$firstname = sanitise_input($_POST["firstname"] ?? '');
$lastname = sanitise_input($_POST["lastname"] ?? '');
$species = sanitise_input($_POST["species"] ?? 'Unknown species');
$age = sanitise_input($_POST["age"] ?? '');
$food = sanitise_input($_POST["food"] ?? 'No preference');
$partySize = sanitise_input($_POST["partysize"] ?? '1');

// Validate Inputs
$errMsg = "";
if ($firstname == "" || !preg_match("/^[a-zA-Z]+$/", $firstname)) {
    $errMsg .= "<p> Only alphabetic characters allowed in first name.</p>";
}

if ($lastname == "" || !preg_match("/^[a-zA-Z]+(?:-[a-zA-Z]+)*$/", $lastname)) {
    $errMsg .= "<p> Only alphabetic characters and hyphens allowed in last name.</p>";
}

if ($age === '' || !is_numeric($age) || $age < 18 || $age > 10000) {
    $errMsg .= "<p> You must enter a valid numeric age between 18 and 10,000.</p>";
}

// Validate Tour Selection
$tour = [];
if (isset($_POST["accom"])) $tour[] = "Accommodation";
if (isset($_POST["4day"])) $tour[] = "Four-day tour";
if (isset($_POST["10day"])) $tour[] = "Ten-day tour";
$tour_selected = !empty($tour) ? implode(", ", $tour) : "No tour selected";

// Output Result
if ($errMsg != "") {
    echo "<p>$errMsg</p>";
} else {
    echo "<p>Welcome <strong>" . htmlspecialchars($firstname) . " " . htmlspecialchars($lastname) . "</strong>!<br/>
    You are now booked on: <strong>" . htmlspecialchars($tour_selected) . "</strong>.<br/>
    Species: <strong>" . htmlspecialchars($species) . "</strong><br/>
    Age: <strong>" . htmlspecialchars($age) . "</strong><br/>
    Meal Preference: <strong>" . htmlspecialchars($food) . "</strong><br/>
    Number of travellers: <strong>" . htmlspecialchars($partySize) . "</strong></p>";
}
?>

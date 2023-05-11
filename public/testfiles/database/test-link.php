<?php
ob_start();

// Make sure a server is present
if ($_POST['host'] == "") {
    header("HTTP/1.1 404 Not Found");
    die("host missing");
}

// Make sure a database user is present
if ($_POST['username'] == "") {
    header("HTTP/1.1 404 Not Found");
    die("username missing");
}

// Make sure a password is present
if ($_POST['passwd'] == "") {
    header("HTTP/1.1 404 Not Found");
    die("passwd missing");
}

// Make sure a database is present
if ($_POST['dbname'] == "") {
    header("HTTP/1.1 404 Not Found");
    die("dbname missing");
}

// Create connection
$conn = new mysqli($_POST['host'], $_POST['username'], $_POST['passwd'], $_POST['dbname']);

// Check connection
if ($conn->connect_error) {
    header("HTTP/1.1 500 Internal Server Error");
    die("Connection failed: " . $conn->connect_error);
}

$conn->close();

echo "Connected successfully";

<?php
include './load-env.php';
$db_host = env('DB_HOST');
$db_username = env('DB_USERNAME');
$db_password = env('DB_PASSWORD');
$db_name = env('DB_NAME');
$db_port = env('DB_PORT');

$conn =  mysqli_connect($db_host,  $db_username,  $db_password);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error() . "\n");
}

$db_selected = mysqli_select_db($conn, $db_name,);

if (!$db_selected) {
    $sql = 'CREATE DATABASE ' . $db_name;

    if (!mysqli_query($conn, $sql)) {
        die('Error creating database: ' . mysqli_error($conn) . "\n");
    }

    $conn =  mysqli_connect($db_host,  $db_username,  $db_password, $db_name, $db_port);

    // sql to create meals table
    $sql = "CREATE TABLE meals (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(500) NOT NULL,
        description VARCHAR(500) NOT NULL
    )";

    if (!mysqli_query($conn, $sql)) {
        die(mysqli_error($conn) . "\n");
    }

    // sql to create users table
    $sql = "CREATE TABLE users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(500) NOT NULL,
    password VARCHAR(500) NOT NULL
    )";
    if (!mysqli_query($conn, $sql)) {
        die(mysqli_error($conn) . "\n");
    }

    // add admin user
    $sql = "insert into  users (email, password) VALUES ('admin@admin.com','1234')";
    if (!mysqli_query($conn, $sql)) {
        die(mysqli_error($conn) . "\n");
    }
}
$_SESSION['DB-loaded'] = true;
mysqli_close($conn);

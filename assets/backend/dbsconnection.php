<?php

require ('../../vendor/autoload.php');


$dotenv = Dotenv\Dotenv::createImmutable('../backend');
$dotenv->load();


$host = $_ENV['DB_HOST'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$dbname = $_ENV['DB_NAME'];


$conn = new mysqli($host, $username, $password, $dbname);

// Check Connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}


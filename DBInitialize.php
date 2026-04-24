<?php // This file initializes the database.
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_dashboard";

// Create database
$conn = new mysqli($servername,$username,$password);
$sql = "CREATE DATABASE $dbname";

// Check if database is created
if($conn->query($sql) === TRUE){
    echo "Database created successfully";
    $conn->close();
    include 'DBTables.php';
    echo "Tables Created";
}
// $conn = new mysqli($servername, $username, $password, $dbname);
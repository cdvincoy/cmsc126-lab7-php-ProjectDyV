<!-- This file initializes the database. -->
<?php 
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
    // Create the tables and the values of the database
    include 'DBTables.php';
    echo "Tables Created";
    header("Location: index.php");
    exit;

}
$conn->close();
?>
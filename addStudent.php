<?php // This file adds a student to the database.
session_start(); // Start the session to store messages
include 'DBConnector.php';

// Get the student name, age, email, course, year level, status, and image from the form
$name = $_POST["name"] ?? ''; 
$age = $_POST["age"] ?? '';
$email = $_POST["user_email"] ?? '';
$course = $_POST["course"] ?? '';
$year_level = $_POST["year_level"] ?? '';
$status = isset($_POST["graduating_status"]);
$image = $_FILES["image"]["name"] ?? '';
$start_year = date("Y") - $year_level; // Compute the starting year

move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $image);

// Generate student_number based on year level
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM student WHERE student_number LIKE ?");
$search = $start_year . "-%";
$stmt->bind_param("s", $search);
$stmt->execute();
$count = $stmt->get_result()->fetch_assoc()['total'] + 1;
$student_number = $start_year . "-" . str_pad($count, 5, "0", STR_PAD_LEFT);

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO student (student_number, student_name,student_age, student_email, student_yearlevel, course_id, graduating_status, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssisiiis", $student_number, $name, $age, $email, $year_level, $course, $status, $image);

// Execute the SQL statement
if ($stmt->execute()) {
    $_SESSION['success_message'] = "Student '$name' with Student Number: '$student_number' has been successfully added!";
    header("Location: index.php");
    exit;
} else {
    echo "Error : " . $stmt->error;
}
?>

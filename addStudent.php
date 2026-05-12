<?php // This file adds a business to the database.
session_start(); // Start the session to store messages
include 'DBConnector.php';

// Get the business owner, name, category, description, contact info, and location from the form
$name = $_POST["name"] ?? ''; 
$age = $_POST["age"] ?? '';
$email = $_POST["user_email"] ?? '';
$course = $_POST["course"] ?? '';
$year_level = $_POST["year_level"] ?? '';
$status = isset($_POST["graduating_status"]) ? 1 : 0;
$image = $_FILES["profile_image"]["name"] ?? '';
$start_year = date("Y") - $year_level;

move_uploaded_file($_FILES["profile_image"]["tmp_name"], "uploads/" . $image);

// Generate student_code based on year level
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM student WHERE student_code LIKE ?");
$search = $start_year . "-%";
$stmt->bind_param("s", $search);
$stmt->execute();
$count = $stmt->get_result()->fetch_assoc()['total'] + 1;
$student_code = $start_year . "-" . str_pad($count, 5, "0", STR_PAD_LEFT);

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO student (student_code, student_name,student_age, student_email, student_yearlevel, course_id, graduating_status, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssisiiis", $student_code, $name, $age, $email, $year_level, $course, $status, $image);

// Execute the SQL statement
if ($stmt->execute()) {
    $_SESSION['success_message'] = "Student '$name' with Student ID: '$student_code' has been successfully added!";
    header("Location: index.php");
    exit;
} else {
    echo "Error : " . $stmt->error;
}
?>

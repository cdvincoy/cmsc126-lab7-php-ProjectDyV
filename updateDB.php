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

if (!empty($_FILES["profile_image"]["name"])) {
    $image = $_FILES["profile_image"]["name"];
    move_uploaded_files($_FILES["profile_image"]["tmp_name"],"uploads/" , $image);
} else {
    $image = $_POST["existing_image"];
}

// Prepare the SQL statement
$stmt = $conn->prepare("UPDATE student SET student_name=?,student_age=?, student_email=?, student_yearlevel=?, course_id=?, graduating_status=?, image=? WHERE student_code=?");
$stmt->bind_param("sisiiis",$name, $age, $email, $year_level, $course, $status, $image, $studentID);

// Execute the SQL statement
if ($stmt->execute()) {
    $_SESSION['success_message'] = "Student '$name' with Student ID: '$student_code' has been successfully added!";
    header("Location: index.php");
    exit;
} else {
    echo "Error : " . $stmt->error;
}
?>

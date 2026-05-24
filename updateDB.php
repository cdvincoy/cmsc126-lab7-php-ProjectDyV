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
$studentID = $_POST["student_number"] ?? ''; 

if (!empty($_FILES["image"]["name"])) {
    $image = $_FILES["image"]["name"];
    move_uploaded_file($_FILES["image"]["tmp_name"],"uploads/" . $image);
} else {
    $image = $_POST["existing_image"] ?? '';
}

// echo "Image: " . $image . "<br>";
// echo "Student: " . $studentID . "<br>";
// echo "Files: ";
// exit;

// Prepares the SQL statement
$stmt = $conn->prepare("UPDATE student SET student_name=?,student_age=?, student_email=?, student_yearlevel=?, course_id=?, graduating_status=?, image=? WHERE student_number=?");
$stmt->bind_param("sisiiiss",$name, $age, $email, $year_level, $course, $status, $image, $studentID);

// Executes the SQL statement
if ($stmt->execute()) {
    $_SESSION['success_message'] = "Student $name with student no.: $studentID has been updated successfully!";
    header("Location: index.php");
    exit;
} else {
    echo "Error : " . $stmt->error;
}
?>

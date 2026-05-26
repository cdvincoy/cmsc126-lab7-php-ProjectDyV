<!-- This file searches for the student and its information in the database. -->
<?php
session_start();
include 'DBConnector.php';

$studentID = trim($_POST['studentID']);

if (empty($studentID)) {
    $_SESSION['success_message'] = "Please enter a student number.";
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("SELECT s.*, c.course_name FROM student s JOIN course c ON s.course_id = c.course_id WHERE s.student_number = ?");
$stmt->bind_param("s", $studentID);
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
    $_SESSION['success_message'] = "Student Found!\n" .
                                    "Student No.: " . $student['student_number'] . "\n" .
                                    "Name: " .  $student['student_name'] ."\n" .
                                    "Age: " .  $student['student_age'] ."\n" .
                                    "Email: " .  $student['student_email'] ."\n".
                                    "Year Level: " .  $student['student_yearlevel'] ."\n".
                                    "Course: " .  $student['course_name'] ."\n".
                                    "Graduating Status: " . ($student['graduating_status'] ? "Yes" : "No");
} else {
    $_SESSION['success_message'] = "No student found with ID: " . $studentID;
}

header("Location: index.php");
exit;
?>

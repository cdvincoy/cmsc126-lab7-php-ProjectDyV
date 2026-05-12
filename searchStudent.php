<?php
session_start();
include 'DBConnector.php';

$studentID = trim($_POST['studentID']);

$stmt = $conn->prepare("SELECT * FROM student WHERE student_code = ?");
$stmt->bind_param("s", $studentID);
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
    $_SESSION['success_message'] = "Student Found!\n" .
                                    "ID: " . $student['student_code'] . "\n" .
                                    "Name:" .  $student['student_name'] ."\n" .
                                    "Age:" .  $student['student_age'] ."\n" .
                                    "Email:" .  $student['student_email'];
} else {
    $_SESSION['success_message'] = "No student found with ID: " . $studentID;
}

header("Location: index.php");
exit;
?>

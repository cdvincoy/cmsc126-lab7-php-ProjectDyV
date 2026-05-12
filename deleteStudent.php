<?php
session_start();
include 'DBConnector.php';

$studentID = trim($_POST['studentID']);

$stmt = $conn->prepare("SELECT student_name FROM student WHERE student_code =?");
$stmt->bind_param("s", $studentID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
    $name = $student['student_name'];

    $stmt = $conn->prepare("DELETE FROM student WHERE student_code=?");
    $stmt->bind_param("s", $studentID);

    if ($stmt->execute()){
        $_SESSION['success_message'] = "Student $name has been successfully deleted.";
    } else {
        $_SESSION['success_message'] = "Error deleting student: " . $conn->error;
    } else {
        $_SESSION['success_message'] = "No student found with ID: " . $studentID;
    }

    header("Location: index.php");
    exit;
}
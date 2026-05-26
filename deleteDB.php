<!-- This file deletes student record from the database and deletes image from the uploads folder. -->
<?php
session_start();
include 'DBConnector.php';

$student_name = $_POST['student_name'];
$student_number = $_POST['student_number'];
$image = $_POST['image'];

if (!empty($image) && file_exists("uploads/" . $image)) {
    unlink("uploads/".$image);
}

$stmt = $conn->prepare("DELETE FROM student WHERE student_number=?");
$stmt->bind_param("s", $student_number);
$stmt->execute();

$_SESSION['success_message'] = "Student " .$student_name. " with student no.: " .$student_number . " has been deleted.";
header("Location: index.php");
exit;
?>
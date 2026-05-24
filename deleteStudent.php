<!-- This gets the student number information and asks the user if they are sure deleting the student record. -->
<?php
session_start();
include 'DBConnector.php';

$studentID = trim($_POST['studentID']);

if (empty($studentID)) {
    $_SESSION['success_message'] = "Please enter a student number.";
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM student WHERE student_number = ?");
$stmt->bind_param("s", $studentID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
} else {
    $_SESSION['success_message'] = "No student found with ID: " . $studentID;
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
    <title>Delete Student</title>
</head>

<body>
    <div id="confirm-modal" style="position:fixed; top: 0; left:0; width:100%; height:100%; background:rgba(0, 0, 0, 0.3); z-index:1;">
         <div style="background: white; margin:20% auto; padding:30px; width:50%; border-radius: 8px; text-align: center;">
            <p>Are you sure you want to delete <strong><?= htmlspecialchars($student['student_name']) ?></strong> with ID <strong><?=htmlspecialchars($student['student_number']) ?></strong>?</p>
            <p style="color:red; font-size: 0.9em;"> This cannot be done.</p><br>
            <form action="deleteDB.php" method="POST">
                <input type="hidden" name="student_name" value="<?=htmlspecialchars($student['student_name']) ?>">
                <input type="hidden" name="student_number" value="<?=htmlspecialchars($student['student_number']) ?>">
                <input type="hidden" name="image" value="<?= htmlspecialchars($student['image']) ?>">
                <button type="submit" style="color:red; border:1px solid red; padding: 6px 16px; border-radius: 4px; cursor: pointer; margin-right:10px;">Yes, Delete</button>
                <a href="index.php"><button type="button" style="padding: 6px 16px; border-radius: 4px; cursor: pointer;">Cancel</button></a>
            </form>
        </div>
    </div>
</body>
</html>

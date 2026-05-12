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
    $courseStmt = $conn->prepare("SELECT course_name FROM course WHERE course_id = ?");
    $courseStmt->bind_param("i", $student['course_id']);
    $courseStmt->execute();
    $courseResult = $courseStmt->get_result();
    $course = $courseResult->fetch_assoc();
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
    <title>Update Student Information</title>
</head>

<body>
    <header>
    <br>
        <h1>Update Student Information</h1>
        <p>All fields marked * are required.</p>
    </header><br>
    <div class="content">
        <table>
            <form action="updateDB.php" 
                method="post" 
                enctype="multipart/form-data">
                
            <tr>
                <td><p class="title">PERSONAL INFORMATION</p></td>
            </tr>
            <tr>
                <td><label>Name <span class="red">*</span></label><br>
                <input type="text" name="name" value="<?=htmlspecialchars($student['student_name']) ?>"></td>

                <td><label>Age <span class="red">*</span></label><br>
                <input type="number" name="age" value="<?=htmlspecialchars($student['student_age']) ?>"></td>
            </tr>
            <tr>
                <td colspan="2"><label>Email <span class="red">*</span></label><br>
                <input type="email" name="user_email" value="<?=htmlspecialchars($student['student_email']) ?>"></td>
            </tr>
            <tr>
                <td><p class="title">ACADEMIC INFORMATION</p></td>
            </tr>
            <tr>
                <td><label>Course <span class="red">*</span></label>
                <input type="text" id="course_input" value="<?=htmlspecialchars($course['course_name']) ?>" autocomplete="off" required>
                <input type="hidden" name="course" id="course_id">
                <div id="suggestions"></div></td>

                <td><label>Year Level <span class="red">*</span></label>
                <input type="number" name="year_level" value="<?=htmlspecialchars($student['student_yearlevel']) ?>"></td>
            </tr>
            
            <tr>
                <td><label>Graduating this year? <span class="red">*</span></label><br>
                <input type="checkbox" name="graduating_status" value="1" <?=$student['graduating_status'] == 1 ? 'checked' : '' ?>><span> Yes </span></td>
            </tr>

            <tr>
                <td><p class="title">PROFILE PHOTO</p>
                <label>Profile Image <span class="red">*</span></label>
                <div class="upload-box" onclick="document.getElementById('profile_image').click()">
                    <img src="upload-icon.png" alt="Upload Icon" class="upload-icon">
                    <p><span class="red">Choose a file</span> or drag it here</p>
                    <p>JPG, PNG, GIF, WEBP are accepted</p><br>
                    <p id="file-name"><?=htmlspecialchars($student['image']) ?> has been selected.</p>
                </div>
                <input type="file" name="profile_image" id="profile_image" required style="display: none;"
                onchange="document.getElementById('file-name').textContent=this.files[0].name"></td>
            </tr>

            <tr>
                <td><button type="submit">+Update Now</button></td>
            </tr>
            </form>
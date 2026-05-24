<!-- This is the interface for updating student record which is similar to the homepage.  -->
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
$stmt->bind_param("i", $studentID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
    $courseStmt = $conn->prepare("SELECT course_name FROM course WHERE course_id = ?");
    $courseStmt->bind_param("i", $student['course_id']);
    $courseStmt->execute();
    $courseResult = $courseStmt->get_result();
    $course = $courseResult->fetch_assoc();
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
                <input type="hidden" name="student_number" value="<?=htmlspecialchars($student['student_number']) ?>">
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
                <input type="hidden" name="course" id="course_id" value="<?=htmlspecialchars($student['course_id']) ?>" >
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
                <div class="upload-box" id="upload-box" onclick="triggerUpload()">
                    <img src="image_icon.png" alt="Upload Icon" class="upload-icon" id="upload-icon" style="display:none;">
                    <div id="upload-placeholder" style="display:none;">
                        <p><span class="red">Choose a file</span> or drag it here</p>
                        <p>JPG, PNG, GIF, WEBP are accepted</p>
                    </div>
                    <div id="file-selected" style="display:block;">
                        <img id="preview-img" src="uploads/<?=htmlspecialchars($student['image'], ENT_QUOTES, 'UTF-8') ?>" alt="Preview" style="max-height:100px; max-width:100%; border-radius:6px;">
                        <p id="file-name" style="margin:6px 0 0;"></p>
                        <button type="button" onclick="removeFile(event)" style="margin-top: 8px; color:red; background: none; border: 1px solid red; border-radius: 4px; padding: 3px 10px; cursor: pointer;">Remove</button>
                    </div>
                </div>
                <input type="file" name="image" id="image" accept=".jpg,.jpeg,.gif,.webp" style="display: none;"
                    onchange="handleFileSelect(this)">
                <input type="hidden" name="existing_image" value="<?=htmlspecialchars($student['image']) ?>">
                <input type="hidden" name="student_number" value="<?=htmlspecialchars($student['student_number']) ?>">
            </td>
            </tr>

            <tr>
                <td><button class="registration" type="submit">+Update Now</button></td>
            </tr>
            </form>
    
    <script>
        function triggerUpload() {
            if (!document.getElementById('image').files.length) {
                document.getElementById('image').click();
            }
        }

        function handleFileSelect(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                };
                reader.readAsDataURL(file);

                document.getElementById('file-name').textContent = file.name;
                document.getElementById('upload-placeholder').style.display = 'none';
                document.getElementById('upload-icon').style.display = 'none';
                document.getElementById('file-selected').style.display = 'block';
                }
            }
        
            function removeFile(event) {
                event.stopPropagation();

                const input = document.getElementById('image');
                input.value = '';
                
                document.getElementById('preview-img').src = '';
                document.getElementById('file-name').textContent = '';
                document.getElementById('upload-placeholder').style.display = 'block';
                document.getElementById('upload-icon').style.display = 'block';
                document.getElementById('file-selected').style.display = 'none';
                
            }

    </script>

</body>
</html>

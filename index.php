<!-- This is the source code for index.html -->
 <?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
    <title>Student Registration</title>
</head>

<body>
    <header>
    <br>
        <h1>Student Registration</h1>
        <p>All fields marked * are required.</p>
    </header><br>
    <div class="content">
        <!-- This the form for the student registration. -->
        <table>
            <form action="addStudent.php" 
                method="post" 
                enctype="multipart/form-data">
                
            <tr>
                <td><p class="title">PERSONAL INFORMATION</p></td>
            </tr>
            <tr>
                <td><label>Name <span class="red">*</span></label><br>
                <input type="text" name="name" required></td>

                <td><label>Age <span class="red">*</span></label><br>
                <input type="number" name="age" required></td>
            </tr>
            <tr>
                <td colspan="2"><label>Email <span class="red">*</span></label><br>
                <input type="email" name="user_email" required></td>
            </tr>
            <tr>
                <td><p class="title">ACADEMIC INFORMATION</p></td>
            </tr>
            <tr>
                <!-- There is a course suggestion function that is to the database. -->
                <td><label>Course <span class="red">*</span></label>
                <input type="text" id="course_input" placeholder="e.g. BS Computer Science" autocomplete="off" required>
                <input type="hidden" name="course" id="course_id">
                <div id="suggestions"></div></td>

                <td><label>Year Level <span class="red">*</span></label>
                <input type="number" name="year_level" required></td>
            </tr>
            
            <tr>
                <td><label>Graduating this year? <span class="red">*</span></label><br>
                <input type="checkbox" name="graduating_status" value="1"><span> Yes </span></td>
            </tr>

            <tr>
                <!-- This section asks user for a photo and previews the photo, with an option to remove the photo and reupload.  -->
                <td colspan="2"><p class="title">PROFILE PHOTO</p><br>
                <label>Profile Image <span class="red">*</span></label>
                <div class="upload-box" id="upload-box" onclick="triggerUpload()">
                    <img src="image_icon.png" alt="Upload Icon" class="upload-icon" id="upload-icon">
                    <div id="upload-placeholder">
                        <p><span class="red">Choose a file</span> or drag it here</p>
                        <p>JPG, PNG, GIF, WEBP are accepted</p>
                    </div>
                    <div id="file-selected" style="display:none;">
                        <img id="preview-img" src="" alt="Preview" style="max-height:100px; max-width:100%; border-radius:6px;">
                        <p id="file-name" style="margin:6px 0 0;"></p>
                        <button type="button" onclick="removeFile(event)" style="margin-top: 8px; color:red; background: none; border: 1px solid red; border-radius: 4px; padding: 3px 10px; cursor: pointer;">Remove</button>
                    </div>
                </div>
                <input type="file" name="image" id="image" accept=".jpg,.jpeg,.gif,.webp" style="display: none;"
                    onchange="handleFileSelect(this)"></td>
            </tr>

            <tr>
                <td colspan="2"><button class="registration" type="submit">+Submit Registration</button></td>
            </tr>
            </form>
        
            <!-- This is the success message which is used across other files to output results after different actions. -->
            <?php if(isset($_SESSION['success_message'])): ?>
            <div id="modal" class="modal-overlay">
                <div class="modal-box">
                    <p><?php echo nl2br(htmlspecialchars($_SESSION['success_message'])); ?></p><br>
                    <button class="modal-close" onclick="document.getElementById('modal').style.display='none'">Close</button>
                </div>
            </div>
            <?php unset($_SESSION['success_message']);?>
            <?php endif; ?>

            <tr>
                <td><p class="title">RECORD MANAGEMENT</p></td>
            </tr>

            <tr>
                <td> <p class="title-1">LOOK UP STUDENT BY ID<p></td>
            </tr>
    
            <!-- The following are the things you can do once student becomes registered.
            You can search a student record, update a student record, and delete a student record. -->
            <tr>
                <td>
                    <form action="searchStudent.php" method="POST">
                        <input type="text" name="studentID" placeholder="Enter Student ID(e.g.2024-00123)">
                        <button class="search" type="submit" formaction="searchStudent.php">Search</button>
                        <button class="update" type="submit" formaction="updateStudent.php">Update</button>
                        <button class="delete" type="submit" formaction="deleteStudent.php">Delete</button>
                    </form>
                </td>
            </tr>
            </table>
    </div>

    
    <script>
        // This part of the code gets triggered when a user inputs a course and a suggested course appears.
        document.getElementById("course_input").addEventListener("keyup", function() {
            let query = this.value;

            if (query.length === 0) {
                return;
            }
            fetch("suggestCourse.php?q=" + query)
                .then(response => response.text())
                .then(data => {
                        document.getElementById("suggestions").innerHTML = data;
            });
        });

        // Once a course is selected, this function gets triggered.
        function selectCourse(id, name){
            document.getElementById("course_input").value = name;
            document.getElementById("course_id").value = id;
            document.getElementById("suggestions").innerHTML ="";
        }

        // This function is for uploading photo. 
        function triggerUpload() {
            if (!document.getElementById('image').files.length) {
                document.getElementById('image').click();
            }
        }

        // This function previews the chosen photo.
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
        
            // This function removes the chosen photo.
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
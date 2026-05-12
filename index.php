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
                <td><p class="title">PROFILE PHOTO</p>
                <label>Profile Image <span class="red">*</span></label>
                <div class="upload-box" onclick="document.getElementById('profile_image').click()">
                    <img src="upload-icon.png" alt="Upload Icon" class="upload-icon">
                    <p><span class="red">Choose a file</span> or drag it here</p>
                    <p>JPG, PNG, GIF, WEBP are accepted</p>
                    <p id="file-name"></p>
                </div>
                <input type="file" name="profile_image" id="profile_image" required style="display: none;"
                onchange="document.getElementById('file-name').textContent=this.files[0].name"></td>
            </tr>

            <tr>
                <td><button type="submit">+Submit Registration</button></td>
            </tr>
            </form>
        
            <?php if(isset($_SESSION['success_message'])): ?>
            <div id="modal" class="modal-overlay">
                <div class="modal-box">
                    <p><?php echo nl2br(htmlspecialchars($_SESSION['success_message'])); ?></p>
                    <button class="modal-close" onclick="document.getElementById('modal').style.display='none'">Close</button>
                </div>
            </div>
            <?php unset($_SESSION['success_message']);?>
            <?php endif; ?>

            <tr>
                <td><p class="title">RECORD MANAGEMENT</p></td>
            </tr>

            <tr>
                <td> <p class="title">LOOK UP STUDENT BY ID<p></td>
            </tr>
    
            <tr>
                <td>
                    <form action="searchStudent.php" method="POST">
                        <input type="text" name="studentID" placeholder="Enter Student ID(e.g.2024-00123)">
                        <button type="submit" formaction="searchStudent.php">Search</button>
                        <button type="submit" formaction="updateStudent.php">Update</button>
                        <button type="submit" formaction="deleteStudent.php">Delete</button>
                    </form>
                </td>
            </tr>
            </table>
    </div>

    
    <script>
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

        function selectCourse(id, name){
            document.getElementById("course_input").value = name;
            document.getElementById("course_id").value = id;
            document.getElementById("suggestions").innerHTML ="";
        }

    </script>

</body>
</html>
<!-- This is the source code for index.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
<<<<<<< HEAD
</head>

<body>
=======
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1>Student Registration</h1>
        <p>All fields marked * are required.</p>
    </header><br>
    <div class="content">
        <form action="addStudent.php" method="get">
        <table>
            <tr>
                <td><p>PERSONAL INFORMATION</p></td>
            </tr>

            <tr>
                <td><label>Name *</label><br>
                <input type="text" name="name" required></td>

                <td><label>Age *</label><br>
                <input type="number" name="age" required></td>
            </tr>

            <tr>
                <td><label>Email *</label>
                <input type="email" name="user_email" required></td>
            </tr>

            <tr>
                <td><p>ACADEMIC INFORMATION</p></td>
            </tr>

            <tr>
                <td><label>Course *</label>
                <input type="text" name="course" required></td>

                <td><label>Year Level</label>
                <input type="number" name="year_level" required></td>
            </tr>
            
            <tr>
                <td><label>Graduating this year?</label>
                <input type="checkbox" name="graduating_status" value="1"></td>
            </tr>

            <tr>
                <td><p>PROFILE PHOTO</p>
                <label>Profile Image *</label>
                <input type="file" name="profile_image" required></td>
            </tr>

            <tr>
                <td><button type="submit">+Submit Registration</button></td>
            </tr>
        </form>

        <tr>
            <td><p>RECORD MANAGEMENT</p></td>
        </tr>

        <tr>
            <td> <p>LOOK UP STUDENT BY ID<p></td>
        </tr>
    
        <tr>
            <td><input type="text" placeholder="Enter Student ID(e.g.2024-00123)">
            <button>Search</button>
            <button>Update</button.
            <button>Delete</button>
        </tr>
        </table>
    </div>
>>>>>>> 79994f6 (Initial pages)
</body>
</html>
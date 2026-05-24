<?php // This file creates the tables in the database.
    include 'DBConnector.php';

// Create course
$sql = "CREATE TABLE course (
    course_id     VARCHAR(40) PRIMARY KEY,
    course_name   VARCHAR(50) NOT NULL 
)";
$conn->query($sql);

// Create student 
$sql = "CREATE TABLE student (
    student_id     INT AUTO_INCREMENT PRIMARY KEY,
    student_number    VARCHAR(20) UNIQUE, 
    student_name   VARCHAR(50) NOT NULL,
    student_age    INT NOT NULL,
    student_email   VARCHAR(40) NOT NULL UNIQUE,
    student_yearlevel INT(1),
    course_id       VARCHAR(40) NOT NULL,
    graduating_status   BOOLEAN,
    image               VARCHAR(255),
    FOREIGN KEY (course_id) REFERENCES course(course_id)
)";
$conn->query($sql);

// Insert course values
$sql = "INSERT INTO course (course_id, course_name)
    VALUES
        ('5034', 'BS Applied Mathematics'),
        ('5038', 'BS Biology'),
        ('5046', 'BS Chemistry'),
        ('5241', 'BS Communication and Media Studies'),
        ('5202', 'BA Commnuity Development'),
        ('5132', 'BS Computer Science'),
        ('5145', 'BS Economics'),
        ('5012', 'BA History'),
        ('5182', 'BA Literature'),
        ('5022', 'BA Political Science'),
        ('5023', 'BA Psychology'),
        ('5111', 'BS Public Health'),
        ('5025', 'BA Sociology'),
        ('5114', 'BS Statistics'),
        ('5087', 'BS Fisheries'),
        ('5176', 'BS Accountancy'),
        ('5042', 'BS Business Administration (Marketing)'),
        ('5099', 'BS Management');
        ";
$conn->query($sql);    

$conn->close();
?>

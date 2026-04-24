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
    student_id     VARCHAR(40) PRIMARY KEY,
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


$conn->close();
?>

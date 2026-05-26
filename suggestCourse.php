<!-- This file is responsible for giving course suggestions when user inputs a course. -->
<?php
include 'DBConnector.php';

$q = $_GET['q'] ?? '';

$sql = "SELECT course_id, course_name
    FROM course
    WHERE course_name LIKE ?
    LIMIT 1";

$stmt = $conn->prepare($sql);
$search = "%" .$q. "%";
$stmt->bind_param("s", $search);
$stmt->execute();

$result = $stmt->get_result();

while ($row = $result->fetch_assoc()){
    echo "<div onclick=\"selectCourse('{$row['course_id']}','{$row['course_name']}')\"
    >
    {$row['course_name']}
</div>";
}
?>
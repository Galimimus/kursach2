<?php

require_once('/var/www/html/kursach2/helpers/result_helper.php');
require_once('/var/www/html/kursach2/models/user_model.php');
require_once('/var/www/html/kursach2/helpers/database.php');
require_once('/var/www/html/kursach2/helpers/validator.php');

if(!check_rights(Role::admin)) die();

$link = new Database();
$link = $link->connect();
$query = "SELECT * FROM students";
$result = mysqli_query($link, $query);
$students = array();
while($row = mysqli_fetch_assoc($result)) {
    $student = new Student($row['student_name'], $row['password'], $row['grade_name']);
    $student->id = $row['student_id'];
    array_push($students, $student);
}
mysqli_close($link);

return_ok($students, 200);
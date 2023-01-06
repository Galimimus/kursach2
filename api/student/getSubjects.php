<?php
require_once('/var/www/html/kursach2/helpers/validator.php');
require_once('/var/www/html/kursach2/helpers/database.php');
require_once('/var/www/html/kursach2/models/user_model.php');
require_once('/var/www/html/kursach2/models/subject_model.php');
include_once '/var/www/html/kursach2/helpers/result_helper.php';

if(!check_rights(Role::student)) die();

$grade = unserialize($_SESSION['user'])->grade;

$link = new Database();
$link = $link->connect();
$query = "SELECT * FROM subjects WHERE grade_name = '$grade' LEFT JOIN teachers t ON s.teacher_id = t.id";
$result = mysqli_query($link, $query);
$subjects = array();
while($row = mysqli_fetch_assoc($result)) {
    $subject = new Subject($row['name'], $row['teacher_name'] ,$row['grade_name']);
    $subject->id = $row['subject_id'];
    $subjects[] = $subject;
}

mysqli_close($link);

return_ok($subjects, 200);
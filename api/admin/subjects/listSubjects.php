<?php
require_once('/var/www/html/kursach2/helpers/result_helper.php');
require_once('/var/www/html/kursach2/models/user_model.php');
require_once('/var/www/html/kursach2/models/subject_model.php');
require_once('/var/www/html/kursach2/helpers/database.php');
require_once('/var/www/html/kursach2/helpers/validator.php');

if(!check_rights(Role::admin)) die();

$link = new Database();
$link = $link->connect();
$query = "SELECT name, teacher_name, grade_name, subject_id FROM subjects s LEFT JOIN teachers t ON s.teacher_id = t.id";
$result = mysqli_query($link, $query);
$subjects = array();

while($row = mysqli_fetch_assoc($result)) {
    $subject = array(
        "id" => $row['subject_id'],
        "name" => $row['name'],
        "grade" => $row['grade_name'],
        "teacher" => $row['teacher_name']
    );
    array_push($subjects, $subject);
}

mysqli_close($link);

return_ok($subjects, 200);
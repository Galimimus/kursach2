<?php
require_once('/var/www/html/kursach2/helpers/result_helper.php');
require_once('/var/www/html/kursach2/models/user_model.php');
require_once('/var/www/html/kursach2/helpers/database.php');
require_once('/var/www/html/kursach2/helpers/validator.php');

if(!check_rights(Role::admin)) die();
if(!isset($_GET['name'])) return_error("No name", 400);
if(!isset($_GET['teacher'])) return_error("No teacher", 400);
if(!isset($_GET['grade'])) return_error("No grade", 400);

$name = $_GET['name'];
$teacher = $_GET['teacher'];
$grade = $_GET['grade'];

$link = new Database();
$link = $link->connect();
$query = "INSERT INTO subjects (name, grade_name, teacher_id) VALUES ('$name', '$grade', '$teacher')";
$result = mysqli_query($link, $query);

$id = mysqli_insert_id($link);
mysqli_close($link);

if($result) {
    $subject = array(
        "id" => $id,
        "name" => $name,
        "grade" => $grade,
        "teacher" => $teacher
    );

    return_ok($subject, 200);
} else {
    return_error("Subject not added", 400);
}
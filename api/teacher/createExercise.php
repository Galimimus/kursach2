<?php
require_once('/var/www/html/kursach2/models/exercise_model.php');
require_once('/var/www/html/kursach2/helpers/result_helper.php');
require_once('/var/www/html/kursach2/helpers/database.php');
require_once('/var/www/html/kursach2/helpers/validator.php');

if(!check_rights(Role::teacher)) die();
if(!isset($_GET['name'])) return_error('name is not set', 400);
if(!isset($_GET['subject_id'])) return_error('subject_id is not set', 400);
if(!isset($_GET['text'])) return_error('text is not set', 400);

$name = $_GET['name'];
$subject_id = $_GET['subject_id'];
$text = $_GET['text'];
$teacher_id = unserialize($_SESSION['user'])->id;

$link = new Database();
$link = $link->connect();

$query = "SELECT * FROM subjects WHERE subject_id='$subject_id' AND teacher_id='$teacher_id'";
$result = check_query(mysqli_query($link, $query), 'Database error', 500);

check_query(mysqli_num_rows($result), 'No such subject for teacher', 400);

$query = "INSERT INTO exercises (text, subject_id, teacher_id, name) VALUES ('$text', $subject_id, $teacher_id, '$name')";
$result = check_query(mysqli_query($link, $query), 'Database error', 500);

mysqli_close($link);

if($result) {
    return_ok("Exercise added", 200);
} else {
    return_error("Exercise not added", 400);
}
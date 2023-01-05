<?php
require_once('/var/www/html/kursach2/helpers/result_helper.php');
require_once('/var/www/html/kursach2/models/user_model.php');
require_once('/var/www/html/kursach2/models/exercise_model.php');
require_once('/var/www/html/kursach2/helpers/database.php');
require_once('/var/www/html/kursach2/helpers/validator.php');

if(!check_rights(Role::teacher)) die();
if(!isset($_GET['subject_id'])) return_error('subject_id is not set', 400);

$subject_id = $_GET['subject_id'];
$teacher_id = unserialize($_SESSION['user'])->id;

$link = new Database();
$link = $link->connect();

$query = "SELECT * FROM subjects WHERE subject_id = '$subject_id' AND teacher_id = '$teacher_id'";
$result = check_query(mysqli_query($link, $query), 'Database error', 500);
check_query(mysqli_num_rows($result), 'No such subject for teacher', 400);

$query = "SELECT * FROM exercises WHERE subject_id = '$subject_id'";
$result = check_query(mysqli_query($link, $query), 'Database error', 500);
$exercises = array();
while($row = mysqli_fetch_assoc($result)) {
    $exercise = new Exercise($row['name'], $row['subject_id'], $row['text'], $row['teacher_id']);
    $exercise->id = $row['exercise_id'];
    $exercises[] = $exercise;
}

mysqli_close($link);

return_ok($exercises, 200);

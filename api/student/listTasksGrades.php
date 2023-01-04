<?php
require_once('/var/www/html/kursach2/helpers/validator.php');
require_once('/var/www/html/kursach2/helpers/result_helper.php');
require_once('/var/www/html/kursach2/models/user_model.php');
require_once('/var/www/html/kursach2/helpers/database.php');

if(!check_rights(Role::student)) die();
if(!isset($_GET['subject_id'])) return_error('subject_id is not set', 400);

$subject_id = $_GET['subject_id'];

$student_id = unserialize($_SESSION['user'])->id;

$link = new Database();
$link = $link->connect();
$query = "SELECT exercises.exercise_id, name, text, task_grade FROM exercises
LEFT JOIN tasks_grades ON exercises.exercise_id=tasks_grades.exercise_id
WHERE subject_id='$subject_id'";
$result = mysqli_query($link, $query);
$tasks_grades = array();
while($row = mysqli_fetch_assoc($result)) {
    $task_grade['task_grade'] = $row['task_grade'];
    $task_grade['exercise_name'] = $row['name'];
    $task_grade['exercise_text'] = $row['text'];
    array_push($tasks_grades, $task_grade);
}

mysqli_close($link);

return_ok($tasks_grades, 200);
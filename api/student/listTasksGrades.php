<?php
require_once('/var/www/html/kursach2/helpers/validator.php');
require_once('/var/www/html/kursach2/helpers/result_helper.php');
require_once('/var/www/html/kursach2/models/user_model.php');
require_once('/var/www/html/kursach2/helpers/database.php');

if(!check_rights(Role::student)) die();
check_get_field('subject_id', 'string');

$subject_id = $_GET['subject_id'];

$student_id = unserialize($_SESSION['user'])->id;

$link = new Database();
$link = $link->connect();

$query = "SELECT grade_name FROM subjects WHERE subject_id='$subject_id'";
$result = check_query(mysqli_query($link, $query), 'Database error', 500);

check_query(mysqli_num_rows($result), 'No such subject', 400);


if(unserialize($_SESSION['user'])->grade != mysqli_fetch_assoc($result)['grade_name']) {
    return_error('You are not in this grade', 400);
}

$query = "SELECT exercises.exercise_id, name, text, task_grade FROM exercises
LEFT JOIN tasks_grades ON exercises.exercise_id=tasks_grades.exercise_id AND student_id='$student_id'
WHERE subject_id='$subject_id'";

$result = check_query(mysqli_query($link, $query), 'Database error', 500);


$tasks_grades = array();
while($row = mysqli_fetch_assoc($result)) {
    $task_grade['task_grade'] = $row['task_grade'];
    $task_grade['exercise_name'] = $row['name'];
    $task_grade['exercise_text'] = $row['text'];
    array_push($tasks_grades, $task_grade);
}

mysqli_close($link);

return_ok($tasks_grades, 200);
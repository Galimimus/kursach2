<?php
require_once('/var/www/html/kursach2/helpers/result_helper.php');
require_once('/var/www/html/kursach2/models/user_model.php');
require_once('/var/www/html/kursach2/helpers/database.php');
require_once('/var/www/html/kursach2/helpers/validator.php');

if(!check_rights(Role::teacher)) die();
if(!isset($_GET['student_id'])) return_error("No student id", 400);
if(!isset($_GET['exercise_id'])) return_error("No exercise id", 400);
if(!isset($_GET['task_grade'])) return_error("No task grade", 400);

$student_id = $_GET['student_id'];
$exercise_id = $_GET['exercise_id'];
$task_grade = $_GET['task_grade'];

$link = new Database();
$link = $link->connect();

$query="UPDATE tasks_grades SET task_grade = $task_grade WHERE exercise_id = $exercise_id AND student_id = $student_id";
$result = mysqli_query($link, $query);

if(mysqli_affected_rows($link) == 0){

$query="INSERT INTO tasks_grades (exercise_id, student_id, task_grade)
SELECT $exercise_id, $student_id, $task_grade
FROM students
WHERE student_id = $student_id AND EXISTS (
    SELECT * FROM exercises WHERE exercise_id = $exercise_id
)";
$result = mysqli_query($link, $query);

}

mysqli_close($link);

if($result) {
    return_ok("Task grade changed", 200);
} else {
    return_error("Task grade not changed", 400);
}



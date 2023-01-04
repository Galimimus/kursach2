<?php
require_once('/var/www/html/kursach2/models/subject_model.php');
require_once('/var/www/html/kursach2/helpers/result_helper.php');
require_once('/var/www/html/kursach2/helpers/database.php');
require_once('/var/www/html/kursach2/helpers/validator.php');

if(!check_rights(Role::teacher)) die();
if(!isset($_GET['exercise_id'])) return_error('exercise_id is not set', 400);
if(!isset($_GET['grade_name'])) return_error('grade_name is not set', 400);

$exercise_id = $_GET['exercise_id'];
$grade_name = $_GET['grade_name'];

$link = new Database();
$link = $link->connect();
$query = "SELECT students.*, tasks_grades.task_grade FROM students
LEFT JOIN tasks_grades ON students.student_id = tasks_grades.student_id AND tasks_grades.exercise_id = '$exercise_id' WHERE students.grade_name = '$grade_name'";

$result = mysqli_query($link, $query);
$tasks_grades = array();

while($row = mysqli_fetch_assoc($result)) {
    $task_grade = array(
        'student_id' => $row['student_id'],
        'student_name' => $row['student_name'],
        'task_grade' => $row['task_grade']
    );
    array_push($tasks_grades, $task_grade);
}

mysqli_close($link);

return_ok($tasks_grades, 200);
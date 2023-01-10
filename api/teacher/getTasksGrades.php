<?php
require_once('/var/www/html/kursach2/models/subject_model.php');
require_once('/var/www/html/kursach2/helpers/result_helper.php');
require_once('/var/www/html/kursach2/helpers/database.php');
require_once('/var/www/html/kursach2/helpers/validator.php');

if(!check_rights(Role::teacher)) die();

check_get_field('exercise_id', 'int');
check_get_field('grade_name', 'string');

$exercise_id = $_GET['exercise_id'];
$grade_name = $_GET['grade_name'];

$teacher_id = unserialize($_SESSION['user'])->id;

$link = new Database();
$link = $link->connect();

// check if exercise belongs to teacher
$query = "SELECT * FROM exercises WHERE exercise_id = '$exercise_id' AND teacher_id = '$teacher_id'";
$result = check_query(mysqli_query($link, $query), 'Database error', 500);
check_query(mysqli_num_rows($result), 'No such exercise for teacher', 400);

// check if grade belongs to teacher

$query = "SELECT * FROM subjects WHERE grade_name = '$grade_name' AND teacher_id = '$teacher_id'";
$result = check_query(mysqli_query($link, $query), 'Database error', 500);
check_query(mysqli_num_rows($result), 'No such grade for teacher', 400);


$query = "SELECT students.*, tasks_grades.task_grade FROM students
LEFT JOIN tasks_grades ON students.student_id = tasks_grades.student_id AND tasks_grades.exercise_id = '$exercise_id' WHERE students.grade_name = '$grade_name'";

$result = check_query(mysqli_query($link, $query), 'Database error', 500);

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
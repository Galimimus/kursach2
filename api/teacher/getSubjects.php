<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/result_helper.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/models/user_model.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/models/subject_model.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/database.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/validator.php');

if(!check_rights(Role::teacher)) die();

$teacher_id = unserialize($_SESSION['user'])->id;

$link = new Database();
$link = $link->connect();
$query = "SELECT * FROM subjects WHERE teacher_id = '$teacher_id'";
$result = check_query(mysqli_query($link, $query), 'Database error', 500);
$subjects = array();

while($row = mysqli_fetch_assoc($result)) {
    $subject = new Subject($row['name'], $row['teacher_id'] ,$row['grade_name']);
    $subject->id = $row['subject_id'];
    array_push($subjects, $subject);
}

mysqli_close($link);

return_ok($subjects, 200);

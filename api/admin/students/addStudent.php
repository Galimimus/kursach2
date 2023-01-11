<?php


require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/result_helper.php');
require_once('../../../models/user_model.php');
require_once('../../../helpers/database.php');
require_once('../../../kursach2/helpers/validator.php');

if (!check_rights(Role::admin)) die();

check_get_field('email', 'string');
check_get_field('password', 'string');
check_get_field('grade', 'string');
check_get_field('name', 'string');

$email = $_GET['email'];
$name = $_GET['name'];
$pass = $_GET['password'];
$grade = $_GET['grade'];

$link = new Database();
$link = $link->connect();
$pass .= "fdfdsfdvhj";
$pass = md5($pass);
$query = "INSERT INTO students (grade_name, student_name, password, email) VALUES ('$grade', '$name', '$pass', '$email')";
$result = mysqli_query($link, $query);

$id = mysqli_insert_id($link);
mysqli_close($link);

if ($result) {
    $user = array(
        "id" => $id,
        "name" => $name,
        "email" => $email,
        "grade" => $grade,
        "role" => Role::student
    );

    return_ok($user, 200);
} else {
    return_error("Student not added", 400);
}

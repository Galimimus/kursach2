<?php

// TODO: uncomment md5() function

require_once('/var/www/html/kursach2/helpers/result_helper.php');
require_once('/var/www/html/kursach2/models/user_model.php');
require_once('/var/www/html/kursach2/helpers/database.php');
require_once('/var/www/html/kursach2/helpers/validator.php');

if (!check_rights(Role::admin)) die();
if (!isset($_GET['email'])) return_error("No email", 400);
if (!isset($_GET['pass'])) return_error("No pass", 400);
if (!isset($_GET['grade'])) return_error("No grade", 400);
if (!isset($_GET['name'])) return_error("No name", 400);

$email = $_GET['email'];
$name = $_GET['name'];
$pass = $_GET['pass'];
$grade = $_GET['grade'];

$link = new Database();
$link = $link->connect();
//$this->password .= "fdfdsfdvhj";
//$pass = md5($pass);
$query = "INSERT INTO students (grade_name, student_name, password, email) VALUES ('$grade', '$name', '$pass', '$email')";
$result = mysqli_query($link, $query);

mysqli_close($link);

if ($result) {
    return_ok("Student added", 200);
} else {
    return_error("Student not added", 400);
}

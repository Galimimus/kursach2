<?php
require_once('/var/www/html/kursach2/helpers/result_helper.php');
require_once('/var/www/html/kursach2/models/user_model.php');
require_once('/var/www/html/kursach2/helpers/database.php');
require_once('/var/www/html/kursach2/helpers/validator.php');

if(!check_rights(Role::admin)) die();

check_get_field('id', 'int');

$id = $_GET['id'];

$link = new Database();
$link = $link->connect();
$query = "DELETE FROM students WHERE student_id = $id";
$result = mysqli_query($link, $query);
mysqli_close($link);

if($result) {
    return_ok("Student deleted", 200);
} else {
    return_error("Student not deleted", 400);
}
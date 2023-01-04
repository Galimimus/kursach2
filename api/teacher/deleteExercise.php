<?php
require_once('/var/www/html/kursach2/models/exercise_model.php');
require_once('/var/www/html/kursach2/helpers/result_helper.php');
require_once('/var/www/html/kursach2/helpers/database.php');
require_once('/var/www/html/kursach2/helpers/validator.php');

if(!check_rights(Role::teacher)) die();
if(!isset($_GET['exercise_id'])) return_error('exercise_id is not set', 400);

$exercise_id = $_GET['exercise_id'];

$link = new Database();
$link = $link->connect();
$query = "DELETE FROM exercises WHERE exercise_id = '$exercise_id'";
$result = mysqli_query($link, $query);

$query = "DELETE FROM tasks_grades WHERE exercise_id = '$exercise_id'";
$result = mysqli_query($link, $query);

mysqli_close($link);

if($result) {
    return_ok("Exercise deleted", 200);
} else {
    return_error("Exercise not deleted", 400);
}
<?php
require_once('/var/www/html/kursach2/helpers/result_helper.php');
require_once('/var/www/html/kursach2/models/user_model.php');
require_once('/var/www/html/kursach2/models/exercise_model.php');
require_once('/var/www/html/kursach2/helpers/database.php');
require_once('/var/www/html/kursach2/helpers/validator.php');

if(!check_rights(Role::teacher)) die();
if(!isset($_GET['subject_id'])) return_error('subject_id is not set', 400);

$subject_id = $_GET['subject_id'];

$link = new Database();
$link = $link->connect();
$query = "SELECT * FROM exercises WHERE subject_id = '$subject_id'";
$result = mysqli_query($link, $query);
$exercises = array();
while($row = mysqli_fetch_assoc($result)) {
    $exercise = new Exercise($row['name'], $row['subject_id'], $row['text'], $row['teacher_id']);
    $exercise->id = $row['exercise_id'];
    $exercises[] = $exercise;
}

mysqli_close($link);

return_ok($exercises, 200);

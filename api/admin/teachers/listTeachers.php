<?php

require_once('/var/www/html/kursach2/helpers/result_helper.php');
require_once('/var/www/html/kursach2/models/user_model.php');
require_once('/var/www/html/kursach2/helpers/database.php');
require_once('/var/www/html/kursach2/helpers/validator.php');

if(!check_rights(Role::admin)) die();

$link = new Database();
$link = $link->connect();
$query = "SELECT * FROM teachers";
$result = mysqli_query($link, $query);
$teachers = array();

while($row = mysqli_fetch_assoc($result)) {
    $teacher = array(
        "id" => $row['id'],
        "name" => $row['teacher_name'],
        "email" => $row['email']
    );
    array_push($teachers, $teacher);
}

mysqli_close($link);

return_ok($teachers, 200);
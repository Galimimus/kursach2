<?php

// TODO: uncomment salt

require_once('/var/www/html/kursach2/helpers/result_helper.php');
require_once('/var/www/html/kursach2/models/user_model.php');
require_once('/var/www/html/kursach2/helpers/database.php');
require_once('/var/www/html/kursach2/helpers/validator.php');

if (!check_rights(Role::admin)) die();

check_get_field('email', 'string');
check_get_field('password', 'string');
check_get_field('name', 'string');

$name = $_GET['name'];
$pass = $_GET['password'];
$email = $_GET['email'];

$link = new Database();
$link = $link->connect();
//$this->password .= "fdfdsfdvhj";
//$pass = md5($pass);
$query = "INSERT INTO teachers (teacher_name, password, email) VALUES ('$name', '$pass', '$email')";

$result = mysqli_query($link, $query);

$id = mysqli_insert_id($link);
mysqli_close($link);

if ($result) {
    $user = array(
        "id" => $id,
        "name" => $name,
        "email" => $email,
        "role" => Role::teacher
    );

    return_ok($user, 200);
} else {
    return_error("Teacher not added", 400);
}

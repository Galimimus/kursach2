<?php

// TODO: uncomment salt

require_once('/var/www/html/kursach2/helpers/result_helper.php');
require_once('/var/www/html/kursach2/models/user_model.php');
require_once('/var/www/html/kursach2/helpers/database.php');
require_once('/var/www/html/kursach2/helpers/validator.php');

if (!check_rights(Role::admin)) die();
if (!isset($_GET['name'])) return_error("No name", 400);
if (!isset($_GET['password'])) return_error("No pass", 400);
if (!isset($_GET['email'])) return_error("No email", 400);

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

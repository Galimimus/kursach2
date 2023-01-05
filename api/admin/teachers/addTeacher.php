<?php

// TODO: uncomment salt

require_once('/var/www/html/kursach2/helpers/result_helper.php');
require_once('/var/www/html/kursach2/models/user_model.php');
require_once('/var/www/html/kursach2/helpers/database.php');
require_once('/var/www/html/kursach2/helpers/validator.php');

if (!check_rights(Role::admin)) die();
if (!isset($_GET['fio'])) return_error("No fio", 400);
if (!isset($_GET['pass'])) return_error("No pass", 400);

$fio = $_GET['fio'];
$pass = $_GET['pass'];

$link = new Database();
$link = $link->connect();
//$this->password .= "fdfdsfdvhj";
$pass = md5($pass);
$query = "INSERT INTO teachers (name, password) VALUES ('$fio', '$pass')";

$result = mysqli_query($link, $query);

mysqli_close($link);

if ($result) {
    return_ok("Teacher added", 200);
} else {
    return_error("Teacher not added", 400);
}

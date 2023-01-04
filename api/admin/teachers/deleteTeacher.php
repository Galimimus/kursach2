<?php

require_once('/var/www/html/kursach2/helpers/result_helper.php');
require_once('/var/www/html/kursach2/models/user_model.php');
require_once('/var/www/html/kursach2/helpers/database.php');
require_once('/var/www/html/kursach2/helpers/validator.php');

if(!check_rights(Role::admin)) die();
if(!isset($_GET['id'])) return_error("No id", 400);

$id = $_GET['id'];

$link = new Database();
$link = $link->connect();
$query = "DELETE FROM teachers WHERE id = $id";
$result = mysqli_query($link, $query);
mysqli_close($link);

if($result) {
    return_ok("Teacher deleted", 200);
} else {
    return_error("Teacher not deleted", 400);
}
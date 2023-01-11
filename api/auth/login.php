<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/models/user_model.php');
include_once $_SERVER['DOCUMENT_ROOT'].'/helpers/result_helper.php';


$email = $_GET['email'];
$pass = $_GET['password'];

switch ($_GET['role']) {
    case "admin_login":

        $user = new Admin($email, $pass);
        $res = $user->login();
        break;

    case "teacher_login":

        $user = new Teacher($email, $pass);
        $res = $user->login();
        break;

    case 'student_login':

        $user = new Student($email, $pass);
        $res = $user->login();
        break;

    default:
        return_error("Wrong role", 400);
        break;
}

if ($res) {
    $_SESSION['user'] = serialize($user);
    return_ok('authorised', 200);
} else {
    return_error("Wrong password", 401);
}
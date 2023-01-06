<?php
session_start();
require_once('/var/www/html/kursach2/models/user_model.php');
include_once '/var/www/html/kursach2/helpers/result_helper.php';

// TODO: get $email and $pass from switch

switch ($_GET['role']) {
    case "admin_login":

        $email = $_GET['email'];
        $pass = $_GET['password'];
        $admin = new Admin($email, $pass);
        $res = $admin->login();
        if ($res) {
            $_SESSION['user'] = serialize($admin);
            return_ok('authorised', 200);
        } else {
            return_error("Wrong password", 401);
        }
        break;

    case "teacher_login":

        $email = $_GET['email'];
        $pass = $_GET['password'];
        $name = $_GET['name'];
        $teacher = new Teacher($email, $pass, $name);
        $res = $teacher->login();
        if ($res) {
            $_SESSION['user'] = serialize($teacher);
            return_ok('authorised', 200);
        } else {
            return_error("Wrong password", 401);
        }
        break;

    case 'student_login':

        $email = $_GET['email'];
        $pass = $_GET['password'];
        $student = new Student($email, $pass);
        $res = $student->login();
        if ($res) {
            $_SESSION['user'] = serialize($student);
            return_ok('authorised', 200);
        } else {
            return_error("Wrong password", 401);
        }
        break;

    default:
        return_error("Wrong role", 400);
        break;
}

<?php
session_start();
require_once('/var/www/html/kursach2/models/user_model.php');
include_once '/var/www/html/kursach2/helpers/result_helper.php';

switch ($_GET['role']) {
    case "admin_login":

        $fio = $_GET['fio'];
        $pass = $_GET['pass'];
        $admin = new Admin($fio, $pass);
        $res = $admin->login();
        if ($res) {
            $_SESSION['user'] = serialize($admin);
            return_ok('authorised', 200);
        } else {
            return_error("Wrong password", 401);
        }
        break;

    case "teacher_login":

        $fio = $_GET['fio'];
        $pass = $_GET['pass'];
        $teacher = new Teacher($fio, $pass);
        $res = $teacher->login();
        if ($res) {
            $_SESSION['user'] = serialize($teacher);
            return_ok('authorised', 200);
        } else {
            return_error("Wrong password", 401);
        }
        break;

    case 'student_login':

        $fio = $_GET['fio'];
        $grade = $_GET['grade'];
        $pass = $_GET['pass'];
        $student = new Student($fio, $pass, $grade);
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

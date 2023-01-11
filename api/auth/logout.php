<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/result_helper.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/models/user_model.php');

session_start();
if (isset($_SESSION['user'])) {
    session_unset();
    session_destroy();
    return_ok('deauthorised', 200);
} else {
    return_error("Not authorised", 401);
}

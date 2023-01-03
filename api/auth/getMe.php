<?php
require_once('/var/www/html/kursach2/helpers/result_helper.php');
require_once('/var/www/html/kursach2/models/user_model.php');

session_start();
if (!isset($_SESSION['user'])) {
    return_error("Not authorised", 401);
} else {
    return_ok(unserialize($_SESSION['user']), 200);
}

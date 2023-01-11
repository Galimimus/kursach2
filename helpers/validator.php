<?php

//function for checking rights
function check_rights($rights)
{
    session_start();
    if (!isset($_SESSION['user'])) {
        return_error("Not authorised", 401);
        return false;
    }
    $user = unserialize($_SESSION['user']);
    if ($user->role != $rights) {
        return_error("Not enough rights", 403);
        return false;
    }
    return true;
}

function check_field($value, $type){
    switch ($type){
        case "int":
            return $value>0;
        case "string":
            return is_string($value) && $value!=="";
        default:
            return false;
    }
}

function check_get_field($field, $type){
    if(!isset($_GET[$field]) || !check_field($_GET[$field], $type)){
        return_error("$field is not set", 400);
        die();
    }
}
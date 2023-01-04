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
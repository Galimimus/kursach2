<?php
// create class database with connect function

use function PHPSTORM_META\type;

class Database
{
    public function connect()
    {
        $host = "sql7.freesqldatabase.com";
        $user = "sql7589709";
        $pass = "UTAQQcxLl4";
        $db = "sql7589709";
        $link = mysqli_connect($host, $user, $pass, $db);
        if (!$link) {
            return_error("Database connection error", 400);
        }
        mysqli_set_charset($link, "utf8");
        return $link;
    }


}


function check_query($res, $msg, $code){
    if(gettype($res) == "boolean" || gettype($res) == "integer"){
        if($res == 0){
            return_error($msg, $code);
        }
    }
    return $res;
}
<?php
// create class database with connect function

class Database{
    public function connect(){
        $host = "localhost";
        $user = "galimimus";
        $pass = "pass111";
        $db = "kursach";
        $link = mysqli_connect($host, $user, $pass, $db);
        mysqli_set_charset($link, "utf8");
        return $link;
    }
}
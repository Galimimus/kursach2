<?php
require_once('/var/www/html/kursach2/helpers/database.php');

// TODO: uncomment md5() in login() methods
// abstract class User with fields: id, fio, password

enum Role
{
    case admin;
    case teacher;
    case student;
}

class User
{
    public $id;
    public $fio;
    public $password;
    public Role $role;

    public function __construct($fio, $password)
    {
        $this->fio = $fio;
        $this->password = $password;
    }
}


// class Student extends User with fields: grade

class Student extends User
{
    public $grade;

    public function __construct($fio, $password, $grade)
    {
        parent::__construct($fio, $password);
        $this->grade = $grade;
        $this->role = Role::student;
    }

    public function login()
    {
        $link = new Database();
        $link = $link->connect();
        $query = "SELECT * FROM students WHERE student_name = '$this->fio' AND grade_name = '$this->grade'";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_assoc($result);
        //$this->password .= "fdfdsfdvhj";
        //$this->password = md5($this->password);
        if ($row['password'] == $this->password) {
            $this->id = $row['student_id'];
            return true;
        } else {
            return false;
        }
    }
}

//class Teacher extends User

class Teacher extends User
{
    public function __construct($fio, $password)
    {
        parent::__construct($fio, $password);
        $this->role = Role::teacher;
    }

    public function login()
    {
        $link = new Database();
        $link = $link->connect();
        $query = "SELECT * FROM teachers WHERE name = '$this->fio'";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_assoc($result);
        //$this->password .= "fdfdsfdvhj";
        $this->password = md5($this->password);
        if ($row['password'] == $this->password) {
            $this->id = $row['id'];
            return true;
        } else {
            return false;
        }
    }
}

// class Admin extends User

class Admin extends User
{
    public function __construct($fio, $password)
    {
        parent::__construct($fio, $password);
        $this->role = Role::admin;
    }

    public function login()
    {
        $link = new Database();
        $link = $link->connect();
        $query = "SELECT * FROM admins WHERE name = '$this->fio'";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_assoc($result);
        //$this->password .= "fdfdsfdvhj";
        //$this->password = md5($this->password);
        mysqli_close($link);
        if ($row['password'] == $this->password) {
            $this->id = $row['id'];
            return true;
        } else {
            return false;
        }
    }
}

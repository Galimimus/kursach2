<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/database.php');

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
    public $email;
    public $password;
    public Role $role;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }
}


// class Student extends User with fields: grade

class Student extends User
{
    public $grade;
    public $name;

    public function __construct($email, $password)
    {
        parent::__construct($email, $password);
        $this->role = Role::student;
    }

    public function login()
    {
        $link = new Database();
        $link = $link->connect();
        $query = "SELECT * FROM students WHERE email = '$this->email'";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_assoc($result);
        $this->password .= "fdfdsfdvhj";
        $this->password = md5($this->password);
        if ($row['password'] == $this->password) {
            $this->grade = $row['grade_name'];
            $this->name = $row['student_name'];
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
    
    public $name;

    public function __construct($email, $password, $name)
    {
        parent::__construct($email, $password);
        $this->name = $name;
        $this->role = Role::teacher;
    }

    public function login()
    {
        $link = new Database();
        $link = $link->connect();
        $query = "SELECT * FROM teachers WHERE email = '$this->email'";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_assoc($result);
        $this->password .= "fdfdsfdvhj";
        $this->password = md5($this->password);
        if ($row['password'] == $this->password) {
            $this->name = $row['teacher_name'];
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
    public function __construct($email, $password)
    {
        parent::__construct($email, $password);
        $this->role = Role::admin;
    }

    public function login()
    {
        $link = new Database();
        $link = $link->connect();
        $query = "SELECT * FROM admins WHERE name = '$this->email'";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_assoc($result);
        $this->password .= "fdfdsfdvhj";
        $this->password = md5($this->password);
        mysqli_close($link);
        if ($row['password'] == $this->password) {
            $this->id = $row['id'];
            return true;
        } else {
            return false;
        }
    }
}

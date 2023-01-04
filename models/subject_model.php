<?php
class Subject {
    public $id;
    public $name;
    public $teacher;
    public $grade;

    public function __construct($name, $teacher, $grade) {
        $this->name = $name;
        $this->grade = $grade;
        $this->teacher = $teacher;
    }
}
<?php
//class Exercise with fields: exercise_id, text, name, subject_id, teacher_id, name

class Exercise {
    public $id;
    public $name;
    public $subject_id;
    public $description;
    public $teacher_id;

    public function __construct($name, $subject_id, $description, $teacher_id) {
        $this->name = $name;
        $this->subject_id = $subject_id;
        $this->description = $description;
        $this->teacher_id = $teacher_id;
    }
}
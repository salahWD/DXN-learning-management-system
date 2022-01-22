<?php

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $info = [
      "title"       => $_POST["title"],
      "description" => $_POST["desc"],
      "is_enable"   => isset($_POST["private"]) ? 1: 2,
    ];
    
    $course = new Course();

    if ($user::USER_TYPE == 1) {
      if (isset($_POST["course_owner"]) && !empty($_POST["course_owner"]) && is_numeric($_POST["course_owner"])) {
        $info["course_owner"] = $_POST["course_owner"];
      }
    }
    
    $course->set_data($info);
    
    $user->insert_course($course);

    header("Location: " . theURL . language . "/manage-course");
    exit();

  }?>
<?php
  // this page is just for handling javascript data post
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["course"]) && !empty($_POST["course"]) && isset($_POST["order"]) && !empty($_POST["order"])) {
  
      $lecture = new Lecture();
  
      $lecture->course_id = intval($_POST["course"]);
      $lecture->order = intval($_POST["order"]);
      $lecture->set_data($lecture->get_item_type_id(intval($_POST["course"]), intval($_POST["order"])));
  
      $res = $lecture->item_pass($user->student_id);
      echo json_encode(["success" => $res]); 

    }else {
      echo json_encode(["success" => false]); 
    }
  }else {
    header("Location: " . theURL . language . "/home");
    exit();
  }

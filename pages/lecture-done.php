<?php
  // this page is just for handling javascript data post
  if (isset($_POST["course"]) && !empty($_POST["course"]) && isset($_POST["order"]) && !empty($_POST["order"])) {

    $lecture = new Lecture();

    $lecture->set_data(["course_id" => intval($_POST["course"]), "order" => intval($_POST["order"])]);

    if ($res = $lecture->item_pass($user->student_id)) {
      if ($res == true) {
        echo json_encode(["success" => true]); 
      }else {
        echo json_encode(["success" => false]); 
      }
    }else {
      echo json_encode(["success" => false]); 
    }
  }else {
    echo json_encode(["success" => false]); 
  }

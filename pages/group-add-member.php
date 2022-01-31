<?php

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    if ($_POST["request"] == "get-addable-members") {
      
      echo json_encode([
        ["id" => 9, "name" => "salah"],
        ["id" => 12, "name" => "baraa"],
        ["id" => 15, "name" => "zober"],
      ]);
    }
    // $group_id   = intval($URL[2]);
    // $member_id  = intval($_POST["member_id"]);

  }else {
    header("Location: " . theURL . language . "/dashboard-" . strtolower(get_class($user)));
    exit();
  }
?>
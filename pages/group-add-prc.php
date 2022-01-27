<?php

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $info = [
      "name"        => $_POST["name"],
      "description" => $_POST["desc"],
      "teacher_id"  => $user->teacher_id,
      "icon"        => isset($_posT["icon"]) && is_numeric($_posT["icon"]) ? intval($_posT["icon"]) : 1,
    ];
    
    if (isset($_POST["path"]) && !empty($_POST["path"]) && is_numeric($_POST["path"])) {
      $info["path_id"] = intval($_POST["path"]);
    }
    
    $group = new Group();

    $group->set_data($info);
    
    $group->add_group();

    header("Location: " . theURL . language . "/manage-groups");
    exit();

  }?>
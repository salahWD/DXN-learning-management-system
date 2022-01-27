<?php

  if ($_SERVER["REQUEST_METHOD"] == "POST"):

    $permission = false;// triger for permission

    $group_id = intval($URL[2]);

    $group = new Group();
    $group->id = $group_id;

    if ($user::USER_TYPE == 2):
      $groups = $group->get_id_by_teacher($user->teacher_id);
      $groups = array_column($groups, 'id');

      if (in_array($group_id, $groups)):
        $permission = true;
      endif;
    elseif($user::USER_TYPE == 1):
      $permission = true;
    endif;


    if ($permission):

      $info = [
        "id"          => $group_id,
        "teacher_id"  => $user->teacher_id,
        "path_id"     => NULL,
        "name"        => $_POST["name"],
        "description" => $_POST["desc"],
        "icon_id"     => isset($_POST["icon"]) && !empty($_POST["icon"]) && is_numeric($_POST["icon"]) ? intval($_POST["icon"]): 1,
      ];

      if (isset($_POST["path"]) && !empty($_POST["path"]) && is_numeric($_POST["path"])):
        if ($user::USER_TYPE == 2):
          $paths = array_column($user->get_paths(), "id");
          if (in_array($_POST["path"], $paths)) {
            $info["path_id"] = $_POST["path"];
          }
        endif;
      endif;

      $group->set_data($info);

      $group->update_group();

      header("Location: " . theURL . language . "/manage-groups/");
      exit();
      
    endif;

  endif;?>


  <div class="container">
    <div class="alert alert-danger text-center mt-4">
      <h3>لا يمكن الوصول</h3>
      <p class="lead">يبدو انك لا تمتلك صلاحيات التعديل على هذه المجموعة</p>
    </div>
  </div>

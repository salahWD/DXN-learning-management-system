<?php

$group_id = intval($URL[2]);
  $permission = false;// triger for permission

  if ($user::USER_TYPE == 2):
    $groups = array_column(Group::get_id_by_teacher($user->teacher_id), 'id');

    if (in_array($group_id, $groups)):
      $permission = true;
    endif;
  elseif($user::USER_TYPE == 1):
    $permission = true;
  endif;

  if ($permission):
    $result = Group::delete_group($group_id);

    if ($result):
      header("Location: " . theURL . language . "/manage-groups");
      exit();
    endif;

  else:
    header("Location: " . theURL . language . "/dashboard-" . strtolower(get_class($user)));
    exit();
  endif;

?>
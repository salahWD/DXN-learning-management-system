<?php

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $pass = false;
    $group_id   = intval($URL[2]);

    if ($user::USER_TYPE == 2):
      $groups = array_column(Group::get_id_by_teacher($user->teacher_id), "id");
      if (in_array($group_id, $groups)):
        $pass = true;
      endif;
    else:
      $pass = true;
    endif;

    if ($pass) {

      if ($_POST["request"] == "get-addable-members") {
        
        echo json_encode(Group::get_bot_members_students($user->dxnid, $user->teacher_id));

      }elseif ($_POST["request"] == "add-member") {

        $member_id  = intval($_POST["member_id"]);

        // check if this member is downline
        echo json_encode(Group::add_member($group_id, $member_id));

      }elseif ($_POST["request"] == "delete-member") {
        
        $member_id  = intval($_POST["member_id"]);

        // check if this member is downline
        echo json_encode(Group::delete_member($group_id, $member_id));

      }else {
        echo json_encode(false);
        exit();
      }
    }else {
      echo json_encode(false);
      exit();
    }

  }else {
    echo json_encode(false);
    exit();
  }
?>
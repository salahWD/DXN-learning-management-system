<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $group_id       = intval($URL[2]);
    
    $pass = false;// trigger for permission check
  
    if ($user::USER_TYPE == 2):
      $groups = array_column(Group::get_id_by_teacher($user->teacher_id), "id");
      if (in_array($group_id, $groups)):
        $pass = true;
      endif;
    else:
      $pass = true;
    endif;
    
    if ($pass) {
      if ($_POST["request"] == "add-course") {// add course to path

        $course_id  = intval($_POST["course_id"]);
        $path_id    = Group::get_path_id($group_id);

        if (Path::add_course($path_id, $course_id)) {
          echo json_encode(Course::get_course($course_id));
        }else {
          echo json_encode(false);
        }

      }else if ($_POST["request"] == "get-addable-courses") {// delete course from path
        $path_id    = Group::get_path_id($group_id);
        echo json_encode(Path::get_addable_courses_id_name($user->teacher_id, $path_id));

      }else if ($_POST["request"] == "reorder-course") {// delete course from path
        
        $course_id      = intval($_POST["course_id"]);
        $new_order      = intval($_POST["new_order"]);
        
        echo json_encode(Path::update_course_order($group_id, $course_id, $new_order));
        
      }else if ($_POST["request"] == "delete-course") {// delete course from path

        $course_id      = intval($_POST["course_id"]);

        echo json_encode(Path::delete_course_from_path_by_group($course_id, $group_id));

      }else {
        header("Location: " . theURL . language . "/error.php");
        exit();
      }
    }else {
      header("Location: " . theURL . language . "/error.php");
      exit();
    }
  }
?>
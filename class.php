<?php

class page {
  public $id;
  public $name;
  public $title;
  public $meta;
  public $type;
  public $components;
  public $arguments;
  public $file;
  public $thumb;
  public $description;
  public $mini_description;
  public $featured_img;
  public $language;


  public function set_data($data) {
    
    if (!empty($data["id"])) {
      $this->id = $data["id"];
    }
    if (!empty($data["name"])) {
      $this->name = $data["name"];
    }
    if (!empty($data["title"])) {
      $this->title = $data["title"];
    }
    if (!empty($data["meta"])) {
      $this->meta = $data["meta"];
    }
    if (!empty($data["type"])) {
      $this->type = $data["type"];
    }
    if (!empty($data["components"])) {
      $this->components = $data["components"];
    }
    if (!empty($data["arguments"])) {
      $this->arguments = $data["arguments"];
    }
    if (!empty($data["file"])) {
      $this->file = $data["file"];
    }
    if (!empty($data["thumb"])) {
      $this->thumb = $data["thumb"];
    }
    if (!empty($data["description"])) {
      $this->description = $data["description"];
    }
    if (!empty($data["mini_description"])) {
      $this->mini_description = $data["mini_description"];
    }
    if (!empty($data["featured_img"])) {
      $this->featured_img = $data["featured_img"];
    }
    if (!empty($data["language"])) {
      $this->language = $data["language"];
    }
  }

  public function get_page($page_name) {

    global $conn;

    $page = $conn->prepare("SELECT * FROM pages WHERE `name` = ?");
    $page->execute([$page_name]);

    if ($page->rowCount() > 0) {
      return $page->fetch(PDO::FETCH_ASSOC);
    }else {
      return false;
    }

  }

}



class User {
  public $id     ;
  public $username     ;
  public $fullname     ;
  public $dxnid        ;
  public $dxn_upline   ;
  public $password     ;
  public $email        ;
  public $mobile       ;
  public $country      ;
  public $birthdate    ;
  public $job          ;
  public $address      ;
  public $gander       ;
  public $image        ;
  public $registerdate ;
  public $thumbimage   ;
  
  protected function create_user() {
    global $conn;
    $stmt = $conn->prepare(
      "INSERT INTO
              users (username, fullname, dxnid, dxn_upline, password, email, mobile, country, birthdate, job, address, gander, registerdate)
      VALUES
              (:username, :fullname, :dxnid, :dxn_upline, :password, :email, :mobile, :country, :birthdate, :job, :address, :gander, NOW())");
    if ($stmt->execute([
      ":username"       => $this->username,
      ":fullname"       => $this->fullname,
      ":dxnid"          => $this->dxnid,
      ":dxn_upline"     => $this->dxn_upline,
      ":password"       => $this->password,
      ":email"          => $this->email,
      ":mobile"         => $this->mobile,
      ":country"        => $this->country,
      ":birthdate"      => $this->birthdate,
      ":job"            => $this->job,
      ":address"        => $this->address,
      ":gander"         => $this->gander,
    ])) {
      return true;
    }else {
      return false;
    }
  }// end of register method

  protected function delete_user($id) {
    /*
      takes: $id wich is user_id
      does: removes user from users table
      returns: on success true : on fail false
    */

    global $conn;

    $stmt = $conn->prepare(
      "DELETE FROM users WHERE users.id = ?"); 

    if ($stmt->execute([$id])) {
      return true;
    }else {
      return false;
    }

  }// end of delete_admin method

}// end of class user



class Group {
  public $id;
  public $name;
  public $path_id = false;// if no id it stil false
  public $members = [];
  public $teacher_id;

  public static function get_all() {
    /*  
      retuturn: gets all of groups
    */

    global $conn;

    $stmt = $conn->prepare("SELECT * FROM groups");
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }else {
      return false;
    }

  }// array > object group[*]

  public static function get_all_by_teacher($teacher_id) {
    /*  
      takes   : teacher id
      retuturn: gets all of teacher's groups
    */

    global $conn;

    $stmt = $conn->prepare("SELECT * FROM groups WHERE groups.teacher_id = ?");
    $stmt->execute([$teacher_id]);

    if ($stmt->rowCount() > 0) {
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }else {
      return false;
    }

  }// array > object group[*]{teacher_id}

}


class Student extends User {
  public $student_id;
  public $main_courses;
  const USER_TYPE = 3;


  /*=========== Process Methods ===========*/
  /*=========== Create Methods ===========*/

  public function create_student() {
    /*
      does : inserts new students table
      returns : boolian true | false
    */

    global $conn;

    $this->create_user();

    $stmt = $conn->prepare("SELECT id FROM users WHERE dxnid = ?");
    $stmt->execute([$this->dxnid]);
    if ($stmt->rowCount() > 0) {
      $this->id = $stmt->fetch(PDO::FETCH_ASSOC)["id"];
    }else {
      echo "ther is an error go check your code.";// error
      exit();
    }
    
    $stmt = $conn->prepare("INSERT INTO students (`user_id`) VALUES (?)");
    if ($stmt->execute([$this->id])) {
      return true;
    }else {
      return false;
    }

  }// boolian true | false

  public function login($dxnid, $pass) {
    
    global $conn;
    
    // get user info
    $stmt = $conn->prepare(
      "SELECT users.*, students.*, students.id AS student_id, users.id AS `user_id`
      FROM users
      INNER JOIN students
      ON students.user_id = users.id
      WHERE dxnid = ? AND password = ?");

    $stmt->execute([$dxnid, sha1($pass)]);

    if ($stmt->rowCount() > 0) {

      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      
      $this->set_student($result);

      return true;

    }else {
      return false;
    }

  }// boolian true | false

  public function set_student($info) {
    /*
      ====== sets members to the object
    */

    if (isset($info['id']) && !empty($info['id'])) {
      $this->id = $info['id'];
    }
    if (isset($info['user_id']) && !empty($info['user_id'])) {
      $this->id = $info['user_id'];
    }
    if (isset($info['username']) && !empty($info['username'])) {
      $this->username = $info['username'];
    }
    if (isset($info['fullname']) && !empty($info['fullname'])) {
      $this->fullname = $info['fullname'];
    }
    if (isset($info['dxnid']) && !empty($info['dxnid'])) {
      $this->dxnid = $info['dxnid'];
    }
    if (isset($info['dxn_upline']) && !empty($info['dxn_upline'])) {
      $this->dxn_upline = $info['dxn_upline'];
    }
    if (isset($info['password']) && !empty($info['password'])) {
      $this->password = $info['password'];
    }
    if (isset($info['email']) && !empty($info['email'])) {
      $this->email = $info['email'];
    }
    if (isset($info['mobile']) && !empty($info['mobile'])) {
      $this->mobile = $info['mobile'];
    }
    if (isset($info['country']) && !empty($info['country'])) {
      $this->country = $info['country'];
    }
    if (isset($info['birthdate']) && !empty($info['birthdate'])) {
      $this->birthdate = $info['birthdate'];
    }
    if (isset($info['job']) && !empty($info['job'])) {
      $this->job = $info['job'];
    }
    if (isset($info['address']) && !empty($info['address'])) {
      $this->address = $info['address'];
    }
    if (isset($info['gander']) && !empty($info['gander'])) {
      $this->gander = $info['gander'];
    }
    if (isset($info['image']) && !empty($info['image'])) {
      $this->image = $info['image'];
    }
    if (isset($info['registerdate']) && !empty($info['registerdate'])) {
      $this->registerdate = $info['registerdate'];
    }
    if (isset($info['thumbimage']) && !empty($info['thumbimage'])) {
      $this->thumbimage = $info['thumbimage'];
    }
    if (isset($info['student_id']) && !empty($info['student_id'])) {
      $this->student_id = $info['student_id'];
    }
    if (isset($info['main_courses']) && !empty($info['main_courses'])) {
      $this->main_courses = $info['main_courses'];
    }

  }

  /*=========== Retrieve Methods ===========*/
  
  public function get_course_from_session($course_id) {
    
    foreach ($this->main_courses as $course) {
      if ($course->id == $course_id) {
        return $course;
      }
    }
    return false;
  }// object course[1]{course_id in session}
  
  public function get_student($id) {
    /*
      returns : student info
    */

    global $conn;
    
    // get student info
    $stmt = $conn->prepare("SELECT users.*, students.*, students.id AS student_id, users.id AS `user_id`
                            FROM users
                            INNER JOIN students
                            ON students.user_id = users.id
                            WHERE users.id = ?");

    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
      return$stmt->fetch(PDO::FETCH_ASSOC);
    }else {
      return false;
    }
  }// array student_info[1]{student_id}

  public function get_course_status($course_id) {
    /*
      takes : course id
      does  : get course status
      return: 1 = close, 2 = open, 3 = done
    */

    global $conn;
    
    $all_items = $conn->prepare(
      "SELECT items_order.id FROM items_order WHERE items_order.course_id = ?");

    $all_items->execute([$course_id]);

    if ($all_items->rowCount() > 0) {
    
      $all_items = $all_items->fetchAll(PDO::FETCH_ASSOC);

      $finished_items = $conn->prepare(
        "SELECT student_pass.item_order_id AS id
        FROM student_pass
        INNER JOIN items_order ON items_order.id = student_pass.item_order_id
        WHERE items_order.course_id = ? AND student_pass.student_id = ?");

      $finished_items->execute([$course_id, $this->student_id]);

      if ($finished_items->rowCount() > 0) {

        $finished_items     = $finished_items->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($all_items as $index => $item):
          if (!in_array($item, $finished_items)) {
            return 2;// it is open but not finish
          }
        endforeach;
          
        return 3;// finished all the lectures

      }else {
        return 1;// did't finish any lecture
      }
      
    }else {
      return 1;// course is empty [no items inside the course]
    }
  }// number 1 = close, 2 = open, 3 = done

  public function get_courses_path() {
    /*
      return: courses path
    */
    
    global $conn;
   
    // get student group then path then courses he most complate
    $stmt = $conn->prepare(
      "SELECT courses.id, courses.title, courses.description, courses.date FROM users AS user
      INNER JOIN students ON students.user_id = user.id
      INNER JOIN students_groups ON students_groups.student_id = students.id
      INNER JOIN groups ON groups.id = students_groups.group_id
      INNER JOIN paths ON paths.id = groups.path_id
      INNER JOIN paths_courses ON paths_courses.path_id = paths.id
      INNER JOIN courses ON courses.id = paths_courses.course_id
      WHERE user.id = ? ORDER BY paths_courses.order");

    $stmt->execute([$this->id]);

    if ($stmt->rowCount() > 0) {

      $courses_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    }else {// if teacher have't priority_courses
      
      // get teacher's main path for current student [ to see if current course is on main path to let him show items inside current course ]
      $stmt = $conn->prepare(
        "SELECT courses.id, courses.title, courses.description, courses.date FROM users AS user
        INNER JOIN users AS teacher ON teacher.dxnid = user.dxn_upline
        INNER JOIN teachers ON teachers.user_id = teacher.id
        INNER JOIN paths ON paths.teacher_id = teachers.id
        INNER JOIN paths_courses ON paths_courses.path_id = paths.id
        INNER JOIN courses ON courses.id = paths_courses.course_id
        WHERE paths.is_main = 1 AND user.id = ? ORDER BY paths_courses.order
      ");
      $stmt->execute();
      if ($stmt->rowCount() > 0) {

        $courses_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
      }else {
        echo "There is no group's main path and default courses";
        exit();
      }
    }

    // create objcts
    $courses = [];
    foreach ($courses_data as $crs) {
      $course = new Course();
      $course->set_data($crs);
      array_push($courses, $course);
    }

    for ($i=0; $i < count($courses); $i++) { 
      $course_status = $this->get_course_status($courses[$i]->id);// 1 close 2 open 3 finished
      $courses[$i]->show_status = $course_status;
      if ($course_status == 2) {
        break;
      }
      if ($course_status == 1) {
        $courses[$i]->show_status = 2;
        break;
      }
    }

    return $courses;// array of courses objects

  }// array object course[*]{in main path}

  /*=========== Update Methods ===========*/
  /*=========== Delete Methods ===========*/

}// end of class Student



class Teacher extends User {
  const USER_TYPE = 2;
  public $courses;
  public $teacher_id;
  public $accessible_courses = [];

  public function create_teacher() {
    /*
      takes: nothing
      does: inserts on users and teachers tables based on $this->info
      returns: on success true | on faild false
    */

    global $conn;
    
    if ($this->create_user()) {
      $stmt = $conn->prepare("SELECT id FROM users WHERE dxnid = ?");
      $stmt->execute([$this->dxnid]);
      $this->id = $stmt->fetch(PDO::FETCH_ASSOC)["id"];
    }else {
      echo "error on insertation";
      exit();
    }
    
    $stmt = $conn->prepare("INSERT INTO teachers (`user_id`) VALUES (?)");
    if ($stmt->execute([$this->id])) {
      return true;
    }else {
      return false;
    }

  }// end of create_teacher method

  public function insert_course($course_obj) {
    /* 
      takes     : course object
      does      : inserts new course for this teacher
      returns   : course id | false
    */

    global $conn;

    // Get Course_Id After It Inserted
    $course_id = $course_obj->insert_course();

    // teachers_courses Table Insert
    $stmt = $conn->prepare(
      "INSERT INTO `teachers_courses` (`course_id`, `teacher_id`, `permission_id`, `permission_giver`) VALUES (?, ?, '1', ?)");

    if ($stmt->execute([$course_id, $this->teacher_id, $this->teacher_id])) {
      return $course_id;
    }else {
      return false;
    }


  }// insert course

  public function set_teacher($info) {
    /*
      takes $info wich is an array containes the info bellow
      sets members to the object
    */

    $this->id            = isset($info['user_id'])        ? $info['user_id']:       NULL;
    $this->teacher_id    = isset($info['id'])             ? $info['id']:            NULL;// teacher_id
    $this->username      = isset($info['username'])       ? $info['username']:      NULL;
    $this->fullname      = isset($info['fullname'])       ? $info['fullname']:      NULL;
    $this->dxnid         = isset($info['dxnid'])          ? $info['dxnid']:         NULL;
    $this->dxn_upline    = isset($info['dxn_upline'])     ? $info['dxn_upline']:    NULL;
    $this->password      = isset($info['password'])       ? $info['password']:      NULL;
    $this->email         = isset($info['email'])          ? $info['email']:         NULL;
    $this->mobile        = isset($info['mobile'])         ? $info['mobile']:        NULL;
    $this->country       = isset($info['country'])        ? $info['country']:       NULL;
    $this->birthdate     = isset($info['birthdate'])      ? $info['birthdate']:     NULL;
    $this->job           = isset($info['job'])            ? $info['job']:           NULL;
    $this->address       = isset($info['address'])        ? $info['address']:       NULL;
    $this->gander        = isset($info['gander'])         ? $info['gander']:        NULL;
    $this->image         = isset($info['image'])          ? $info['image']:         NULL;
    $this->registerdate  = isset($info['registerdate'])   ? $info['registerdate']:  NULL;
    $this->thumbimage    = isset($info['thumbimage'])     ? $info['thumbimage']:    NULL;
    $this->accessible_courses    = isset($info['permissions'])     ? $info['permissions']:    NULL;
  }// end of method set_teacher

  public function get_teacher($id) {
    /*
      takes $id wich is the user_id
      gets important info from DB
    */

    global $conn;
    
    $stmt = $conn->prepare(
      "SELECT users.*, teachers.*
      FROM users
      INNER JOIN teachers
      ON teachers.user_id = users.id
      WHERE users.id = ?");

    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
    
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      $this->set_teacher($result);
      
    }else {
      echo '<h1>error get_teacher [ther is no row count]</h1>';// debug
      $this->__destruct();
      exit();
    }
  }// array teacher_info[1]{id}

  public function login($dxnid, $pass) {
    
    global $conn;

    $stmt = $conn->prepare(
      "SELECT users.*, teachers.*
      FROM users
      INNER JOIN teachers
      ON teachers.user_id = users.id
      WHERE dxnid = ? AND password = ?");

    $stmt->execute([$dxnid, sha1($pass)]);

    if ($stmt->rowCount() > 0) {
    
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      $this->set_teacher($result);
      
    }else {
      echo '<h1>You are not a teacher</h1>';// debug
      exit();
    }

  }// boolian true | false

  public function get_own_courses() {
    /*
      returns all courses that teacher have access on it as [
        [id of course] ==>> permission that he have
      ]
    */

    global $conn;

    $courses_data = $conn->prepare("SELECT permissions.value as permission, courses.*
        FROM teachers_courses
        INNER JOIN courses
        ON courses.id = teachers_courses.course_id
        INNER JOIN permissions
        ON permissions.id = teachers_courses.permission_id
        WHERE teachers_courses.teacher_id = ?");
    $courses_data->execute([$this->teacher_id]);

    if ($courses_data->rowCount() > 0) {
      
      $courses_data = $courses_data->fetchAll(PDO::FETCH_ASSOC);

      $data = [];

      foreach ($courses_data as $course) {
        $course_obj = new Course();
        $course_obj->set_data($course);
        $data[$course["id"]] = $course_obj;
      }
      
      return $data;
    }else {
      return false;
    }

  }// array > object course[*]{permission}

}// end of class Teacher



class Admin extends User {
  const USER_TYPE = 1;
  public $courses; 
  public $accessible_courses = []; 

  public function set_admin($info) {
    /*
      takes $info wich is an array containes the info bellow
      sets members to the object
    */

    if (isset($info['id']) && !empty($info['id'])) {
      $this->id = $info['id'];
    }
    if (isset($info['username']) && !empty($info['username'])) {
      $this->username = $info['username'];
    }
    if (isset($info['fullname']) && !empty($info['fullname'])) {
      $this->fullname = $info['fullname'];
    }
    if (isset($info['dxnid']) && !empty($info['dxnid'])) {
      $this->dxnid = $info['dxnid'];
    }
    if (isset($info['dxn_upline']) && !empty($info['dxn_upline'])) {
      $this->dxn_upline = $info['dxn_upline'];
    }
    if (isset($info['password']) && !empty($info['password'])) {
      $this->password = $info['password'];
    }
    if (isset($info['email']) && !empty($info['email'])) {
      $this->email = $info['email'];
    }
    if (isset($info['mobile']) && !empty($info['mobile'])) {
      $this->mobile = $info['mobile'];
    }
    if (isset($info['country']) && !empty($info['country'])) {
      $this->country = $info['country'];
    }
    if (isset($info['birthdate']) && !empty($info['birthdate'])) {
      $this->birthdate = $info['birthdate'];
    }
    if (isset($info['job']) && !empty($info['job'])) {
      $this->job = $info['job'];
    }
    if (isset($info['address']) && !empty($info['address'])) {
      $this->address = $info['address'];
    }
    if (isset($info['gander']) && !empty($info['gander'])) {
      $this->gander = $info['gander'];
    }
    if (isset($info['image']) && !empty($info['image'])) {
      $this->image = $info['image'];
    }
    if (isset($info['registerdate']) && !empty($info['registerdate'])) {
      $this->registerdate = $info['registerdate'];
    }
    if (isset($info['thumbimage']) && !empty($info['thumbimage'])) {
      $this->thumbimage = $info['thumbimage'];
    }
  
  }// end of method set_admin

  public function login($dxnid, $pass) {
    
    global $conn;
    
    $stmt = $conn->prepare("SELECT users.*, admins.*, users.id as id
                            FROM users
                            INNER JOIN admins
                            ON admins.user_id = users.id
                            WHERE dxnid = ? AND password = ?");

    $stmt->execute([$dxnid, sha1($pass)]);

    if ($stmt->rowCount() > 0) {
    
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->set_admin($result);

    }else {
      echo '<h1>error login [ther is no row count]</h1>';// debug
      $this->__destruct();
    }

  }// end of login method

  public function get_admin($id) {
    /*
      takes $id wich is the user_id
      gets important info from DB
    */

    global $conn;
    
    $stmt = $conn->prepare(
      "SELECT users.*, admins.*
      FROM users
      INNER JOIN admins ON admins.user_id = users.id
      WHERE users.id = ?");

    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
    
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->set_admin($result);
      
    }else {
      echo '<h1>error get_admin [ther is no row count]</h1>';// debug
      $this->__destruct();
    }
  }// end of get_admin method

}// end of class Admin



class Course {
  public $id;
  public $date;
  public $title;
  public $parent;// if it's sub course
  public $items = [];
  public $is_enable;// to show it
  public $creator_id;
  public $show_status = 1;// 1 close 2 open 3 finished
  public $permission;
  public $description;
  public $errors = [];

  /*=========== Process Methods ===========*/

  private function check_data() {
    /* 
      does      : check and validate every property
      returns   : true | false
    */

    if (empty($this->title)) {
      $this->errors["title"] = "course name can't be empty";
    }
    if (empty($this->description)) {
      $this->errors["description"] = "description can't be empty";
    }

    return !(count($this->errors) > 0);

  }

  public function check_permission($check) {
    /* 
      does      : check permission and allowances
      returns   : true | false
    */

    if (isset($this->permission) && !empty($this->permission) && is_numeric($this->permission)) {

      $keys = [
        "OWNER"           => 0,
        "CREATE"          => 1,
        "UPDATE"          => 2,
        "DELETE"          => 3,
        "ADD_TEACHERS"    => 4,
        "CLONE"           => 5,
      ];

      return $this->permission[$keys[$check]];

    }else {
      return false;
    }

  }// boolian true | false{permission}
  
  private function order($items) {
    /*
      takes     : $items array of items
      does      : orders items by "order"
      returns   : ordered items
    */

    for ($i=0; $i < count($items); $i++) {

      $min = $items[$i];
      $max = $items[$i];

      for ($j = $i + 1;$j < count($items); $j++):
        if ($min->order > $items[$j]->order) {
          $max = $min;
          $min = $items[$j];
          $items[$j] = $max;
          $items[$i] = $min;
        }
      endfor;

    }
    
    return $items;

  }// array > object Lecture | Exam[*]{order}

  public function mark_watched_items($student_id, $items) {
    /*
      takes     : Array Of Items
      does      : Gets All Watched items and compare it with given items
      returns   : array of objects [in every object there is a is_open]
    */

    global $conn;

    // get finished items items_order.order_id
    $finished_items_data = $conn->prepare(
      "SELECT student_pass.item_order_id AS id
      FROM student_pass
      INNER JOIN items_order ON items_order.id = student_pass.item_order_id
      WHERE items_order.course_id = ? AND student_pass.student_id = ?");

    $finished_items_data->execute([$this->id, $student_id]);

    if ($finished_items_data->rowCount() > 0) {

      $finished_items_data = $finished_items_data->fetchAll(PDO::FETCH_NUM);

      // extract the [value into array into array] and make it [value into array]
      $finished_items = array();
      foreach ($finished_items_data as $value) {
        array_push($finished_items, $value[0]);
      }

      // check if lecture is open or not
      for ($i=0; $i < count($items); $i++):
        if (in_array($items[$i]->order_id, $finished_items)):
          $items[$i]->show_status = 3;
        else:
          $items[$i]->show_status = 2;
          break;
        endif;
      endfor;

    }else {
      $items[0]->show_status = 2;
    }

    return $items;

  }// array > object Lecture | Exam[*](show_status)

  /*=========== Create Methods ===========*/

  public function set_data($info) {
    /* 
      takes $data wich is an array containes members bellow
      sets given data to the object
    */

    if (isset($info['id']) && !empty($info['id'])) {
      $this->id = $info['id'];
    }
    if (isset($info['date']) && !empty($info['date'])) {
      $date = date_create($info['date']);
      $this->date = date_format($date, 'Y-m-d');
    }
    if (isset($info['level']) && !empty($info['level'])) {
      $this->level = $info['level'];
    }
    if (isset($info['title']) && !empty($info['title'])) {
      $this->title = $info['title'];
    }
    if (isset($info['parent']) && !empty($info['parent'])) {
      $this->parent = $info['parent'];
    }
    if (isset($info['is_enable']) && !empty($info['is_enable'])) {
      $this->is_enable = $info['is_enable'];
    }
    if (isset($info['teacher_id']) && !empty($info['teacher_id'])) {
      $this->creator_id = $info['teacher_id'];
    }
    if (isset($info['permission']) && !empty($info['permission'])) {
      $this->permission = $info['permission'];
    }
    if (isset($info['is_primary']) && !empty($info['is_primary'])) {
      $this->is_primary = $info['is_primary'];
    }
    if (isset($info['description']) && !empty($info['description'])) {
      $this->description = $info['description'];
    }
    if (isset($info['items']) && !empty($info['items'])) {
      $this->items = $info['items'];
    }
  
  }// set data to object

  public function insert_course() {
    /*
      does    : insert new course
      returns : inserted course id || false
    */
    
    global $conn;

    if ($this->check_data()) {// data is valid

      // courses Table Insert
      $stmt = $conn->prepare(
        "INSERT INTO courses (`title`, `description`, `is_enable`, `date`)
        VALUES (:title, :description, :is_enable, NOW())");
  
      if ($stmt->execute([
        ":title"        => $this->title,
        ":description"  => $this->description,
        ":is_enable"    => $this->is_enable,
      ])) {
        // Get Course_Id After It Inserted
        return $this->id = $conn->lastInsertId();
      }else {
        return false; 
      }
    }else {
      foreach ($this->errors as $err) {
        echo $err . "<br>";
      }
    }
  }// insert into courses table

  /*=========== Retrieve Methods ===========*/

  static public function get_courses_by_teacher_id($teacher_id) {
    /*
      takes teacher id
      returns all accessible courses
    */

    global $conn;

    $stmt = $conn->prepare(
      "SELECT courses.* FROM teachers_courses
      INNER JOIN courses ON teachers_courses.course_id = courses.id
      WHERE teachers_courses.teacher_id = ?");
    $stmt->execute([$teacher_id]);

    if ($stmt->rowCount() > 0) {
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }else {
      return false;
    }

  }// object course[*]{accessible}
  
  static public function get_courses_all() {
    /*
      takes nothig
      returns All Courses
    */

    global $conn;

    $stmt = $conn->prepare("SELECT courses.* FROM courses");
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      $courses_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $courses = [];
      foreach ($courses_data as $course) {
        $course_obj = new Course();
        $course_obj->set_data($course);
        array_push($courses, $course_obj);
      }
      return $courses;
    }else {
      return false;
    }

  }// object course[*]{*}

  public function get_course() {
    /* 
      does  : gets all course data
      return: info | false
    */

    global $conn;
    
    $get_course_data = $conn->prepare("SELECT courses.* FROM courses WHERE courses.id = ?");
    $get_course_data->execute([$this->id]);

    
    if ($get_course_data->rowCount() > 0) {
      return $get_course_data->fetch(PDO::FETCH_ASSOC);
    }else {
      return false;
    }

  }// object course[1]{id}
  
  public function get_items_id_name() {
    /*
      does    : gets all items, IDs for this course
      returns : array of objects | false
    */

    global $conn;

    // get lectures
    $stmt = $conn->prepare(
      "SELECT lectures.id, lectures.title, items_order.order FROM items_order
      INNER JOIN lectures ON lectures.id = items_order.item_id
      WHERE items_order.item_type = 1 AND items_order.course_id = ?");

    $stmt->execute([$this->id]);

    $lectures = [];
    // create lectures objects
    if ($stmt->rowCount() > 0) {
      $lectures_obj = $stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach ($lectures_obj as $obj):
        $lctr_obj = new Lecture();
        $lctr_obj->set_data($obj);
        array_push($lectures, $lctr_obj);
      endforeach;
    }
    
    // get exams
    $stmt = $conn->prepare(
      "SELECT exams.id, exams.title, items_order.order FROM items_order
      INNER JOIN exams ON exams.id = items_order.item_id
      WHERE items_order.item_type = 2 AND items_order.course_id = ?");

    $stmt->execute([$this->id]);

    $exams = [];
    // create exams objects
    if ($stmt->rowCount() > 0) {
      $exams_obj = $stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach ($exams_obj as $obj):
        $exm_obj = new Lecture();
        $exm_obj->set_data($obj);
        array_push($exams, $exm_obj);
      endforeach;
    }

    $all_items = array_merge($lectures, $exams);

    if (count($all_items) > 0) {
      return $this->order(array_merge($lectures, $exams));
    }else {
      return false;
    }

  }// array object Lecture | Exam[*]{in this course}

  public function get_teacher_permission($teacher_id) {
    /*
      takes: $teacher_id wich is teacher id
      does: return permission of teacher on this course
      returns: [permission] | false
    */

    global $conn;

    $stmt = $conn->prepare(
      "SELECT permissions.value FROM teachers_courses
      INNER JOIN permissions ON permissions.id = teachers_courses.permission_id
      WHERE course_id = ? AND teacher_id = ?");

    $stmt->execute([$this->id, $teacher_id]);
    if ($stmt->rowCount() > 0) {
      return $stmt->fetch(PDO::FETCH_ASSOC)["value"];
    }else {
      return false;
    }

  }// Number Permission

  /*=========== Update Methods ===========*/

  /*=========== Delete Methods ===========*/

  public function delete_course() {
    /*
      does  : removes all course info
      return: true | false
    */

    global $conn;
    
    # Delete Teachers Permission
    $stmt = $conn->prepare("DELETE FROM teachers_courses WHERE course_id = ?");
    $result = $stmt->execute([$this->id]);
    if (!$result) {
      return false;
    }
    
    /*
    DELETE `one`, two FROM three
      INNER JOIN `one` ON `one`.id = three.name
      INNER JOIN two ON two.id = three.age
    WHERE three.id = 9
    */


    # Delete Lectures
    $stmt = $conn->prepare(
      "DELETE FROM lectures
        INNER JOIN items_order AS item ON item.item_id = lectures.id
      WHERE item.item_type = ? AND item.course_id = ?");
    $result = $stmt->execute([Lecture::TYPE, $this->id]);
    if (!$result) {
      return false;
    }
    
    # Delete Exams
    $stmt = $conn->prepare(
      "DELETE item, exams, questions, answers FROM exams
        INNER JOIN items_order AS item ON item.item_id = exams.id
        INNER JOIN questions ON questions.exam_id = exams.id
        INNER JOIN answers ON answers.question_id = questions.id
      WHERE item.item_type = ? AND item.course_id = ?");
    $result = $stmt->execute([Exam::TYPE, $this->id]);
    if (!$result) {
      return false;
    }
    # Delete Exams
    $stmt = $conn->prepare(
      "DELETE FROM exams
        INNER JOIN items_order AS item ON item.item_id = exams.id
      WHERE item.item_type = ? AND item.course_id = ?");
    $result = $stmt->execute([Exam::TYPE, $this->id]);
    if (!$result) {
      return false;
    }
    
    # Delete Course Data
    $stmt = $conn->prepare("DELETE FROM courses WHERE courses.id = ?");
    $result = $stmt->execute([$this->id]);
    if (!$result) {
      return false;
    }
    return true;

  }// Boolian true | false

  public function get_items_all() {
    /*
      1- Get ALL Lectures
      2- Create Objects From lectures Data
      3- Get ALL Exams
      4- Create Objects From Exams Data
      5- Order All Items Objects By [$item->Order]
      
      then return the result
    */

    global $conn;
        
    // get Lectures
    $get_lectures = $conn->prepare(
      "SELECT lectures.*, items_order.order, items_order.course_id, items_order.id AS order_id
      FROM items_order
      INNER JOIN lectures ON lectures.id = items_order.item_id
      WHERE items_order.item_type = 1 AND items_order.course_id = ?");
    $get_lectures->execute([$this->id]);

    // create Lectures Objects
    $lectures = []; 
    if ($get_lectures->rowCount() > 0) {
      $lectures_data = $get_lectures->fetchAll(PDO::FETCH_ASSOC);
      foreach ($lectures_data as $lecture_data):
        $lecture = new Lecture();
        $lecture->set_data($lecture_data);
        array_push($lectures, $lecture);
      endforeach;
    }

    // get Exams
    $get_exams = $conn->prepare(
      "SELECT exams.*, items_order.order, items_order.course_id, items_order.id AS order_id
      FROM items_order
      INNER JOIN exams ON exams.id = items_order.item_id
      WHERE items_order.item_type = 2 AND items_order.course_id = ?");
    $get_exams->execute([$this->id]);
    
    // create Exams Objects
    $exams = []; 
    if ($get_exams->rowCount() > 0) {
      $exams_data = $get_exams->fetchAll(PDO::FETCH_ASSOC);
      foreach ($exams_data as $exam_data):
        $exam = new Exam();
        $exam->set_data($exam_data);
        array_push($exams, $exam);
      endforeach;
    }

    $items = $this->order(array_merge($lectures, $exams));
    return $items;

  }// array object Lecture | Exam[*]{in this course}

  public function get_items_for_manage() {
    /*
      1- Get ALL Items
      2- Make "show_status" = 2        
      
      then return the result    
    */

    $items = $this->get_items_all();
    foreach ($items as $item):
      $item->show_status = 2;
    endforeach;

    return $items;

  }// get all items and make show_status = 2 [ open ]

  public function get_items_for_students($student_id) {
    /*
      1- Get ALL Items
      2- Order All Items Objects By [$item->Order] [items will be given ordered from get_items_all method]
      3- Mark Finished Items
      
      then return the result
    */

    $items = $this->get_items_all();
    $items = $this->mark_watched_items($student_id, $items);

    return $items;

  }// get all items and mark all finished 

}// end of class Course



class Item {
  public $id;
  public $course_id;
  public $order;
  public $show_status = 1;// 1 close 2 open 3 finish
  public $order_id;// items_order.id 
  public $title;
  public $description;
  public $date;
  public $type;
  public $day_before;
  public $errors = [];

  protected function MB($bite) {
    return ((($bite / 8) / 1024) / 1024);
  }// end

  public function item_pass($user_id) {
    /*
    takes: $user_id wich is student id
    does: insert into student_pass table
    returns: true | false
    */

    global $conn;

    $insert_finish_item = $conn->prepare(
      "INSERT INTO student_pass (student_id, item_order_id) VALUES (?, (SELECT id FROM items_order WHERE course_id = ? AND `order` = ?))");

    if ($insert_finish_item->execute([$user_id, $this->course_id, $this->order])) {
      
      return true;
    }else {
      return false;
    }

  }// end

  public function get_item_type($course, $order) {
    /*
      takes   : $order wich is item order && $course wich is course id
      does    : checks and gets given item type
      returns : [item_type, item_id] | false
    */

    global $conn;

    $stmt = $conn->prepare(
      "SELECT items_order.item_type, items_order.item_id FROM items_order WHERE course_id = ? AND `order` = ?");
    $stmt->execute([$course, $order]);

    if ($stmt->rowCount() > 0) {
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->id     = $result["item_id"];
      $this->type   = $result["item_type"];
      return true;
    }else {
      return false;
    }

  }// end

}



class Lecture extends Item {
  const ACCEPTED_IMAGE = [
    "jpg",
    "jpeg",
    "png",
    "webp",
    "gif",
  ];
  const ACCEPTED_VIDEO = [
    "mp4",
    "webm"
  ];
  const ALL_COURSES = "ALL_LECTURES";
  const MAX_VIDEO_SIZE = 0.5;// mega byte
  const MAX_IMAGE_SIZE = 0.5;// mega byte
  const TYPE           = 1;// item type
  public $thumbnail;
  public $video;


  public function set_data($data) {
    /* 
      takes $data wich is an array containes members bellow
      sets given data to the object
    */

    if (isset($data["id"])) {
      $this->id = $data["id"];
    }
    if (isset($data["course_id"])) {
      $this->course_id = $data["course_id"];
    }
    if (isset($data["title"])) {
      $this->title = $data["title"];
    }
    if (isset($data["description"])) {
      $this->description = $data["description"];
    }
    if (isset($data["order"])) {
      $this->order = $data["order"];
    }
    if (isset($data["order_id"])) {
      $this->order_id = $data["order_id"];
    }
    if (isset($data["video"])) {
      $this->video = $data["video"];
    }
    if (isset($data["thumbnail"])) {
      $this->thumbnail = $data["thumbnail"];
    }
    if (isset($data["date"])) {
      $this->date = $data["date"];
    }
    if (isset($data["day_before"])) {
      $this->day_before = $data["day_before"];
    }

  }// end of set_data method

  private function check_data() {
    #  lecture video validation
    if (!isset($this->video["name"]) || empty($this->video["name"])) {// availability
      $this->errors["video"] = "ther is no video.";
    }
    if ($this->MB($this->video["size"]) > self::MAX_VIDEO_SIZE) {// size
      $this->errors["video"] = "this video is larger then " . self::MAX_VIDEO_SIZE . "MB";
    }
    $name_array = explode(".", $this->video["name"]);
    if (!in_array(end($name_array), self::ACCEPTED_VIDEO)) {// extension
      $this->errors["video"] = "the file most to be " . implode(", ", self::ACCEPTED_VIDEO);
    }

    #  thumbnail image validation
    if (!isset($this->thumbnail["name"]) || empty($this->thumbnail["name"])) {
      $this->errors["thumbnail"] = "ther is no thumbnail image";
    }
    if ($this->MB($this->thumbnail["size"]) > self::MAX_IMAGE_SIZE) {// size
      $this->errors["thumbnail"] = "this image is larger then " . self::MAX_IMAGE_SIZE . "MB";
    }
    $name_array = explode(".", $this->thumbnail["name"]);
    if (!in_array(end($name_array), self::ACCEPTED_IMAGE)) {// extension
      $this->errors["thumbnail"] = "the image most to be " . implode(", ", self::ACCEPTED_VIDEO);
    }
  }// end of check_data method

  private function token($length) {
    /*
    takes $length wich is the token length
    returns a random token
    */
    
    $alphabet   = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    $token      = "";
    
    for ($i = 0; $i <= $length; $i += 1) {
      $token .= $alphabet[rand(0, strlen($alphabet) - 1)];
    }
    
    return $token;
  }// end of token method
  
  public function insert_lecture() {
    /*
      takes   : nothing
      does    : get random name for files and upload them than insert into lectures table and items_order table
      returns : true | none
    */

    $this->check_data();
    if (count($this->errors) > 0) {

        foreach ($this->errors as $error):
          echo $error;
        endforeach;
      exit();

    }else {// if ther is no errors

      global $conn;

      # move the files to ther directory
      $video_name_array = explode(".", $this->video["name"]);
      $image_name_array = explode(".", $this->thumbnail["name"]);
      $tmp_name_one = $this->token(10) . "." . end($video_name_array);
      $tmp_name_tow = $this->token(10) . "." . end($image_name_array);

      move_uploaded_file($this->video["tmp_name"], $_SERVER["DOCUMENT_ROOT"] . '/dxnln' . lecturesURL . $tmp_name_one);
      move_uploaded_file($this->thumbnail["tmp_name"], $_SERVER["DOCUMENT_ROOT"] . '/dxnln' . thumbnailsURL . $tmp_name_tow);
        
      // Lectures Table Insert
      $stmt = $conn->prepare(
        "INSERT INTO
            lectures (`title`, `description`, `video`, `thumbnail`, `date`)
      VALUES
            (:title, :description, :video, :thumbnail, NOW())");

      if ($stmt->execute([
        ":title"        => $this->title,
        ":description"  => $this->description,
        ":video"        => $tmp_name_one,
        ":thumbnail"    => $tmp_name_tow,
      ])) {

        // Getting Lecture Id
        $stmt = $conn->prepare("SELECT LAST_INSERT_ID() AS id FROM lectures");

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

          $this->id = $stmt->fetch(PDO::FETCH_ASSOC)["id"];
  
          // Get Last Order
          $order = $conn->prepare("SELECT MAX(`order`) + 1 AS `order` FROM items_order WHERE course_id = ?");
  
          $order->execute([$this->course_id]);
          
          if ($order->rowCount() > 0) {
            $order = $order->fetch(PDO::FETCH_ASSOC)["order"];
            $this->order = $order != NULL ? $order: 1;
          }else {
            $this->order = 1;
          }
          
          // items_order Table Insert
          $stmt = $conn->prepare(
            "INSERT INTO
                  items_order (course_id, item_id, item_type, `order`)
            VALUES
                  (:course_id, :item_id, 1, :order)");

          if ($stmt->execute([
            ":course_id"  => $this->course_id,
            ":item_id"    => $this->id,
            ":order"      => $this->order,
          ])) {

            return true;

          }else {// Filed To items_order Table Insert
            echo "Error: Items_Order Table Insert";
            exit();
          }
  
        }else {// Field To "Get Lecture Id After Insert"
          echo "Error: Getting Lecture Id After Insert";
          exit();
        }

      }else {// Field TO "lectures Table Insert"
        echo "Error: Lectures Table Insert";
        exit();
      }
    }// End "Data Errors" Check
      
  }// end of insert_lecture method

  public static function get_lectures($id = NULL) {
    /*
      takes   : $id wich is teacher id to get hes lectures
      does    : gets all lectures of spesefic owner or all lectures in general
      returns : array of lectures info
    */

    global $conn;
    
      
      if ($id == self::ALL_COURSES) {
        $stmt = $conn->prepare("SELECT lectures.* FROM lectures");
        $stmt->execute();
      }else {
        $stmt = $conn->prepare(
          "SELECT lectures.*
          FROM teachers_courses
          INNER JOIN courses ON courses.id = teachers_courses.course_id
          INNER JOIN lectures ON lectures.course_id = courses.id
          WHERE teachers_courses.teacher_id = ?");
        $stmt->execute([$id]);
      }

    if ($stmt->rowCount() > 0) {
      return $stmt->fetchALL(PDO::FETCH_ASSOC);
    }else {
      return false;
    }
  }// end of get_lectures method

  public function get_lecture() {
    /*
      returns : array containes lecture info
    */

    global $conn;

    $stmt = $conn->prepare(
      "SELECT lectures.*, items_order.order, items_order.course_id, items_order.id AS order_id,
      DATEDIFF(NOW(), lectures.date) AS day_before
      FROM lectures
      INNER JOIN items_order ON items_order.item_id = lectures.id
      WHERE items_order.item_type = 1 AND lectures.id = ?");
    $stmt->execute([$this->id]);
    if ($stmt->rowCount() > 0) {
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }else {
      return false;
    }

  }// end of get_lecture method
  
  public static function delete_lecture($id) {
    /*
      takes: lectures id
      does: removes lecture from lectures table and make sure the items_order.order is right
      returns: true |false
    */

    global $conn;

    $update_order = $conn->prepare(
      "UPDATE items_order SET `order` = (`order` - 1)
      WHERE `order` > (SELECT items_order.order FROM items_order WHERE items_order.item_id = ? AND items_order.item_type = ?)
      AND items_order.course_id = (SELECT items_order.course_id FROM items_order WHERE items_order.item_id = ? AND items_order.item_type = 1)");
    $update_order->execute([Lecture::TYPE, $id, $id]);

    $order_delete = $conn->prepare("DELETE FROM items_order WHERE item_id = ? AND item_type = 1");
    
    $order_delete->execute([$id]);

    $lecture_delete = $conn->prepare("DELETE FROM lectures WHERE lectures.id = ?");

    if ($lecture_delete->execute([$id])) {
      return true;
    }else {
      return false;
    }

  }// end of delete_lecture method

}



class Exam extends Item {
  const TYPE      = 2;// item type
  public $percent = 70;// default degree to success
  public $questions_count = 1;
  public $questions = [];
  public $answers   = [];
  

  public function set_data($data) {
    /* 
      takes $data wich is an array containes members bellow
      sets given data to the object
    */

    if (isset($data["id"])) {
      $this->id = $data["id"];
    }
    if (isset($data["course_id"])) {
      $this->course_id = $data["course_id"];
    }
    if (isset($data["title"])) {
      $this->title = $data["title"];
    }
    if (isset($data["description"])) {
      $this->description = $data["description"];
    }
    if (isset($data["percent"])) {
      $this->percent = $data["percent"];
    }
    if (isset($data["exam_percent"])) {
      $this->percent = $data["exam_percent"];
    }
    if (isset($data["order"])) {
      $this->order = $data["order"];
    }
    if (isset($data["order_id"])) {
      $this->order_id = $data["order_id"];
    }
    if (isset($data["questions_count"])) {
      $this->questions_count = $data["questions_count"];
    }
    if (isset($data["answers"])) {
      $this->answers = $data["answers"];
    }
    if (isset($data["date"])) {
      $this->date = $data["date"];
    }
    if (isset($data["day_before"])) {
      $this->day_before = $data["day_before"];
    }
  }// end of set_data method

  private function check_data() {
    if (empty($this->title)) {
      $this->errors["title"] = "ther is no title for this exam.";
    }
    if (empty($this->description)) {
      $this->errors["description"] = "ther is no description for this exam.";
    }
    if (empty($this->course_id)) {
      $this->errors["course_id"] = "you most chose a course for the exam.";
    }
    if (!is_numeric($this->course_id)) {
      $this->errors["course_id"] = "the course you chosed is not valid";
    }
    if ($this->percent > 100 || $this->percent < 0) {
      $this->errors["percent"] = "the success percent most be between 0 & 100";
    }
  }// end of check_data method

  public function insert_exam() {
    /*
      does    : inserts exam in exams table and sets its order
      returns : true | false
    */

    $this->check_data();
    if (count($this->errors) > 0) {
        foreach ($this->errors as $error):
          echo $error;
        endforeach;
      exit();
    }else {// end "check error"

      global $conn;

      // Exams Table Insert
      $stmt = $conn->prepare(
        "INSERT INTO
            exams (`title`, `description`, `exam_percent`)
        VALUES
            (:title, :description, :percent)");

      if ($stmt->execute([
        ":title"        => $this->title,
        ":description"  => $this->description,
        ":percent"      => $this->percent,
      ])) {
        
        // Getting Id
        $stmt = $conn->prepare("SELECT LAST_INSERT_ID() AS id FROM exams");

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
          
          $this->id = $stmt->fetch(PDO::FETCH_ASSOC)["id"];

          // Selecting Larger Order
          $stmt = $conn->prepare("SELECT MAX(`order`) + 1 AS `order` FROM items_order WHERE course_id = ?");
            
          $stmt->execute([$this->course_id]);
          
          if ($stmt->rowCount() > 0) {
            $order = $stmt->fetch(PDO::FETCH_ASSOC)["order"];
            if ($order != NULL) {
              $this->order = $order;
            }else {
              $this->order = 1;
            }
          }else {
            $this->order = 1;
          }
    
          // items_order Table Insert
          $stmt = $conn->prepare(
            "INSERT INTO items_order (course_id, item_id, item_type, `order`)
            VALUES (?, ?, 2, ?)");

          if ($stmt->execute([
            $this->course_id,
            $this->id,
            $this->order,
            ])) {
              
              return true;
              
            }else {// Field To "items_order Insert"
              echo $this->order;
              echo "Error: items_order Insert";
            exit();
          }

        }else {// Field To "Get exam Id After Insert"
          echo "Error: Getting Exam Id After Inster";
          exit();
        }

      }else {// Field To "exams Table Insert"  
        echo "Error: exams Table Insert";
        exit();
      }

    }// if ther is no errors
  }// end of insert_exam method

  public function get_exam() {
    /*
      does    : gets exam from exams table
      returns : info | false
    */

    global $conn;

    $stmt = $conn->prepare(
      "SELECT exams.*, items_order.order, count(questions.id) AS questions_count, items_order.course_id,
      DATEDIFF(NOW(), exams.date) AS day_before FROM exams
      INNER JOIN items_order ON items_order.item_id = exams.id
      LEFT JOIN questions ON questions.exam_id = exams.id
      WHERE exams.id = ?");
    $stmt->execute([$this->id]);

    if ($stmt->rowCount() > 0) {
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }else {
      return false;
    }

  }// end of get_exam method

  public function delete_exam() {
    /*
      takes: exam id
      does: removes exam from exams table and make sure the order is right
      returns: true | false
    */

    global $conn;

    $this->set_data($this->get_exam());

    $update_order = $conn->prepare(
      "UPDATE items_order
        SET `order` = (`order` - 1)
      WHERE course_id = ? AND `order` > 
      (SELECT items_order.order FROM items_order WHERE items_order.item_id = ? AND item_type = ?)");
    $update_order->execute([$this->course_id, $this->id, self::TYPE]);

    $questions_answers = $conn->prepare(
      "DELETE questions, answers FROM exams
        INNER JOIN questions ON questions.exam_id = exams.id
        INNER JOIN answers ON answers.question_id = questions.id
      WHERE exams.id = ?");
    $questions_answers->execute([$this->id]);
    
    $exam_delete = $conn->prepare(
      "DELETE items_order, exams FROM exams
        INNER JOIN items_order ON items_order.item_id = exams.id
      WHERE items_order.item_type = ? AND exams.id = ?");
    
    $result = $exam_delete->execute([Exam::TYPE, $this->id]);
    if ($result) {
      return true;
    }else {
      return false;
    }

  }// end of delete_exam method

  public function get_questions() {
    /*
      takes: nothing
      does: gets questions for this exam
      returns: info | false
    */
    global $conn;

    $questions = $conn->prepare("SELECT * FROM questions WHERE exam_id = ?");
    $questions->execute([$this->id]);

    if ($questions->rowCount() > 0) {
      $questions = $questions->fetchAll(PDO::FETCH_ASSOC);
      
      $answers = $conn->prepare(
        "SELECT answers.* FROM answers
        INNER JOIN questions ON questions.id = answers.question_id
        WHERE questions.exam_id = ?");
      $answers->execute([$this->id]);
      
      if ($answers->rowCount() > 0) {
        $answers = $answers->fetchAll(PDO::FETCH_ASSOC);
        // Create Anserts Objects
        foreach($questions as $qst):
          $quest = new Question();
          $quest->set_data($qst);
          $this->questions[] = $quest;
        endforeach;
        foreach($answers as $ans):
          $ansr = new Answer();
          $ansr->set_data($ans);
          $this->answers[] = $ansr;
        endforeach;
        foreach($this->questions as $quest):
          foreach($this->answers as $ansr):
            if ($ansr->question_id == $quest->id) {
              $quest->answers[] = $ansr;
            }
          endforeach;
        endforeach;
        return true;
      }else {
        return false;
      }
    }else {
      return false;
    }

  }// end of get_questions method

  public function get_last_id() {
    /*
    takes   : nothing
    does    : gets last inserted id
    returns : id | false
    */

    global $conn;

    $stmt = $conn->prepare("SELECT LAST_INSERT_ID() AS id FROM exams");
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return $stmt->fetch(PDO::FETCH_ASSOC)["id"];
    }else {
      return false;
    }

  }// end if method get_last_id

  public function compare_answers($user, $compare) {
    /*
    takes : $user wich is student_id
    does  : inserts into exams_take table
    returns: info [percent, success] | false
    */

    global $conn;

    // get Answers And Questions
    $get_db_questions = $conn->prepare(
      "SELECT questions.id, questions.important AS important, answers.id AS answer_id FROM questions
      INNER JOIN answers ON answers.question_id = questions.id
      INNER JOIN exams ON questions.exam_id = exams.id 
      WHERE exams.id = ? AND answers.is_right = 2");
    $get_db_questions->execute([$this->id]);
    
    
    if ($get_db_questions->rowCount() > 0) {
    
      $db_answers = $get_db_questions->fetchAll(PDO::FETCH_ASSOC);
      
      $get_db_answers_count = $conn->prepare(
        "SELECT COUNT(answers.id) AS answers_count FROM answers
        INNER JOIN questions ON questions.id = answers.question_id
        WHERE questions.exam_id = ?");
      $get_db_answers_count->execute([$this->id]);
  
      $answers_count = $get_db_answers_count->fetch(PDO::FETCH_ASSOC)["answers_count"];
      
      $obj_cash   = [];

      // creating objecties for DB answers
      foreach($db_answers as $quest):
        if (in_array($quest["id"], array_keys($obj_cash))) {
          $obj = new Answer();
          $obj->set_data(["id" => $quest["answer_id"], "question_id" => $quest["id"], "is_right" => 2]);
          array_push($obj_cash[$quest["id"]]->answers, $obj);
        }else {
          $obj = new Question($quest);
          $obj->set_data(["id" => $quest["id"], "important" => $quest["important"]]);
          $ans_obj = new Answer();
          $ans_obj->set_data(["id" => $quest["answer_id"], "question_id" => $quest["id"], "is_right" => 2]);
          array_push($obj->answers, $ans_obj);
          $obj_cash[$quest["id"]] = $obj;
        }
      endforeach;

      $result = [];

      foreach($obj_cash as $i => $quest):
        // if ($quest->important == 1) {
        //   $full_mark_slices_count += 2;
        // }else {
        //   $full_mark_slices_count += 1;
        // }
        if ($quest->id == $compare[$i]->id) {
          if (COUNT($quest->answers) > 1) {// db answer is multible
            if (COUNT($compare[$i]->answers) > 1) {

              $post_answers_ids = [];
              foreach($compare[$i]->answers as $post_ansr):
                array_push($post_answers_ids, $post_ansr->id);
              endforeach;
              
              $db_answers = [];
              foreach($quest->answers as $db_ansr):
                array_push($db_answers, $db_ansr->id);
              endforeach;

              $t = 0;
              $f = 0;
              foreach($post_answers_ids as $post_ansr):
                if (in_array($post_ansr, $db_answers)) {
                  $t += 1;
                }else {
                  $f += 1;
                }
              endforeach;
              
              $tf     = $answers_count - count($quest->answers);
              $result[$i] = round((($t + $tf - $f) / $answers_count) * 100);

            }else {
              // $result[$i] = "Answer Is single But Db Is't";
              $result[$i] = 0;
            }
          }else {// db answer is single
            if (COUNT($compare[$i]->answers) < 2) {
              if ($quest->answers[0]->id == $compare[$i]->answers[0]->id) {
                $result[$i] = 100;
              }else {
                // $result[$i] = "Not The Same Answer";
                $result[$i] = 0;
              }
            }else {
              // $result[$i] = "your answer is multible but DB is't";
              $result[$i] = 0;
            }
          }
        }else  {
          // $result[$i] = "Not The Same Id";
          $result[$i] = 0;
        }
      endforeach;
      
      if ($user != self::ADMIN) {
        
        $exams_take = $conn->prepare(
          "INSERT INTO exam_take (exam_id, student_id, `date`) VALUES ( :exam, :student, NOW())");
        $exams_take->execute([":exam" => $this->id, ":student" => $user]);
        $exams_take_id = $conn->lastInsertId();
        
        $conn->beginTransaction();
        $sql    = "INSERT INTO exams_answers (exam_take, question_id, `right`) VALUES (?, ?, ?)";
        $add_try_answers = $conn->prepare($sql);
        
        foreach($result as $i => $ans):
          $add_try_answers->execute([
            $exams_take_id,
            $i,
            $ans
          ]);
        endforeach;
        $conn->commit();
      }

      $returned = [
        "percent" => (array_sum($result) / COUNT($compare)),
        "exam_title" => $this->title,
        "require_percent" => $this->percent
      ];

      if ((array_sum($result) / COUNT($compare)) >= $this->percent) {
        
        $this->item_pass($user);
        $returned["success"] = "true";
      }else {
        $returned["success"] = "false";
      }

      return $returned;

    }else {
      return false;
    }

  }// end of Method compare_answers

}// end of class exam



class Answer {
  public $id;
  public $answer;
  public $is_right;
  public $question_id;
  public $errors = [];

  public function set_data($info) {

    if (isset($info["id"]) && !empty($info["id"])) {
      $this->id = $info["id"];
    }
    if (isset($info["quest_id"]) && !empty($info["quest_id"])) {
      $this->question_id = $info["quest_id"];
    }
    if (isset($info["question_id"]) && !empty($info["question_id"])) {
      $this->question_id = $info["question_id"];
    }
    if (isset($info["answer"]) && !empty($info["answer"])) {
      $this->answer = $info["answer"];
    }
    if (isset($info["is_right"]) && !empty($info["is_right"])) {
      $this->is_right = $info["is_right"];
    }
  }// end of set_data method

  private function check_data() {

    if ((!isset($this->id) || empty($this->id)) && (!isset($this->question_id) || empty($this->question_id))) {
      $this->errors[] = "most to contain at least one id [Question_id | Id]";
    }
    if (!isset($this->is_right) || empty($this->is_right) || !is_numeric($this->is_right)) {
      $this->errors[] = "is_right can't Be empty Or any Type but Int";
    }
    if (!isset($this->answer) || empty($this->answer)) {
      $this->errors[] = "answer can't be empty";
    }
  }// end of set_data method

  public function insert_answer() {
    /*
      takes: nothing
      does: inserts answer for this question
      returns: true | false
    */

    global $conn;

    $this->check_data();
    if (count($this->errors) > 0) {
      foreach ($this->errors as $err) {
        echo $err;
      }
      exit();
    }else {

      $answer = $conn->prepare(
        "INSERT INTO answers (question_id, answer, is_right)
        VALUES (?, ?, ?)");
  
      if ($answer->execute([$this->question_id, $this->answer, $this->is_right])) {
        return true;
      }else {
        return false;
      }
      
    }// end of check errors

  }// end of insert_answer method

}// end of class Answer



class Question {
  const ADMIN = "ADMIN";
  public $id;
  public $exam_id;
  public $question;
  public $answers = [];
  public $update = [];
  public $multible_option = 2;
  public $important = 0;
  public $order;
  public $errors = [];

  public function get_question_by_order($exam_id, $order) {
    /*
      takes   : $exam_id wich is exam id AND $order wich is question order
      does    : gets info of question based on it's order
      returns : info | false
    */

    global $conn;

    $question = $conn->prepare(
      "SELECT questions.* FROM questions WHERE questions.exam_id = ? AND questions.order = ?");
    $question->execute([$exam_id, $order]);

    if ($question->rowCount() > 0) {
      $question = $question->fetch(PDO::FETCH_ASSOC);
      
      $answers = $conn->prepare(
        "SELECT answers.* FROM answers INNER JOIN questions ON questions.id = answers.question_id
        WHERE questions.exam_id = ? AND questions.order = ?");
      $answers->execute([$exam_id, $order]);

      if ($answers->rowCount() > 0) {
        $answers = $answers->fetchAll(PDO::FETCH_ASSOC);

        $question["answers"] = $answers;// add answers to question info
        return $question;

      }else {// field to get answers
        return false;
      }
    }else {// field to get question
      return false;
    }

  }// end of get_question_by_order method

  public function get_question($user_id, $id) {
    /*
      takes   : $user_id wich is user id and $id wich is id of question
      does    : gets data of question givin
      returns : info | false
    */

    global $conn;

    if ($user_id == self::ADMIN) {
      $question = $conn->prepare("SELECT questions.* FROM questions WHERE questions.id = ?");
      $question->execute([$id]);
      
      $answers = $conn->prepare("SELECT answers.* FROM answers WHERE answers.question_id = ?");
      $answers->execute([$id]);
    }else {
      $question = $conn->prepare(
        "SELECT questions.*, teachers_courses.course_id FROM questions
        INNER JOIN items_order ON items_order.item_id = questions.exam_id
        INNER JOIN teachers_courses ON teachers_courses.course_id = items_order.course_id
        WHERE items_order.item_type = 2 AND teachers_courses.teacher_id = ? AND questions.id = ?");
      $question->execute([$user_id, $id]);

      $answers = $conn->prepare(
        "SELECT answers.* FROM answers
        INNER JOIN questions ON questions.id = answers.question_id
        INNER JOIN items_order ON items_order.item_id = questions.exam_id
        INNER JOIN teachers_courses ON teachers_courses.course_id = items_order.course_id
        WHERE items_order.item_type = 2 AND teachers_courses.teacher_id = ? AND answers.question_id = ?");
      $answers->execute([$user_id, $id]);
    }

    if ($question->rowCount() > 0) {
      $question = $question->fetch(PDO::FETCH_ASSOC);
      
      if ($answers->rowCount() > 0) {
        $answers = $answers->fetchAll(PDO::FETCH_ASSOC);
        
        $question["answers"] = $answers;
        return $question;

      }else {// field to get answers
        return false;
      }
    }else {// field to get question
      return false;
    }
  }// end of get_question method

  public function set_data($info) {
    
    if (isset($info["id"]) && !empty($info["id"])) {
      $this->id = $info["id"];
    }
    if (isset($info["exam_id"]) && !empty($info["exam_id"])) {
      $this->exam_id = $info["exam_id"];
    }
    if (isset($info["question"]) && !empty($info["question"])) {
      $this->question = $info["question"];
    }
    if (isset($info["answers"]) && !empty($info["answers"])) {
      $this->answers = $info["answers"];
    }
    if (isset($info["update"]) && !empty($info["update"])) {
      $this->update = $info["update"];
    }
    if (isset($info["multible_option"]) && !empty($info["multible_option"])) {
      $this->multible_option = $info["multible_option"];
    }
    if (isset($info["important"]) && !empty($info["important"])) {
      $this->important = $info["important"];
    }
    if (isset($info["order"]) && !empty($info["order"])) {
      $this->order = $info["order"];
    }

  }// end of set_data method

  private function check_data() {
    /* 
      takes   : nothing
      does    : check if all data is valid
      returns : true| array of errors
     */

    if (!isset($this->question) || empty($this->question)) {
      $this->errors[] = "Question Can't Be Empty";
    }else {
      if (strlen($this->question) < 5) {
        $this->errors[] = "The Question Is Too Short";
      }
    }
    if (count($this->answers) <= 1 && count($this->update) <= 1) {
      $this->errors[] = "Answers Is Less Than 2";
    }

  }// end of method check_data
  
  public function insert_question() {
    /*
      takes   : nothing
      does    : Inserts Question And Answers In Questions and Answers Tables
      returns : true | false
    */

    $this->check_data();
    if (count($this->errors) > 0) {
      foreach($this->errors as $error):
        echo $error;
      endforeach;
      exit();
    }else {// if No errors

      global $conn;

      // get Larger Order 
      $order = $conn->prepare("SELECT MAX(`order`) + 1 AS `order` FROM questions WHERE exam_id = ?");
      $order->execute([$this->exam_id]);
      if ($order->rowCount() > 0) {
        $fetch = $order->fetch(PDO::FETCH_ASSOC)["order"];
        $this->order = isset($fetch) ? $fetch: 1;
      }else {
        $this->order = 1;
      }
  
      // Insert question
      $question = $conn->prepare(
        "INSERT INTO questions (`exam_id`, `question`, `important`, `order`, `multible_option`)
        VALUES (:exam_id, :question, :important, :order, :multible_option)");

      if ($question->execute([
          ":exam_id"          => $this->exam_id,
          ":question"         => $this->question,
          ":important"        => $this->important,
          ":order"            => $this->order,
          ":multible_option"  => $this->multible_option,
      ])) {

        // get id after insert it 
        $id = $conn->prepare("SELECT LAST_INSERT_ID() AS id FROM questions");
        $id->execute();

        $this->id = $id->fetch(PDO::FETCH_ASSOC)["id"];

        $sql = "INSERT INTO answers (`question_id`, `answer`, `is_right`) VALUES";
        $arg = [];

        foreach($this->answers as $i => $answer):
          if ($i == 0) {
            $sql .= " (?, ?, ?)";
          }else {
            $sql .= ", (?, ?, ?)";
          }
          array_push($arg, $this->id);
          array_push($arg, $answer->answer);
          array_push($arg, $answer->is_right);
        endforeach;

        $insert = $conn->prepare($sql);

        if ($insert->execute($arg)) {
          return true;
        }else {// error inserting answer
          return false;
        }
        
      }else {
        return false;
      }// end "question insert" check

    }// end "there is error"

  }// end of method insert_question

  public function update_question() {
    /*
      takes   : nothing
      does    : updates Question And Answers In Questions and Answers Tables
      returns : true | false
    */

    $this->check_data();
    if (count($this->errors) > 0) {
      foreach($this->errors as $error):
        echo $error;
      endforeach;
      exit();
    }else {// if No errors

      global $conn;

      // Update The Question
      $question = $conn->prepare(
        "UPDATE questions SET
        `exam_id` = :exam_id, `question` = :question, `important` = :important, `multible_option` = :multible_option
        WHERE id = :id");

      if ($question->execute([
          ":exam_id"          => $this->exam_id,
          ":question"         => $this->question,
          ":important"        => $this->important,
          ":multible_option"  => $this->multible_option,
          ":id"               => $this->id,
      ])) {

        // Insert New Answers
        if (isset($this->answers) && !empty($this->answers) && count($this->answers) > 0) {
          foreach ($this->answers as $answer):
            $answer->insert_answer();
          endforeach;
        }
        
        // Update Old Answers
        if (isset($this->update) && !empty($this->update) && count($this->update) > 0) {
          foreach ($this->update as $upd):
            $stmt = $conn->prepare("UPDATE answers SET answer = ?, is_right = ? WHERE id = ?");
            $stmt->execute([$upd->answer, $upd->is_right, $upd->id]);
          endforeach;
          return true;
        }else {
          echo "filed To Update answers";
          return false;
        }
        
      }else {
        echo "filed To Update Question";
        return false;
      }// end "question insert" check

    }// end "there is error"

  }// end of method insert_question

}// end of class question
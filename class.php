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

}


class Student extends User {
  public $student_id;
  public $main_courses;
  public $group;// group name
  public $group_id;
  const USER_TYPE = 3;


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

  }// boolian

  public function set_data($info) {
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
    if (isset($info['group']) && !empty($info['group'])) {
      $this->group = $info['group'];
    }
    if (isset($info['group_id']) && !empty($info['group_id'])) {
      $this->group_id = $info['group_id'];
    }
    
  }

  public static function student_obj($students_data) {
    if (is_array($students_data) && count($students_data) > 0) {
      $stu_objs = [];
      foreach($students_data as $student_data):
        $student = new Student();
        $student->set_data($student_data);
        array_push($stu_objs, $student);
      endforeach;
      return $stu_objs;
    }else {
      return [];
    }
  }
  
  /*=========== Retrieve Methods ===========*/
  
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
      
      $this->set_data($result);

      return true;

    }else {
      return false;
    }

  }// boolian

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
      return: "user's path" courses | the courses of the user's path
    */
    
    global $conn;
  
    // get student group then path then courses he most complate
    $stmt = $conn->prepare(
      "SELECT c.id, c.title, c.description, c.date FROM students AS student
      INNER JOIN students_groups ON students_groups.student_id = student.id
      INNER JOIN groups ON groups.id = students_groups.group_id
      INNER JOIN paths ON paths.id = groups.path_id
      INNER JOIN paths_courses ON paths_courses.path_id = paths.id
      INNER JOIN courses c ON c.id = paths_courses.course_id
      WHERE student.id = ? ORDER BY paths_courses.order");

    $stmt->execute([$this->student_id]);

    if ($stmt->rowCount() > 0) {

      $courses_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    }else {// if teacher have't priority_courses
      
      // get teacher's main path for current student [ to see if current course is on main path to let him show items inside current course ]
      $stmt = $conn->prepare(
        "SELECT courses.id, courses.title, courses.description, courses.date FROM students
        INNER JOIN users AS user ON user.id = students.user_id
        INNER JOIN users AS teacher ON teacher.dxnid = user.dxn_upline
        INNER JOIN teachers ON teachers.user_id = teacher.id
        INNER JOIN paths ON paths.teacher_id = teachers.id
        INNER JOIN paths_courses ON paths_courses.path_id = paths.id
        INNER JOIN courses ON courses.id = paths_courses.course_id
        WHERE paths.is_main = 1 AND students.id = ? ORDER BY paths_courses.order
      ");
      
      $stmt->execute([$this->student_id]);
      if ($stmt->rowCount() > 0) {

        $courses_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
      }else {
        echo "There is no group's main path and default courses";// website's default courses
        exit();
      }
    }

    // create objcts
    $courses = Course::course_obj($courses_data);

    for ($i=0; $i < count($courses); $i++) { 
      $courses[$i]->show_status = $this->get_course_status($courses[$i]->id);// 1 close 2 open 3 finished

      if ($courses[$i]->show_status == 2 || $courses[$i]->show_status == 1) {
        $courses[$i]->show_status = 2;
        break;
      }
    }

    return $courses;// array of courses objects

  }// array object course[*]{in main path}

  public function get_current_course() {
    
    // 2- get student_pass and items_order and compare them to see if he passed this course or not

    global $conn;

    $courses = $this->get_courses_path();

    $get_student_pass = $conn->prepare("SELECT item_order_id FROM student_pass WHERE student_id = ?");
    $get_student_pass->execute([$this->student_id]);

    if ($get_student_pass->rowCount() > 0) {

      $student_pass = $get_student_pass->fetchAll(PDO::FETCH_ASSOC);
      $passed_items = array_column($student_pass, "item_order_id");

      foreach ($courses as $course):

        $get_all_items = $conn->prepare("SELECT id FROM items_order WHERE course_id = ?");
        $get_all_items->execute([$course->id]);

        if ($get_all_items->rowcount() > 0) {

          $all_items = $get_all_items->fetchAll(PDO::FETCH_ASSOC);
          $all_items = array_column($all_items, "id");

          foreach($all_items as $item):
            if (!in_array($item, $passed_items)) {
              return $course;
            }
          endforeach;

        }else {
          return false;// course has no items wich have to be impossible
        }

      endforeach;

    }else {// if there's no any finished item
      return $group_courses[0];// so first course in the path will be "current course"
    }

  }

}


class Teacher extends User {
  const USER_TYPE = 2;
  public $courses;
  public $teacher_id;
  public $accessible_courses = [];

  /*=========== Create Methods ===========*/

  public function create_teacher() {
    /*
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

  }// boolian

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


  }// Number cousrse_id
  
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
  }

  /*=========== Retrieve Methods ===========*/

  public static function get_own_courses($teacher_id, $require_permission = "ANY") {
    /*
      returns all courses that teacher have access on it as [
        [id of course] ==>> course_obj {* data}
      ]
    */

    $permission_convert = [
      "OWNER"   => 1,// digit 1 = own
      "CREATE"  => 2,// digit 2 = create
      "UPDATE"  => 3,// digit 3 = update
      "DELETE"  => 4,// digit 4 = delete
      "INVITE"  => 5,// digit 6 = can add teachers to the course
      "CLONE"   => 6,// digit 5 = add to priority
      "ANY"     => 7,// any digit containes 1 | have any permissison
    ];

    global $conn;

    if (array_key_exists($require_permission, $permission_convert)) {

      if ($require_permission != "ANY") {
        $sql = "SELECT P.value as permission, C.*
        FROM teachers_courses TC
        INNER JOIN courses C
        ON C.id = TC.course_id
        INNER JOIN permissions P
        ON P.id = TC.permission_id
        WHERE TC.teacher_id = ? AND SUBSTRING(P.value, ?, 1) = 1";
        $args = [$teacher_id, $permission_convert[$require_permission]];
      }else {
        $sql = "SELECT P.value as permission, C.*
        FROM teachers_courses TC
        INNER JOIN courses C
        ON C.id = TC.course_id
        INNER JOIN permissions P
        ON P.id = TC.permission_id
        WHERE TC.teacher_id = ? AND INSTR(P.value, 1)";
        $args = [$teacher_id];
      }
  
      $courses_data = $conn->prepare($sql);
      $courses_data->execute($args);
  
      if ($courses_data->rowCount() > 0) {
        
        $courses_data = $courses_data->fetchAll(PDO::FETCH_ASSOC);
  
        // $data = [];
  
        // foreach ($courses_data as $course) {
        //   $course_obj = new Course();
        //   $course_obj->set_data($course);
        //   $data[$course["id"]] = $course_obj;
        // }
        
        return $courses_data;
      }else {
        return false;
      }
    }else {
      return false;
    }

  }// array > object course[*]{permission}

  public static function get_own_courses_id($teacher_id) {
    /*
      returns all courses that teacher have access on it as [
        [id of course] ==>> course_obj {permission}
      ]
    */

    global $conn;

    $courses_data = $conn->prepare("SELECT permissions.value as permission, courses.id
        FROM teachers_courses
        INNER JOIN courses
        ON courses.id = teachers_courses.course_id
        INNER JOIN permissions
        ON permissions.id = teachers_courses.permission_id
        WHERE teachers_courses.teacher_id = ?");
    $courses_data->execute([$teacher_id]);

    if ($courses_data->rowCount() > 0) {
      
      $data = $courses_data->fetchAll(PDO::FETCH_ASSOC);

      return $data;
    }else {
      return false;
    }

  }// array > object courses[*](id, permission){permission}

  public static function get_own_courses_id_name($teacher_id, $require_permission = "ANY") {
    /*
      returns all courses that teacher have access on it as [
        [id of course] ==>> course_obj {permission, name}
      ]
    */

    $permission_convert = [
      "OWNER"   => 1,// digit 1 = own
      "CREATE"  => 2,// digit 2 = create
      "UPDATE"  => 3,// digit 3 = update
      "DELETE"  => 4,// digit 4 = delete
      "INVITE"  => 5,// digit 6 = can add teachers to the course
      "CLONE"   => 6,// digit 5 = add to priority
      "ANY"     => 7,// any digit containes 1 | have any permissison
    ];

    global $conn;

    if (array_key_exists($require_permission, $permission_convert)) {

      if ($require_permission != "ANY") {
        $sql = "SELECT P.value as permission, C.id, C.title
        FROM teachers_courses TC
        INNER JOIN courses C
        ON C.id = TC.course_id
        INNER JOIN permissions P
        ON P.id = TC.permission_id
        WHERE TC.teacher_id = ? AND SUBSTRING(P.value, ?, 1) = 1";
        $args = [$teacher_id, $permission_convert[$require_permission]];
      }else {
        $sql = "SELECT P.value as permission, C.id, C.title
        FROM teachers_courses TC
        INNER JOIN courses C
        ON C.id = TC.course_id
        INNER JOIN permissions P
        ON P.id = TC.permission_id
        WHERE TC.teacher_id = ? AND INSTR(P.value, 1)";
        $args = [$teacher_id];
      }

      $courses_data = $conn->prepare($sql);
      $courses_data->execute($args);
    
      if ($courses_data->rowCount() > 0) {
        
        $data     = $courses_data->fetchAll(PDO::FETCH_ASSOC);
        $ordered  = [];
        $courses  = Course::course_obj($data);

        foreach ($courses as $course) {
          $ordered[$course->id] = $course;
        }

        return $ordered;

      }else {
        return false;
      }
    }else {
      return false;
    }
  
  }// array > object courses[*](id, name, permission){permission}

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

  public function get_paths() {
    /*
      returns all teacher's paths
    */

    global $conn;

    $stmt = $conn->prepare("SELECT * FROM paths P WHERE P.teacher_id = ?");
    $stmt->execute([$this->teacher_id]);

    if ($stmt->rowCount() > 0) {
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }else {
      return false;
    }

  }

  public function get_paths_id() {
    /*
      returns all teacher's path's ids
    */

    global $conn;

    $stmt = $conn->prepare("SELECT P.id FROM paths P WHERE P.teacher_id = ?");
    $stmt->execute([$this->teacher_id]);

    if ($stmt->rowCount() > 0) {
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }else {
      return false;
    }

  }

  public function get_students() {

    global $conn;

    $stmt = $conn->prepare(
      "SELECT U.id, U.username, S.id AS student_id, G.id AS group_id, G.name AS `group` FROM users U
      INNER JOIN students S ON S.user_id = U.id
      LEFT JOIN students_groups SG ON SG.student_id = S.id
      LEFT JOIN groups G ON G.id = SG.group_id
      WHERE U.dxn_upline = ?");
    $stmt->execute([$this->dxnid]);

    if ($stmt->rowCount() > 0) {
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }else {
      return false;
    }

  }

}


class Admin extends User {
  const USER_TYPE = 1;
  public $courses; 
  public $accessible_courses = []; 

  /*=========== Retrieve Methods ===========*/

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
  
  }

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
    
  }

}


class Group {
  public $id;
  public $name;
  public $description;
  public $path_id = false;// if no path_id it stil false
  public $path = [];// shold contain courses_objs
  public $icon_id;// icon id
  public $icon;// icon name
  public $members = [];
  public $members_count;
  public $teacher_id;

  /*=========== Create Methods ===========*/

  public function add_group() {
    /*
      uses  : teacher_id, name, description, icon_id
      return : True | False
    */

    global $conn;

    if (!empty($this->path_id) && is_numeric(intval($this->path_id))) {
      $sql = "INSERT INTO groups (`name`, `description`, teacher_id, icon, path_id) VALUES ( ?, ?, ?, ?, ?)";
      $exec = [$this->name, $this->description, $this->teacher_id, $this->icon_id, $this->path_id];

    }else {
      $sql = "INSERT INTO groups (`name`, `description`, teacher_id, icon) VALUES ( ?, ?, ?, ?)";
      $exec = [$this->name, $this->description, $this->teacher_id, $this->icon_id];

    }

    $stmt = $conn->prepare($sql);
    $result = $stmt->execute($exec);

    return $result;

  }

  public static function group_obj($groups_data) {
    /*
      return : group objects
    */

    if (is_array($groups_data) && count($groups_data) > 0):
      $groups = [];
      foreach($groups_data as $group_data):
        $group = new Group();
        $group->set_data($group_data);
        array_push($groups, $group);
      endforeach;
      return $groups;
    else:
      return [];
    endif;

  }

  public static function add_member($group_id, $member_id) {
    /* adds member to given group */

    global $conn;

    $stmt = $conn->prepare("INSERT INTO students_groups (student_id, group_id) VALUES (?, ?)");
    $result = $stmt->execute([$member_id, $group_id]);

    return $result;

  }

  /*=========== Retrieve Methods ===========*/

  public function set_data($data) {

    if (isset($data["id"]) && !empty($data["id"])) {
      $this->id = $data["id"];
    }
    if (isset($data["name"]) && !empty($data["name"])) {
      $this->name = $data["name"];
    }
    if (isset($data["path_id"]) && !empty($data["path_id"])) {
      $this->path_id = $data["path_id"];
    }
    if (isset($data["icon_id"]) && !empty($data["icon_id"])) {
      $this->icon_id = $data["icon_id"];
    }
    if (isset($data["icon"]) && !empty($data["icon"])) {
      $this->icon = $data["icon"];
    }
    if (isset($data["teacher_id"]) && !empty($data["teacher_id"])) {
      $this->teacher_id = $data["teacher_id"];
    }
    if (isset($data["members_count"]) && !empty($data["members_count"])) {
      $this->members_count = $data["members_count"];
    }
    if (isset($data["description"]) && !empty($data["description"])) {
      $this->description = $data["description"];
    }
  }// object

  public static function get_group($id) {
    /*  
      retuturn: gets all of groups
    */

    global $conn;

    $stmt = $conn->prepare(
      "SELECT g.*, i.id, i.icon FROM groups g
      INNER JOIN icons i ON g.icon = i.id
      WHERE g.id = ?");
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }else {
      return false;
    }

  }// array > group[id]

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

  }// array > group[*]

  public static function get_all_by_teacher($teacher_id) {
    /* retuturn: gets all of teacher's groups */

    global $conn;

    $stmt = $conn->prepare(
      "SELECT G.*, I.id AS icon_id, I.icon AS icon
      FROM groups G
      INNER JOIN icons I ON G.icon = I.id
      WHERE G.teacher_id = ?");
    $stmt->execute([$teacher_id]);

    if ($stmt->rowCount() > 0) {
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }else {
      return false;
    }

  }// array > group[*]{teacher_id}

  public static function get_id_by_teacher($teacher_id) {
    /*  
      takes   : teacher id
      retuturn: gets all of teacher's group's ids
    */

    global $conn;

    $stmt = $conn->prepare(
      "SELECT g.id FROM groups g WHERE g.teacher_id = ?");
    $stmt->execute([$teacher_id]);

    if ($stmt->rowCount() > 0) {
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }else {
      return false;
    }

  }// array > group[*]{teacher_id}

  public static function get_members($group_id) {
    /*
      return : all members of this group
      takes : group id
    */

    global $conn;

    $stmt = $conn->prepare(
      "SELECT U.fullname, U.dxnid, S.id AS student_id FROM groups G
      INNER JOIN students_groups SG ON SG.group_id = G.id
      INNER JOIN students S ON S.id = SG.student_id
      INNER JOIN users U ON U.id = S.user_id
      WHERE G.id = ?");

    $stmt->execute([$group_id]);

    if ($stmt->rowCount() > 0) {
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }else {
      return false;
    }

  }// array > group's members

  public static function get_members_studentid_name($group_id) {
    /*
      return : student_id of all members in this group
      takes : group id
    */

    global $conn;

    $stmt = $conn->prepare(
      "SELECT S.id AS `id`, U.fullname AS `name` FROM groups G
      INNER JOIN students_groups SG ON SG.group_id = G.id
      INNER JOIN students S ON S.id = SG.student_id
      INNER JOIN users U ON U.id = S.user_id
      WHERE G.id = ?");

    $stmt->execute([$group_id]);

    if ($stmt->rowCount() > 0) {
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }else {
      return false;
    }

  }// array > group's members ids

  public static function get_bot_members_students($tacher_dxnid, $teacher_id) {
    /*
      return : "not member" student of this teacher
    */

    global $conn;

    $stmt = $conn->prepare(
      "SELECT S.id AS `student_id`, U.fullname FROM users U
      INNER JOIN students S ON S.user_id = U.id
      WHERE U.dxn_upline = ? AND S.id NOT IN(
        SELECT SG.student_id FROM students_groups SG
        INNER JOIN groups G ON G.id = SG.group_id
        WHERE G.teacher_id = ?
      )");

    $stmt->execute([$tacher_dxnid, $teacher_id]);

    if ($stmt->rowCount() > 0) {
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }else {
      return false;
    }

  }// array > group's members ids

  public static function get_members_count($group_id) {
    /* return : count of all members in group */

    global $conn;

    $stmt = $conn->prepare(
      "SELECT COUNT(SG.id) AS members_count FROM students_groups SG
      INNER JOIN groups G ON G.id = SG.group_id
      WHERE G.id = ?");

    $stmt->execute([$group_id]);

    if ($stmt->rowCount() > 0) {
      return $stmt->fetch(PDO::FETCH_ASSOC)["members_count"];
    }else {
      return false;
    }

  }// int

  public static function get_path_courses($group_id) {
    /*
      return : path's courses for group
      takes : group id
    */

    global $conn;

    $stmt = $conn->prepare(
      "SELECT C.id, C.title, C.description, PC.order FROM groups G
      INNER JOIN paths P ON P.id = G.path_id
      INNER JOIN paths_courses PC ON PC.path_id = P.id
      INNER JOIN courses C ON C.id = PC.course_id
      WHERE G.id = ? ORDER BY PC.order");

    $stmt->execute([$group_id]);

    if ($stmt->rowCount() > 0) {
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }else {
      return false;
    }

  }// array > group's members

  public static function get_path_id($group_id) {

    global $conn;

    $stmt = $conn->prepare(
      "SELECT P.id FROM groups G
      INNER JOIN paths P ON P.id = G.path_id
      WHERE G.id = ?");

    $stmt->execute([$group_id]);

    if ($stmt->rowCount() > 0) {
      return $stmt->fetch(PDO::FETCH_ASSOC)['id'];
    }else {
      return false;
    }

  }// array > group's members

  public static function get_icons() {
    /*
      return : gets all icons
    */

    global $conn;

    $stmt = $conn->prepare(
      "SELECT * FROM icons");

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }else {
      return false;
    }

  }// array > icons

  /*=========== Update Methods ===========*/

  public function update_group() {
    /*
      takes : "group data" you will update
      return : true | false
    */

    global $conn;

    $stmt = $conn->prepare("UPDATE groups G SET `name` = ?, `description` = ?, icon = ?, path_id = ? WHERE G.id = ?");
    $result = $stmt->execute([
      $this->name,
      $this->description,
      $this->icon_id,
      $this->path_id,
      $this->id,
    ]);
    
    return $result;

  }// Boolian

  /*=========== Delete Methods ===========*/

  public static function delete_group($group_id) {
    /* delete groupo from DB */

    global $conn;

    $stmt = $conn->prepare("DELETE FROM `groups` WHERE `groups`.id = ?");
    $result = $stmt->execute([$group_id]);

    return $result;

  }// Boolian

  public static function delete_member($group_id, $member_id) {
    /* deletes member from given group */

    global $conn;

    $stmt = $conn->prepare("DELETE FROM students_groups WHERE student_id = ? AND group_id = ?");
    $result = $stmt->execute([$member_id, $group_id]);

    return $result;

  }// Boolian

}


class Path {
  public $id;
  public $group_id;
  public $teacher_id;
  public $courses = [];

  /*=========== CREATE Methods ===========*/

  public static function add_course($path_id, $course_id) {
    /*============ adds course to spesefic path ============*/

    global $conn;

    $check = $conn->prepare("SELECT PC.id FROM paths_courses PC WHERE PC.path_id = ? AND PC.course_id = ?");
    $check->execute([$path_id, $course_id]);
    
    if ($check->rowCount() == 0) {

      $get_order = $conn->prepare("SELECT MAX(PC.order) + 1 AS `order` FROM paths_courses PC WHERE PC.path_id = ?");
      $get_order->execute([$path_id]);
      
      if ($get_order->rowCount() > 0) {
        $order = $get_order->fetch(PDO::FETCH_ASSOC)["order"];
        if ($order == NULL || $order <= 0 || !is_numeric($order)) {
          $order = 1;
        }
      }else {
        $order = 1;
      }
      
      $add_course = $conn->prepare("INSERT INTO paths_courses (path_id, course_id, `order`) VALUES (?, ?, ?)");
      $result     = $add_course->execute([$path_id, $course_id, $order]);

      return $result;

    }else {
      return false;
    }

  }

  /*=========== RETRIVE Methods ===========*/

  public static function get_addable_courses_id_name($teacher_id, $path_id) {
    /*
      returns all courses that teacher have CLONE permission on it and it's not added to the path before
    */

    global $conn;

    $get_courses = $conn->prepare(
      "SELECT P.value as permission, C.id, C.title
      FROM teachers_courses TC
      INNER JOIN courses C
      ON C.id = TC.course_id
      INNER JOIN permissions P
      ON P.id = TC.permission_id
      WHERE TC.teacher_id = ? AND SUBSTRING(P.value, 6, 1) = 1 AND NOT EXISTS (
        SELECT `order`
        FROM paths_courses PC
        WHERE PC.course_id = C.id AND PC.path_id = ?)
    ");

    $get_courses->execute([$teacher_id, $path_id]);
  
    if ($get_courses->rowCount() > 0) {
      
      return $get_courses->fetchAll(PDO::FETCH_ASSOC);;
    }else {
      return false;
    }

  }

  /*=========== UPDATE Methods ===========*/

  public static function update_course_order($group_id, $course_id, $new_order) {
    /*
      Target [A] [B] [C] : [A] => [C] : [C] [B] [A]
      Step 1 get [A] order As `item_order` : [A] [B] [C] (item_order = [C] position)
      Step 2 [C] => become at [A] position : [CA] [B] [null]
      Step 3 [A] => become at `item_order` : [C] [B] [A]
    */
    global $conn;

    try {
      #    get item's `order`
      $stmt = $conn->prepare("SELECT `order` FROM paths_courses PC
        INNER JOIN groups G ON G.path_id = PC.path_id
        WHERE PC.course_id = ? AND G.id = ?");
      $stmt->execute([$course_id, $group_id]);
      $item_order = $stmt->fetch(PDO::FETCH_ASSOC)["order"];

      #   update target item's `order` to be at the same order of item
      $update_tow = $conn->prepare("UPDATE paths_courses PC
        INNER JOIN groups G ON G.path_id = PC.path_id
        SET PC.order = ? WHERE PC.order = ? AND G.id = ?");
      $update_tow->execute([$item_order, $new_order, $group_id]);
      
      #   update item's `order`
      $update_item = $conn->prepare("UPDATE paths_courses PC
        INNER JOIN groups G ON G.path_id = PC.path_id
        SET PC.order = ? WHERE PC.course_id = ? AND G.id = ?");
      $update_item->execute([$new_order, $course_id, $group_id]);
      
      return true;
    }catch (Exception $e) {
      return $e->getMessage();
    }

  }// Boolian

  /*=========== Delete Methods ===========*/

  public static function delete_course_from_path_by_group($course_id, $group_id) {

    global $conn;

    #   update the order
    $stmt = $conn->prepare("UPDATE paths_courses PC
      INNER JOIN groups G ON G.path_id = PC.path_id
      SET PC.order = PC.order - 1 WHERE PC.order > (
        SELECT `order` FROM paths_courses INNER JOIN groups ON groups.path_id = paths_courses.path_id WHERE course_id = ? AND groups.id = ?
        ) AND G.id = ?");
    $result = $stmt->execute([$course_id, $group_id, $group_id]);

    #   delete course from path
    $stmt = $conn->prepare("DELETE PC FROM paths_courses PC
      INNER JOIN groups G ON G.path_id = PC.path_id
      WHERE PC.course_id = ? AND G.id = ?");
    $result = $stmt->execute([$course_id, $group_id]);

    return $result;

  }// Boolian

}


class Course {
  public $id;
  public $date;
  public $title;
  public $order;// if this course is on a path he must have an order
  public $parent;// if it's sub course "parent" will containe "parent course id"
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

  }// boolian

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

  }// boolian {permission}
  
  private function order($items) {
    /*
      takes     : array of items
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
      takes     : student id & Array Of Items[Lecture, Exam]
      does      : Assign "Open Status" For Every Item
      returns   : array of objects 
    */

    global $conn;

    // get finished items items_order.order_id
    $finished_items_data = $conn->prepare(
      "SELECT student_pass.item_order_id
      FROM student_pass
      INNER JOIN items_order ON items_order.id = student_pass.item_order_id
      WHERE items_order.course_id = ? AND student_pass.student_id = ?");

    $finished_items_data->execute([$this->id, $student_id]);

    if ($finished_items_data->rowCount() > 0) {

      $finished_items_data = $finished_items_data->fetchAll(PDO::FETCH_ASSOC);

      $finished_items = array_column($finished_items_data, "item_order_id");

      // is lecture open or not
      for ($i=0; $i < count($items); $i++):

        if (in_array($items[$i]->order_id, $finished_items)):

          $items[$i]->show_status = 3;// finished

        else:

          $items[$i]->show_status = 2;// open but not finished
          break;

        endif;

      endfor;

      return $items;

    }else {

      $items[0]->show_status = 2;// open but not finished

      return $items;
    }

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
    if (isset($info['order']) && !empty($info['order'])) {
      $this->order = $info['order'];
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

  public static function course_obj($courses_data) {
    if (is_array($courses_data) && count($courses_data) > 0) {
      $cur_objs = [];
      foreach($courses_data as $course_data):
        $course = new Course();
        $course->set_data($course_data);
        array_push($cur_objs, $course);
      endforeach;
      return $cur_objs;
    }else {
      return [];
    }
  }// create objects from arrays

  /*=========== Retrieve Methods ===========*/

  public static function get_courses_by_teacher_id($teacher_id) {
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
  
  public static function get_courses_all() {
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

  public static function get_course($course_id) {
    /* 
      does  : gets all course data
      return: info | false
    */

    global $conn;
    
    $get_course_data = $conn->prepare("SELECT courses.* FROM courses WHERE courses.id = ?");
    $get_course_data->execute([$course_id]);

    
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
      "DELETE lectures FROM lectures
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
      "DELETE exams FROM exams
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

}


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

  /* ============== Create Methods ============== */

  public function item_pass($student_id) {
    /*
    takes: student id & $this->type & $this->id
    does: insert into student_pass table
    returns: true | false
    */

    global $conn;

    $check = $conn->prepare("SELECT id FROM student_pass WHERE student_id = ? AND item_order_id = (SELECT id FROM items_order WHERE item_id = ? AND item_type = ? AND course_id = ?)");
    $check->execute([$student_id, $this->id, $this::TYPE, $this->course_id]);
    
    if ($check->rowCount() == 0) {

      $insertation = $conn->prepare(
        "INSERT INTO student_pass (student_id, item_order_id) VALUES (?, (SELECT id FROM items_order WHERE item_id = ? AND item_type = ? AND course_id = ?))");
      $result = $insertation->execute([$student_id, $this->id, $this::TYPE, $this->course_id]);

      return $result;

    }else {
      return true;
    }

  }

  public function set_data($data) {

    if (isset($data["id"]) && !empty($data["id"])) {
      $this->id = intval($data["id"]);
    }
    if (isset($data["type"]) && !empty($data["type"])) {
      $this->type = intval($data["type"]);
    }
    if (isset($data["order"]) && !empty($data["order"])) {
      $this->order = intval($data["order"]);
    }
    if (isset($data["course_id"]) && !empty($data["course_id"])) {
      $this->course_id = intval($data["course_id"]);
    }

  }

  /* ============== Retrieve Methods ============== */

  public function get_item_type_id($course, $order) {
    /*
      takes   : $order wich is item order && $course wich is course id
      does    : gets item type
      returns : true | false
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

  }

  static public function is_allowed($student_id, $course_id, $item_order) {
    /*
      does    : gets item status using student_pass table
      returns : true | false
    */

    global $conn;

    $stmt = $conn->prepare(
      "SELECT (MAX(items_order.order) + 1) AS `max_order` FROM items_order
      INNER JOIN student_pass ON student_pass.item_order_id = items_order.id
      WHERE items_order.course_id = ? AND student_pass.student_id = ?");
    $stmt->execute([$course_id, $student_id]);

    if ($stmt->rowCount() > 0) {
      $result = $stmt->fetch(PDO::FETCH_NUM)[0];

      if ($item_order <= $result) {
        return true;
      }else {
        return false;
      }
    }else {

      return false;

    }

  }

  public function get_course_id($item_id, $item_type) {
    /*
      takes: item_id, item_type
      gets : course id
    */

    global $conn;

    $stmt = $conn->prepare("SELECT course_id FROM items_order WHERE items_order.item_type = ? AND items_order.item_id = ?");
    $stmt->execute([$item_type, $item_id]);

    if ($stmt->rowCount() > 0) {
      return $stmt->fetch(PDO::FETCH_ASSOC)["course_id"];
    }else {
      return false;
    }

  }

  /* not used yet  */
  static public function get_status($student_id, $course_id, $item_order) {
    /*
      does    : gets item status using student_pass table
      returns : true | false
    */

    global $conn;

    $stmt = $conn->prepare(
      "SELECT (MAX(items_order.order) + 1) AS `max_order` FROM items_order
      INNER JOIN student_pass ON student_pass.item_order_id = items_order.id
      WHERE items_order.course_id = ? AND student_pass.student_id = ?");
    $stmt->execute([$course_id, $student_id]);

    if ($stmt->rowCount() > 0) {
      $result = $stmt->fetch(PDO::FETCH_NUM)[0];

      if ($item_order == $result) {
        return 2;
      }elseif ($item_order < $result) {
        return 3;
      }else {
        return 1;
      }
    }else {
      return 1;
    }

  }

}


class Lecture extends Item {
  const ALL_COURSES = "ALL_LECTURES";
  const TYPE           = 1;// item type
  public $thumbnail;
  public $video;
  public $errors = [];


  /* ============== Process Methods ============== */

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

  }

  private function check_data($check_type = 2) {
    /*
      $check_type = [1 => check for insert, 2 => check for update]
    */

    $errors = [];

    if ($check_type == 1) {

      # video checks
      if (!isset($this->video) || empty($this->video) || !is_object($this->video)) {
        $errors[] = "ther is no video.";
      }else {
        if (!$this->video->validate_data()) {
          foreach ($this->video->errors as $err):
            $errors[] = $err;
          endforeach;
        }
      }
      
      # image checks
      if (!isset($this->thumbnail) || empty($this->thumbnail) || !is_object($this->thumbnail)) {
        $errors[] = "ther is no image.";
      }else {

        if (!$this->thumbnail->validate_data()) {
          foreach ($this->thumbnail->errors as $err):
            $errors[] = $err;
          endforeach;
        }
      }

    }else {

      if (isset($this->video) && !empty($this->video) && is_object($this->video)) {
        if (!$this->video->validate_data()) {
          foreach ($this->video->errors as $err):
            array_push($errors["video"], $err);
          endforeach;
        }
      }

      if (isset($this->thumbnail) && !empty($this->thumbnail) && is_object($this->thumbnail)) {
        if (!$this->thumbnail->validate_data()) {
          foreach ($this->thumbnail->errors as $err):
            array_push($errors["image"], $err);
          endforeach;
        }
      }

      if (!isset($this->title) || empty($this->title) || !is_string($this->title)) {
        $errors["title"] = "title can't be empty.";
      }

      if (!isset($this->description) || empty($this->description) || !is_string($this->description)) {
        $errors["description"] = "description can't be empty.";
      }

    }

    if (count($errors) > 0) {
      $this->errors = $errors;
      return false;
    }else {
      return true;
    }
  }

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
  }
  
  /* ============== Create Methods ============== */

  public function insert_lecture() {
    /*
      does    : get random name for files and upload them than insert into lectures table and items_order table
      returns : true | none
    */

    if ($this->check_data(1)) {

      global $conn;

      # move the files to ther directory
      $video_name_array = explode(".", $this->video->name);
      $image_name_array = explode(".", $this->thumbnail->name);
      $tmp_name_one = $this->token(10) . "." . end($video_name_array);
      $tmp_name_tow = $this->token(10) . "." . end($image_name_array);
      
      $result1 = move_uploaded_file($this->video->tmp_name, $_SERVER["DOCUMENT_ROOT"] . '/dxnln' . lecturesURL . $tmp_name_one);
      
      $result2 = move_uploaded_file($this->thumbnail->tmp_name, $_SERVER["DOCUMENT_ROOT"] . '/dxnln' . thumbURL . $tmp_name_tow);

      // Lectures Table Insert
      $stmt = $conn->prepare(
        "INSERT INTO
            lectures (`title`, `description`, `video`, `thumbnail`, `date`)
          VALUES
            (:title, :description, :video, :thumbnail, NOW())");

      $stmt->execute([":title" => $this->title, ":description" => $this->description, ":video" => $tmp_name_one, ":thumbnail" => $tmp_name_tow]);
      
      $this->id = $conn->lastInsertId();
  
      $stmt = $conn->prepare("SELECT MAX(items_order.order) + 1 FROM items_order WHERE course_id = ?");

      $stmt->execute([$this->course_id]);

      $order = $stmt->fetch(PDO::FETCH_NUM)[0];

      $this->order = is_numeric($order) && $order > 0 ? $order : 1;

      $stmt = $conn->prepare(
        "INSERT INTO
              items_order (course_id, item_id, item_type, `order`)
        VALUES
              (:course_id, :item_id, 1, :order)");

      $result = $stmt->execute([":course_id" => $this->course_id, ":order" => $this->order, ":item_id" => $this->id]);

      return $result;
      
    }else {// if ther is no errors
      return false;
    }

  }

  /* ============== Retrieve Methods ============== */

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

  }

  /* ============== Update Methods ============== */

  public function update() {
    /*
      returns : array containes lecture info
    */

    global $conn;

    if ($this->check_data(2)) {
      $stmt = $conn->prepare(
        "UPDATE lectures SET title = ?, `description` = ?, `date` = NOW()
        WHERE lectures.id = ?");
      $result = $stmt->execute([$this->title, $this->description, $this->id]);

      if ($result) {
        return true;
      }else {
        return false;
      }
    }else {
      return false;
    }


  }
  
  /* ============== Delete Methods ============== */

  public function delete_lecture() {
    /*
      does: removes lecture from lectures table and make sure the items_order.order is right
      returns: true |false
    */

    global $conn;

    $update_order = $conn->prepare(
      "UPDATE items_order SET `order` = (`order` - 1)
      WHERE `order` > (SELECT items_order.order FROM items_order WHERE items_order.item_id = ? AND items_order.item_type = ?)
      AND items_order.course_id = (SELECT items_order.course_id FROM items_order WHERE items_order.item_id = ? AND items_order.item_type = 1)");
    $update_order->execute([self::TYPE, $this->id, $this->id]);

    $order_delete = $conn->prepare(
      "DELETE lectures, items_order FROM lectures
      INNER JOIN items_order ON lectures.id = items_order.item_id
      WHERE lectures.id = ? AND items_order.item_type = ?");
    
    $result = $order_delete->execute([$this->id, self::TYPE]);

    return $result;

  }// end of delete_lecture method

}


class Exam extends Item {
  const TYPE      = 2;// item type
  public $percent = 70;// default degree to success
  public $questions_count = 1;
  public $questions = [];
  
  /* =========== Process Methods =========== */

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
    if (isset($data["date"])) {
      $this->date = $data["date"];
    }
    if (isset($data["day_before"])) {
      $this->day_before = $data["day_before"];
    }
  }

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
  }
  
  /* =========== Create Methods =========== */

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
  }

  /* =========== Retrieve Methods =========== */

  public function get_id_by_order($course_id, $exam_order) {
    /*
      takes   : course id & exam order
      return  : exam id | false
    */

    global $conn;

    $stmt = $conn->prepare(
      "SELECT exams.id FROM exams
      INNER JOIN items_order ON items_order.item_id = exams.id
      WHERE items_order.item_type = ? AND items_order.course_id = ? AND items_order.order = ?");

    $stmt->execute([Exam::TYPE, $course_id, $exam_order]);

    if ($stmt->rowCount() > 0) {
      return $stmt->fetch(PDO::FETCH_NUM)[0];
    }else {
      return false;
    }

  }
  
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

  }

  public function get_questions() {
    /*
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
        $answers_info = $answers->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($questions as $info):
          $quest = new Question();
          $quest->set_data($info);
          $this->questions[] = $quest;
        endforeach;

        $answers = [];
        foreach($answers_info as $info):
          $ansr = new Answer();
          $ansr->set_data($info);
          array_push($answers, $ansr);
        endforeach;

        foreach($this->questions as $quest):
          foreach($answers as $ansr):
            if ($ansr->question_id == $quest->id) {
              $quest->answers[] = $ansr;
            }
          endforeach;
        endforeach;
        unset($answers);
        return true;
      }else {
        return false;
      }
    }else {
      return false;
    }

  }

  public function get_questions_answers_id() {
    /*
      does: gets [questions ids, answers ids, is_right] for this exam
      returns: info | false
    */
    global $conn;

    $questions = $conn->prepare("SELECT id FROM questions WHERE exam_id = ?");
    $questions->execute([$this->id]);

    if ($questions->rowCount() > 0) {
      $questions = $questions->fetchAll(PDO::FETCH_ASSOC);
      
      $multi_answers = $conn->prepare(
        "SELECT answers.id, answers.question_id FROM answers
        INNER JOIN questions ON questions.id = answers.question_id
        WHERE questions.exam_id = ? AND questions.multible_option = 2");
      $multi_answers->execute([$this->id]);
      
      $single_answers = $conn->prepare(
        "SELECT answers.id, answers.question_id FROM answers
        INNER JOIN questions ON questions.id = answers.question_id
        WHERE questions.exam_id = ? AND questions.multible_option = 1 AND answers.is_right = 2");
      $single_answers->execute([$this->id]);
      
      if ($multi_answers->rowCount() > 0  || $single_answers->rowCount() > 0) {
        $answers_info = array_merge($single_answers->fetchAll(PDO::FETCH_ASSOC), $multi_answers->fetchAll(PDO::FETCH_ASSOC));

        foreach($questions as $info):
          $quest = new Question();
          $quest->set_data($info);
          $this->questions[] = $quest;
        endforeach;

        $answers = [];
        foreach($answers_info as $info):
          $ansr = new Answer();
          $ansr->set_data($info);
          array_push($answers, $ansr);
        endforeach;

        foreach($this->questions as $quest):
          foreach($answers as $ansr):
            if ($ansr->question_id == $quest->id) {
              $quest->answers[] = $ansr;
            }
          endforeach;
        endforeach;
        unset($answers);
        return true;
      }else {
        return false;
      }
    }else {
      return false;
    }

  }

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

  }

  /* =========== Delete Methods =========== */

  public function delete_exam() {
    /*
      does: removes exam from exams table and make sure the order is right
      returns: true | false
    */

    global $conn;

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

    return $result;

  }

}


class ExamProces {

  public $id;
  public $min_mark;
  public $compare_table = [];// Assocative Array [Q_id => [Q_obj.answers, Q_mark]]

  /* =========== Process Methods =========== */

  public function compare_answers($student_answers) {
    /*
      takes   : student answers and compare it with compare_table answers
      does    : fills "compare table" with [student answer]
    */

    # question loop 
    foreach ($this->compare_table as $index => $question):

      $grade_part = (100 / count($question[0]->answers));

      # answers loop
        foreach ($question[0]->answers as $answer):

          if (is_array($student_answers[$question[0]->id])) {// it's multi choices
            if ($answer["is_right"] == 2) {// 2 = answer is right
              if (in_array($answer["id"], $student_answers[$question[0]->id])) {
                $question[1] = intval($question[1]) + $grade_part;
              }
            }else {
              if (!in_array($answer["id"], $student_answers[$question[0]->id])) {
                $question[1] = intval($question[1]) + $grade_part;
              }
            }
          }else {
          
            if ($answer["is_right"] == 2) {// 2 = answer is right

              if ($answer["id"] == $student_answers[$question[0]->id]) {
                $question[1] = 100;
              }

            }
          }
          
        endforeach;
        
        // Remove Other Answers After All Calculations And Let The Ones That Was Selected From The User
        foreach ($this->compare_table[$index][0]->answers as $x => $ansr):
          if (is_array($student_answers[$index])) {
            if (!in_array($ansr["id"], $student_answers[$index])) {
              unset($this->compare_table[$index][0]->answers[$x]);
            }
          }else {
            if ($student_answers[$index] != $ansr["id"]) {
              unset($this->compare_table[$index][0]->answers[$x]);
            }
          }
        endforeach;
        
        $this->compare_table[$index][1] = ceil($question[1]);
    endforeach;
  }

  public function some_markes() {
    $full_marke = 0;
    
    foreach ($this->compare_table as $question):

        $full_marke += (100 / count($this->compare_table)) * ($question[1] / 100);
      
    endforeach;
    return $full_marke;
  }

  /* =========== Retrieve Methods =========== */

  public function get_compare_table() {
    /*
      does    : fills "compare table" with "Q_id => [question_obj, 0]"
      returns : true | false
    */

    global $conn;

    $questions_data = $conn->prepare("SELECT questions.id FROM questions WHERE questions.exam_id = ?");
    $questions_data->execute([$this->id]);

    if ($questions_data->rowCount() > 0) {
      $questions_data = $questions_data->fetchAll(PDO::FETCH_ASSOC);

      foreach ($questions_data as $question_data):

        $question = new Question();
        $question->set_data($question_data);
        $question->get_answers_id_status();

        $this->compare_table[$question->id][0] = $question;
        $this->compare_table[$question->id][1] = 0;// question full grade
      endforeach; 

      return true;
    }else {
      return false;
    }

  }

  public function get_min_mark() {
    /*
      does: gets min mark
    */

    global $conn;

    $stmt = $conn->prepare("SELECT exam_percent FROM exams WHERE exams.id = ?");
    $stmt->execute([$this->id]);

    if ($stmt->rowCount() > 0) {
      return $stmt->fetch(PDO::FETCH_NUM)[0];
    }else {
      return false;
    }

  }

  /* =========== Create Methods =========== */

  public function add_recorde($student_id) {
    /* saves answers and date of exam take */

    global $conn;

    
    $exam_take_insert = $conn->prepare("INSERT INTO exam_take (exam_id, student_id, `date`) VALUES (?, ?, NOW())");
    $conn->beginTransaction();
    $result = $exam_take_insert->execute([$this->id, $student_id]);

    $exam_take_id = $conn->lastInsertId();
    $conn->commit();
    $conn->beginTransaction();

    foreach($this->compare_table as $question_id => $question) {

      $answers_insert = $conn->prepare("INSERT INTO exams_answers (exam_take, question_id, `grade`) VALUES (?, ?, ?)");
      $answers_insert->execute([$exam_take_id, $question_id, $question[1]]);

    }
    
    $conn->commit();

    return $result;
  }

}


class Question {
  const ADMIN = "ADMIN";
  public $id;
  public $exam_id;
  public $question;
  public $answers = [];
  public $update = [];
  public $multible_option = 2;// 2 true | 1 false
  // public $grade = 0;// used in exam-proces to save grade
  public $important = 0;
  public $order;
  public $errors = [];

  /*=========== Process Methods ===========*/

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
    if (isset($info["answers"]) && !empty($info["answers"] && is_array($info["answers"]))) {
      foreach ($info["answers"] as $answer_info) {
        $answer = new Answer();
        $answer->set_data($answer_info);
        array_push($this->answers, $answer);
      }
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

  }

  private function check_data() {
    /* 
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

  }

  /*=========== Create Methods ===========*/

  public function insert_question() {
    /*
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

      $conn->beginTransaction();

      if ($question->execute([
          ":exam_id"          => $this->exam_id,
          ":question"         => $this->question,
          ":important"        => $this->important,
          ":order"            => $this->order,
          ":multible_option"  => $this->multible_option,
      ])) {

        $this->id = $conn->lastInsertId();
        
        $conn->commit();

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

        $result = $insert->execute($arg);

        return $result;
        
      }else {
        return false;
      }// end "question insert" check

    }// end "there is error"

  }

  /*=========== Retrieve Methods ===========*/

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

      }else {
        return false;
      }
    }else {// field to get question
      return false;
    }

  }

  public function get_question($id) {
    /*
      takes   : question id
      does    : gets data of question givin
      returns : info | false
    */

    global $conn;

    $question = $conn->prepare("SELECT questions.* FROM questions WHERE questions.id = ?");
    $question->execute([$id]);
      
    if ($question->rowCount() > 0) {
      $question = $question->fetch(PDO::FETCH_ASSOC);

      $answers = $conn->prepare("SELECT answers.* FROM answers WHERE answers.question_id = ?");
      $answers->execute([$id]);

      if ($answers->rowCount() > 0) {
        $answers = $answers->fetchAll(PDO::FETCH_ASSOC);

        $question["answers"] = $answers;
        return $question;
  
      }else {
        return false;
      }
    }else {
      return false;
    }
      
  }

  public function get_answers_id_status() {
    /*
      does    : gets id and status for question answers
      returns : info | false
    */

    global $conn;

    $answers = $conn->prepare("SELECT answers.id, answers.is_right FROM answers WHERE answers.question_id = ?");
    $answers->execute([$this->id]);

    if ($answers->rowCount() > 0) {
      $answers = $answers->fetchAll(PDO::FETCH_ASSOC);

      $this->answers = $answers;
      
      return true;
    }else {
      return false;
    }
      
  }

  /*=========== Update Methods ===========*/

  public function update_question() {
    /*
      does    : updates Question And Answers In Questions and Answers Tables
      returns : true | false
    */

    $this->check_data();
    if (count($this->errors) > 0) {
      foreach($this->errors as $error):
        echo $error;
      endforeach;
      exit();
    }else {

      global $conn;

      // Update The Question
      $question = $conn->prepare(
        "UPDATE questions SET
        `question` = :question, `important` = :important, `multible_option` = :multible_option
        WHERE id = :id");

      if ($question->execute([
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
            $upd->update_answer();
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

  }

  /* =========== Delete Methods =========== */
  
  public function delete_question_by_order($exam_id, $order) {
    /*
      takes   : exam id & question order
      does    : delete question and his answers
      returns : true | false
    */

    global $conn;

    $question = $conn->prepare(
      "DELETE FROM questions WHERE questions.exam_id = ? AND questions.order = ?");
    $result = $question->execute([$exam_id, $order]);

    return $result;

  }

}


class Answer {
  public $id;
  public $answer;
  public $is_right = 1;// 1 false | 2 true
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
    if ($this->is_right != 1 && $this->is_right != 2) {
      $this->errors[] = "is_right can't Be empty Or any Type but Int";
    }
    if (!isset($this->answer) || empty($this->answer)) {
      $this->errors[] = "answer can't be empty";
    }else {
      $this->answer = htmlspecialchars($this->answer);
    }

    return count($this->errors) > 0 ? false : true;
    
  }// end of set_data method

  public function insert_answer() {
    /*
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

  }

  public function update_answer() {
    /*
      does  : update answer info
      return: true | false
    */

    global $conn;

    if ($this->check_data()) {
      $stmt = $conn->prepare("UPDATE answers SET answer = ?, is_right = ? WHERE id = ?");
      $result = $stmt->execute([$this->answer, $this->is_right, $this->id]);
  
      return $result;
    }else {
      return false;
    }


  }

}


class File {
  public $name;
  public $type;
  public $tmp_name;
  public $error = 0;
  public $size;
  public $errors = [];
  
    public function MB($bite) {
      return ((($bite / 8) / 1024) / 1024);
    }

    protected function __construct($data) {
      if (isset($data["name"]) && !empty($data["name"]) && is_string($data["name"])) {
        $this->name = $data["name"];
      }
      if (isset($data["type"]) && !empty($data["type"])) {
        $this->type = $data["type"];
      }
      if (isset($data["tmp_name"]) && !empty($data["tmp_name"]) && is_string($data["tmp_name"])) {
        $this->tmp_name = $data["tmp_name"];
      }
      if (isset($data["error"]) && !empty($data["error"]) && is_numeric($data["error"])) {
        $this->error = $data["error"];
      }
      if (isset($data["size"]) && !empty($data["size"]) && is_numeric($data["size"])) {
        $this->size = $data["size"];
      }
    }
  
    protected function general_validation($accepted = [], $name, $max_size) {
  
      $errors = [];
  
      $extn = explode(".", $this->name);
  
      if (in_array(end($extn), $accepted)) {
  
        if ($this->MB($this->size) > $max_size) {
          $errors[] = $name . " is larger then max allowed size";
  
        }elseif ($this->MB($this->size) == 0) {
          $errors[] = $name . " size is 0";
        }
          
      }else {
        $errors[] = "this file is not allowed";
      }
  
      if ($this->error !== 0) {
        $errors[] = "something wrong on this file";
      }
  
      if (count($errors) > 0) {
        $this->errors = $errors;
        return false;
      }else {
        return true;
      }
  
    }

}


class Image extends File {
  const NAME = "Image";
  const ACCEPTED = [// File Types
    "jpg",
    "jpeg",
    "png",
    "webp",
    "gif",
  ];
  const MAX_SIZE = 0.5;// MB/mega byte

  public function __construct($data) {
    parent::__construct($data);
  }

  public function validate_data() {
    $this->general_validation(self::ACCEPTED, self::NAME, self::MAX_SIZE);
  }

}


class Video extends File {
  const NAME = "Video";
  const ACCEPTED = [// File Types
    "mp4",
    "webm"
  ];
  const MAX_SIZE = 0.5;// MB/mega byte

  public function __construct($data) {
    parent::__construct($data);
  }
  
  public function validate_data() {
    $this->general_validation(self::ACCEPTED, self::NAME, self::MAX_SIZE);
  }
}
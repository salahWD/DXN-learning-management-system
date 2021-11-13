<?php

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $info = [
      "title"       => $_POST["title"],
      "description" => $_POST["desc"],
      "is_enable"   => isset($_POST["private"]) ? 1: 2,
    ];
    
    $course = new Course();

    if ($user::USER_TYPE == 1) {
      if (isset($_POST["course_owner"]) && !empty($_POST["course_owner"]) && is_numeric($_POST["course_owner"])) {
        $info["course_owner"] = $_POST["course_owner"];
      }
    }
    
    $course->set_data($info);
    
    $user->insert_course($course);

    header("Location: " . theURL . language . "/manage-course");
    exit();

  }?>

<div class="container">
  <div class="col-md-8 offset-2 mt-md-5">
    <form action="<?php echo theURL . language . '/course-add';?>" method="POST" enctype="multipart/form-data">
      
      <!-- Title input -->
      <div class="form-outline mb-4">
        <div class="form-outline">
          <label class="form-label" for="name">العنوان</label>
          <input type="text" id="name" name="title" placeholder="عنوان الدورة" class="form-control"
          <?php echo isset($_POST['title']) ? 'value="' . $_POST["title"] . '"': '';?>/>
        </div>
      </div>
    
      <!-- Description textarea -->
      <div class="form-outline mb-4">
        <label class="form-label" for="desc">الوصف</label>
        <textarea id="desc" placeholder="وصف الدورة" name="desc" class="form-control"><?php echo isset($_POST['desc']) ? $_POST["desc"]: '';?></textarea>
      </div>

      <!-- is_private Checkbox -->
      <div class="form-check  mb-4">
        <label class="form-check-label" for="private">خاص</label>
        <input class="form-check-input float-none me-2" type="checkbox" id="private" name="private"
        <?php echo isset($_POST["private"]) == "on" ? 'checked': '';?>/>
      </div>

      <!-- Submit button -->
      <button type="submit" class="btn btn-primary w-100">Create</button>
      
    </form>
  </div>
</div>
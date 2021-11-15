<?php
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      
      $exam_data = [// all form data
        "course_id"     => $URL[2],
        "title"         => $_POST["title"],
        "percent"       => $_POST["percent"],
        "description"   => $_POST["description"],
      ];
  
      $exam = new Exam();
      $exam->set_data($exam_data);

      if ($exam->insert_exam()) {
        header("Location: " . theURL . language . "/manage-course/" . $exam->course_id);
        exit();
      }else {
        echo "Error: No Insert Exam";
        exit();
      }

      
    }// end "if method == post" check
  
?>

<div class="container">
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8 mt-md-5">
      <form action="<?php echo theURL . language . '/exam-create/' . $URL[2];?>" method="POST" enctype="multipart/form-data">
        
        <!-- Title input -->
        <div class="form-outline mb-4">
          <div class="form-outline">
            <label class="form-label" for="title">Title</label>
            <input type="text" id="title" name="title" placeholder="Exam Title" class="form-control"
            <?php echo isset($_POST['title']) ? 'value="' . $_POST["title"] . '"': '';?>/>
          </div>
        </div>
      
        <!-- Description textarea -->
        <div class="form-outline mb-4">
          <label class="form-label" for="desc">Description</label>
          <textarea id="desc" placeholder="Exam Description" name="description" class="form-control"><?php echo isset($_POST['description']) ? $_POST["description"]: '';?></textarea>
        </div>

        <!-- Percent input -->
        <div class="form-outline mb-4">
          <label class="form-label" for="Percent">Percent</label>
          <input type="number" id="Percent" placeholder="Success Percent" name="percent" class="form-control" />
        </div>
      
        <!-- Submit button -->
        <button type="submit" class="btn btn-primary mb-4">Create</button>
        
      </form>
    </div>
    <div class="col-md-2"></div>
  </div>
</div>

      <!-- Checkbox -->
      <!-- <div class="form-check d-flex justify-content-center mb-4">
        <input
          class="form-check-input me-2"
          type="checkbox"
          value=""
          id="form2Example3"
          checked
        />
        <label class="form-check-label" for="form2Example3">
          Subscribe to our newsletter
        </label>
      </div> -->

      <!-- Register buttons -->
      <!-- <div class="text-center">
        <p>or sign up with:</p>
        <button type="button" class="btn btn-primary btn-floating mx-1">
          <i class="fab fa-facebook-f"></i>
        </button>
    
        <button type="button" class="btn btn-primary btn-floating mx-1">
          <i class="fab fa-google"></i>
        </button>
    
        <button type="button" class="btn btn-primary btn-floating mx-1">
          <i class="fab fa-twitter"></i>
        </button>
    
        <button type="button" class="btn btn-primary btn-floating mx-1">
          <i class="fab fa-github"></i>
        </button>
      </div> -->
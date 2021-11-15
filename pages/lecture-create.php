<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      
      $lecture_data = [// all form data
        "course_id"     => intval($URL[2]),
        "title"         => $_POST["title"],
        "description"   => $_POST["desc"],
        "video"         => new Video($_FILES["video"]),
        "thumbnail"     => new Image($_FILES["thumb"]),
      ];

      $lecture = new Lecture();
      $lecture->set_data($lecture_data);

      if ($lecture->insert_lecture()) {
        header("Location: " . theURL . language . "/manage-course/" . $lecture->course_id);
        exit();
      }else {
        echo "Error: On Insert_lecture() started";
        exit();
      }

    }
  
?>

  <div class="container">
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8 mt-md-5">
        <form action="<?php echo theURL . language . "/lecture-add/" . intval($URL[2]);?>" method="POST" enctype="multipart/form-data">
          
          <!-- Title input -->
          <div class="form-outline mb-4">
            <div class="form-outline">
              <label class="form-label" for="title">Title</label>
              <input type="text" id="title" class="form-control" name="title" placeholder="Lecture Title"
              <?php echo isset($_POST['title']) ? 'value="' . $_POST["title"] . '"': '';?>/>
            </div>
          </div>
        
          <!-- Description textarea -->
          <div class="form-outline mb-4">
            <label class="form-label" for="desc">Description</label>
            <textarea id="desc" placeholder="Lecture Description" name="desc" class="form-control"><?php echo isset($_POST['desc']) ? $_POST["desc"]: '';?></textarea>
          </div>

          <!-- Video File Input -->
          <div class="form-outline  mb-4">
            <label class="form-label" for="video">Video</label>
            <input type="file" class="form-control" id="video" name="video"
            accept="
            <?php foreach (Video::ACCEPTED as $ext):
              echo "." . $ext . ", ";
            endforeach;?>"
            />
          </div>

          <!-- Thumbnail File Input -->
          <div class="form-outline  mb-4">
            <label class="form-label" for="thumb">Thumbnail</label>
            <input type="file" class="form-control" id="thumb" name="thumb"
            accept="
            <?php foreach (Image::ACCEPTED as $ext):
              echo "." . $ext . ", ";
            endforeach;?>"
            />
          </div>

          <!-- Submit button -->
          <button type="submit" class="btn btn-primary w-100">Create</button>
          
        </form>
      </div>
      <div class="col-md-2"></div>
    </div>
  </div>
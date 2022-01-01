<?php

# in SESSION { exam_result } should be :
    # course_id
    # exam_id
    # exam_title
    # exam_full_mark
    # questions_marks
    # exam_min_mark

  
if (isset($_SESSION["exam_result"]) && !empty($_SESSION["exam_result"])):
  $result = $_SESSION["exam_result"];?>

  <div class="container">
    <div class="result" id="result">
      <div class="alert text-center mt-4 mb-3" id="result-alert">
        <h4 class="fw-bold" id="result-status"><?php echo $result["exam_title"];?></h4>
        <p class="lead" id="result-text">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
        <div class="card bordered" id="result-itemsContaioner">
          <ul class="list-unstyled list-group list-group-flush border <?php if ($result["exam_min_mark"] <= $result["exam_full_mark"]) {echo "border-success";}else {echo "border-danger";}?>" id="result-items">
            <?php foreach($result["questions_marks"] as $question):?>
            <li class="list-grou-item alert alert-dark">
              <div class="m-0 p-1">
                id: <?php echo $question[0]->id;?><br/>
                <?php foreach($question[0]->answers as $ansr):?>
                  <div class="alert <?php echo $ansr["is_right"] == 2 ? "alert-success" : "alert-danger";?>">
                  <?php echo $ansr["id"];?>
                  </div>
                <?php endforeach;?>
              </div>
              <span class="grade"><?php echo $question[1]?></span>
            </li>
            <?php endforeach;?>
          </ul>
        </div>
      </div>
      <div class="d-flex justify-content-around mt-4 pb-4">
        <a class="btn btn-success" href="<?php echo theURL . language . "/course/" . $result["course_id"];?>">Next</a>
        <a class="btn btn-danger" href="<?php echo theURL . language . "/view/" . $result["course_id"];?>">Cancel</a>
      </div>
    </div>
  </div>
<?php else:?>

  <div class="container">
    <div class="alert alert-danger text-center mt-4">
      <h3>No Result</h3>
      <p class="lead">there is no exam result</p>
    </div>
  </div>

<?php endif;?>

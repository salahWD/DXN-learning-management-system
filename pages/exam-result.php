<?php

if (isset($_SESSION["exam_result"]) && !empty($_SESSION["exam_result"])):
  $result = $_SESSION["exam_result"];?>
  <div class="container">
    <h2 class="text-center mb-3"><?php echo $result["exam_title"];?></h2>
    <?php if ($result["percent"] >= $result["require_percent"]):?>
      <div class="alert alert-success text-center">
        <h4 class="fw-bold">Success</h4>
        <p class="lead">You Got: <?php echo $result["percent"];?> But This Exam Require <?php echo $result["require_percent"];?></p>
      </div>
    <?php else:?>
      <div class="alert alert-danger text-center">
        <h4 class="fw-bold">Field</h4>
        <p class="lead">You Got: <?php echo $result["percent"];?> But This Exam Require <?php echo $result["require_percent"];?></p>
      </div>
    <?php endif;?>
  </div>
<?php else:?>

  <div class="container">
    <div class="alert alert-danger text-center mt-4">
      <h3>No Result</h3>
      <p class="lead">there is no exam result</p>
    </div>
  </div>

<?php endif;?>
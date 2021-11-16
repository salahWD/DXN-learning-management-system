<?php

echo json_encode(["msg" => "REQUEST METHOD is GET"]);
exit();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["answers"]) && !empty($_POST["answers"])) {
    $answers = $_POST["answers"];
    echo json_encode($answers);
  }
}else {
  echo json_encode(["msg" => "REQUEST METHOD is GET"]);
}
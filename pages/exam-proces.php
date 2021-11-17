<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["exam_id"]) && !empty($_POST["exam_id"]) && is_numeric($_POST["exam_id"])) {

    $student_exam = new Exam();
    $student_exam->id         = intval($_POST["exam_id"]);

    if (isset($_POST["questions"]) && !empty($_POST["questions"]) && is_array($_POST["questions"])) {

      foreach ($_POST["questions"] as $question_info):

        $question = new Question();
        $question->set_data($question_info);
        array_push($exam->questions, $question);

      endforeach;

      $exam = new Exam();
      $exam->id = $student_exam->id;
      $exam->get_questions_answers_id();

      foreach ($exam->questions as $question):
        foreach ($student_exam->questions as $student_question):
          if ($question->id == $student_question) {
            if ($question->multible_option == 2) {// right answer is multible
              
              foreach ($question->answers as $answer):
                foreach ($student_question->answers as $student_answer):

                  if ($answer->is_right == 2) {
                    if ($answer->id == $student_answer->id) {
                      $student_question->grade += (count($question->answers) / 100);
                    }
                  }else {
                    // $student_answers_filltered = array_filter($array, function($obj) {
                    //   if (isset($obj->admins)) {
                    //       foreach ($obj->admins as $admin) {
                    //           if ($admin->member == 11) return false;
                    //       }
                    //   }
                    //   return true;
                    // });
                    if ($answer->id == $student_answer->id) {// you shold use array_fillter to fillter the objects inside the array
                      // $student_question->grade += (count($question->answers) / 100);
                    }
                  }

                endforeach;
              endforeach;

            }else {// right answer is just one
              if ($question->answers[0]->id == $student_question->answers[0]->id) {
                $student_question->grade = 100;
              }else {
                $student_question->grade = 0;
              }
            }
          }
        endforeach;
      endforeach;

    }
    print_r($exam);
    // echo json_encode(true);
  }else {
    // echo json_encode(false);
  }
}else {
  header("Location: " . theURL . language . "/login");
  exit();
}
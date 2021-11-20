<?php
if (isset($_GET["url"]) && !empty($_GET["url"])) {

  $LANGS = [
    'ar',
    'en'
  ];
  
  $get_arguments = $_GET["url"];
  $get_arguments = rtrim($get_arguments, '/');
  $URL = explode('/', $get_arguments);
  
  if (isset($URL[0]) && !empty($URL[0])) {// language check

    if (in_array($URL[0], $LANGS)) {// define the language

      $LANG = $URL[0];

      if (isset($URL[1]) && !empty($URL[1])) {// page check

        $page =  new page();
        $page->set_data($page->get_page($URL[1]));

        if (!empty($page->id) && $page->id != false) {

          session_start();

          if (isset($_SESSION["user"]) && !empty($_SESSION["user"])) {
            $user = $_SESSION["user"];
          }

          if ($page->type == "login") {// Login Check
            if (!isset($_SESSION["user"]) || empty($_SESSION["user"])) {
              echo "You Have To Login";
              exit();
            }
          }elseif ($page->type == "admin") {// Just Admin Can Enter
            if (!isset($_SESSION["user"]) || empty($_SESSION["user"]) || $_SESSION["user"]::USER_TYPE != 1) {
              echo "You Have No Access To This Page";
              exit();
            }
          }elseif ($page->type == "manage") {// Admin OR Teacher
            if (!isset($_SESSION["user"]) || $_SESSION["user"]::USER_TYPE > 2 || $_SESSION["user"]::USER_TYPE < 1) {
              echo "You Have No Access To This Page<br/>";
              exit();
            }
          }

          if ($page->arguments >= 1) {
            if (!isset($URL[2]) || empty($URL[2]) || !is_numeric($URL[2])) {
              echo "ther is no " . '$URL[2]' . " wich is " . '$item_id';
              exit();
            }
          }
          if ($page->arguments >= 2) {
            if (!isset($URL[3]) || empty($URL[3]) || (!is_numeric($URL[3]) && $URL[3] != "add" && $URL[3] != "del")) {
              echo "ther is no " . '$URL[3]';
              exit();
            }
          }
          if ($page->arguments >= 3) {
            if (!isset($URL[4]) || empty($URL[4]) || !is_numeric($URL[4])) {
              echo "ther is no " . '$URL[4]';
              exit();
            }
          }
          
        }else {// No Page In DB
          header("Location: " . theURL . language . '/error');// error_redirect
          exit();
        }
      }else {// No Page Argument
        header("Location: " . theURL . language . '/error');// error_redirect
        exit();
      }
    }else {// Language Is Foriegn
      header("Location: " . theURL . language . '/error');// error_redirect
      exit();
    }
  }else {// No Langage Argument
    header("Location: " . theURL . language . '/error');// error_redirect
    exit();
  }
}else {// No Get Argument At All
  header("Location: " . theURL . language . '/error');// error_redirect
  exit();
}


?>
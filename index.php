<?php
include 'config.php';
include 'connect.php';
include 'class.php';
include 'init.php';

if (isset($page)) {

  if ($page->components == 3) {// only include the file

    include './pages/' . $page->file;

  }elseif ($page->components == 2) {// include the page without header and footer

    include 'head.php';
    include './pages/' . $page->file;
    include 'end.php';
    
  }else {// include header and footer
    include 'head.php';
    include 'header.php';
    include './pages/' . $page->file;
    include 'footer.php';
    include 'end.php';// end is the close of the page becuse somtimes you dont wanna include the footer so you just end the page like that
  }
  
}else {
  // error
  include './pages/404.php';
}

?>
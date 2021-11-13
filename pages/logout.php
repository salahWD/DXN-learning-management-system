<?php
session_unset();
session_destroy();
header("Location: " . theURL . language . '/home');// redirect
exit();
?>
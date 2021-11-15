<?php

  // DB Connection
  try {
    $dsn = 'mysql:dbname='.dbname.';host='.hostip;
    $conn = new PDO($dsn, username, password);
  }catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
  }

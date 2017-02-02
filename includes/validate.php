<?php
  function validate_input($data) {
    if(isset($data)){
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
      return $data;
    }
    else{
      return "";
    }
  }
 ?>

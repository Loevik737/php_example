<!DOCTYPE html>
<?php
//start the session so we can check if a user is logged in or hare the right privelages later
//the token is to prevnt CSRF attacks
session_start();
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
  //connect to the datavase via the connect.php script
  include("includes/connect.php");
  include("includes/validate.php");
?>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>User example</title>
</head>
<body>

  <section class="container">
  <?php
    //if we go to index only we will be sent to login
    if (empty($_GET["feature"])) {
        include("features/login.php");
    }
    //if fe pas a parameter to feature we wil try to bo to that location
    else if (file_exists("features/" . $_GET["feature"] . ".php") && isset($_SESSION["logged_in"]) ) {
        if($_SESSION["logged_in"]){
          include("features/" . $_GET["feature"] . ".php");
        }
    }
    //if we cant find it we give the 404 page as a response
    else {
        include("404.php");
    }
  ?>
  </section>

</body>
</html>

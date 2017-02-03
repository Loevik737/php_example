<?php

//checks if user is logged in by checking  the session parameter
function is_logged_in() {
    if (!empty($_SESSION["logged_in"])) {
      if($_SESSION["logged_in"]){
        return TRUE;
      }
    } else {
        return FALSE;
    }
}

//function for setting the session parameter logged_in true so we can check if a user is logged in
function log_in() {
    echo "logged in as " . $_SESSION["name"];
    exit();
}

//if we are already logged in we just go to the login function
if (is_logged_in()) {
    /* Already logged in */
    log_in();
    //by pressing the submit button in the html the submitted parameter wil be set and we can contineue
    //the if statement if the token match
} else if (!empty($_POST["submitted"]) && ($_POST["token"] === $_SESSION["token"])) {
    /* User is trying to log in */
    $email = validate_input($_POST["email"]);
    $passwd = validate_input($_POST["password"]);
    //preparing sql call that cant be sql injected
    //we may limit the things we request and rather request them after the login is confirmed?
    $sql = $conn->prepare("SELECT password FROM user WHERE email= ?");
    $sql->bind_param('s', $email);
    //the sql call in now ready for the query
    $sql->execute();
    $result = $sql->get_result();
    //if the query was successful we wil get more than 0 rows back
    if (mysqli_num_rows($result) >= 1) {
        $row = mysqli_fetch_assoc($result);
        //using the recomended way of checking encrypted passwords
        if (password_verify($passwd, $row["password"])) {
          //if the passwords match we save the session details in the sessin variable
              $sql = $conn->prepare("SELECT name, ID FROM user WHERE email= ?");
              $sql->bind_param('s', $email);
              //the sql call in now ready for the query
              $sql->execute();
              $result = $sql->get_result();
              //if the query was successful we wil get more than 0 rows back
              if (mysqli_num_rows($result) >= 1) {
                 $row = mysqli_fetch_assoc($result);
                 $_SESSION["logged_in"] = TRUE;
                 $_SESSION["name"] = $row['name'];
                 $_SESSION["id"] = $row['ID'];
                 //generating a new token after login
                 $_SESSION['token'] = bin2hex(random_bytes(32));
                 log_in();
              }
              else{
                  echo "Connection with the database lost";
              }
            } else {
                echo 'Invalid password';
            }
    } else {
        echo("Database query failed");
    }
} else {
    /*  */
?>
<section class="center">
  <h2> Login</h2>
  <form action="../index.php" method="post">
    <div class="form-group">
      <label for="inputEmail">Email</label>
      <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
    </div>
    <div class="form-group">
      <label for="inputPassword">Password</label>
      <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
    </div>
    <input type="hidden" name="submitted" value="1" />
    <input type="hidden" name="token" value=<?php echo $_SESSION["token"] ?> />
    <input class="btn btn-primary" type="submit" value="Logg inn"></label>
  </form>
 </section>
<?php
}
?>

<?php
//checks if user is logged in by checking  the session parameter
function is_logged_in() {
    if (!empty($_SESSION["logged_in"])) {
        return TRUE;
    } else {
        return FALSE;
    }
}

//function for setting the session parameter logged_in true so we can check if a user is logged in
function log_in() {
    $_SESSION["logged_in"] = TRUE;
    echo "logged in as " . $_SESSION["name"];
    exit();
}

//if we are already logged in we just go to the login function
if (is_logged_in()) {
    /* Already logged in */
    log_in();
    //by pressing the submit button in the html the submitted parameter wil be set and we can contineue
    //the if statement
} else if (!empty($_POST["submitted"])) {
    /* User is trying to log in */
    $email = validate_input($_POST["email"]);
    $passwd = validate_input($_POST["password"]);
    //preparing sql call that cant be sql injected
    $sql = $conn->prepare("SELECT name, password, ID FROM user WHERE email= ?");
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
            $_SESSION["logged_in"] = TRUE;
            $_SESSION["email"] = $email;
            $_SESSION["name"] = $row['name'];
            $_SESSION["id"] = $row['ID'];
            log_in();
            } else {
                echo 'Invalid password';
            }
    } else {
        echo("Database query failed");
    }
} else {
    /*  */
?>

<form class="animated fadeIn"  action="../index.php" method="post">
    <label for="inputEmail" class="sr-only">Epostaddresse</label>
    <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
    <label for="inputPassword" class="sr-only">Passord</label>
    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
    <input type="hidden" name="submitted" value="1" />
    <input class="btn btn-lg btn-primary btn-block" type="submit" value="Logg inn"></label>
</form>

<?php
}

?>

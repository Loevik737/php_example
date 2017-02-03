<?php

if (!empty($_POST["submitted"]) && $_POST["token"] === $_SESSION["token"] ) {
    // User has pressed the submit button and the session token matched
    //hashing the password with the recomended method, the PASSWORD_DEFAULT parameter is currently encrypting using bcrypt, but this will likely change to Argon2i later

    //connecting to wertify that the user is not a bot
    $secret="6LdqPBQUAAAAAHIWCVin52n43yvf-UsRGk7kpFlc";
    $response= $_POST["g-recaptcha-response"];
    $verify=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$response}");
    $captcha_success=json_decode($verify);

    if (!empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && $captcha_success->success==true) {
            //vallidation is needed. Now we just prevent xss attacks
            $email = validate_input($_POST['email']);
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT,["cost" => 12]);
            $name = validate_input($_POST['name']);

            $sql = $conn->prepare("INSERT INTO user (email, password, name) VALUES (?,?,?)");
            $sql->bind_param("sss",$email,$password,$name);

            //the sql call is now propperly prepared, and we're sending the user info to the databvase
            if ($sql->execute()) {
                echo("Ny bruker opprettet");
            }
            else {
                echo("Eposten er allerede i bruk");
            }
    }
    else{
        if($captcha_success->success==false) {
          echo "You are a bot!";
        }else{
          echo("Venligst fyll ut alle feltene");
        }
      }
    }

?>
      <section class="center">
        <h2>Register new user</h2>
        <form action="../index.php?feature=createUser" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name: </label>
                <input class="form-control" type="text" name="name" id="name">
            </div>
            <div class="form-group">
                <label for="email">Email: </label>
                <input class="form-control" type="email" name="email" id="email">
            </div>
            <div class="form-group">
                <label for="password">Password: </label>
                <input class="form-control" type="password" name="password" id="password">
            </div>
            <!--Showing the captcha test for the user-->
            <div class="captcha_wrapper">
                <div class="g-recaptcha" data-sitekey="6LdqPBQUAAAAADoSCz0aH0sfbIcoyj9nT1MXt-cJ"></div>
            </div>
            <input type="hidden" name="submitted" value="1" >
            <input type="hidden" name="token" value=<?php echo $_SESSION["token"] ?> />
            <input class="btn btn-primary" type="submit" value="Register new user" >
        </form>
      </section>

<?php

if (!empty($_POST["submitted"]) && $_POST["token"] === $_SESSION["token"]) {
    // User has pressed the submit button and the session token matched
    //hashing the password with the recomended method, the PASSWORD_DEFAULT parameter is currently encrypting using bcrypt, but this will likely change to Argon2i later
    if (!empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
            //vallidation is needed. Now we just prevent ssx attacks
            $email = validate_input($_POST['email']);
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT,["cost" => 12]);
            $name = validate_input($_POST['name']);

            $sql = $conn->prepare("INSERT INTO user (email, password, name) VALUES (?,?,?)");
            $sql->bind_param("sss",$email,$password,$name);

            //the sql call is now propperly prepared, and we're sending the user info to the databvase
            if ($sql->execute()) {
                echo("Bruker lagt til");
            }
            else {
                echo("Eposten er allerede i bruk");
            }
    }
    else{
        echo("Venligst fyll ut alle feltene");
    }

}

?>
      <h2>Registrer ny bruker</h2>
      <form action="../index.php?feature=createUser" method="post">
          <div class="form-group">
              <label for="name">Name: </label>
              <input class="form-control" type="text" name="name" id="name">
          </div>
          <div class="form-group">
              <label for="email">Email: : </label>
              <input class="form-control" type="email" name="email" id="email">
          </div>
          <div class="form-group">
              <label for="password">Password: </label>
              <input class="form-control" type="password" name="password" id="password">
          </div>
          <input type="hidden" name="submitted" value="1" >
          <input type="hidden" name="token" value=<?php echo $_SESSION["token"] ?> />
          <input type="submit" value="Registrer ny bruker" >
      </form>

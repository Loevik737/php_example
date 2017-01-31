<?php

// a logout script that destroys the session and sends you to the index/login page
function logout() {
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');
    session_regenerate_id(true);

    echo("Logged out.");

    header("Location: ../index.php");
    exit("exiting");
}
logout();

?>

<?php session_start(); // turning on the session for this page ?> 
<?php

// null means nothing is there, so we are cancelling the sessions after they visit logout
$_SESSION['username'] = null;
$_SESSION['firstname'] = null;
$_SESSION['lastname'] = null;
$_SESSION['user_role'] = null;

header("Location: ../index.php");


?>
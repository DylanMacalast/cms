<?php include "db.php"; ?>
<?php session_start(); // turning on the session for this page ?> 
<?php

if(isset($_POST['login'])) {

 $username = $_POST['username'];
 $password = $_POST['password'];

//function to prevenet hacking in feilds and reassigning to password and username
$username = mysqli_real_escape_string($connection, $username);
$password = mysqli_real_escape_string($connection, $password);

$query = "SELECT * FROM users WHERE username = '{$username}' ";
$select_user_query = mysqli_query($connection, $query);

if(!$select_user_query){
    die("fail" . mysqli_error($connection));
}

while($row = mysqli_fetch_assoc($select_user_query)) {

    $db_user_id = $row['user_id'];
    $db_username = $row['username'];
    $db_user_firstname = $row['user_firstname'];
    $db_user_lastname = $row['user_lastname'];
    $db_user_password = $row['user_password'];
    $db_user_role = $row['user_role'];

}

//OLD WAY!!!!!

//allowing user to log in with originall password.
//so the crypt function will encrypt the password when u pass in password and $salt.
// ... it will then output the same password if you provide the second parameter with the password typed in by user agian.
// $password = crypt($password, $db_user_password);


// if ($username === $db_username && $password === $db_user_password ) {

// // starting session using global variable. 
// // the $db_username, which we are getting from the db we are assigning it to a session which we have named username.
// // so if we have our session turned on in other pages we are able to easily access the value of $_SESSION['username].
//     $_SESSION['username'] = $db_username;
//     $_SESSION['firstname'] = $db_user_firstname;
//     $_SESSION['lastname'] = $db_user_lastname;
//     $_SESSION['user_role'] = $db_user_role;
// // so if/when we log into the admin page from the else if, we will have access to all of this data above from the session.

//     header("Location: ../admin");

// } else {

//     header("Location: ../index.php");
// }


//NEW WAY OF DOING IT
if(password_verify($password, $db_user_password) ) {

    $_SESSION['username'] = $db_username;
    $_SESSION['firstname'] = $db_user_firtname;
    $_SESSION['lastname'] = $db_user_lastname;
    $_SESSION['user_role'] = $db_user_role;

    header("Location: ../admin");

} else {
        header("Location: ../index.php");
}

}


?>
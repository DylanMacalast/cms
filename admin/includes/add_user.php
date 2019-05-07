<?php

if(isset($_POST['create_user'])) {

$user_firstname = escape($_POST['user_firstname']);
$user_lastname = escape($_POST['user_lastname']);
$user_role = escape($_POST['user_role']);
$username = escape($_POST['username']);
$user_email = escape($_POST['user_email']);
$user_password = escape($_POST['user_password']);

//prevent sql injection

$user_firstname = mysqli_real_escape_string($connection, $user_firstname);
$user_lastname = mysqli_real_escape_string($connection, $user_lastname);
$username = mysqli_real_escape_string($connection, $username);
$user_email = mysqli_real_escape_string($connection, $user_email);
$user_password = mysqli_real_escape_string($connection, $user_password);

$user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10) );





$query = "INSERT INTO users(user_firstname, user_lastname, username, user_email, user_role, user_password) ";


$query .= "VALUES('{$user_firstname}','{$user_lastname}','{$username}','{$user_email}','{$user_role}','{$user_password}' )";

$create_user_query = mysqli_query($connection, $query);

confirm($create_user_query);

echo "User Created: " . " " . "<a href='users.php' class='btn btn-info'>Take a Look</a> ";
}


?>



<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Firstname</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>
    <div class="form-group">
        <label for="lastname">Lastname</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>

    <div class="form-group">
        <select name="user_role" id="">
            <option value="subscriber">Select Options</option>
            <option value="admin">Admin</option>
            <option value="subscriber">User</option>
        </select>
    </div>


    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="user_email">
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_user" value="Add User">
    </div>

    

<form>
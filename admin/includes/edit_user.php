<?php

if(isset($_GET['edit_user'])) {
    $the_user_id = escape($_GET['edit_user']);


    $query = "SELECT * FROM users WHERE user_id = $the_user_id";
    $select_users = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($select_users)) {
        $username = escape($row['username']);
        $user_password = escape($row['user_password']);
        $user_firstname = escape($row['user_firstname']);
        $user_lastname = escape($row['user_lastname']);
        $user_email = escape($row['user_email']);
        $user_role = escape($row['user_role']);
    }




if(isset($_POST['edit_user'])) {

$user_firstname = escape($_POST['user_firstname']);
$user_lastname = escape($_POST['user_lastname']);
$user_role = escape($_POST['user_role']);
$username = escape($_POST['username']);
$user_email = escape($_POST['user_email']);
$user_password = escape($_POST['user_password']);

//OLD WAY OF DOING IT

// // getting data from db.
// $query = "SELECT randSalt FROM users";
// $select_randSalt_query = mysqli_query($connection, $query);
// if(!$select_randSalt_query){
//     die("failed" . mysqli_error($connection));
// }
// // updating userpassword colum to $hashed_password. encrytping the edited password.
// $row = mysqli_fetch_assoc($select_randSalt_query);
// $salt = $row['randSalt'];
// $hashed_password = crypt($user_password, $salt);

//NEW WAY OF DOING IT

if(!empty($user_password)) {
    $query_password = "SELECT user_password fROM users WHERE user_id = $the_user_id";
    $get_user_query = mysqli_query($connection, $query_password);
    if(!$get_user_query){
        die("failed");
    }

    $row = mysqli_fetch_assoc($get_user_query);

    $db_user_password = escape($row['user_password']);

    if($db_user_password != $user_password) {
        $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array("cost" => 12));
    }

$query = "UPDATE users SET ";
$query .="user_firstname = '{$user_firstname}', ";
$query .="user_lastname = '{$user_lastname}', ";
$query .="user_role = '{$user_role}', ";
$query .="username = '{$username}', ";
$query .="user_email = '{$user_email}', ";
$query .="user_password = '{$hashed_password}' ";
$query .="WHERE user_id = {$the_user_id} ";

$update_user_query = mysqli_query($connection, $query);
confirm($update_user_query);

confirm($update_user_query);
}




}

} else {

    header("Location: ../index.php");



}


?>



<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Firstname</label>
        <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname; ?>">
    </div>
    <div class="form-group">
        <label for="lastname">Lastname</label>
        <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname; ?>">
    </div>

    <div class="form-group">
        <select name="user_role" id="">
        <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>

        <?php
    if($user_role == 'admin') {

        echo "<option value='subscriber'>user</option>";

    } else {

        echo "<option value='admin'>admin</option>";

    }

        ?>


        
        </select>
    </div>


    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="user_email" value="<?php echo $user_email; ?>">
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input autocomplete="off" type="password" class="form-control" name="user_password">
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="edit_user" value="Update User">
    </div>

    

<form>
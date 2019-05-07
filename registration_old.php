<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>

 <?php

 if(isset($_POST['submit'])) {
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $username = $_POST['username'];
    $user_email = $_POST['email'];
    $user_password = $_POST['password'];

//checking to see if feilds are empty - if not empty run below code
if(!empty($username) && !empty($user_email) && !empty($user_password)) {

//prevent sql injection
$username = mysqli_real_escape_string($connection, $username);
$user_email = mysqli_real_escape_string($connection, $user_email);
$user_password = mysqli_real_escape_string($connection, $user_password);
$user_firstname = mysqli_real_escape_string($connection, $user_firstname);
$user_lastname = mysqli_real_escape_string($connection, $user_lastname);


//checkin on randSalt column for a default value which we set in the db using crypt function.
$query = "SELECT randSalt FROM users";
$select_randSalt_query = mysqli_query($connection, $query);

if(!$select_randSalt_query){
    die("faild" . mysqli_error($connection));
}

// no need to use while loop below as only getting one result.
//displaying and fetching the default value of randSalt set in the db.
$row = mysqli_fetch_assoc($select_randSalt_query);

$salt = $row['randSalt'];
// combine the $password typed in and the $salt which is the value we set in the db.
$user_password = crypt($user_password, $salt);

// making user query from registration - user role is hard coded to prevent people becoming admins, we do this as an admin.
$query = "INSERT INTO users (user_firstname, user_lastname, username, user_email, user_password, user_role) ";
$query .= "VALUES('{$user_firstname}', '{$user_lastname}', '{$username}', '{$user_email}', '{$user_password}', 'subscriber') ";
$register_user_query = mysqli_query($connection, $query);
if(!$register_user_query) {
    die("fail" . mysqli_error($connection));
}

$message = "<p class='text-success'>Your Registration was successful</p>";


// if it is empty run this.
} else {
    $message = "<p class='text-danger'>Feilds cannot be empty</p>";
}




} else {
//if submit button is not pressed below in form will throw an error for undefined variable $message.
// so we do an else on the main if statement and set the $message to empty.
$message = "";



}


?>


    <!-- Navigation -->
    
    <?php  include "includes/nav.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <h6 class="text-center"><?php echo $message; ?></h6>
                        <div class="form-group">
                            <label for="firstname" class="sr-only">Firstname</label>
                            <input type="text" name="user_firstname" id="firstname" class="form-control" placeholder="Enter First Name">
                        </div>
                        <div class="form-group">
                            <label for="lastname" class="sr-only">Lasname</label>
                            <input type="text" name="user_lastname" id="lastname" class="form-control" placeholder="Enter Last Name">
                        </div>
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>

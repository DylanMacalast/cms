<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<?php

if(isset($_POST['submit'])) {
    $to = "dylanmacalast@icloud.com";
    $subject = wordwrap($_POST['subject'], 70);
    $body = $_POST['body'];
    $header = "From: " .$_POST['email'];


    if(!empty($header) && !empty($subject) && !empty($body)){
        mail($to, $subject, $body, $header);

        $message = "<p class='text-success'>Thanks for you message we will get back to you soon!</p>";

    } else {
        $message = "<p class='text-danger'>Feilds cannot be empty</p>";
    }
    
        
} else {
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
                <h1 class="text-center">Contact Me</h1>
                    <form role="form" action="contact.php" method="post" id="contact-form" autocomplete="off">
                        <h6 class="text-center"><?php echo $message; ?></h6>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email Adress">
                        </div>
                        <div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="" name="subject" id="subject" class="form-control" placeholder="Enter Your Subject">
                        </div>
                         <div class="form-group">
                            <textarea class="form-control" name="body" id="email_body" cols="20" rows="5"></textarea>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Send">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>

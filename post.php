<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>


    <!-- Navigation -->
<?php include "includes/nav.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php

// checking to see if the p_id is in the url when the title is pressed, if it is run code.
                if(isset($_GET["p_id"])) {

                    $the_post_id = $_GET["p_id"];

                    $view_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = $the_post_id";
                    $send_query = mysqli_query($connection, $view_query);

                    if(!$send_query){
                        die("failed" . mysqli_error($connection));
                    }

                    


                $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
                $select_all_posts_query = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc($select_all_posts_query)) {
// looping through the data in the posts table and bringing back what we want.
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_img = $row['post_img'];
                    $post_content = $row['post_content'];
// the html below will produce dynamic data from the variables above.
// html is inside the loop so it will make a post each time there is new data in the posts table inserting that new data where specified.
                    ?>

                    <h1 class="page-header">
                        Page Heading
                        <small>Secondary Text</small>
                    </h1>

                    <!-- First Blog Post -->
                    <h2>
                        <a href="#"><?php echo $post_title; ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="index.php"><?php echo $post_author; ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                    <hr>
                    <img class="img-responsive" src="img/<?php echo $post_img; ?>" alt="">
                    <hr>
                    <p><?php echo $post_content; ?></p>
                    <hr>
                    
                

              <?php  } 
            
            
            
            
            }else{
                header("Location: index.php");
            }
            
            ?>

                <!-- Blog Comments -->

                <?php

                if(isset($_POST['create_comment'])) {
                    // if submit comment is clicked, get the post id from the url.
                    $the_post_id = $_GET['p_id'];

                    $comment_author = $_POST['comment_author'];
                    $comment_email = $_POST['comment_email'];
                    $comment_content = $_POST['comment_content'];
                    // checking to see if the feilds are empty or not. if they are not empty run code.
                    if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content) ) {


                        $query = "INSERT INTO comments (comment_post_id, comment_date, comment_author, comment_email, comment_content, comment_status)";

                        $query .= "VALUES ($the_post_id,now(),'$comment_author','$comment_email','$comment_content','unapproved' )";
    
                        $create_comment_query = mysqli_query($connection, $query);
    
                        if(!$create_comment_query){
                            die("uh oh" . mysqli_error($connection));
                        }
    //OLD COMMENT COUNT
    // // query to update posts table in the post_comment_count table and set it equal to the the post_comment_count + 1.
    //                     $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
    // // Where the post_id is equal to the_post_id which is the id of the post selected which we get from the get request.
    //                     $query .= "WHERE post_id = $the_post_id ";

    // $update_comment_count = mysqli_query($connection, $query);
    // if(!$update_comment_count){
    //     die("failed" . mysqli_error($connection));
    // }


// if they are empty run this - js to show alert saying you can not leave empty.
                    } else {

                        echo "<script>alert('Can not submit an empty comment you idiot!')</script>";

                    }







                }






                ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" action="" method="post">
                        <div class="form-group">
                            <label for="author">Name</label>
                            <input class="form-control" type="text" name="comment_author">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" type="email" name="comment_email">
                        </div>
                        <div class="form-group">
                            <label for="comment">Comment Here</label>
                            <textarea class="form-control" rows="3" id="body" name="comment_content"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <?php
// select everything from comments where comment_post_id is equal to $the_post_id (the id at top which is sleceted post from get request).
                $query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} ";
//AND comment status must equal aprroved to run
                $query .= "AND comment_status = 'approved' ";
// order by the column 'comment_id' in DESC which will order in descending order.(bottom to top(newest)).
                $query .= "ORDER BY comment_id DESC ";
                $select_comment_query = mysqli_query($connection, $query);

                if(!$select_comment_query) {
                    die("Failed" . mysqli_error($connection));
                }
//running loop to get data out.
                while($row = mysqli_fetch_assoc($select_comment_query)) {
                    $comment_date = $row['comment_date'];
                    $comment_content = $row['comment_content'];
                    $comment_author = $row['comment_author'];

                    ?>

                    <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <?php echo $comment_content; ?>
                    </div>
                </div>


           <?php    } ?>






                

            </div>



            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>

            </div>
            <!-- /.row -->

            <hr>


                



               
<?php include "includes/footer.php"; ?>

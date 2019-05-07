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

        //---MAKING A CUSTOM SEARCH ENGINE---
        if(isset($_POST['submit'])) {

             $search =  $_POST['search'];
// sql query selecting all data from posts where post_tags are like (same as) what is searched.
             $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%' ";
             $search_query = mysqli_query($connection, $query);

// if sql query failed let us know.
             if(!$search_query) {
                 die("query failed" . musqli_error($connection));
             } else {
                echo "search was good <br>";
             $count = mysqli_num_rows($search_query);

             if($count == 0) {
                 echo "<h1>NO RESULTS FOUND</h1>";
             } else {
// if a row from database is found run the while loop 

                while($row = mysqli_fetch_assoc($search_query)) {

                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_img = $row['post_img'];
                    $post_content = $row['post_content'];


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
                    <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                    <hr>

                <?php } 
            
                }
            }
        }
            ?>
             




        



                
              </div>



            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>

            </div>
            <!-- /.row -->

            <hr>
            <?php include "includes/footer.php"; ?>
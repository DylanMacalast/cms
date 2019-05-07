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
// MAKING PAGINATION

// per_page is set to how many posts we want on each page.
                $per_page = 5;
// checking to see if page is in url using get request
                if(isset($_GET['page'])) {

                    
//if page is set then assign the value to $page
                    $page = $_GET['page'];
//if not set assign $page a value of nothing
                } else {
                    $page = "";
                }

// if page equals nothing or 1 then set $page_1 equal to 0
                if($page == "" || $page == 1){
                    $page_1 = 0;
                    //if $page is equal to a number eg. 1 or 2 set $page_1 equal to $page * 5 - 5.
                } else {
                    $page_1 = ($page * $per_page) - $per_page;
                }


                $post_query_count = "SELECT * FROM posts";
                $find_count_query = mysqli_query($connection, $post_query_count);
                $count = mysqli_num_rows($find_count_query);
// ceil function to round up.
                $count = ceil($count / $per_page);


// using limit to set how many posts are seen on each page in this case 5.
                $query = "SELECT * FROM posts ORDER BY post_id DESC LIMIT $page_1, $per_page";
                $select_all_posts_query = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc($select_all_posts_query)) {
// looping through the data in the posts table and bringing back what we want.
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_img = $row['post_img'];
                    // substr() will set a max amount of characters that are shown.
                    $post_content = substr($row['post_content'], 0, 50);
                    
                    // !!!!GO BACK TO THIS ON HOW TO MAKE ONLY PUBLISHED POSTS AVAILABLE TO SEE!!!!
                    // $post_status = $row['post_status'];

                    // if($post_status == 'draft' {

                    //     echo "<h1 class='text-warning text-center'>NO POSTS SORRY </h1>";

                    // } else {


                    

// the html below will produce dynamic data from the variables above.
// html is inside the loop so it will make a post each time there is new data in the posts table inserting that new data where specified.
                    ?>
                    <h1 class="page-header">
                        Page Heading 
                        <small>Secondary Text</small>
                    </h1>

                    <!-- First Blog Post -->
                    <h2>
                    <!-- When click on title send a parameter to the url which will be the p_id = to the id of the post $post_id-->
                        <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="author_posts.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author; ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                    <hr>
                    <a href="post.php?p_id=<?php echo $post_id; ?>">
                    <img class="img-responsive" src="img/<?php echo $post_img; ?>" alt=""></a>
                    <hr>
                    <p><?php echo $post_content; ?></p>
                    <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                    <hr>
                    
                

              <?php  } ?>

              </div>



            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>

            </div>
            <!-- /.row -->

            <hr>



<!-- Creating the pagination at bottom of the index -->
            <ul class="pager">
                    
            <?php 
// so page 1 count = 0. if i <= $count add 1. then page 2 $count = 1. so when i is less than or eqaul to $count add 1. and so on.
            for($i=1; $i <= $count; $i++) {

                if($i == $page) {

                    echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";

                }  else {
                    echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                }
            }



            ?>
            </ul>


                



               
<?php include "includes/footer.php"; ?>
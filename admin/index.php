<?php include "includes/admin_header.php"; ?>

    <div id="wrapper">

    <?php
   
    ?>


        <!-- Navigation -->
        <?php include "includes/admin_nav.php"; ?>



        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <h1 class="page-header">
                        Welcome to Admin
                        <small><?php echo $_SESSION['username'] ?></small>
                    </h1>
                </div>
                <!-- /.row -->

                        <?php

                        $query = "SELECT * FROM posts";
                        $select_all_posts_query = mysqli_query($connection, $query);
                        //the mysqli_num_rows will count all the rows for the result of the query above.
                        $post_counts = mysqli_num_rows($select_all_posts_query);

                        $query = "SELECT * FROM comments";
                        $select_all_comments_query = mysqli_query($connection, $query);
                        $comment_counts = mysqli_num_rows($select_all_comments_query);

                        $query = "SELECT * FROM users";
                        $select_all_users_query = mysqli_query($connection, $query);
                        $user_counts = mysqli_num_rows($select_all_users_query);

                        $query = "SELECT * FROM categories";
                        $select_all_categories_query = mysqli_query($connection, $query);
                        $category_counts = mysqli_num_rows($select_all_categories_query);
                        ?>


                       
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                <div class='huge'><?php echo $post_counts; ?></div>
                                        <div>Posts</div>
                                    </div>
                                </div>
                            </div>
                            <a href="posts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    <div class='huge'><?php echo $comment_counts; ?></div>
                                    <div>Comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="comments.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    <div class='huge'><?php echo $user_counts; ?></div>
                                        <div> Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="users.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class='huge'><?php echo $category_counts; ?></div>
                                        <div>Categories</div>
                                    </div>
                                </div>
                            </div>
                            <a href="categories.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                <?php  

                $query = "SELECT * FROM posts WHERE post_status = 'published' ";
                $select_all_published_posts = mysqli_query($connection, $query);
                $post_published_counts = mysqli_num_rows($select_all_published_posts);

                $query = "SELECT * FROM posts WHERE post_status = 'draft' ";
                $select_all_draft_posts = mysqli_query($connection, $query);
                $post_draft_counts = mysqli_num_rows($select_all_draft_posts);

                $query = "SELECT * FROM comments WHERE comment_status = 'unapproved' ";
                $select_unapproved_comments = mysqli_query($connection, $query);
                $comment_unapproved_counts = mysqli_num_rows($select_unapproved_comments);

                $query = "SELECT * FROM users WHERE user_role = 'subscriber' ";
                $select_all_subscribers = mysqli_query($connection, $query);
                $subscriber_counts = mysqli_num_rows($select_all_subscribers);


                ?>




                <div class="row">
                    
                    <script type="text/javascript">
                    google.charts.load('current', {'packages':['bar']});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                        ['Date', 'Count'],

                        <?php

                        $element_text = ['All Posts', 'Active Post', 'Draft Posts', 'Comments', 'Pending Comments', 'Users', 'Subscribers', 'Categories'];
                        $element_count = [$post_counts, $post_published_counts, $post_draft_counts, $comment_counts, $comment_unapproved_counts, $user_counts, $subscriber_counts, $category_counts];
// for loop to loop through array and define when to start and to stop.
                        for($i = 0; $i < 8; $i++) {
// echoing two values every time it goes around.(name and ammount)
// the [$i] in $element_text[$i] is used to define where in the array to get data from
// ... eg at $i = 0, get element_text and element_count at index 0 and echo it and then add one to $i moving onto next index inside both of the arrays.

                            echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";

                        }


// what is going on here. 
// so this data ['Posts', 100], is usually static(u would have to type it out over and over).
//instead of writing it all static we use two arrays to print all values eg. print the name and the number which is the variable assigned in php at top assigneing the number of rows in each table.


                        ?>
// below is how you would write it staticlly however echo above is doing same thing but dynamiclly.
                        // ['Post', 1000],
                        
                        ]);

                        var options = {
                        chart: {
                            title: '',
                            subtitle: '',
                        }
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
                    }
                    </script>
                    <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
<?php include "includes/admin_footer.php"; ?>

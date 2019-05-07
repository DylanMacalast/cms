<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">CMS</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">

                    <?php
            // creating navbar links from the database table.(displaying dynamic data from our database)!
            $query = "SELECT * FROM categories";
            $select_all_categories_query = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($select_all_categories_query)) {
                $cat_title = $row['cat_title'];

                echo "<li><a href='#'>{$cat_title}</a><li>";

            }
             ?>

                    <li>
                        <a href="admin">Admin</a>
                    </li>
                    <li>
                        <a href="registration.php">Register</a>
                    </li>
                    <li>
                        <a href="contact.php">Contact</a>
                    </li>

            <?php

            // creating edit post link in nav.
// This will work if the session is started(you log in to start session)
// the p_id is in the url bar ie. you clicked on a post whilst signed in the link in nav will show

            if(isset($_SESSION['user_role'])) {

                if(isset($_GET['p_id'])) {

                    $the_post_id = $_GET['p_id'];
// the link is sending you to correct page by sending in parameters.
                    echo "<li><a href='admin/posts.php?source=edit_post&p_id={$the_post_id}'>Edit Post</a></li>";

                }


            }

            ?>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
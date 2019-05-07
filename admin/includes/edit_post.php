<?php
// if the p_id is set to a value run code. the get will grab the value as it retruns assoc array.
if(isset($_GET['p_id'])) {

    $the_post_id =  $_GET['p_id'];

}
// WHERE the post_id is equal to the post id we getting from the get request.
$query = "SELECT * FROM posts WHERE post_id = $the_post_id";
$select_posts_by_id = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($select_posts_by_id)) {
        $post_id = escape($row['post_id']);
        $post_category = escape($row['post_category_id']);
        $post_title = escape($row['post_title']);
        $post_author = escape($row['post_author']);
        $post_date = escape($row['post_date']);
        $post_img = escape($row['post_img']);
        $post_content = escape($row['post_content']);
        $post_tags = escape($row['post_tags']);
        $post_comments = escape($row['post_comment_count']);
        $post_status = escape($row['post_status']);

    }

    if(isset($_POST['update_post'])) {

        $post_title = escape($_POST['title']);
        $post_category = escape($_POST['post_category']);
        $post_author = escape($_SESSION['username']);
        $post_img = escape($_FILES['img']['name']);
        $post_img_temp = escape($_FILES['img']['tmp_name']);
        $post_status = escape($_POST['post_status']);
        $post_tags = escape($_POST['post_tags']);
        $post_content = escape($_POST['post_content']);
       

        move_uploaded_file($post_img_temp, "../img/$post_img");

        // below will update the img when clicked update and then again.
        if(empty($post_img)) {

            $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
            $select_img = mysqli_query($connection, $query);
// while loop to loop through the result set above, it will loop through and pull out the img.
            while($row = mysqli_fetch_array($select_img)) {
                $post_img = escape($row['post_img']);
            }

        }

        //update query- concatinating as its so long
//updating the posts table and seting the post_title column to the value of $post_title form form and so on.
        $query = "UPDATE posts SET ";
        $query .="post_title = '{$post_title}', ";
        $query .="post_category_id = '{$post_category}', ";
        $query .="post_author = '{$_SESSION['username']}', ";
        $query .="post_img = '{$post_img}', ";
        $query .="post_status = '{$post_status}', ";
        $query .="post_tags = '{$post_tags}', ";
        $query .="post_content = '{$post_content}', ";
        $query .="post_date = now() ";
        $query .="WHERE post_id = {$the_post_id} ";

        $update_post = mysqli_query($connection, $query);
        confirm($update_post);

        echo "<p class='bg-success'>Post Updated. <a href='../post.php?p_id={$the_post_id}'>Veiw Post</a> OR <a href='posts.php'>Edit More Posts</a></p>";



    }





?>



<form action="" method="post" enctype="multipart/form-data">
<!-- the enctype is included as we are uploading image data -->

    <div class="form-group">
        <label for="title">Post Title</label>
        <input value="<?php echo $post_title; ?>" type="text" class="form-control" name="title">
    </div>

    <div class="form-group">
        <label for="category">Category</label><br>
        <!-- must have this name so we know what we are submiting and assigning it a value. -->
        <select name="post_category" id="post_category">
        
        <?php
        $query = "SELECT * FROM categories";
        $select_categories = mysqli_query($connection, $query);

        confirm($select_categories);

        while($row = mysqli_fetch_assoc($select_categories)) {
            $cat_title = escape($row['cat_title']);
            $cat_id = escape($row['cat_id']);
// getting the category id from the categories table and giving the title as the option we can select to put on our post.
            echo "<option value='{$cat_id}'>{$cat_title}</option>";
        }
        ?>

        </select>
    </div>



    

    <div class="form-group">
        <select name="post_status" id="">

            <option value='<?php echo $post_status; ?>'><?php echo $post_status; ?></option>
            
            <?php
            if($post_status == 'published'){
                echo "<option value='draft'>Draft</option>";
            } else {
                echo "<option value='published'>Publish</option>";
            }
            ?>

        </select>
    </div>


    <div class="form-group">
        <label for="post_img">Image</label><br>
        <img width="100" src="../img/<?php echo $post_img;  ?>" alt="">
        <input type="file" name="img">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea  class="form-control" id="body" name="post_content" cols="10" rows="5"><?php echo $post_content; ?>
        </textarea>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" type="submit" name="update_post" value="Update Post">
    </div>

    

<form>
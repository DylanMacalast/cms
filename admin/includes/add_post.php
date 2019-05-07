<?php

if(isset($_POST['create_post'])) {

$post_title = escape($_POST['title']);
$post_category = escape($_POST['post_category']);
$post_author = escape($_SESSION['username']);
$post_status = escape($_POST['post_status']);

//the image uses super global $_FILES it has name of img and the name of the file.
$post_img = escape($_FILES['img']['name']);
// temporary location of the image so when we submit it we want to send the image somewhere else.
$post_img_temp = escape($_FILES['img']['tmp_name']);

$post_tags = escape($_POST['post_tags']);
$post_content = escape($_POST['post_content']);
// sending the date in with a function.
$post_date = escape(date('d-m-y'));
// for now hard coding this value not getting it as dynamic data.
// $post_comment_count = 4;

// function that moves the file from the temp location to the location we want (the img folder outside admin folder).
move_uploaded_file($post_img_temp, "../img/$post_img" );

// query to insert data into the post table in database. we then pass in the parameters.(these are the feilds in our database table, the information we want to put into table).
$query = "INSERT INTO posts(post_title, post_category_id, post_author, post_img, post_status, post_tags, post_content, post_date )";
// Concatinating the querys together- easier to read. these are the values(taken from what is typed into the form) that we pass into the the post table.
// the now function is going to format the date we are sending into the database and make it look good.
$query .= "VALUES('{$post_title}','{$post_category}','{$_SESSION['username']}','{$post_img}','{$post_status}','{$post_tags}','{$post_content}',now() )";

$create_post_query = mysqli_query($connection, $query);

confirm($create_post_query);

//pulls last created record id from the database. in this case the post you are adding.
$the_post_id = mysqli_insert_id($connection);

echo "<p class='bg-success'>Post Created. <a href='../post.php?p_id={$the_post_id}'>Veiw Post</a> OR <a href='posts.php'>Edit More Posts</a></p>";


}


?>



<form action="" method="post" enctype="multipart/form-data">
<!-- the enctype is included as we are uploading image data -->

    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
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
            $cat_title = $row['cat_title'];
            $cat_id = $row['cat_id'];
// getting the category id from the categories table and giving the title as the option we can select to put on our post.
            echo "<option value='{$cat_id}'>{$cat_title}</option>";
        }
        ?>

        </select>
    </div>

    <!-- <div class="form-group">
        <label for="title">Post Author</label>
        <input type="text" class="form-control" name="author">
    </div> -->

    <div class="form-group">
        <label for="post_status">Post Status</label><br>
        <select name="post_status" id="">
            <option value="draft">Select Options</option>
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
        </select>
    </div>

    <div class="form-group">
        <label for="post_img">Post Image</label>
        <input type="file" class="form-control-file" name="img">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" id="body" name="post_content" cols="10" rows="5"></textarea>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>

    

<form>
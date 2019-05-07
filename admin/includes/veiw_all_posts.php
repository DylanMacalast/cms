<?php

if(isset($_POST['checkBoxArray'])) {
// going through each of the feilds and assing the value to $postValueId.
    foreach($_POST['checkBoxArray'] as $postValueId) {
// $bulk_options is saved to the value of the $_POST['bulk_options] which is the name of the select. each option has a value which is saved to the select.
        $bulk_options = escape($_POST['bulk_options']);

        switch($bulk_options) {
            case 'published':
            $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = $postValueId ";
            $update_to_publish_status = mysqli_query($connection, $query);
            break;
            case 'draft':
            $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = $postValueId ";
            $update_to_draft_status = mysqli_query($connection, $query);
            break;
            case 'delete':
            $query = "DELETE FROM posts WHERE post_id = $postValueId ";
            $update_to_delete_status = mysqli_query($connection, $query);
            break;
            case 'clone':

        $query = "SELECT * FROM posts WHERE post_id = '{$postValueId}' ";
        $select_post_query = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_post_query)){
            $post_title = escape($row['post_title']);
            $post_category_id = escape($row['post_category_id']);
            $post_date = escape($row['post_date']);
            $post_author = escape($row['post_author']);
            $post_status = escape($row['post_status']);
            $post_img = escape($row['post_img']);
            $post_tags = escape($row['post_tags']);
            $post_content = escape($row['post_content']);

        }

        $query = "INSERT INTO posts(post_category_id, post_title, post_date, post_author, post_status, post_img, post_tags, post_content) ";
        $query .= "VALUES({$post_category_id},'{$post_title}',now(),'{$post_author}','{$post_status}','{$post_img}','{$post_tags}','{$post_content}') ";
        $clone_posts_query = mysqli_query($connection, $query);
        if(!$clone_posts_query){
            die("failed" . mysqli_error($connection));
        }
            break;

// using switch statement so if $bulk_options = 'published' run query below and so on.

        }
    }

}




?>



<form action="" method="post">
    <table class="table table-bordered table-hover">

        <div id="bulkOptionContainer" class="col-xs-4">

            <select class="form-control" name="bulk_options" id="">
<!-- everytime we select an option we assign its value eg. 'published' to bulk_options which is used in foreach loop above. -->
                <option value="">Select Option</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone</option>

            </select>

        </div>
        <div class="col-xs-4">

            <input type="submit" name="submit" class="btn btn-success" value="Apply" >
            <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>

        </div>

        <thead>
            <tr>
                <th><Input id="selectAllBoxes" type="checkbox"></th>
                <th>Id</th>
                <th>category</th>
                <th>Title</th>
                <th>Author</th>
                <th>Date</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Status</th>
                <th>Veiw Post</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>Views</th>
            </tr>
        </thead>
        <tbody>

        <?php
        // view posts in descending order of post id.

        $query = "SELECT * FROM posts ORDER BY post_id DESC ";
        $select_posts = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_posts)) {
            $post_id = escape($row['post_id']);
            $post_category = escape($row['post_category_id']);
            $post_title = escape($row['post_title']);
            $post_author = escape($row['post_author']);
            $post_date = escape($row['post_date']);
            $post_img = escape($row['post_img']);
            $post_tags = escape($row['post_tags']);
            $post_comments = escape($row['post_comment_count']);
            $post_status = escape($row['post_status']);
            $post_views_count = escape($row['post_views_count']);
            //everytime it goes around will put all info above in one row.
            echo "<tr>";

            ?>
<!-- creating check boxes when one is selected and we click apply the name='checkBoxArray[]' will be sent to the POST superglobal as an array -->
<!-- ... we provide a value to go inside the array of selected posts which is the $post_id so it knows which post to do stuff to. -->
<!-- Array is used instead beacuse we are storing loads of values -->

            <td><Input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>

            <?php
            echo "<td>{$post_id}</td>";

            // linking categories table to posts table so that the view posts will 
            // ... set the category column dynamicly depending on what cat has been set by user.

            $query = "SELECT * FROM categories WHERE cat_id = $post_category";
            $select_categories_id = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($select_categories_id)) {
            $cat_id = escape($row['cat_id']);
            $cat_title = escape($row['cat_title']);

            echo "<td>{$cat_title}</td>";

            }



            echo "<td>{$post_title}</td>";
            echo "<td>{$post_author}</td>";
            echo "<td>{$post_date}</td>";
            echo "<td><img width = 100 src='../img/{$post_img}' alt='image'></td>";
            echo "<td>{$post_tags}</td>";

            $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
            $send_comment_query = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($send_comment_query);
            $comment_id = escape($row['comment_id']);
            $count_comments = mysqli_num_rows($send_comment_query);

            
            echo "<td><a href='post_comments.php?id={$post_id}'>{$count_comments}</a></td>";



            echo "<td>{$post_status}</td>";
    // the ?source value is edit_post this is the page it will take u to, then another parameter is passed in setting p_id to the $post_id seleceted.
            echo "<td><a href='../post.php?p_id={$post_id}'>Veiw</a></td>";
            echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
            // Javascript below onClick which will return a confirm function which is boolean so yes deletes.
            echo "<td><a onClick=\"jsavascript: return confirm('Are you sure you want to delete this?'); \" href='posts.php?delete={$post_id}'>Delete</a></td>";
            echo "<td><a href='posts.php?reset={$post_id}'>{$post_views_count}</a></td>";
            echo "</tr>";
            

        }

        ?>

        </tbody>
    </table>
</form>


<?php
// if delete is returned from the GET variable (in the http or url) run code.
if(isset($_GET['delete'])) {
//$the_post_id is equal to the value of the delete as its assoc array returned using $_GET.
$the_post_id = escape($_GET['delete']);
// query that deletes data from posts table in the column post_id. $the_post_id will be set to seleceted post from url and will be deleted from db.
$query = "DELETE FROM posts WHERE post_id = {$the_post_id}";
$delete_query = mysqli_query($connection, $query);

header("Location: posts.php");

}

if(isset($_GET['reset'])){
    $the_post_id = escape($_GET['reset']);

    $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = " . mysqli_real_escape_string($connection, $_GET['reset']) . " ";
    $reset_views_query = mysqli_query($connection, $query);

    header("Location: posts.php");
}


?>
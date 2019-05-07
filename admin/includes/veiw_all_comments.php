<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Comment</th>
            <th>Email</th>
            <th>Status</th>
            <th>In Response to</th>
            <th>Date</th>
            <th>Approve</th>
            <th>Unapprove</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>

    <?php

    $query = "SELECT * FROM comments";
    $select_comments = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($select_comments)) {
        $comment_id = escape($row['comment_id']);
        $comment_post_id = escape($row['comment_post_id']);
        $comment_date = escape($row['comment_date']);
        $comment_author = escape($row['comment_author']);
        $comment_email = escape($row['comment_email']);
        $comment_content = escape($row['comment_content']);
        $comment_status = escape($row['comment_status']);
        
        //everytime it goes around will put all info above in one row.
        echo "<tr>";
        echo "<td>{$comment_id}</td>";
        echo "<td>{$comment_author}</td>";
        echo "<td>{$comment_content}</td>";
        echo "<td>{$comment_email}</td>";
        echo "<td>{$comment_status}</td>";

// post_id = $comment_post_id beacuse in post.php we saved the p_id in url to comment_post_id in so it has the id of seleceted post using get.
        $query ="SELECT * FROM posts WHERE post_id = $comment_post_id";
        $select_post_id_query = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($select_post_id_query)) {
            $post_id = escape($row['post_id']);
            $post_title = escape($row['post_title']);
// when we click on the link it will send us to the specifc link of the post due to code above.
            echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
        }

        


        echo "<td>{$comment_date}</td>";
        echo "<td><a href='comments.php?approve=$comment_id'>Approve</a></td>";
        echo "<td><a href='comments.php?unapprove=$comment_id'>Unapprove</a></td>";
        echo "<td><a href='comments.php?delete=$comment_id'>Delete</a></td>";
        echo "</tr>";
        

    }

    ?>

    </tbody>
</table>


<?php

if(isset($_GET['approve'])) {

    $the_comment_id = $_GET['approve'];
// where statement to make sure that only the comment with the comment id set to $the_comment_id is changed.
    $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $the_comment_id ";
    $approve_comment_query = mysqli_query($connection, $query);

    header("location: comments.php");
    
    }



if(isset($_GET['unapprove'])) {

    $the_comment_id = escape($_GET['unapprove']);

    $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $the_comment_id ";
    $unapprove_comment_query = mysqli_query($connection, $query);

    header("location: comments.php");
    
    }






if(isset($_GET['delete'])) {

$the_comment_id = escape($_GET['delete']);

$query = "DELETE FROM comments WHERE comment_id = {$the_comment_id}";
$delete_query = mysqli_query($connection, $query);
header("location: comments.php");

}



?>
<?php


//prevent sql injection online
// I will then use the function on all information that is linked to the db using querys.

function escape($string) {
global $connection;
return mysqli_real_escape_string($connection, trim($string));

}


// function to check the query is working or not by passing in the query name as a parameter of the funciton.
function confirm($result) {
    global $connection;
    if(!$result) {
        die("query failed. " . mysqli_error($connection));
    } 
}



function insert_categories() {

    global $connection;

    if(isset($_POST['submit'])) {

        $cat_title = $_POST['cat-title'];
// if cat_title is an empty string or empty do something.
        if($cat_title == "" || empty($cat_title)) {
            
            echo "<p class='text-danger'>This feild should not be empty</p>";
// if not empty insert data into our table.
        } else {
// query telling sql to insert data typed in to cat_title and move into the cat_title column in the categories table.
            $query = "INSERT INTO categories(cat_title)";
            $query .= "VALUE('{$cat_title}') ";

            $create_category_query = mysqli_query($connection, $query);

            if(!$create_category_query){
                die("query faild" . mysqli_error($connection) );
            }

        }


    } 
}


function findAllCategories() {

global $connection;

// find all categories query.
 // getting data from categories table and including it in a table in html.
 $query = "SELECT * FROM categories";
 $select_categories = mysqli_query($connection, $query);

 while($row = mysqli_fetch_assoc($select_categories)) {
 $cat_id = $row['cat_id'];
 $cat_title = $row['cat_title'];
 echo "<tr>";
 echo "<td>{$cat_id}</td>";
 echo "<td>{$cat_title}</td>";
// link to categories.php?delete where delete will be the key and $cat_id the value as $_GET returns an assoc array passed into the url.
 echo "<td><a class='btn btn-danger' href='categories.php?delete={$cat_id}'>Delete</a></td>";
// link to categories.php?edit where edit is the key and $cat_id (the id of the cat we clicked) is the value.
 echo "<td><a class='btn btn-success' href='categories.php?edit={$cat_id}'>Edit</a></td>";
 echo "</tr>";

 }


}





function delete_categories() {
    global $connection;

// if the delete key (assoc array) exists run.
            if(isset($_GET['delete'])) {
            $the_cat_id = $_GET['delete'];
// the sql query deletes the value ($cat_id) of the delete key(id) from the cat_id column in categories table.
            $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id} ";
            $delete_query = mysqli_query($connection, $query);
//when pressing delete button on webpage, it must be refreshed to stop this use below code.
            header("Location: categories.php");

         }    
    }



function users_online() {


    global $connection;
    // session_id() function gets the session info so we can use it.
    $session = session_id();
    $time = time();
    $time_out_in_secs = 30;
    $time_out = $time - $time_out_in_secs;
    // where session = the session already created and uisng it here.
    $query = "SELECT * FROM users_online WHERE session = '$session'";
    $send_query = mysqli_query($connection, $query);
    // we are counting to see if anyone is online
    $count = mysqli_num_rows($send_query);
    // if mysqli_num_rows is equal to nothing (a new user just logged in) we are inserting the time and the session to the users_online table in the db.
    if($count == NULL) {
        mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session','$time')");
        // if the user is not new(they have been on the session before we will update)
    } else{
        mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
    }

    // query to see select all users in the users_online table where the time they are online is greater then there offline time therefore they are online.
    $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
    // count user is saved to the number of users online.
    return $count_user = mysqli_num_rows($users_online_query);
    }
users_online();


    





?>
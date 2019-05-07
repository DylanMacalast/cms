<form action="" method="post">
    <div class="form-group">
        <label for="cat-title">Edit Category</label>
    <?php

    if(isset($_GET['edit'])) {
// saving the $_GET['edit'] as a variable for easy use of it. the value of $_GET['edit'] is the key as it returns an assoc array
// .. in this instance it would be the id as it is in the link in the table on other page.
    $cat_id = escape($_GET['edit']);
// selecting all values from the categories table where the colum cat_id is equal to the value of $cat_id.
    $query = "SELECT * FROM categories WHERE cat_id = $cat_id";
    $select_categories_id = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($select_categories_id)) {

        $cat_id = escape($row['cat_id']);
        $cat_title = escape($row['cat_title']);
//html below: if the $cat_title is present echo it as the value in the input field.
        ?>
        <input value="<?php if(isset($cat_title)) {echo $cat_title;} ?>" class="form-control" type="text" name="cat_title">
    
    <?php 
        }
    }
    ?>

    <?php
// below is the update query...
    if(isset($_POST['update_category'])) {

    $the_cat_title = escape($_POST['cat_title']);
// update the categories in cat_title column on the row wich has the id which is being sleceted(WHERE), this is found from the above code which uses the $_GET var 
// ...to get the value from the assoc array key edit(look at the link href on other page).
    $query = "UPDATE categories SET cat_title = '{$the_cat_title}' WHERE cat_id = {$cat_id} ";
    $update_query = mysqli_query($connection, $query);

    if(!$update_query) {
        die( "update failed" . mysqli_error($connection));
    } 
    

    }


    ?>



        
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_category" value="Update Category">
    </div>
</form>
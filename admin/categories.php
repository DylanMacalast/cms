<?php include "includes/admin_header.php"; ?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/admin_nav.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <h1 class="page-header">
                        Welcome to Admin
                        <small>Author</small>
                    </h1>

                    <div class="col-xs-6">
            
                    <?php insert_categories(); ?>

                        <form action="" method="post">
                            <div class="form-group">
                                <label for="cat-title">Add Category</label>
                                <input class="form-control" type="text" name="cat-title" placeholder="Category Title">
                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
                            </div>
                        </form>

                        <?php
                    // Update and include query from update_categories.php.
                    //if the edit key in the array in url is present run.
                        if(isset($_GET['edit'])) {

                        $cat_id = $_GET['edit'];

                        include "includes/update_categories.php"; 
                        
                        }
                        ?>

                        


                    </div>  <!--Add category Form-->
                    <div class="col-xs-6">

                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category Title</th>
                                    <th>Delete category</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php 
                        // find all categories query
                        findAllCategories();
                                 ?>

                            <?php //DELETE QUERY BELOW
                            delete_categories();
                             ?>
                           

                            </tbody>
                        </table>

                    </div>


                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
<?php include "includes/admin_footer.php"; ?>
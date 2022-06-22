    <?php  
include "includes/database.php";
include "includes/blogs.php";
include "includes/tags.php";

$database = new database();
$db = $database->connect();
$new_blog = new blog($db);

if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['update'])){
    
        $main_image = empty($_FILES['main_image']['name'])?$_POST['old_main_image']:"";
        $alt_image = empty($_FILES['alt_image']['name'])?$_POST['old_alt_image']:"";

        // Params
        $new_blog->n_blog_post_id = $_POST['blog_id'];
        $new_blog->n_category_id = $_POST['select_category'];
        $new_blog->v_post_title = $_POST['title'];
        $new_blog->v_post_meta_title = $_POST['meta_title'];
        $new_blog->v_post_path = $_POST['blog_path'];
        $new_blog->v_post_summary = $_POST['blog_summary'];
        $new_blog->v_post_content = $_POST['blog_content'];
        $new_blog->v_main_image_url = $main_image;
        $new_blog->v_alt_image_url = $alt_image;
        $new_blog->n_blog_post_views = $_POST['post_view'];
        $new_blog->n_home_page_place = $_POST['opt_place'];
        $new_blog->f_post_status = $_POST['status'];
        $new_blog->d_date_created = $_POST['date_created'];
        $new_blog->d_time_created = $_POST['time_created'];
        $new_blog->d_date_updated = date("Y-m-d",time());
        $new_blog->d_time_updated = date("h:i:s",time());

        // Update blog
        if($new_blog->update()){
            $flag = "Update successful!";        
        }

    }

    if(isset($_POST['delete'])){
        $new_tag = new tag($db);
        $new_tag->n_blog_post_id = $_POST['blog_id'];
        $new_tag->delete();

        if($_POST['main_image']!=""){
            unlink("../images/upload/".$_POST['main_image']);
        }

        if($_POST['alt_image']!=""){
            unlink("../images/upload/".$_POST['alt_image']);
        }

        $new_blog->n_blog_post_id = $_POST['blog_id'];
        if($new_blog->delete()){
            $flag = "Delete successful!";
        }        
    }

}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vinhs blog</title>
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Morris Chart Styles-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>

<body>
    <div id="wrapper">
        <?php  
            include "header.php";
        ?>
        <!--/. NAV TOP  -->
        <?php  
            include "sidebar.php";
        ?>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">


                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Blogs
                        </h1>
                    </div>
                </div>
                <!-- /. ROW  -->

                <?php 
                    if(isset($flag)){

                ?>
                    <div class="alert alert-success">
                        <strong><?php echo $flag ?></strong>
                    </div>                        
                <?php 
                    }
                ?>
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Blogs Post
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Title</th>
                                                <th>Views</th>
                                                <th>Path</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>                                        
                                        <tbody>
                                            <?php  
                                            $result = $new_blog->read();
                                            $num = $result->rowCount();
                                            if($num>0){
                                                while($rows = $result->fetch()){                             
                                            ?>
                                            <tr>
                                                <td><?php echo $rows['n_blog_post_id'] ?></td>
                                                <td><?php echo $rows['v_post_title'] ?></td>
                                                <td><?php echo $rows['n_blog_post_views'] ?></td>
                                                <td><?php echo $rows['v_post_path'] ?></td>
                                                <td>
                                                <button class="popup-button">View</button>
                                                <button onclick="location.href='edit_blogs.php?id=<?php echo $rows['n_blog_post_id']?>'">Edit</button>

                                                <button data-toggle="modal" data-toggle="modal" data-target="#delete_blog<?php echo $rows['n_blog_post_id']?>">Delete</button>

                                               

                                                <div class="modal fade" id="delete_blog<?php echo $rows['n_blog_post_id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form method="POST" action="">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title" id="myModalLabel">Delete Blog</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure that you want to delete this blog?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="form_name" value="delete_blog">
                                                                <input type="hidden" name="main_image" value="<?php echo $rows['v_main_image_url'] ?>">
                                                                <input type="hidden" name="alt_image" value="<?php echo $rows['v_alt_image_url'] ?>">
                                                                <input type="hidden" name="blog_id" value="<?php echo $rows['n_blog_post_id']; ?>">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                <button name="delete" type="submit" class="btn btn-primary">Delete</button>
                                                            </div>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                </td>
                                            </tr> 
                                            <?php  
                                                }        
                                            }
                                            ?>                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel -->
                    </div>
                </div>
                <!-- /. ROW  -->
                
				<footer><p>&copy;2022</p></footer>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- Morris Chart Js -->
    <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
    <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>


</body>

</html>
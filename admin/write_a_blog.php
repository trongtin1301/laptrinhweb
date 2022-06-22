﻿<?php  
include "includes/database.php";
include "includes/categories.php";
include "includes/blogs.php";

$database =new database();
$db = $database->connect();
$new_blog=new blog($db);

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>blog</title>
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
    <!-- include summernote css/js -->
    <link href="summernote/summernote.min.css" rel="stylesheet">
    
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
                            Edit a Blog
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
                                Edit a blog
                            </div>
                            <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form role="form" method="POST" action="blogs.php" enctype="multipart/form-data">
                                       
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input name="title"  class="form-control" placeholder="Enter category">
                                        </div>

                                        <div class="form-group">
                                            <label>Meta Title</label>
                                            <input name="meta_title"  
                                            class="form-control" placeholder="Enter meta category">
                                        </div>

                                        <?php  
                                        $cate = new category($db);
                                        $result = $cate->read();
                                        ?>
                                        <div class="form-group">
                                            <label>Blog Categories</label>
                                            <select name="select_category" class="form-control">
                                                <?php  
                                                while($rs = $result->fetch()){
                                                ?>
                                                <option value="<?php echo $rs['n_category_id'] ?>" >
                                                    <?php echo $rs['v_category_title'] ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Main Image</label>
                                            <input type="file" name="main_image">
                                           
                                        </div>

                                        <div class="form-group">
                                            <label>Alt Image</label>
                                            <input type="file" name="alt_image">
                                       
                                        </div>

                                        <div class="form-group" >
                                            <label>Summary</label>
                                            <textarea id="summernote_summary" name="blog_summary" class="form-control" rows="3"><?php echo htmlspecialchars_decode($new_blog->v_post_summary) ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Blog Content</label>
                                            <textarea id="summernote_content" name="blog_content" class="form-control" rows="3"><?php echo htmlspecialchars_decode($new_blog->v_post_content) ?></textarea>
                                        </div>

                                     
                                        <div class="form-group">
                                            <label>Blog Tags (separated by comma)</label>
                                            <input name="blog_tags"  placeholder="Enter path category">
                                        </div>

                                        <div class="form-group">
                                            <label>Blog Path</label>
                                            <input name="blog_path"  placeholder="Enter path category">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Home Page Placement</label>
                                            <label class="radio-inline">
                                                <input type="radio" name="opt_place" id="optionsRadiosInline1" value="1" 
                                               >1
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="opt_place" id="optionsRadiosInline2" value="2"
                                               >2
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="opt_place" id="optionsRadiosInline3" value="3"
                                                >3
                                            </label>
                                        </div>
                                       
                                        <button name="write_blog" type="submit" class="btn btn-default">Write Blog</button>
                                        
                                    </form>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                                
                            </div>
                            <!-- /.row (nested) -->
                            </div>
                            <!-- /.panel-body -->
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

    <script src="summernote/summernote.min.js"></script>
    <script>      
    $('#summernote_summary').summernote({
        placeholder: 'Blog summary',
        height: 100
    });

    $('#summernote_content').summernote({
        placeholder: 'Blog content',
        height: 200
    });
    
    </script>
</body>

</html>
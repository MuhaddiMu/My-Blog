<?php 
    define("TITLE", "Posts");
    include("Includes/Header.php");

    if(isset($_GET['Delete'])){
        DeletePost();
    }
?>

    <!-- CK Editor -->
    <script src="//cdn.ckeditor.com/4.10.0/standard/ckeditor.js"></script>

    <!-- ============================================================== -->
    <!-- Page Content -->
    <!-- ============================================================== -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Posts</h4> </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="../Admin/">Dashboard</a></li>
                        <li class="active">Post</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <?php echo (isset($PostMsg)) ? $PostMsg : ""; ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title"><i class="fa fa-plus"></i> Create New Post</h3>
                        <form method="post" action="" enctype="multipart/form-data">
                            <div class="form-group">
                                <?php echo (isset($PostTitleError)) ? $PostTitleError : ""; ?>
                                <input name="PostTitle" type="text" class="form-control rounded" placeholder="Post Title" required>
                            </div>

                            <div class="form-group">
                                <?php echo (isset($PostContentError)) ? $PostContentError : ""; ?>
                                <textarea name="PostContent" class="form-group form-control rounded" id="Editor"></textarea>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo (isset($ImageError)) ? $ImageError : ""; ?>
                                    <label for="Feature Image">Feature Image:</label>
                                    <input name="FeatureImage" title="Feature Image" id="Feature Image" type="file" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo (isset($PostTagError)) ? $PostTagError : ""; ?>
                                    <label for="Post Tag">Select Category:</label>
                                    <select name="Tag" class="form-control" id="Post Tag" required>
                                        <option value="" selected>Select Tag</option>
                                        <?php DisplayTagOption(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <button name="AddPost" type="submit" class="input-md btn btn-success waves-effect">Add Post</button>
                            </div>

                        </form>

                        <script>
                            CKEDITOR.replace('Editor');
                        </script>

                    </div>

                    <div class="white-box">
                        <h3 class="box-title"><i class="fa fa-file-text"></i> Recent Posts</h3>

                        <div class="comment-center p-t-10">
                            <?php DisplayRecentPosts(); ?>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
        <footer class="footer text-center">
            <?php echo date('Y'); ?> &copy; Muhaddis </footer>
    </div>
    <!-- ============================================================== -->
    <!-- End Page Content -->
    <!-- ============================================================== -->

<?php 

    include("Includes/Footer.php");

?>
<script>
//Remove Parameters                                     
$(document).ready(function(){
    var uri = window.location.toString();
	if (uri.indexOf("?") > 0) {
	    var clean_uri = uri.substring(0, uri.indexOf("?"));
	    window.history.replaceState({}, document.title, clean_uri);
	}
});
</script>
<?php 
    define("TITLE", "Comments");
    include("Includes/Header.php");

    if(isset($_GET['Delete'])){
        DeleteComment();
    }

?>
    <!-- ============================================================== -->
    <!-- Page Content -->
    <!-- ============================================================== -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Comments</h4> </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="../Admin/">Dashboard</a></li>
                        <li class="active">Comments</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <?php echo (isset($CommentMsg)) ? $CommentMsg : ""; ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title">Recent Comments</h3>
                        <div class="comment-center p-t-10">
                            <?php DisplayComments(); ?>
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
//Feedback Notification
$(document).ready(function() {
    
    setTimeout(function() {
     $('.alert').addClass("bounceOutUp");
    }, 3000)
    
    setTimeout(function() {
     $('.alert').remove();
    }, 4000)
    
});    
    
    
//Remove Parameters                                     
$(document).ready(function(){
    var uri = window.location.toString();
	if (uri.indexOf("?") > 0) {
	    var clean_uri = uri.substring(0, uri.indexOf("?"));
	    window.history.replaceState({}, document.title, clean_uri);
	}
});
</script>
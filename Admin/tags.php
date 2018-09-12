<?php 
    define("TITLE", "Tags");
    include("Includes/Header.php");

if(isset($_GET['Delete'])){
    $Delete = ValidateFormData($_GET['Delete']);
    RemoveTags($Delete);
}

?>
    <!-- ============================================================== -->
    <!-- Page Content -->
    <!-- ============================================================== -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Tags</h4> </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                    <ol class="breadcrumb">
                        <li><a href="../Admin/">Dashboard</a></li>
                        <li class="active">Tags</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12 white-box">
                        <?php echo (isset($TagsMessage)) ? $TagsMessage : ""; ?>
                        <h3 class="box-title"><i class="fa fa-plus"></i> Add New Tag</h3>
                        <form method="post" action="" class="form-material">
                            <div class="form-group">
                                <div class="col-md-5">
                                    <input required name="Tag" type="text" placeholder="Motivation" class="form-control form-control-line"><?php echo (isset($TagError)) ? $TagError : ""; ?>
                                </div>

                                <div class="col-md-2">
                                    <button name="Submit" type="submit" class="btn btn-success waves-effect">Add Tag</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="white-box col-md-12">
                        <section>
                            <h3 class="box-title"><i class="fa fa-tags"></i> Tags</h3>
                            <div class="icon-list-demo clearfix">
                                <?php DisplayTags(); ?>
                            </div>
                        </section>
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
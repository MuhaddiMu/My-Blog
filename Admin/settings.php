<?php 
    define("TITLE", "Settings");
    include("Includes/Header.php");
    DisplayHomepageSettings();

?>
    <!-- ============================================================== -->
    <!-- Page Content -->
    <!-- ============================================================== -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Blank Page</h4> </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="../Admin/">Dashboard</a></li>
                        <li class="active">Settings</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
                
            </div>
            <?php echo (isset($SettingsMsg)) ? $SettingsMsg : ""; ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="white-box">
                        <h3 class="box-title"><i class="fa fa-home fa-fw"></i> Homepage</h3>
                        <img src="<?php echo (isset($Img)) ? $Img : ""; ?>" width="100%" class="img-fluid img-thumbnail DisplayImage" alt="Username">
                        <br>
                        <br>
                        <form method="post" action="" class="form-material" enctype="multipart/form-data">
                            <div class="form-group">
                                <?php echo (isset($ImgError)) ? $ImgError : ""; ?>
                                <label for="Main Image">Homepage Image</label>
                                <input title="Main Image" name="MainImage" id="Main Image" type="file" class="form-control" onchange="DisplayImage(this)" accept=".bmp, .jpg, .png, .tiff">
                            </div>

                            <div class="form-group">
                                <?php echo (isset($NameError)) ? $NameError : ""; ?>
                                <label for="Name">Name</label>
                                <input title="Name" id="Name" type="text" class="form-control form-control-line" name="UserName" value="<?php echo (isset($Name)) ? $Name : ""; ?>">
                            </div>

                            <div class="form-group">
                                <?php echo (isset($MessageError)) ? $MessageError : ""; ?>
                                <label for="Msg">Message</label>
                                <textarea title="Message" id="Msg" rows="5" class="form-control form-control-line" name="Message"><?php echo (isset($Msg)) ? $Msg : ""; ?></textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success waves-effect" name="UpdateProfile">Update Profile</button>
                            </div>

                        </form>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="white-box">
                        <h3 class="box-title"><i class="fa fa-info fa-fw" aria-hidden="true"></i> Description</h3>
                        <form action="" method="post" class="form-material">

                            <div class="form-group">
                                <?php echo (isset($DescriptionError)) ? $DescriptionError : ""; ?>
                                <label for="Homepage Caption">Description</label>
                                <textarea title="Description" name="Description" id="Homepage Caption" rows="5" class="form-control form-control-line"><?php echo (isset($Description)) ? $Description : ""; ?></textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit" name="UpdateDescription" class="btn btn-success waves-effect">Update Description</button>
                            </div>

                        </form>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="white-box">
                        <h3 class="box-title"><i class="fa fa-info fa-fw" aria-hidden="true"></i> Footer</h3>
                        <form method="post" action="" class="form-material">

                            <div class="form-group">
                                <?php echo (isset($FooterTextError)) ? $FooterTextError : ""; ?>
                                <label for="FooterText">Footer Text</label>
                                <input name="FooterText" title="Fotter Text" id="FooterText" type="text" class="form-control form-control-line" value="<?php echo (isset($FooterText)) ? $FooterText : ""; ?>">
                            </div>

                            <div class="form-group">
                                <?php echo (isset($FooterLinkError)) ? $FooterLinkError : ""; ?>
                                <label for="FooterLink">Footer Link</label>
                                <input name="FooterLink" title="Footer Link" id="FooterLink" type="text" class="form-control form-control-line" value="<?php echo (isset($FooterLink)) ? $FooterLink : ""; ?>">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success waves-effect" name="UpdateFooter">Update Footer</button>
                            </div>

                        </form>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="white-box">
                        <h3 class="box-title"><i class="fa fa-sitemap fa-fw" aria-hidden="true"></i> Favicon</h3>

                        <img src="plugins/images/favicon.png" width="30" height="30" class="img-fluid img-thumbnail" alt="Favicon">
                        <br>
                        <br>

                        <form action="" method="post" class="form-material">

                            <div class="form-group">
                                <?php echo (isset($FaviconError)) ? $FaviconError : ""; ?>
                                <label for="Favicon">Favicon Link 16&times;16</label>
                                <input name="Favicon" title="Favicon" id="Favicon" type="text" class="form-control form-control-line">
                            </div>

                            <div class="form-group">
                                <button type="submit" name="UpdateFavicon" class="btn btn-success waves-effect">Update Favicon</button>
                            </div>

                        </form>
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
//Display Image On Selection
function DisplayImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.DisplayImage')
                .attr('src', e.target.result)
                .width('100%') ;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
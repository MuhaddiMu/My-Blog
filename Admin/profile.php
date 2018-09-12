<?php 
    define("TITLE", "Profile");
    include("Includes/Header.php");
    DisplayAccountDetails();
?>

    <link href="plugins/bower_components/bootstrap-form-helper/dist/css/bootstrap-formhelpers.min.css">
    <script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="plugins/bower_components/bootstrap-form-helper/dist/js/bootstrap-formhelpers.min.js"></script>

    <!-- ============================================================== -->
    <!-- Page Content -->
    <!-- ============================================================== -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Profile page</h4> </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="../Admin/">Dashboard</a></li>
                        <li class="active">Profile Page</li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->
            <!-- .row -->
            <?php echo (isset($ProfileMsg)) ? $ProfileMsg : ""; ?>
            <div class="row">
                <div class="col-md-4 col-xs-12">
                    <div class="white-box">
                        <div class="user-bg"> <img width="100%" height="100%" alt="user" src="https://cdn.allwallpaper.in/wallpapers/900x600/1637/cityscapes-night-dubai-900x600-wallpaper.jpg">
                            <div class="overlay-box">
                                <div class="user-content">
                                    <a href=""><img src="<?php echo GravatarImage($Email); ?>" class="thumb-lg img-circle" alt="Username"></a>
                                    <h4 class="text-white"><?php echo (isset($Username)) ? $Username : ""; ?></h4>
                                    <h5 class="text-white"><?php echo (isset($Email)) ? $Email : ""; ?></h5> </div>
                            </div>
                        </div>
                        <div class="user-btm-box">
                            <div class="col-md-4 col-sm-4 text-center">
                                <h1><?php echo (isset($Phone)) ? $Phone : ""; ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-xs-12">
                    <div class="white-box">
                        <h3 class="box-title">Profile</h3>
                        <form method="post" action="" class="form-horizontal form-material">
                            <div class="form-group">
                                <?php echo (isset($NameError)) ? $NameError : ""; ?>
                                <label class="col-md-12">Full Name</label>
                                <div class="col-md-12">
                                    <input name="Fullname" type="text" placeholder="Johnathan Doe" class="form-control form-control-line" value="<?php echo (isset($Name)) ? $Name : ""; ?>"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <?php echo (isset($EmailError)) ? $EmailError : ""; ?>
                                <label class="col-md-12">Email</label>
                                <div class="col-md-12">
                                    <input name="Email" type="email" placeholder="johnathan@admin.com" class="form-control form-control-line" value="<?php echo (isset($Email)) ? $Email : ""; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php echo (isset($UsernameError)) ? $UsernameError : ""; ?>
                                <label for="" class="col-md-12">Username</label>
                                <div class="col-md-12">
                                    <input name="Username" type="text" class="form-control form-control-line" placeholder="<?php echo (isset($Username)) ? $Username : "Drakemesk"; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <?php echo (isset($PhoneError)) ? $PhoneError : ""; ?>
                                <label class="col-md-12">Phone No</label>
                                <div class="col-md-12">
                                    <input name="Phone" type="text" placeholder="123 456 7890" class="form-control form-control-line" value="<?php echo (isset($Phone)) ? $Phone : ""; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <?php echo (isset($MessageError)) ? $MessageError : ""; ?>
                                <label class="col-md-12">Message</label>
                                <div class="col-md-12">
                                    <textarea name="Message" rows="5" class="form-control form-control-line"><?php echo (isset($Message)) ? $Message : ""; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php echo (isset($CountryError)) ? $CountryError : ""; ?>
                                <label class="col-sm-12">Select Country</label>
                                <div class="col-sm-12">
                                    <select name="Country" class="form-control form-control-line bfh-countries" data-country="<?php echo (isset($Country)) ? $Country : ""; ?>"></select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" name="UpdateUserProfile" class="btn btn-success waves-effect">Update Profile</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12"></div>
                <div class="col-md-8 col-xs-12">
                    <div class="white-box">
                        <h3 class="box-title">Change Password</h3>
                        <form method="post" action="" class="form-horizontal form-material">

                            <div class="form-group">
                                <?php echo (isset($CPassError)) ? $CPassError : ""; ?>
                                <label class="col-md-12">Current Password</label>
                                <div class="col-md-12">
                                    <input name="CPass" id="CPass" type="password" class="form-control-line" required>
                                    <span toggle="#CPass" class="fa fa-fw fa-eye field-icon CPass"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <?php echo (isset($NPassError)) ? $NPassError : ""; ?>
                                <label class="col-md-12">New Password</label>
                                <div class="col-md-12">
                                    <input name="NPass" id="NPass" type="password" class="form-control-line" required>
                                    <span toggle="#NPass" class="fa fa-fw fa-eye field-icon NPass"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <?php echo (isset($CNPassError)) ? $CNPassError : ""; ?>
                                <label class="col-md-12">Confirm New Password</label>
                                <div class="col-md-12">
                                    <input name="CNPass" id="CNPass" type="password" class="form-control-line" required>
                                    <span toggle="#CNPass" class="fa fa-fw fa-eye field-icon CNPass"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" name="UpdatePassword" class="btn btn-success waves-effect">Update Password</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
        <footer class="footer text-center">
            <?php echo date('Y'); ?> &copy; Muhaddis </footer>
    </div>
    <!-- /#page-wrapper -->

<?php 

    include("Includes/Footer.php");

?>
<script>
//Match New Password and Confirm New Password
var NPass = document.getElementById("NPass")
  , CNPass = document.getElementById("CNPass");

function validatePassword(){
  if(NPass.value != CNPass.value) {
    CNPass.setCustomValidity("Passwords Don't Match");
  } else {
    CNPass.setCustomValidity('');
  }
}

NPass.onchange = validatePassword;
CNPass.onkeyup = validatePassword;
    
</script>
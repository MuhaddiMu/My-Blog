<?php 
    
    include("Includes/Header.php");

?>

<link href="plugins/bower_components/bootstrap-form-helper/dist/css/bootstrap-formhelpers.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
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
                        <a href="https://wrappixel.com/templates/ampleadmin/" target="_blank" class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Upgrade to Pro</a>
                        <ol class="breadcrumb">
                            <li><a href="#">Dashboard</a></li>
                            <li class="active">Profile Page</li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                <!-- .row -->
                <div class="row">
                    <div class="col-md-4 col-xs-12">
                        <div class="white-box">
                            <div class="user-bg"> <img width="100%" height="100%" alt="user" src="plugins/images/large/img1.jpg">
                                <div class="overlay-box">
                                    <div class="user-content">
                                        <a href="javascript:void(0)"><img src="plugins/images/users/genu.jpg" class="thumb-lg img-circle" alt="Username"></a>
                                        <h4 class="text-white">User Name</h4>
                                        <h5 class="text-white">info@myadmin.com</h5> </div>
                                </div>
                            </div>
                            <div class="user-btm-box">
                                <div class="col-md-4 col-sm-4 text-center">
                                    <h1>03346016010</h1> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title">Profile</h3>
                            <form class="form-horizontal form-material">
                                <div class="form-group">
                                    <label class="col-md-12">Full Name</label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="Johnathan Doe" class="form-control form-control-line"> </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-email" class="col-md-12">Email</label>
                                    <div class="col-md-12">
                                        <input type="email" placeholder="johnathan@admin.com" class="form-control form-control-line" name="example-email" id="example-email"> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Phone No</label>
                                    <div class="col-md-12">
                                        <input type="text" placeholder="123 456 7890" class="form-control form-control-line"> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Message</label>
                                    <div class="col-md-12">
                                        <textarea rows="5" class="form-control form-control-line"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12">Select Country</label>
                                    <div class="col-sm-12">
                                        <select class="form-control form-control-line bfh-countries" data-country="US"></select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button class="btn btn-success waves-effect">Update Profile</button>
                                    </div>
                                </div>
                            </form>            
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-12"></div>
                    <div class="col-md-8 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title">Change Password</h3>
                            <form class="form-horizontal form-material">
                                
                                <div class="form-group">
                                    <label class="col-md-12">Current Password</label>
                                    <div class="col-md-12">
                                        <input type="password" class="form-control form-control-line"> </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-12">New Password</label>
                                    <div class="col-md-12">
                                        <input type="password" class="form-control form-control-line"> </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-12">Confirm New Password</label>
                                    <div class="col-md-12">
                                        <input type="password" class="form-control form-control-line"> </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button class="btn btn-success waves-effect">Update Password</button>
                                    </div>
                                </div>
                            </form>
                            
                        </div>
                    </div>                    
                </div>
                
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
            <footer class="footer text-center"> <?php echo date('Y'); ?> &copy; Muhaddis  </footer>
        </div>
        <!-- /#page-wrapper -->
<?php 
    
    include("Includes/Footer.php");

?>

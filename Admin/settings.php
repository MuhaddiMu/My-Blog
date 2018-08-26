<?php 
    
    include("Includes/Header.php");

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
                            <li><a href="">Dashboard</a></li>
                            <li class="active">Blank Page</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="white-box">
                            <h3 class="box-title"><i class="fa fa-home fa-fw"></i> Homepage Image</h3>
                                <img src="https://www.w3schools.com/w3images/avatar_g.jpg" width="100%" class="img-fluid img-thumbnail" alt="Username">
                                <br><br>
                                <form class="form-material">
                                    <div class="form-group">
                                        <label for="Main Image">Homepage Image</label>
                                        <input title="Main Image" id="Main Image" type="file" class="form-control">
                                    </div> 


                                    <div class="form-group">
                                        <label for="Name">Name</label>
                                        <input title="Name" id="Name" type="text" class="form-control form-control-line">
                                    </div>  
                                    
                                    <div class="form-group">
                                        <label for="Msg">Message</label>
                                        <textarea id="Msg" rows="5" class="form-control form-control-line"></textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <button class="btn btn-success waves-effect">Update Profile</button>
                                    </div>
                                    
                                </form>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="white-box">
                            <h3 class="box-title"><i class="fa fa-info fa-fw" aria-hidden="true"></i> Description</h3>
                            <form class="form-material">

                                <div class="form-group">
                                    <label for="Homepage Caption">Description</label>
                                    <textarea id="Homepage Caption" rows="5" class="form-control form-control-line"></textarea>
                                </div>
                                    
                                <div class="form-group">
                                    <button class="btn btn-success waves-effect">Update Description</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="white-box">
                            <h3 class="box-title"><i class="fa fa-info fa-fw" aria-hidden="true"></i> Footer</h3>
                            <form class="form-material">

                                <div class="form-group">
                                    <label for="FooterText">Footer Text</label>
                                    <input title="FooterText" id="FooterText" type="text" class="form-control form-control-line">
                                </div>
                                
                                <div class="form-group">
                                    <label for="FooterLink">Footer Link</label>
                                    <input title="FooterLink" id="FooterLink" type="text" class="form-control form-control-line">
                                </div>
                                    
                                <div class="form-group">
                                    <button class="btn btn-success waves-effect">Update Footer</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="white-box">
                            <h3 class="box-title"><i class="fa fa-sitemap fa-fw" aria-hidden="true"></i> Favicon</h3>
                            
                            <img src="plugins/images/favicon.png" width="30" height="30" class="img-fluid img-thumbnail" alt="Favicon">
                            <br><br>
                            
                            <form class="form-material">
                                
                                <div class="form-group">
                                    <label for="Favicon">Favicon Link 16&times;16</label>
                                    <input title="Favicon" id="Favicon" type="text" class="form-control form-control-line">
                                </div>
                                    
                                <div class="form-group">
                                    <button class="btn btn-success waves-effect">Update Favicon</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
            <footer class="footer text-center"> <?php echo date('Y'); ?> &copy; Muhaddis  </footer>
        </div>
        <!-- ============================================================== -->
        <!-- End Page Content -->
        <!-- ============================================================== -->
    <?php 
    
    include("Includes/Footer.php");

?>
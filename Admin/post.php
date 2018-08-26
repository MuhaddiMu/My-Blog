<?php 
    
    include("Includes/Header.php");

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
                        <h4 class="page-title">Blank Page</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Dashboard</a></li>
                            <li class="active">Post</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                            <h3 class="box-title"><i class="fa fa-plus"></i> Create New Post</h3>
                            <form method="post" action="">
                                <div class="form-group">
                                    <input type="text" class="form-control rounded" placeholder="Post Title">
                                </div>

                                <div class="form-group">
                                    <textarea class="form-group form-control rounded" id="Editor"></textarea>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label for="Feature Image">Feature Image:</label>
                                            <input title="Feature Image" id="Feature Image" type="file" class="form-control" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Post Tag">Select Category:</label>
                                        <select required class="form-control" id="Post Tag">
                                            <option selected disabled>Select Tag</option>
                                            <option>Tag 1</option>
                                            <option>Tag 2</option>
                                            <option>Tag 3</option>
                                            <option>Tag 4</option>
                                        </select>
                                    </div>
                                </div>
    
                                <div class="form-group">
                                    <button type="submit" class="input-md btn btn-success waves-effect">Add Post</button> 
                                </div>
                                
                            </form>
                                                        
                            <script>
                                CKEDITOR.replace('Editor' );
                            </script>
                            
                            
                        </div>
                        
                        <div class="white-box">
                            <h3 class="box-title"><i class="fa fa-file-text"></i> Recent Posts</h3>
                            
                            <div class="comment-center p-t-10">                           
                                <div class="comment-body">
                                    <div class="mail-contnet">
                                        <h5><b>Post Title</b></h5><span class="time">10:20 AM   20  may 2016</span>
                                        <br/><span class="mail-desc">Donec ac condimentum massa. Etiam pellentesque pretium lacus. Phasellus ultricies dictum suscipit. Aenean commodo dui pellentesque molestie feugiat. Aenean commodo dui pellentesque molestie feugiat</span>
                                        <a href="" class="btn btn btn-rounded btn-default btn-outline m-r-5"><i class="fa fa-edit"></i> Edit This Post</a><a href="" class="btn-rounded btn btn-danger btn-outline"><i class="fa fa-trash"></i> Delete This Post</a>
                                    </div>
                                </div>
                                
                                <div class="comment-body">
                                    <div class="mail-contnet">
                                        <h5><b>Post Title</b></h5><span class="time">10:20 AM   20  may 2016</span>
                                        <br/><span class="mail-desc">Donec ac condimentum massa. Etiam pellentesque pretium lacus. Phasellus ultricies dictum suscipit. Aenean commodo dui pellentesque molestie feugiat. Aenean commodo dui pellentesque molestie feugiat</span>
                                        <a href="" class="btn btn btn-rounded btn-default btn-outline m-r-5"><i class="fa fa-edit"></i> Edit This Post</a><a href="" class="btn-rounded btn btn-danger btn-outline"><i class="fa fa-trash"></i> Delete This Post</a>
                                    </div>
                                </div>
                                
                                <div class="comment-body">
                                    <div class="mail-contnet">
                                        <h5><b>Post Title</b></h5><span class="time">10:20 AM   20  may 2016</span>
                                        <br/><span class="mail-desc">Donec ac condimentum massa. Etiam pellentesque pretium lacus. Phasellus ultricies dictum suscipit. Aenean commodo dui pellentesque molestie feugiat. Aenean commodo dui pellentesque molestie feugiat</span>
                                        <a href="" class="btn btn btn-rounded btn-default btn-outline m-r-5"><i class="fa fa-edit"></i> Edit This Post</a><a href="" class="btn-rounded btn btn-danger btn-outline"><i class="fa fa-trash"></i> Delete This Post</a>
                                    </div>
                                </div>
                            </div>
                            
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
<?php
    session_start();
    include("Includes/Functions_Admin.php");
    
    //Redirect User Back if No LoggedIn Seesion is Set
    if(isset($_COOKIE['LoggedIn']) || isset($_COOKIE['RememberMeLogIn'])){} else { header("Location: Login.php"); }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="10800"/>
    <meta name="description" content="">
    <meta name="author" content="Muhaddis">
    <link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">
    <title><?php echo (defined('TITLE')) ? TITLE . " &lsaquo;" : "" ?> Admin Panel &mdash; My Own Blog</title>
    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- toast CSS -->
    <link href="plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- morris CSS -->
    <link href="plugins/bower_components/morrisjs/morris.css" rel="stylesheet">
    <!-- chartist CSS -->
    <link href="plugins/bower_components/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="css/colors/default.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header">
    <!-- ============================================================== -->
    <!-- Preloader -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Wrapper -->
    <!-- ============================================================== -->
    <div id="wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <div class="top-left-part">
                    <!-- Logo -->
                    <a class="logo" href="index.php">
                        <!-- Logo icon image, you can use font-icon also --><b>
                        <!--This is dark logo icon--><img src="plugins/images/admin-logo.png" alt="home" class="dark-logo" /><!--This is light logo icon--><img src="plugins/images/admin-logo.png" width="30" alt="home" class="light-logo" />
                     </b>
                        <!-- Logo text image you can use text also --><span class="hidden-xs">
                        <!--This is dark logo text--><img src="plugins/images/admin-text.png" alt="home" class="dark-logo" /><!--This is light logo text--><img src="plugins/images/admin-text.png" alt="home" class="light-logo" width="70%" />
                     </span> </a>
                </div>
                <!-- /Logo -->
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li>
                        <form role="search" class="app-search hidden-sm hidden-xs m-r-10">
                            <input type="text" placeholder="Search..." class="form-control"> <a href=""><i class="fa fa-search"></i></a> </form>
                    </li>
                    
                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false"> <img src="<?php echo GravatarImage(ValidateFormData($_COOKIE['LoggedInEmail'])); ?>" alt="User Image" width="36" class="img-circle"><b class="hidden-xs"><?php echo ValidateFormData(str_rot13($_COOKIE['LoggedInName'])); ?></b><span class="caret"></span> </a>
                        <ul class="dropdown-menu dropdown-user animated flipInY">
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-img"><img src="<?php echo GravatarImage(ValidateFormData($_COOKIE['LoggedInEmail'])); ?>" alt="user"></div>
                                    <div class="u-text">
                                        <h4><?php echo ValidateFormData(str_rot13($_COOKIE['LoggedInName'])); ?></h4>
                                        <p class="text-muted"><?php echo ValidateFormData($_COOKIE['LoggedInEmail']); ?></p><a href="profile.php" class="btn btn-rounded btn-danger btn-sm">View Profile</a></div>
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li><a href="profile.php"><i class="ti-user"></i> My Profile</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="?LogOut"><i class="fa fa-power-off"></i> Logout</a></li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- End Top Navigation -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav slimscrollsidebar">
                <div class="sidebar-head">
                    <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu">Navigation</span></h3>
                </div>
                <ul class="nav" id="side-menu">
                    <li style="padding: 70px 0 0;">
                        <a href="index.php" class="waves-effect"><i class="fa fa-clock-o fa-fw" aria-hidden="true"></i>Dashboard</a>
                    </li>
                    <li>
                        <a href="profile.php" class="waves-effect"><i class="fa fa-user fa-fw" aria-hidden="true"></i>Profile</a>
                    </li>
                    <li>
                        <a href="users.php" class="waves-effect"><i class="fa fa-users fa-fw" aria-hidden="true"></i>Users</a>
                    </li>
                    <li>
                        <a href="post.php" class="waves-effect"><i class="fa fa-list-alt fa-fw" aria-hidden="true"></i>Post</a>
                    </li>
                    <li>
                        <a href="comments.php" class="waves-effect"><i class="fa fa-comments fa-fw" aria-hidden="true"></i>Comments</a>
                    </li>
                    <li>
                        <a href="tags.php" class="waves-effect"><i class="fa fa-tags fa-fw" aria-hidden="true"></i>Tags</a>
                    </li>
                    <li>
                        <a href="settings.php" class="waves-effect"><i class="fa fa-cogs fa-fw" aria-hidden="true"></i>Site Settings</a>
                    </li>
                </ul>
                <div class="center p-20">
                    <a href="https://Muhaddis.Info" target="_blank" class="btn btn-danger btn-block waves-effect waves-light">Muhaddis</a>
                </div>
            </div>

        </div>
        <!-- ============================================================== -->
        <!-- End Left Sidebar -->
        <!-- ============================================================== -->
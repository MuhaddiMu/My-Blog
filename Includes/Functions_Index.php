<?php

include("Includes/Connection.php");
date_default_timezone_set("Asia/Karachi");

//Form Validation / XSS / SQLi
function ValidateFormData($FormData) {
    $FormData = trim(stripslashes(htmlspecialchars(strip_tags(str_replace(array('(',')'), '', $FormData)), ENT_QUOTES)));
    return $FormData;
}


//Select Owner Details From Databse /Index
function DisplayOwner() {
    global $Connection;
    
    $Query  = "SELECT * FROM homepage";
    $Result = $Connection->query($Query);
    
    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            $HomepageImage = $Row['Homepage_Image'];
            $HomepageName  = $Row['Homepage_Name'];
            $HomepageMsg   = $Row['Homepage_Message'];
            
            echo '<img src="' . $HomepageImage . '" style="width:100%">
            <div class="w3-container w3-white">
                <h4><b>' . $HomepageName . '</b></h4>
                <p>' . $HomepageMsg . '</p>
            </div>';
            
        }
    }
}


//Display Discription /Index
function Description() {
    global $Connection;
    
    $Query  = "SELECT * FROM homepage";
    $Result = $Connection->query($Query);
    
    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            $Description = $Row['Homepage_Description'];
            echo $Description;
        }
    }
}


//Display Footer Name /Index
function Footer() {
    global $Connection;
    global $FootherText;
    global $FootherLink;
    
    $Query  = "SELECT * FROM homepage";
    $Result = $Connection->query($Query);
    
    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            $FootherText = $Row['Homepage_Footer_Text'];
            $FootherLink = $Row['Homepage_Footer_Link'];
        }
    }
}

//Display Tags Name /Index
function Tags() {
    global $Connection;
    
    $Query  = "SELECT * FROM tags";
    $Result = $Connection->query($Query);
    
    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            $Tags  = $Row['Tag'];
            $TagID = $Row['Tag_ID'];
            echo '<a href="Tags.php?Tag=' . $TagID . '"><span class="w3-tag w3-light-grey w3-small w3-margin-bottom">' . $Tags . '</span></a> ';
        }
    }
}


//Display Posts /Index
function DisplayPostsIndex() {
    global $Connection;
    global $PageNo;
    global $TotalPages;
    
    if(isset($_GET['Page'])){
        $PageNo = $_GET['Page'];
    } else {
        $PageNo = 1;
    }
    
    if($PageNo == 0){
        header("Location: index.php");
    }
    
    $NumberOfRecordsPerPage = 2;
    $Offset = ($PageNo - 1) * $NumberOfRecordsPerPage;
    
    $TotalPagesQuery    = "SELECT COUNT(*) FROM blog_post";
    $TotalPagesResult   = $Connection->query($TotalPagesQuery);
    $TotalRows          = mysqli_fetch_array($TotalPagesResult)[0];
    $TotalPages         = ceil($TotalRows / $NumberOfRecordsPerPage);
    
    $Query = "SELECT * FROM blog_post LIMIT $Offset, $NumberOfRecordsPerPage";
    $Result = $Connection->query($Query);
    if($Result->num_rows > 0){
        while ($Row = $Result->fetch_assoc()){
            $PostID      = $Row['Post_ID'];
            $Tag         = $Row['Post_Tag'];
            $PostTitle   = $Row['Post_Title'];
            $PostImage   = $Row['Post_Feature_Image'];
            $PostContent = $Row['Post_Content'];
            $PostDate    = $Row['Post_Date'];
            
            $PostContent = substr($PostContent, 0, 360);
            $PostContent = ValidateFormData($PostContent);
            $PostDate    = date('F j, Y', strtotime($PostDate));
            
            echo '<div class="w3-card-4 w3-margin w3-white">
            <img src="' . $PostImage . '" alt="Post Image" style="width:100%">
            <div class="w3-container">
                <h3><b>' . $PostTitle . '</b></h3>
                <h5><span class="w3-opacity">' . $PostDate . '</span></h5>
            </div>

            <div class="w3-container">
                <p>' . $PostContent . '</p>
                <div class="w3-row">
                    <div class="w3-col m8 s12">
                        <p>
                            <a href="Post.php?PostID=' . $PostID . '"><button class="w3-button w3-padding-large w3-white w3-border"><b>READ MORE »</b></button></a>
                        </p>
                    </div>
                    <div class="w3-col m4 w3-hide-small">
                        <p><span class="w3-padding-large w3-right"><b>Comments  </b> <span class="w3-badge">' . GetComments($PostID) . '</span></span>
                        </p>
                    </div>
                </div>
            </div>
        </div><hr>';
            
        }
    } else {
        echo '<div class="w3-card-4 w3-margin w3-white">
            <div class="w3-container"><h3>Sorry! Nothing to see here. No Posts!<h3></div>
        </div><hr>';
    }
}

//GetPostCommentNumbers
function GetComments($PostID) {
    global $Connection;
    
    $Query  = "SELECT * FROM comments WHERE CommentPost_ID = '$PostID'";
    $Result = $Connection->query($Query);
    
    if ($Result->num_rows > 0) {
        $Comments = $Result->num_rows;
    } else {
        $Comments = 0;
    }
    
    return $Comments;
}


//Select Posts Via Tag /Tags
function DisplayPostsTag($TagID) {
    global $Connection;
    
    
    $Query  = "SELECT * FROM blog_post WHERE Post_Tag = '$TagID'";
    $Result = $Connection->query($Query);
    
    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            $PostID      = $Row['Post_ID'];
            $Tag         = $Row['Post_Tag'];
            $PostTitle   = $Row['Post_Title'];
            $PostImage   = $Row['Post_Feature_Image'];
            $PostContent = $Row['Post_Content'];
            $PostDate    = $Row['Post_Date'];
            
            $PostContent = substr($PostContent, 0, 360);
            $PostContent = ValidateFormData($PostContent);
            $PostDate    = date('F j, Y', strtotime($PostDate));
            
            echo '<div class="w3-card-4 w3-margin w3-white">
            <img src="' . $PostImage . '" alt="Post Image" style="width:100%">
            <div class="w3-container">
                <h3><b>' . $PostTitle . '</b></h3>
                <h5><span class="w3-opacity">' . $PostDate . '</span></h5>
            </div>

            <div class="w3-container">
                <p>' . $PostContent . '</p>
                <div class="w3-row">
                    <div class="w3-col m8 s12">
                        <p>
                            <a href="Post.php?PostID=' . $PostID . '"><button class="w3-button w3-padding-large w3-white w3-border"><b>READ MORE »</b></button></a>
                        </p>
                    </div>
                    <div class="w3-col m4 w3-hide-small">
                        <p><span class="w3-padding-large w3-right"><b>Comments  </b> <span class="w3-badge">' . GetComments($PostID) . '</span></span>
                        </p>
                    </div>
                </div>
            </div>
        </div><hr>';
        }
    } else {
        echo '<div class="w3-card-4 w3-margin w3-white"><div class="w3-container"><h3>Sorry! Nothing to see here. No Posts!</h3></div></div>';
    }
}


// Display Specific Post with Contetnts /Post
function DisplayPost($PostID) {
    global $Connection;
    $Query  = "SELECT * FROM blog_post WHERE Post_ID = '$PostID'";
    $Result = $Connection->query($Query);
    
    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            $PostID      = $Row['Post_ID'];
            $Tag         = $Row['Post_Tag'];
            $PostTitle   = $Row['Post_Title'];
            $PostImage   = $Row['Post_Feature_Image'];
            $PostContent = $Row['Post_Content'];
            $PostDate    = $Row['Post_Date'];
            
            $PostDate = date('F j, Y', strtotime($PostDate));
           
            echo '<div class="w3-card-4 w3-margin w3-white">
            <div class="w3-center w3-container">
                <h3><b>' . strtoupper($PostTitle) . '</b></h3>
                <h5><span class="w3-opacity">' . $PostDate . '</span></h5>
            </div>
            <img src="' . $PostImage . '" alt="Post Image" style="width:100%">
            <div class="w3-container">
                <p>' . $PostContent . '</p>
            </div>
        </div>';
            
        }
    } else {
        header("Location: index.php");
    }
}


//Display Tag By Tag ID /Tags
function TagByID($TagID) {
    global $Connection;
    
    $Query  = "SELECT * FROM tags WHERE Tag_ID = '$TagID'";
    $Result = $Connection->query($Query);
    
    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            echo $Row['Tag'];
        }
    } else {
        header("Location: index.php");
    }
}


//Add Comment /Post
if (isset($_POST['AddComment'])) {
    $Name    = $_POST['Name'];
    $Comment = $_POST['Comment'];
    $PostID  = ValidateFormData($_POST['PostId']);
    
    if (!$Name) {
        $NameError = "Please Add Your Name";
    } else {
        $Name = ValidateFormData($Name);
    }
    
    if (!$Comment) {
        $CommentError = "Please Add Comment";
    } else {
        $Comment = ValidateFormData($Comment);
    }
    
    if ($Name && $Comment && $PostID) {
        if (is_numeric($PostID) == TRUE) {
            $Query = "INSERT INTO comments(CommentPost_ID, Comment_Author, Comment, Comment_Date) VALUES('$PostID', '$Name', '$Comment', CURRENT_TIMESTAMP)";
            if ($Connection->query($Query) === TRUE) {
                $CommentMessage = '<div class="alert animated bounceInDown w3-panel w3-green w3-display-container"><p>Comment Added Successfully</p></div>';
                
            } else {
                $CommentMessage = '<div class="alert animated bounceInDown w3-panel w3-green w3-display-container"><p>Error: ' . $Connection->error . '</p></div>';
            }
        }
    }
}

//Display Comments /Post
function DisplayComments($PostID) {
    global $Connection;
    
    $Query  = "SELECT * FROM comments WHERE CommentPost_ID = '$PostID'";
    $Result = $Connection->query($Query);
    
    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            $CommentAuthor = $Row['Comment_Author'];
            $Comment       = $Row['Comment'];
            
            echo '<p class="w3-container"><b>' . $CommentAuthor . ': </b>' . $Comment . '</p><hr>';
        }
    }
}


function GetTitle($PostID) {
    global $Connection;
    $Query  = "SELECT * FROM blog_post WHERE Post_ID = '$PostID'";
    $Result = $Connection->query($Query);
    
    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            $PostTitle   = $Row['Post_Title'];
            define("TITLE", $PostTitle);
        }
    }
}


//Display Popular Posts /Index
function PopularPosts(){
    global $Connection;
    
    $Query = "SELECT * FROM post_visits ORDER BY Post_Visits DESC LIMIT 4";
    $Result = $Connection->query($Query);
    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            $PostID = $Row['Post_ID'];
            $PostVisits = $Row['Post_Visits'];
            IDToPost($PostID);
        
        }
    }
}


//PostID to Post Top Function
function IDToPost($PostID){
   global $Connection;
    
    $Query = "SELECT * FROM blog_post WHERE Post_ID = '$PostID'";
    $Result = $Connection->query($Query);
    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            $PostID      = $Row['Post_ID'];
            $Tag         = $Row['Post_Tag'];
            $PostTitle   = $Row['Post_Title'];
            $PostImage   = $Row['Post_Feature_Image'];
            
            echo '<li class="w3-padding-16">
                    <img src="' . $PostImage . '" alt="Popular Post" class="w3-left w3-margin-right" style="width:50px; height:50px">
                    <span class="w3-large"><a style="text-decoration: none;" href="Post.php?PostID='. $PostID .'">' . $PostTitle . '</a></span>
                    <br>
                    <span>' . TagByPostTag($Tag) . '</span>
                </li>';
        }
    }
}  

//Display Tag By Tag ID Top Function
function TagByPostTag($TagID) {
    global $Connection;
    
    $Query  = "SELECT * FROM tags WHERE Tag_ID = '$TagID'";
    $Result = $Connection->query($Query);
    
    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            return $Row['Tag'];
        }
    }
}

//Close Connection
$Connection->error;

?>
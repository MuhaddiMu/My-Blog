<?php 
    include("../Includes/Connection.php");

#Functions_Admin.php For Functioning and Linking or Interacting Admin Panel / Backend Contents with Databse Including Crud Operations

#Form Validation / XSS / SQLi
    function ValidateFormData($FormData){
        $FormData = trim(stripslashes(htmlspecialchars(strip_tags(str_replace( array( '(', ')' ), '', $FormData  )), ENT_QUOTES )));
        return $FormData;
    }


//Insert Tags to Databse in /Admin/Tags.php
if(isset($_POST['Submit'])){
    $Tag = $_POST['Tag'];
    
    if(!$Tag){
        $TagError   = "<p class='text-danger'>Please Add Tag</p>";
    } else {
        $Tag = ValidateFormData($Tag);

        //Insert Tag to Database
        $Query  = "INSERT INTO tags(Tag) VALUES('$Tag')";
        if($Connection->query($Query) === TRUE){
            $TagsMessage = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert"><strong>' . $Tag . '</strong> Added Successfully.<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        } else {
            $TagsMessage = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert">' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        }
    } 
}



//Displaying and Showing Tags in /Admin/Tags.php
function DisplayTags(){
    global $Connection;
    
    //Select All Tags From Databse
    $Query  = "SELECT * FROM tags";
    $Result = $Connection->query($Query);  

        if($Result->num_rows > 0){

            while($Row = $Result->fetch_assoc()){
            echo '<div class="col-sm-6 col-md-4 col-lg-3"><i class="fa fa-tag"></i>' . $Row['Tag'] . '<a href="?Delete=' . $Row['Tag_ID']. '"><i class="fa fa-times DelTag" title="Delete Tag"></i></a></div>';
        }
    }
}


//Remove Tags
function RemoveTags($Delete){
    global $Connection;
    
    //Delete Tag From Databse
    $Query = "DELETE FROM tags WHERE Tag_ID = '$Delete'";
    if($Connection->query($Query) === TRUE){
        global $TagsMessage;
        $TagsMessage = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Tag Removed Successfully.<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
    } else {
        $TagsMessage = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert">' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
    }
}

?>
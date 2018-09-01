<?php 

include("../Includes/Connection.php");

#Functions_Admin.php For Functioning and Linking or Interacting Admin Panel / Backend Contents with Databse Including Crud Operations


//Form Validation / XSS / SQLi
function ValidateFormData($FormData){
    $FormData = trim(stripslashes(htmlspecialchars(strip_tags(str_replace( array( '(', ')' ), '', $FormData  )), ENT_QUOTES )));
    return $FormData;
}


//Insert Tags to Databse in /Admin/Tags.php
if(isset($_POST['Submit'])){
    $Tag = $_POST['Tag'];
    
    if(!$Tag){
        $TagError = "<p class='text-danger'>Please Add Tag</p>";
    } else {
        $Tag = ValidateFormData($Tag);

        //Insert Tag to Database
        $Query  = "INSERT INTO tags(Tag) VALUES('$Tag')";
        if($Connection->query($Query) === TRUE){
            $TagsMessage = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert"><strong>' . $Tag . '</strong> Added Successfully.<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        } else {
            $TagsMessage = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
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


//Remove Tags /Admin/Tags.php
function RemoveTags($Delete){
    global $Connection;
    
    //Delete Tag From Databse
    $Query = "DELETE FROM tags WHERE Tag_ID = '$Delete'";
    if($Connection->query($Query) === TRUE){
        global $TagsMessage;
        $TagsMessage = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Tag Removed Successfully.<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
    } else {
        $TagsMessage = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
    }
}


//Update Profile On /Admin/Settings.php
if (isset($_POST['UpdateProfile'])) {
    
    //Getting Image
	$File      = $_FILES['MainImage'];
	$FileName  = $File['name'];
	$FileTmp   = $File['tmp_name'];
	$FileType  = $File['type'];
	$FileSize  = $File['size'];
	$FileError = $File['error'];
	$FileExt   = pathinfo($FileName, PATHINFO_EXTENSION);
	if ($FileName){
		if ($FileExt == 'png' || $FileExt == 'jpg' || $FileExt == 'bmp' || $FileExt == 'tiff'){
			if ($FileSize <= 5242880){
				    $FileNewName = 'UserAvatar' . '.' . $FileExt;
				    $Dstn = "plugins/images/" . $FileNewName;
				    if (move_uploaded_file($FileTmp, $Dstn)){
                        // Insert Image Path to Databse 
                        $ImagePath = 'http://' . $_SERVER["HTTP_HOST"] . '/CODE/My-Blog/Admin/' . $Dstn;
                        $Query = "UPDATE homepage SET Homepage_Image = '$ImagePath'";
                        $Result = $Connection->query($Query);
                }
            } else {
                $ImgError = "<p class='text-danger'>Your file size must be less than 5MB</p>";
            }
        } else {
            $ImgError = "<p class='text-danger'>Only .bmp, .jpg, .png and .tiff Extensions are allowed.</p>";
        }
    }
    
    //Get Form Data
    $Name      = $_POST['UserName'];
    $Message   = $_POST['Message'];

    if(!$Name){
        $NameError = "<p class='text-danger'>Please Add Name.</p>";
    } else {
        $Name = ValidateFormData($Name);
    }

    if(!$Message){
        $MessageError = "<p class='text-danger'>Please Add Message.</p>";
    } else {
        $Message = ValidateFormData($Message);
    }

    // Insert Name and Message to Databse 
    if($Name && $Message){
        $Query = "UPDATE homepage SET Homepage_Name = '$Name', Homepage_Message = '$Message'";
        if($Connection->query($Query) === TRUE){
            $SettingsMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Homepage Updated Successfully<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        } else {
            $SettingsMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        }
    }
}


//Update Description /Admin/Settings.php
if(isset($_POST['UpdateDescription'])){
    $Description = $_POST['Description'];
    
    if(!$Description){
        $DescriptionError = "<p class='text-danger'>Please Add Description</p>";
    } else {
        $Description = ValidateFormData($Description);

        //Update Description to Database
        $Query  = "UPDATE homepage SET Homepage_Description = '$Description'";
        if($Connection->query($Query) === TRUE){
            $SettingsMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Description Updated Successfully.<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        } else {
            $TagsMessage = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        }
    } 
}


//Display  Contents /Admin/Settings.php
function DisplayHomepageSettings(){
    global $Connection;
    global $Description;
    global $Name;
    global $Img;
    global $Msg;
    
    $Query  = "SELECT * FROM homepage";
    $Result = $Connection->query($Query); 
    
    if($Result->num_rows > 0){
        while($Row = $Result->fetch_assoc()){
            $Description = $Row['Homepage_Description'];
            $Img         = $Row['Homepage_Image'];
            $Name        = $Row['Homepage_Name'];
            $Msg         = $Row['Homepage_Message'];
        }
    }
}



















?>
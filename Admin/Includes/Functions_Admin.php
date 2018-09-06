<?php 

include("../Includes/Connection.php");

#Functions_Admin.php For Functioning and Linking or Interacting Admin Panel / Backend Contents with Databse Including Crud Operations


//Form Validation / XSS / SQLi
function ValidateFormData($FormData){
    $FormData = trim(stripslashes(htmlspecialchars(strip_tags(str_replace( array( '(', ')' ), '', $FormData  )), ENT_QUOTES )));
    return $FormData;
}


//Grab Image From Gravatar
function GravatarImage($Email){
    $Size = 150;
    $Default = "";
    $Grav_Url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $Email ) ) ) . "?d=" . urlencode( $Default ) . "&s=" . $Size;
    return $Grav_Url;
}



//Insert Tags to Databse in /Admin/Tags
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


//Displaying and Showing Tags in /Admin/Tags
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


//Remove Tags /Admin/Tags
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


//Update Profile On /Admin/Settings
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


//Update Description /Admin/Settings
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
            $SettingsMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        }
    } 
}


//Update Footer Link & Footer Text /Admin/Settings
if(isset($_POST['UpdateFooter'])){
    
    $FooterText = $_POST['FooterText'];
    $FooterLink = $_POST['FooterLink'];
    
    if(!$FooterText){
        $FooterTextError = "<p class='text-danger'>Please Add Footer Text</p>";
    } else {
        $FooterText = ValidateFormData($FooterText);
    }
    
    if(!$FooterLink){
        $FooterLinkError = "<p class='text-danger'>Please Add Footer Link</p>";
    } else {
        $FooterLink = ValidateFormData($FooterLink);
    }
    
    if($FooterText && $FooterLink){
        //Update Footer In Database
        $Query  = "UPDATE homepage SET Homepage_Footer_Link = '$FooterLink', Homepage_Footer_Text='$FooterText'";
        if($Connection->query($Query) === TRUE){
            $SettingsMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Footer Updated Successfully.<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        } else {
            $SettingsMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        }
       
    }
}


//Display  Contents /Admin/Settings
function DisplayHomepageSettings(){
    global $Connection;
    global $Description;
    global $FooterLink;
    global $FooterText;
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
            $FooterLink  = $Row['Homepage_Footer_Link'];
            $FooterText  = $Row['Homepage_Footer_Text'];
        }
    }
}


//Save Favicon to Folder /Admin/Settings
if(isset($_POST['UpdateFavicon'])){
    $Favicon = $_POST['Favicon'];
    $Headers = get_headers($Favicon, 1);

    //URL Check and Image Validation Check
    if (filter_var($Favicon, FILTER_VALIDATE_URL) && strpos($Headers['Content-Type'], 'image/') !== false){
        $Content = file_get_contents($Favicon);
        $SaveFav = 'plugins/images/favicon.png';

        //Save Favicon in Directory.
        if(file_put_contents($SaveFav, $Content)){
            $SettingsMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Favicon Updated Successfully. Please Refresh Browser or clear cache and cookies.<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        }  
    } else {
        $FaviconError = "<p class='text-danger'>Please Only Use Image URL for Favicon.</p>";
    }
}


//Update User Profile Details /Admin/Profile
if(isset($_POST['UpdateUserProfile'])){
    
    $Name       = $_POST['Fullname'];
    //$Email      = $_POST['Email'];
    //$Username   = $_POST['Username'];
    $Phone      = $_POST['Phone'];
    $Message    = $_POST['Message'];
    $Country    = $_POST['Country'];  
    
   /* //Get Email From Databse
    $DBEmail     = ValidateFormData($Email);
    $QueryEmail  = "SELECT * FROM account WHERE Email = '$DBEmail'";
    $ResultEmail = $Connection->query($QueryEmail);*/

    
    if(!$Name){
        $NameError = "<p class='text-danger'>Please Enter Your Name</p>";
    } else {
        $Name = ValidateFormData($Name);
    }
    
  /*  //Check if whether Emails Exists or not.
    if(!$Email){
        $EmailError = "<p class='text-danger'>Please Enter Your Email</p>";
    } elseif(!filter_var($Email, FILTER_VALIDATE_EMAIL)){
        $EmailError = "<p class='text-danger'>Please Use Valid Email</p>";
    } elseif($ResultEmail->num_rows > 0){
        $EmailError = "<p class='text-danger'>Account With This Email Already Exists. Please Try Another One.</p>";
    } else {
        $Email = ValidateFormData($Email);
    }  */
    
    if(!$Phone){
        $PhoneError = "<p class='text-danger'>Please Enter Your Phone Number</p>";
    } elseif(preg_match("/^[0-9]{11}$/", $Phone)){
        $Phone = ValidateFormData($Phone);
    } else {
        $PhoneError = "<p class='text-danger'>Please Use Your Valid Phone Number</p>";
    }
    
    if(!$Message){
        $MessageError = "<p class='text-danger'>Please Enter Your Message</p>";
    } else {
        $Message = ValidateFormData($Message);
    }
    
    if(!$Country){
        $CountryError = "<p class='text-danger'>Please Select Your Country</p>";
    } else {
        $Country = ValidateFormData($Country);
    }
    
    //Check if whether Username Exists or not.
    if(isset($_POST['Username'])){
        $Username = $_POST['Username'];
        if($Username){
        
            //Get Username From Databse
            $DBUsername    = ValidateFormData($Username);
            $QueryUsername  = "SELECT * FROM account WHERE Username = '$DBUsername'";
            $ResultUsername = $Connection->query($QueryUsername);

            if($ResultUsername->num_rows > 0){
                $UsernameError = "<p class='text-danger'>Username Already Exists. Please User Another one.</p>";
            } else {
                $UsernameFinal = ValidateFormData(strtok($Username, ' '));

                //Insert Data Into Databse
                if($Name && $UsernameFinal && $Phone && $Message && $Country){

                    $Query = "UPDATE account SET Fullname = '$Name', Username = '$UsernameFinal', Phone = '$Phone', Message = '$Message', Country = '$Country' WHERE Email = 'Muhaddisshah@gmail.com'"; // Session Email (Later)
                        if($Connection->query($Query) === TRUE) {
                            $ProfileMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Profile Updated Successfully.<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                        } else {
                        $ProfileMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                    }
                }
            }
            //If There's No Username Insert All Other Data to Databse
        } else {
            //Insert Data Into Databse
            if($Name && $Phone && $Message && $Country){

                $Query = "UPDATE account SET Fullname = '$Name', Phone = '$Phone', Message = '$Message', Country = '$Country' WHERE Email = 'Muhaddisshah@gmail.com'"; // Session Email (Later)
                if($Connection->query($Query) === TRUE) {
                    $ProfileMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Profile Updated Successfully.<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                } else {
                    $ProfileMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                }
            }
        }
    }
}



//Select Account Details of Specific User Session Email or ID (Later)
function DisplayAccountDetails(){
    global $Connection;
    global $Name;
    global $Email;
    global $Username;
    global $Phone;
    global $Message;
    global $Country;
    
    $Query  = "SELECT * FROM account WHERE Email = 'Muhaddisshah@gmail.com'";
    $Result = $Connection->query($Query);
    
    if($Result->num_rows > 0){
        while($Row = $Result->fetch_assoc()){
            $Name     = $Row['Fullname'];
            $Email    = $Row['Email'];
            $Username = $Row['Username'];
            $Phone    = $Row['Phone'];
            $Message  = $Row['Message'];
            $Country  = $Row['Country'];
        }
    }
}













?>
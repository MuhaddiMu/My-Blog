<?php 

include("../Includes/Connection.php");

#Functions_Admin.php For Functioning and Linking or Interacting Admin Panel / Backend Contents with Databse Including Crud Operations

date_default_timezone_set("Asia/Karachi");


//Login User /Admin/Login
function LogInUser(){
    global $Connection;
    global $EmailError;
    global $PasswordError;
    global $SessionEmail;
    global $SessionEmail;
    global $SessionID;
    global $LoginError;

    if(isset($_POST['Login'])){
        $Email    = $_POST['Email'];
        $Password = $_POST['Password'];
        
        if(!$Email){
            $EmailError = "<p class='text-danger'>Please Enter Your Email</p>";
        } else {
            $Email = ValidateFormData($Email);
        }
        
        if(!$Password){
            $PasswordError = "<p class='text-danger'>Please Enter Your Password</p>";
        }
        
        if(!empty($_POST['RememberMe'])){
            $RememberMe = $_POST['RememberMe'];
        }
        
        if($Email && $Password){
            
            $Query = "SELECT * FROM account WHERE Email = '$Email'";
            $Result = $Connection->query($Query);  

            if($Result->num_rows > 0){
                while($Row = $Result->fetch_assoc()){
                    $SessionEmail  = $Row['Email'];
                    $SessionID     = $Row['ID'];
                    $SessionName   = $Row['Username'];
                    $HashPassword  = $Row['Password'];
                    
                    //Verify Password
                    if(password_verify($Password, $HashPassword)){
                        session_start();
                        
                        //Remember Me Functionality
                        if(isset($RememberMe)){
                            
                            if($RememberMe == "On"){
                                $_SESSION['RememberMe'] = $SessionID;
                                setcookie('RememberMeLogIn', $_SESSION['LoggedInEmail'], time() + (7 * 24 * 60 * 60));
                                $_SESSION['LoggedInEmail'] = $SessionEmail;
                                $_SESSION['LoggedInName']  = $SessionName;
                                $_SESSION['LoggedInID']    = $SessionID;
                            }
                        } else {
                            setcookie('LoggedIn', $_SESSION['LoggedInEmail'], time() + (24 * 60 * 60));
                            $_SESSION['LoggedInEmail'] = $SessionEmail;
                            $_SESSION['LoggedInName']  = $SessionName;
                            $_SESSION['LoggedInID']    = $SessionID;
                        }
                        
                        header("Location: index.php");
                    } else {
                        $LoginError = "<p class='text-danger'>Incorrect Email or Password. Please Try Again.</p>";
                    }
                }
            } else {
                 $LoginError = "<p class='text-danger'>Incorrect Email or Password. Please Try Again.</p>";
            }
        }
    }
}


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
            $TagsMessage = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
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
        $TagsMessage = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
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
            $SettingsMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
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
            $SettingsMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
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
            $SettingsMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
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

                    $Query = "UPDATE account SET Fullname = '$Name', Username = '$UsernameFinal', Phone = '$Phone', Message = '$Message', Country = '$Country' WHERE Email = '" . $_SESSION['LoggedInEmail'] . "'";
                        if($Connection->query($Query) === TRUE) {
                            $ProfileMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Profile Updated Successfully.<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                        } else {
                        $ProfileMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                    }
                }
            }
            //If There's No Username Insert All Other Data to Databse
        } else {
            //Insert Data Into Databse
            if($Name && $Phone && $Message && $Country){

                $Query = "UPDATE account SET Fullname = '$Name', Phone = '$Phone', Message = '$Message', Country = '$Country' WHERE Email = '" . $_SESSION['LoggedInEmail'] . "'";
                if($Connection->query($Query) === TRUE) {
                    $ProfileMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Profile Updated Successfully.<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                } else {
                    $ProfileMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                }
            }
        }
    }
}


//Update User Password /Admin/Profile
if (isset($_POST['UpdatePassword'])) {

	$CPass = "";
	$NPass = "";
	$CNPass = "";

	$CPass = $_POST['CPass'];
	$NPass = $_POST['NPass'];
	$CNPass = $_POST['CNPass'];

	if (!$CPass) {
		$CPassError = "<p class='text-danger'>Current Password is Required</p>";
	}

	if (!$NPass) {
		$NPassError = "<p class='text-danger'>New Password is Required</p>";
	}

	if (!$CNPass) {
		$CNPassError = "<p class='text-danger'>Confirm New Password is Required</p>";
	}

	if ($CPass && $NPass && $CNPass) {
		//Select User Details from Database From Session Email
		$Query = "SELECT * FROM account WHERE Email = '" . $_SESSION['LoggedInEmail'] . "'";
		$Result = $Connection->query($Query);
		if ($Result->num_rows > 0) {
			while ($Row = $Result-> fetch_assoc()) {
				$CurrentPasswordDB = $Row['Password'];
			}
		}

		//Check If Current Password is Correct and Update New Password to Session Email
		if (password_verify($CPass, $CurrentPasswordDB)) {

			//Check if New Password and Confirm New Password are Correct
			if ($NPass === $CNPass) {
				//Hash New Password and Insert into databse.
				$HashPassword = password_hash($CPass, PASSWORD_DEFAULT);

				$Query = "UPDATE account SET Password = '$HashPassword' WHERE Email = '" . $_SESSION['LoggedInEmail'] . "'";
				if ($Connection->query($Query) === TRUE) {
					$ProfileMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Password Updated Successfully.<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
				} else {
					$ProfileMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: '.$Connection-> error.
					'<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
				}
			} else {
				$NPassError = "<p class='text-danger'><strong>New Password</strong> and <strong>Confirm New Password</strong> do not Match.</p>";
			}
		} else {
			$CPassError = "<p class='text-danger'>Current Password is Incorrect.</p>";
		}
	}
}


//User Detail and their Roles (User Management) /Admin/Users
function DisplayUsers(){
    global $Connection;
    
    $Query = "SELECT * FROM account";
    $Result = $Connection->query($Query);
    
     if($Result->num_rows > 0){
         $Number = 0;
        while($Row = $Result->fetch_assoc()){
            $Name     = $Row['Fullname'];
            $Email    = $Row['Email'];
            $Username = $Row['Username'];
            $Role     = $Row['Role'];
            
            echo " <tr>
                        <td>" . ++$Number . "</td>
                        <td><img src='" . GravatarImage($Email) . "' alt='$Name' class='img-circle'></td>
                        <td>$Name</td>
                        <td>@$Username</td>
                        <td>$Role</td>
                   </tr>";
        }
    }
}


//Select Account Details of Specific User Session Email or ID
function DisplayAccountDetails(){
    global $Connection;
    global $Name;
    global $Email;
    global $Username;
    global $Phone;
    global $Message;
    global $Country;
    
    $Query  = "SELECT * FROM account WHERE Email = '" . $_SESSION['LoggedInEmail'] . "'";
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


//Select Tags from Databse /Admin/Post
function DisplayTagOption(){
    global $Connection;
    
    $Query  = "SELECT * FROM tags";
    $Result = $Connection->query($Query);  

        if($Result->num_rows > 0){
            while($Row = $Result->fetch_assoc()){
            echo "<option value='" . $Row['Tag_ID'] . "'>" . $Row['Tag'] . "</option>";
        }
    }
}


//Add New Post in Databse /Admin/Post
if(isset($_POST['AddPost'])){
    
    $PostTitle   = $_POST['PostTitle'];
    $PostContent = $_POST['PostContent'];
    $PostTag     = $_POST['Tag'];
    
    //Getting Feature Image
	$File      = $_FILES['FeatureImage'];
	$FileName  = $File['name'];
	$FileTmp   = $File['tmp_name'];
	$FileType  = $File['type'];
	$FileSize  = $File['size'];
	$FileError = $File['error'];
	$FileExt   = pathinfo($FileName, PATHINFO_EXTENSION);
    
    if(!$PostTitle){
        $PostTitleError = "<p class='text-danger'>Please Add Post Title</p>";
    } else {
        $PostTitle = ValidateFormData($PostTitle);
    }
    
    if(!$PostContent){
        $PostContentError = "<p class='text-danger'>Please Add Post Content</p>";
    }
    
    if(!$PostTag){
        $PostTagError = "<p class='text-danger'>Please Select Post Category</p>";
    } else {
        $PostTag = ValidateFormData($PostTag);
    }
    
    if(empty($FileName)){
        $ImageError = "<p class='text-danger'>Please Select Image to Upload</p>";
    }
    
    if($PostTitle && $FileName && $PostContent && $PostTag){
        if ($FileExt == 'png' || $FileExt == 'jpg' || $FileExt == 'bmp' || $FileExt == 'tiff'){
            if ($FileSize <= 5242880){
				$FileNewName = uniqid(uniqid()) . '.' . $FileExt;
				$Dstn = "plugins/images/BlogImages/" . $FileNewName;
				if (move_uploaded_file($FileTmp, $Dstn)){
                    
                    // Insert Image Path to Databse.
                    $ImagePath = 'http://' . $_SERVER["HTTP_HOST"] . '/CODE/My-Blog/Admin/' . $Dstn;
                    
                    $Query = "INSERT INTO blog_post(Post_Tag, Post_Title, Post_Feature_Image, Post_Content, Posted_By, Post_Date) VALUES('$PostTag', '$PostTitle', '$ImagePath', '$PostContent', '" . $_SESSION['LoggedInID'] . "', CURRENT_TIMESTAMP)";
                                        
                    if($Connection->query($Query) === TRUE) {
                         $PostMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">New Post Added Successfully<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                    } else {
                        $PostMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                    }
                }
            } else {
                $ImageError = "<p class='text-danger'>Your file size must be less than 5MB</p>";
            }
        } else {
            $ImageError = "<p class='text-danger'>Only .bmp, .jpg, .png and .tiff Extensions are allowed.</p>";
        }
    }
}


//Update Post in Databse /Admin/Edit
function EditPost(){
    global $Connection;
    global $PostTag;
    global $PostTitle;
    global $PostContent;
    global $PostMsg;
    global $PostTitleError;
    global $PostContentError;
    global $PostTagError;
    
    
    if(isset($_GET['Edit'])){
        $EditPostID = $_GET['Edit'];
    
        //Check if there's in Post with Parameter ID 
        $Query  = "SELECT * FROM blog_post WHERE Post_ID = '$EditPostID'";
        $Result = $Connection->query($Query);
        
        if($Result->num_rows > 0){
            //Update Post With Selected ID
            while($Row = $Result->fetch_assoc()){
                
                $PostTag     = $Row['Post_Tag'];
                $PostTitle   = $Row['Post_Title'];
                $PostContent = $Row['Post_Content']; 
                
                //Select Post_Tag Name From Databse 
                function DisplayPostTag(){
                    global $Connection;
                    global $PostTag;

                    $Query  = "SELECT * FROM tags WHERE Tag_ID = '$PostTag'";
                    $Result = $Connection->query($Query);

                    if($Result->num_rows > 0){
                        while($Row = $Result->fetch_assoc()){
                            echo "<option selected value='" . $Row['Tag_ID'] . "'>" . $Row['Tag'] . "</option>";
                        }
                    }
                }
                
                //Update The Post
                
                if(isset($_POST['UpdatePost'])){
                    $PostTitle   = $_POST['PostTitle'];
                    $PostContent = $_POST['PostContent'];
                    $PostTag     = $_POST['Tag'];
                    
                    if(!$PostTitle){
                        $PostTitleError = "<p class='text-danger'>Please Add Post Title</p>";
                    } else {
                        $PostTitle = ValidateFormData($PostTitle);
                    }

                    if(!$PostContent){
                        $PostContentError = "<p class='text-danger'>Please Add Post Content</p>";
                    }

                    if(!$PostTag){
                        $PostTagError = "<p class='text-danger'>Please Select Post Category</p>";
                    } else {
                        $PostTag = ValidateFormData($PostTag);
                    }
                    
                    if($PostTitle && $PostContent && $PostTag){
                        
                        $Query = "UPDATE blog_post SET Post_Tag = '$PostTag', Post_Title = '$PostTitle', Post_Content = '$PostContent', Posted_By = '" . $_SESSION['LoggedInID'] . "', Post_Date = CURRENT_TIMESTAMP WHERE Post_ID = '$EditPostID'";
                        
                        if($Connection->query($Query) === TRUE) {
                            $PostMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Post Updated Successfully<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                        } else {
                            $PostMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                        }
                    }
                }
                
            }
        } else {
            echo "<script>window.location = 'post.php'</script>";
            
        }
    } else {
        echo "<script>window.location = 'post.php'</script>";
    }
}


//Display Recent Posts From Database /Admin/Edit
function DisplayRecentPosts(){
    global $Connection;
    global $PostTag;
    global $PostTitle;
    global $PostContent;
    global $PostedBy;
    global $PostDate;
    
    $Query  = "SELECT * FROM blog_post ORDER BY Post_ID DESC";
    $Result = $Connection->query($Query);
    
    if($Result->num_rows > 0){
        while($Row = $Result->fetch_assoc()){
            $PostTag     = $Row['Post_Tag'];
            $PostID      = $Row['Post_ID'];
            $PostTitle   = $Row['Post_Title'];
            $PostContent = ValidateFormData($Row['Post_Content']); 
            $PostedBy    = $Row['Posted_By']; 
            $PostDate    = $Row['Post_Date']; 
            
            $PostDate    = date('h:m A, d F Y', strtotime($PostDate));            
            $PostContent = substr($PostContent, 0, 350);        
            
            echo '<div class="comment-body">
                    <div class="mail-contnet">
                        <h5><b>' . $PostTitle . '</b></h5><span class="time"><b>' . $PostDate . '</b> By <b>' . PostedBy($PostedBy) . '</b></span>
                        <span class="mail-desc">' . $PostContent . '...</span>
                        <a href="Edit.php?Edit=' . $PostID . '" class="btn btn btn-rounded btn-default btn-outline m-r-5"><i class="fa fa-edit"></i> Edit This Post</a><a href="?Delete=' . $PostID . '" onclick="return confirm(\'Are you sure?\');" class="btn-rounded btn btn-danger btn-outline"><i class="fa fa-trash"></i> Delete This Post</a>
                    </div>
                 </div>';
        }
    }   
}


//Select User Who Posted the thread /Admin/Edit
function PostedBy($PostedBy){
        global $Connection;
    
    $Query  = "SELECT * FROM account WHERE ID = '$PostedBy'";
    $Result = $Connection->query($Query);
    if($Result->num_rows > 0){
        while($Row = $Result->fetch_assoc()){
            return $Row['Username'];
        }
    }
}


//Delete Post /Admin/Post
function DeletePost(){
    global $Connection;
    global $PostMsg;
    
    $DeletePost = $_GET['Delete'];
    
    //Check if Post Exist or not
    $Query  = "SELECT * FROM blog_post WHERE Post_ID = '$DeletePost'";
    $Result = $Connection->query($Query);
        
    if($Result->num_rows > 0){
    
        $Query = "DELETE FROM blog_post WHERE Post_ID = '$DeletePost'";
        if($Connection->query($Query) === TRUE) {
            
            $Query = "DELETE FROM comments WHERE CommentPost_ID = '$DeletePost'";
            if($Connection->query($Query) === TRUE) {
                
                $PostMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Post Deleted Successfully<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
            } else {
                $PostMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
            }
            
        } else {
                $PostMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
            }
    } else {
        echo "<script>window.location = 'post.php'</script>";
    }
}


//Select Comments /Admin/Comments
function DisplayComments(){
    global $Connection;
    global $CommentPost;
    global $CommentAuthor;
    global $Comment;
    global $CommentDate;
    
    $Query  = "SELECT * FROM comments ORDER BY Comment_ID DESC";
    $Result = $Connection->query($Query);
    
    if($Result->num_rows > 0){
        while($Row = $Result->fetch_assoc()){
            
            $CommentID      = $Row['Comment_ID'];
            $CommentPost    = $Row['CommentPost_ID'];
            $CommentAuthor  = $Row['Comment_Author'];
            $Comment        = $Row['Comment'];
            $CommentDate    = $Row['Comment_Date'];
            
            $CommentDate    = date('h:m A, d F Y', strtotime($CommentDate));        
            
            //Display Comments
            echo '<div class="comment-body">
                    <div class="mail-contnet">
                        <h5><b>' . PostTitle($CommentPost) . '</b> By <b>' . $CommentAuthor . '</b></h5>
                        <span class="time">' . $CommentDate . '</span>
                        <span class="mail-desc">' . $Comment . '</span>
                        <a href="?Delete=' . $CommentID . '" onclick="return confirm(\'Are you sure?\');" class="btn-rounded btn btn-danger btn-outline"><i class="fa fa-trash"></i> Delete This Comment</a>
                    </div>
                  </div>';
            
        }
    }
}


//Select Post of The Comment /Admin/Comments
function PostTitle(){
    global $Connection;
    global $CommentPost;
    
    $Query = "SELECT * FROM blog_post WHERE Post_ID = '$CommentPost'";
    $Result = $Connection->query($Query);
        if($Result->num_rows > 0){
            while($Row = $Result->fetch_assoc()){
                $CommentPost = $Row['Post_Title'];
                return $CommentPost;
        }
    }
}


//Delete Comment /Admin/Comments
function DeleteComment(){
    global $Connection;
    global $CommentMsg;
    
    $DeleteComment = $_GET['Delete'];
    
    //Check if Post Exist or not
    $Query  = "SELECT * FROM comments WHERE Comment_ID = '$DeleteComment'";
    $Result = $Connection->query($Query);
        
    if($Result->num_rows > 0){
    
        $Query = "DELETE FROM comments WHERE Comment_ID = '$DeleteComment'";
        if($Connection->query($Query) === TRUE) {
            $CommentMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Comment Deleted Successfully<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        } else {
            $CommentMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        }
    }
}


//Display Recent Posts From Database /Admin/Index
function DisplayRecentPostsIndex(){
    global $Connection;
    global $PostTag;
    global $PostTitle;
    global $PostContent;
    global $PostedBy;
    global $PostDate;
    
    $Query  = "SELECT * FROM blog_post";
    $Result = $Connection->query($Query);
    
    if($Result->num_rows > 0){
        $Number = 0;
        while($Row = $Result->fetch_assoc()){
            $PostTag     = $Row['Post_Tag'];
            $PostID      = $Row['Post_ID'];
            $PostTitle   = $Row['Post_Title'];
            $PostDate    = $Row['Post_Date']; 
            
            $PostDate    = date('M d, Y', strtotime($PostDate));            
            $PostTitle   = substr($PostTitle, 0, 35);
            
            if(strlen($PostTitle) > 30){
                $PostTitle = $PostTitle . "...";
            }
            
            //Display Post Update Visits (Later)
            echo '<tr>
                    <td>' . ++$Number . '</td>
                    <td class="txt-oflo">' . $PostTitle  . '</td>
                    <td>' . DisplayTagIndex($PostTag) . '</td>
                    <td class="txt-oflo">' . $PostDate . '</td>
                    <td class="txt-oflo">1337</td>
                  </tr>';
        }
    }   
}


//Display Post Tag
function DisplayTagIndex($PostTag){
    global $Connection;
    global $PostTag;
    
    $Query  = "SELECT * FROM tags WHERE Tag_ID = '$PostTag'";
    $Result = $Connection->query($Query);  

    if($Result->num_rows > 0){
        while($Row = $Result->fetch_assoc()){
            $PostTag = $Row['Tag'];
            return $PostTag;
        }
    }
}

//Close Connection
$Connection->error;

?>
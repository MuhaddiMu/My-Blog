<?php
include("../Includes/Connection.php");

#Functions_Admin.php For Functioning and Linking or Interacting Admin Panel / Backend Contents with Databse Including Crud Operations


date_default_timezone_set("Asia/Karachi");


//Login User /Admin/Login
if (isset($_POST['Login'])) {
    $Email    = $_POST['Email'];
    $Password = $_POST['Password'];
    
    if (!$Email) {
        $EmailError = "<p class='text-danger'>Please Enter Your Email</p>";
    } //!$Email
    else {
        $Email = ValidateFormData($Email);
    }
    
    if (!$Password) {
        $PasswordError = "<p class='text-danger'>Please Enter Your Password</p>";
    } //!$Password
    
    if (!empty($_POST['RememberMe'])) {
        $RememberMe = $_POST['RememberMe'];
    } //!empty($_POST['RememberMe'])
    
    if ($Email && $Password) {
        
        $Query  = "SELECT * FROM account WHERE Email = '$Email'";
        $Result = $Connection->query($Query);
        
        if ($Result->num_rows > 0) {
            while ($Row = $Result->fetch_assoc()) {
                $SessionEmail = $Row['Email'];
                $SessionID    = $Row['ID'];
                $SessionName  = $Row['Username'];
                $HashPassword = $Row['Password'];
                
                //Verify Password
                if (password_verify($Password, $HashPassword)) {
                    session_start();
                    $_SESSION['LoggedInEmail'] = $SessionEmail;
                    $_SESSION['LoggedInName']  = $SessionName;
                    $_SESSION['LoggedInID']    = $SessionID;
                    
                    //Remember Me Functionality
                    if (!isset($RememberMe)) {
                        //Cookie for 24 Hours
                        $OneDayCookie = time() + (24 * 60 * 60);
                        setcookie('LoggedIn', $_SESSION['LoggedInEmail'], $OneDayCookie);
                        setcookie('LoggedInEmail', $_SESSION['LoggedInEmail'], $OneDayCookie);
                        setcookie('LoggedInName', str_rot13($_SESSION['LoggedInName']), $OneDayCookie);
                        setcookie('LoggedInID', str_rot13($_SESSION['LoggedInID']), $OneDayCookie);
                        
                    } //!isset($RememberMe)
                    else {
                        //Cookie for one Week
                        $OneWeekCookie = time() + (7 * 24 * 60 * 60);
                        setcookie('RememberMeLogIn', $_SESSION['LoggedInEmail'], $OneWeekCookie);
                        setcookie('LoggedInEmail', $_SESSION['LoggedInEmail'], $OneWeekCookie);
                        setcookie('LoggedInName', str_rot13($_SESSION['LoggedInName']), $OneWeekCookie);
                        setcookie('LoggedInID', str_rot13($_SESSION['LoggedInID']), $OneWeekCookie);
                    }
                    
                    header("Location: index.php");
                    die();
                } //password_verify($Password, $HashPassword)
                else {
                    $LoginError = "<p class='text-danger'>Incorrect Email or Password. Please Try Again.</p>";
                }
            } //$Row = $Result->fetch_assoc()
        } //$Result->num_rows > 0
        else {
            $LoginError = "<p class='text-danger'>Incorrect Email or Password. Please Try Again.</p>";
        }
    } //$Email && $Password
} //isset($_POST['Login'])


//Form Validation / XSS / SQLi
function ValidateFormData($FormData) {
    $FormData = trim(stripslashes(htmlspecialchars(strip_tags(str_replace(array('(',')'), '', $FormData)), ENT_QUOTES)));
    return $FormData;
}


//Grab Image From Gravatar
function GravatarImage($Email) {
    $Size     = 200;
    $Default  = "";
    $Grav_Url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($Email))) . "?d=" . urlencode($Default) . "&s=" . $Size;
    return $Grav_Url;
}

//Insert Tags to Databse in /Admin/Tags
if (isset($_POST['Submit'])) {
    $Tag = $_POST['Tag'];
    
    if (!$Tag) {
        $TagError = "<p class='text-danger'>Please Add Tag</p>";
    } //!$Tag
    else {
        $Tag = ValidateFormData($Tag);
        
        //Insert Tag to Database
        $Query = "INSERT INTO tags(Tag) VALUES('$Tag')";
        if ($Connection->query($Query) === TRUE) {
            $TagsMessage = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert"><strong>' . $Tag . '</strong> Added Successfully.<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        } //$Connection->query($Query) === TRUE
        else {
            $TagsMessage = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        }
    }
} //isset($_POST['Submit'])


//Displaying and Showing Tags in /Admin/Tags
function DisplayTags() {
    global $Connection;
    
    //Select All Tags From Databse
    $Query  = "SELECT * FROM tags";
    $Result = $Connection->query($Query);
    
    if ($Result->num_rows > 0) {
        
        while ($Row = $Result->fetch_assoc()) {
            echo '<div class="col-sm-6 col-md-4 col-lg-3"><i class="fa fa-tag"></i>' . $Row['Tag'] . '<a href="?Delete=' . $Row['Tag_ID'] . '"><i class="fa fa-times DelTag" title="Delete Tag"></i></a></div>';
        } //$Row = $Result->fetch_assoc()
    } //$Result->num_rows > 0
}


//Remove Tags /Admin/Tags
function RemoveTags($Delete) {
    global $Connection;
    
    //Delete Tag From Databse
    $Query = "DELETE FROM tags WHERE Tag_ID = '$Delete'";
    if ($Connection->query($Query) === TRUE) {
        global $TagsMessage;
        $TagsMessage = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Tag Removed Successfully.<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
    } //$Connection->query($Query) === TRUE
    else {
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
    if ($FileName) {
        if ($FileExt == 'png' || $FileExt == 'jpg' || $FileExt == 'bmp' || $FileExt == 'tiff') {
            if ($FileSize <= 5242880) {
                $FileNewName = 'UserAvatar' . '.' . $FileExt;
                $Dstn        = "plugins/images/" . $FileNewName;
                if (move_uploaded_file($FileTmp, $Dstn)) {
                    // Insert Image Path to Databse 
                    $ImagePath = 'http://' . $_SERVER["HTTP_HOST"] . '/My-Blog/Admin/' . $Dstn;
                    $Query     = "UPDATE homepage SET Homepage_Image = '$ImagePath'";
                    $Result    = $Connection->query($Query);
                } //move_uploaded_file($FileTmp, $Dstn)
            } //$FileSize <= 5242880
            else {
                $ImgError = "<p class='text-danger'>Your file size must be less than 5MB</p>";
            }
        } //$FileExt == 'png' || $FileExt == 'jpg' || $FileExt == 'bmp' || $FileExt == 'tiff'
        else {
            $ImgError = "<p class='text-danger'>Only .bmp, .jpg, .png and .tiff Extensions are allowed.</p>";
        }
    } //$FileName
    
    //Get Form Data
    $Name    = $_POST['UserName'];
    $Message = $_POST['Message'];
    
    if (!$Name) {
        $NameError = "<p class='text-danger'>Please Add Name.</p>";
    } //!$Name
    else {
        $Name = ValidateFormData($Name);
    }
    
    if (!$Message) {
        $MessageError = "<p class='text-danger'>Please Add Message.</p>";
    } //!$Message
    else {
        $Message = ValidateFormData($Message);
    }
    
    // Insert Name and Message to Databse 
    if ($Name && $Message) {
        $Query = "UPDATE homepage SET Homepage_Name = '$Name', Homepage_Message = '$Message'";
        if ($Connection->query($Query) === TRUE) {
            $SettingsMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Homepage Updated Successfully<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        } //$Connection->query($Query) === TRUE
        else {
            $SettingsMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        }
    } //$Name && $Message
} //isset($_POST['UpdateProfile'])


//Update Description /Admin/Settings
if (isset($_POST['UpdateDescription'])) {
    $Description = $_POST['Description'];
    
    if (!$Description) {
        $DescriptionError = "<p class='text-danger'>Please Add Description</p>";
    } //!$Description
    else {
        $Description = ValidateFormData($Description);
        
        //Update Description to Database
        $Query = "UPDATE homepage SET Homepage_Description = '$Description'";
        if ($Connection->query($Query) === TRUE) {
            $SettingsMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Description Updated Successfully.<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        } //$Connection->query($Query) === TRUE
        else {
            $SettingsMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        }
    }
} //isset($_POST['UpdateDescription'])


//Update Footer Link & Footer Text /Admin/Settings
if (isset($_POST['UpdateFooter'])) {
    
    $FooterText = $_POST['FooterText'];
    $FooterLink = $_POST['FooterLink'];
    
    if (!$FooterText) {
        $FooterTextError = "<p class='text-danger'>Please Add Footer Text</p>";
    } //!$FooterText
    else {
        $FooterText = ValidateFormData($FooterText);
    }
    
    if (!$FooterLink) {
        $FooterLinkError = "<p class='text-danger'>Please Add Footer Link</p>";
    } //!$FooterLink
    else {
        $FooterLink = ValidateFormData($FooterLink);
    }
    
    if ($FooterText && $FooterLink) {
        //Update Footer In Database
        $Query = "UPDATE homepage SET Homepage_Footer_Link = '$FooterLink', Homepage_Footer_Text='$FooterText'";
        if ($Connection->query($Query) === TRUE) {
            $SettingsMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Footer Updated Successfully.<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        } //$Connection->query($Query) === TRUE
        else {
            $SettingsMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        }
        
    } //$FooterText && $FooterLink
} //isset($_POST['UpdateFooter'])


//Display  Contents /Admin/Settings
function DisplayHomepageSettings() {
    global $Connection;
    global $Description;
    global $FooterLink;
    global $FooterText;
    global $Name;
    global $Img;
    global $Msg;
    
    $Query  = "SELECT * FROM homepage";
    $Result = $Connection->query($Query);
    
    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            $Description = $Row['Homepage_Description'];
            $Img         = $Row['Homepage_Image'];
            $Name        = $Row['Homepage_Name'];
            $Msg         = $Row['Homepage_Message'];
            $FooterLink  = $Row['Homepage_Footer_Link'];
            $FooterText  = $Row['Homepage_Footer_Text'];
        } //$Row = $Result->fetch_assoc()
    } //$Result->num_rows > 0
}


//Save Favicon to Folder /Admin/Settings
if (isset($_POST['UpdateFavicon'])) {
    $Favicon = $_POST['Favicon'];
    $Headers = get_headers($Favicon, 1);
    
    //URL Check and Image Validation Check
    if (filter_var($Favicon, FILTER_VALIDATE_URL) && strpos($Headers['Content-Type'], 'image/') !== false) {
        $Content = file_get_contents($Favicon);
        $SaveFav = 'plugins/images/favicon.png';
        
        //Save Favicon in Directory.
        if (file_put_contents($SaveFav, $Content)) {
            $SettingsMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Favicon Updated Successfully. Please Refresh Browser or clear cache and cookies.<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        } //file_put_contents($SaveFav, $Content)
    } //filter_var($Favicon, FILTER_VALIDATE_URL) && strpos($Headers['Content-Type'], 'image/') !== false
    else {
        $FaviconError = "<p class='text-danger'>Please Only Use Image URL for Favicon.</p>";
    }
} //isset($_POST['UpdateFavicon'])


//Update User Profile Details /Admin/Profile
if (isset($_POST['UpdateUserProfile'])) {
    
    $Name    = $_POST['Fullname'];
    //$Email      = $_POST['Email'];
    $Phone   = $_POST['Phone'];
    $Message = $_POST['Message'];
    $Country = $_POST['Country'];
    
    /* //Get Email From Databse
    $DBEmail     = ValidateFormData($Email);
    $QueryEmail  = "SELECT * FROM account WHERE Email = '$DBEmail'";
    $ResultEmail = $Connection->query($QueryEmail);*/
    
    
    if (!$Name) {
        $NameError = "<p class='text-danger'>Please Enter Your Name</p>";
    } //!$Name
    else {
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
    
    if (!$Phone) {
        $PhoneError = "<p class='text-danger'>Please Enter Your Phone Number</p>";
    } //!$Phone
    elseif (preg_match("/^[0-9]{11}$/", $Phone)) {
        $Phone = ValidateFormData($Phone);
    } //preg_match("/^[0-9]{11}$/", $Phone)
    else {
        $Phone = "";
        $PhoneError = "<p class='text-danger'>Please Use Your Valid Phone Number</p>";
    }
    
    if (!$Message) {
        $MessageError = "<p class='text-danger'>Please Enter Your Message</p>";
    } //!$Message
    else {
        $Message = ValidateFormData($Message);
    }
    
    if (!$Country) {
        $CountryError = "<p class='text-danger'>Please Select Your Country</p>";
    } //!$Country
    else {
        $Country = ValidateFormData($Country);
    }
    
    //Check if whether Username Exists or not.
    if (isset($_POST['Username'])) {
        $Username = $_POST['Username'];
        if ($Username) {
            
            //Get Username From Databse
            $DBUsername     = ValidateFormData($Username);
            $QueryUsername  = "SELECT * FROM account WHERE Username = '$DBUsername'";
            $ResultUsername = $Connection->query($QueryUsername);
            
            if ($ResultUsername->num_rows > 0) {
                $UsernameError = "<p class='text-danger'>Username Already Exists. Please User Another one.</p>";
            } //$ResultUsername->num_rows > 0
            else {
                $UsernameFinal = ValidateFormData(strtok($Username, ' '));
                
                //Insert Data Into Databse
                if ($Name && $UsernameFinal && $Phone && $Message && $Country) {
                    
                    $Query = "UPDATE account SET Fullname = '$Name', Username = '$UsernameFinal', Phone = '$Phone', Message = '$Message', Country = '$Country' WHERE Email = '" . $_COOKIE['LoggedInEmail'] . "'";
                    if ($Connection->query($Query) === TRUE) {
                        $ProfileMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Profile Updated Successfully.<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                    } //$Connection->query($Query) === TRUE
                    else {
                        $ProfileMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                    }
                } //$Name && $UsernameFinal && $Phone && $Message && $Country
            }
            //If There's No Username Insert All Other Data to Databse
        } //$Username
        else {
            //Insert Data Into Databse
            if ($Name && $Phone && $Message && $Country) {
                
                $Query = "UPDATE account SET Fullname = '$Name', Phone = '$Phone', Message = '$Message', Country = '$Country' WHERE Email = '" . $_COOKIE['LoggedInEmail'] . "'";
                if ($Connection->query($Query) === TRUE) {
                    $ProfileMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Profile Updated Successfully.<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                } //$Connection->query($Query) === TRUE
                else {
                    $ProfileMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                }
            } //$Name && $Phone && $Message && $Country
        }
    } //isset($_POST['Username'])
} //isset($_POST['UpdateUserProfile'])


//Update User Password /Admin/Profile
if (isset($_POST['UpdatePassword'])) {
    
    $CPass  = "";
    $NPass  = "";
    $CNPass = "";
    
    $CPass  = $_POST['CPass'];
    $NPass  = $_POST['NPass'];
    $CNPass = $_POST['CNPass'];
    
    if (!$CPass) {
        $CPassError = "<p class='text-danger'>Current Password is Required</p>";
    } //!$CPass
    
    if (!$NPass) {
        $NPassError = "<p class='text-danger'>New Password is Required</p>";
    } //!$NPass
    
    if (!$CNPass) {
        $CNPassError = "<p class='text-danger'>Confirm New Password is Required</p>";
    } //!$CNPass
    
    if ($CPass && $NPass && $CNPass) {
        //Select User Details from Database From Session Email
        $Query  = "SELECT * FROM account WHERE Email = '" . $_COOKIE['LoggedInEmail'] . "'";
        $Result = $Connection->query($Query);
        if ($Result->num_rows > 0) {
            while ($Row = $Result->fetch_assoc()) {
                $CurrentPasswordDB = $Row['Password'];
            } //$Row = $Result->fetch_assoc()
        } //$Result->num_rows > 0
        
        //Check If Current Password is Correct and Update New Password to Session Email
        if (password_verify($CPass, $CurrentPasswordDB)) {
            
            //Check if New Password and Confirm New Password are Correct
            if ($NPass === $CNPass) {
                //Hash New Password and Insert into databse.
                $HashPassword = password_hash($CPass, PASSWORD_DEFAULT);
                
                $Query = "UPDATE account SET Password = '$HashPassword' WHERE Email = '" . $_COOKIE['LoggedInEmail'] . "'";
                if ($Connection->query($Query) === TRUE) {
                    $ProfileMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Password Updated Successfully.<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                } //$Connection->query($Query) === TRUE
                else {
                    $ProfileMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                }
            } //$NPass === $CNPass
            else {
                $NPassError = "<p class='text-danger'><strong>New Password</strong> and <strong>Confirm New Password</strong> do not Match.</p>";
            }
        } //password_verify($CPass, $CurrentPasswordDB)
        else {
            $CPassError = "<p class='text-danger'>Current Password is Incorrect.</p>";
        }
    } //$CPass && $NPass && $CNPass
} //isset($_POST['UpdatePassword'])


//User Detail and their Roles (User Management) /Admin/Users
function DisplayUsers() {
    global $Connection;
    
    $Query  = "SELECT * FROM account";
    $Result = $Connection->query($Query);
    
    if ($Result->num_rows > 0) {
        $Number = 0;
        while ($Row = $Result->fetch_assoc()) {
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
        } //$Row = $Result->fetch_assoc()
    } //$Result->num_rows > 0
}


//Select Account Details of Specific User Session Email or ID
function DisplayAccountDetails() {
    global $Connection;
    global $Name;
    global $Email;
    global $Username;
    global $Phone;
    global $Message;
    global $Country;
    
    $Query  = "SELECT * FROM account WHERE Email = '" . $_COOKIE['LoggedInEmail'] . "'";
    $Result = $Connection->query($Query);
    
    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            $Name     = $Row['Fullname'];
            $Email    = $Row['Email'];
            $Username = $Row['Username'];
            $Phone    = $Row['Phone'];
            $Message  = $Row['Message'];
            $Country  = $Row['Country'];
        } //$Row = $Result->fetch_assoc()
    } //$Result->num_rows > 0
}


//Select Tags from Databse /Admin/Post
function DisplayTagOption() {
    global $Connection;
    
    $Query  = "SELECT * FROM tags";
    $Result = $Connection->query($Query);
    
    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            echo "<option value='" . $Row['Tag_ID'] . "'>" . $Row['Tag'] . "</option>";
        } //$Row = $Result->fetch_assoc()
    } //$Result->num_rows > 0
}


//Add New Post in Databse /Admin/Post
if (isset($_POST['AddPost'])) {
    
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
    
    if (!$PostTitle) {
        $PostTitleError = "<p class='text-danger'>Please Add Post Title</p>";
    } //!$PostTitle
    else {
        $PostTitle = ValidateFormData($PostTitle);
    }
    
    if (!$PostContent) {
        $PostContentError = "<p class='text-danger'>Please Add Post Content</p>";
    } //!$PostContent
    
    if (!$PostTag) {
        $PostTagError = "<p class='text-danger'>Please Select Post Category</p>";
    } //!$PostTag
    else {
        $PostTag = ValidateFormData($PostTag);
    }
    
    if (empty($FileName)) {
        $ImageError = "<p class='text-danger'>Please Select Image to Upload</p>";
    } //empty($FileName)
    
    if ($PostTitle && $FileName && $PostContent && $PostTag) {
        if ($FileExt == 'png' || $FileExt == 'jpg' || $FileExt == 'bmp' || $FileExt == 'tiff') {
            if ($FileSize <= 5242880) {
                $FileNewName = uniqid(uniqid()) . '.' . $FileExt;
                $Dstn        = "plugins/images/BlogImages/" . $FileNewName;
                if (move_uploaded_file($FileTmp, $Dstn)) {
                    
                    // Insert Image Path to Databse.
                    $ImagePath = 'http://' . $_SERVER["HTTP_HOST"] . '/My-Blog/Admin/' . $Dstn;
                    
                    $Query = "INSERT INTO blog_post(Post_Tag, Post_Title, Post_Feature_Image, Post_Content, Posted_By, Post_Date) VALUES('$PostTag', '$PostTitle', '$ImagePath', '$PostContent', '" . $_COOKIE['LoggedInID'] . "', CURRENT_TIMESTAMP)";
                    
                    if ($Connection->query($Query) === TRUE) {
                        $PostMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">New Post Added Successfully<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                    } //$Connection->query($Query) === TRUE
                    else {
                        $PostMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                    }
                } //move_uploaded_file($FileTmp, $Dstn)
            } //$FileSize <= 5242880
            else {
                $ImageError = "<p class='text-danger'>Your file size must be less than 5MB</p>";
            }
        } //$FileExt == 'png' || $FileExt == 'jpg' || $FileExt == 'bmp' || $FileExt == 'tiff'
        else {
            $ImageError = "<p class='text-danger'>Only .bmp, .jpg, .png and .tiff Extensions are allowed.</p>";
        }
    } //$PostTitle && $FileName && $PostContent && $PostTag
} //isset($_POST['AddPost'])


//Update Post in Databse /Admin/Edit
function EditPost() {
    global $Connection;
    global $PostTag;
    global $PostTitle;
    global $PostContent;
    global $PostMsg;
    global $PostTitleError;
    global $PostContentError;
    global $PostTagError;
    
    
    if (isset($_GET['Edit'])) {
        $EditPostID = $_GET['Edit'];
        
        //Check if there's in Post with Parameter ID 
        $Query  = "SELECT * FROM blog_post WHERE Post_ID = '$EditPostID'";
        $Result = $Connection->query($Query);
        
        if ($Result->num_rows > 0) {
            //Update Post With Selected ID
            while ($Row = $Result->fetch_assoc()) {
                
                $PostTag     = $Row['Post_Tag'];
                $PostTitle   = $Row['Post_Title'];
                $PostContent = $Row['Post_Content'];
                
                //Select Post_Tag Name From Databse 
                function DisplayPostTag() {
                    global $Connection;
                    global $PostTag;
                    
                    $Query  = "SELECT * FROM tags WHERE Tag_ID = '$PostTag'";
                    $Result = $Connection->query($Query);
                    
                    if ($Result->num_rows > 0) {
                        while ($Row = $Result->fetch_assoc()) {
                            echo "<option selected value='" . $Row['Tag_ID'] . "'>" . $Row['Tag'] . "</option>";
                        } //$Row = $Result->fetch_assoc()
                    } //$Result->num_rows > 0
                }
                
                //Update The Post
                
                if (isset($_POST['UpdatePost'])) {
                    $PostTitle   = $_POST['PostTitle'];
                    $PostContent = $_POST['PostContent'];
                    $PostTag     = $_POST['Tag'];
                    
                    if (!$PostTitle) {
                        $PostTitleError = "<p class='text-danger'>Please Add Post Title</p>";
                    } //!$PostTitle
                    else {
                        $PostTitle = ValidateFormData($PostTitle);
                    }
                    
                    if (!$PostContent) {
                        $PostContentError = "<p class='text-danger'>Please Add Post Content</p>";
                    } //!$PostContent
                    
                    if (!$PostTag) {
                        $PostTagError = "<p class='text-danger'>Please Select Post Category</p>";
                    } //!$PostTag
                    else {
                        $PostTag = ValidateFormData($PostTag);
                    }
                    
                    if ($PostTitle && $PostContent && $PostTag) {
                        
                        $Query = "UPDATE blog_post SET Post_Tag = '$PostTag', Post_Title = '$PostTitle', Post_Content = '$PostContent', Posted_By = '" . $_COOKIE['LoggedInID'] . "', Post_Date = CURRENT_TIMESTAMP WHERE Post_ID = '$EditPostID'";
                        
                        if ($Connection->query($Query) === TRUE) {
                            $PostMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Post Updated Successfully<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                        } //$Connection->query($Query) === TRUE
                        else {
                            $PostMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
                        }
                    } //$PostTitle && $PostContent && $PostTag
                } //isset($_POST['UpdatePost'])
                
            } //$Row = $Result->fetch_assoc()
        } //$Result->num_rows > 0
        else {
            echo "<script>window.location = 'post.php'</script>";
            
        }
    } //isset($_GET['Edit'])
    else {
        echo "<script>window.location = 'post.php'</script>";
    }
}


//Display Recent Posts From Database /Admin/Edit
function DisplayRecentPosts() {
    global $Connection;
    global $PostTag;
    global $PostTitle;
    global $PostContent;
    global $PostedBy;
    global $PostDate;
    
    $Query  = "SELECT * FROM blog_post ORDER BY Post_ID DESC";
    $Result = $Connection->query($Query);
    
    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            $PostTag     = $Row['Post_Tag'];
            $PostID      = $Row['Post_ID'];
            $PostTitle   = $Row['Post_Title'];
            $PostContent = ValidateFormData($Row['Post_Content']);
            $PostedBy    = $Row['Posted_By'];
            $PostDate    = $Row['Post_Date'];
            
            $PostDate    = date('h:i A, d F Y', strtotime($PostDate));
            $PostContent = substr($PostContent, 0, 350);
            
            echo '<div class="comment-body">
                    <div class="mail-contnet">
                        <h5><b>' . $PostTitle . '</b></h5><span class="time"><b>' . $PostDate . '</b> By <b>' . PostedBy($PostedBy) . '</b></span>
                        <span class="mail-desc">' . $PostContent . '...</span>
                        <a href="Edit.php?Edit=' . $PostID . '" class="btn btn btn-rounded btn-default btn-outline m-r-5"><i class="fa fa-edit"></i> Edit This Post</a><a href="?Delete=' . $PostID . '" onclick="return confirm(\'Are you sure?\');" class="btn-rounded btn btn-danger btn-outline"><i class="fa fa-trash"></i> Delete This Post</a>
                    </div>
                 </div>';
        } //$Row = $Result->fetch_assoc()
    } //$Result->num_rows > 0
}


//Select User Who Posted the thread /Admin/Edit
function PostedBy($PostedBy) {
    global $Connection;
    
    $Query  = "SELECT * FROM account WHERE ID = '$PostedBy'";
    $Result = $Connection->query($Query);
    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            return $Row['Username'];
        } //$Row = $Result->fetch_assoc()
    } //$Result->num_rows > 0
}


//Delete Post /Admin/Post
function DeletePost() {
    global $Connection;
    global $PostMsg;
    
    $DeletePost = $_GET['Delete'];
    
    //Check if Post Exist or not
    $Query  = "SELECT * FROM blog_post WHERE Post_ID = '$DeletePost'";
    $Result = $Connection->query($Query);
    
    if ($Result->num_rows > 0) {
        
        $Query = "DELETE FROM blog_post WHERE Post_ID = '$DeletePost'";
        if ($Connection->query($Query) === TRUE) {
            
            $Query = "DELETE FROM comments WHERE CommentPost_ID = '$DeletePost'";
            if ($Connection->query($Query) === TRUE) {
                
                $PostMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Post Deleted Successfully<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
            } //$Connection->query($Query) === TRUE
            else {
                $PostMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
            }
            
        } //$Connection->query($Query) === TRUE
        else {
            $PostMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        }
    } //$Result->num_rows > 0
    else {
        echo "<script>window.location = 'post.php'</script>";
    }
}


//Select Comments /Admin/Comments
function DisplayComments() {
    global $Connection;
    global $CommentPost;
    global $CommentAuthor;
    global $Comment;
    global $CommentDate;
    
    $Query  = "SELECT * FROM comments ORDER BY Comment_ID DESC";
    $Result = $Connection->query($Query);
    
    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            
            $CommentID     = $Row['Comment_ID'];
            $CommentPost   = $Row['CommentPost_ID'];
            $CommentAuthor = $Row['Comment_Author'];
            $Comment       = $Row['Comment'];
            $CommentDate   = $Row['Comment_Date'];
            
            $CommentDate = date('h:i A, d F Y', strtotime($CommentDate));
            
            //Display Comments
            echo '<div class="comment-body">
                    <div class="mail-contnet">
                        <h5><b>' . PostTitle($CommentPost) . '</b> By <b>' . $CommentAuthor . '</b></h5>
                        <span class="time">' . $CommentDate . '</span>
                        <span class="mail-desc">' . $Comment . '</span>
                        <a href="?Delete=' . $CommentID . '" onclick="return confirm(\'Are you sure?\');" class="btn-rounded btn btn-danger btn-outline"><i class="fa fa-trash"></i> Delete This Comment</a>
                    </div>
                  </div>';
            
        } //$Row = $Result->fetch_assoc()
    } //$Result->num_rows > 0
}


//Select Post of The Comment /Admin/Comments
function PostTitle() {
    global $Connection;
    global $CommentPost;
    
    $Query  = "SELECT * FROM blog_post WHERE Post_ID = '$CommentPost'";
    $Result = $Connection->query($Query);
    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            $CommentPost = $Row['Post_Title'];
            return $CommentPost;
        } //$Row = $Result->fetch_assoc()
    } //$Result->num_rows > 0
}


//Delete Comment /Admin/Comments
function DeleteComment() {
    global $Connection;
    global $CommentMsg;
    
    $DeleteComment = $_GET['Delete'];
    
    //Check if Post Exist or not
    $Query  = "SELECT * FROM comments WHERE Comment_ID = '$DeleteComment'";
    $Result = $Connection->query($Query);
    
    if ($Result->num_rows > 0) {
        
        $Query = "DELETE FROM comments WHERE Comment_ID = '$DeleteComment'";
        if ($Connection->query($Query) === TRUE) {
            $CommentMsg = '<div class="animated bounceInDown alert alert-success alert-dismissible show" role="alert">Comment Deleted Successfully<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        } //$Connection->query($Query) === TRUE
        else {
            $CommentMsg = '<div class="animated bounceInDown alert alert-warning alert-dismissible show" role="alert"> Error: ' . $Connection->error . '<a href="#" data-dismiss="alert" class="rotate close" aria-hidden="true">&times;</a></div>';
        }
    } //$Result->num_rows > 0
}


//Display Recent Posts From Database /Admin/Index
function DisplayRecentPostsIndex() {
    global $Connection;
    global $PostTag;
    global $PostTitle;
    global $PostContent;
    global $PostedBy;
    global $PostDate;
    
    $Query  = "SELECT * FROM blog_post";
    $Result = $Connection->query($Query);
    
    if ($Result->num_rows > 0) {
        $Number = 0;
        while ($Row = $Result->fetch_assoc()) {
            $PostTag   = $Row['Post_Tag'];
            $PostID    = $Row['Post_ID'];
            $PostTitle = $Row['Post_Title'];
            $PostDate  = $Row['Post_Date'];
            
            $PostDate  = date('M d, Y', strtotime($PostDate));
            $PostTitle = substr($PostTitle, 0, 35);
            
            if (strlen($PostTitle) > 30) {
                $PostTitle = $PostTitle . "...";
            } //strlen($PostTitle) > 30
            echo '<tr>
                    <td>' . ++$Number . '</td>
                    <td class="txt-oflo">' . $PostTitle . '</td>
                    <td>' . DisplayTagIndex($PostTag) . '</td>
                    <td class="txt-oflo">' . $PostDate . '</td>
                    <td class="txt-oflo">' . PostVisits($PostID) . '</td>
                  </tr>';
        } //$Row = $Result->fetch_assoc()
    } //$Result->num_rows > 0
}


//Display Post Tag
function DisplayTagIndex($PostTag) {
    global $Connection;
    global $PostTag;
    
    $Query  = "SELECT * FROM tags WHERE Tag_ID = '$PostTag'";
    $Result = $Connection->query($Query);
    
    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            $PostTag = $Row['Tag'];
            return $PostTag;
        } //$Row = $Result->fetch_assoc()
    } //$Result->num_rows > 0
}


//User Logout
if (isset($_REQUEST['LogOut'])) {
    // Unset Cookies
    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach ($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name  = trim($parts[0]);
            setcookie($name, '', time() - 1000);
            setcookie($name, '', time() - 1000, '/');
        } //$cookies as $cookie
    } //isset($_SERVER['HTTP_COOKIE'])
    session_unset();
    session_destroy();
    header("Location: Login.php");
    die();
} //isset($_REQUEST['LogOut'])


//Show Post Visits /Index
function PostVisits($PostID){
    global $Connection;
    
    $Query = "SELECT * FROM post_visits WHERE Post_ID = '$PostID'";
    $Result = $Connection->query($Query);
    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()) {
            return $Row['Post_Visits'];
        }
    }  
}


//Display Total Posts /Index
function TotalPostsCount(){
    global $Connection;
    
    $Query = "SELECT COUNT(*) AS Total FROM blog_post";
    $Result = $Connection->query($Query);
    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()){
        echo $Row['Total'];
        }
    }
}


//Display Total Visit /Index
function TotalVisit(){
    global $Connection;
    
    $Query = "SELECT * FROM total_visits";
    $Result = $Connection->query($Query);
    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()){
        echo $Row['Total_Visits'];
        }
    }
}


//Display Total Page Views /Index
function TotalPageViews(){
    global $Connection;
    
    $Query = "SELECT SUM(post_visits) AS Total FROM post_visits";
    $Result = $Connection->query($Query);
    if ($Result->num_rows > 0) {
        while ($Row = $Result->fetch_assoc()){
        echo $Row['Total'];
        }
    }
}

//Close Connection
$Connection->error;

?>
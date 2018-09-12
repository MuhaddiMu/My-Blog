<?php 
if(isset($_GET['PostID'])){
    $PostID = $_GET['PostID'];    
} else {
    header("Location: index.php");
}

    //Update Post Stats
    $Query = "SELECT * FROM post_visits WHERE Post_ID = '$PostID'";
    $Result = $Connection->query($Query);
    if($Result->num_rows > 0){
        $Query = "UPDATE post_visits SET Post_Visits=Post_Visits+1 WHERE Post_ID='$PostID'";
        $Result = $Connection->query($Query);
    } else {
        $Query = "INSERT INTO post_visits(Post_ID, Post_Visits) VALUES($PostID, 1)";
        $Result = $Connection->query($Query);
    }
?>

<!-- Grid -->
<div class="w3-row">
    <div class="w3-container"><?php echo (isset($CommentMessage)) ? $CommentMessage : ""; ?></div>
    <div class="w3-col l8 s12">

        <!-- Blog entry -->
        <?php DisplayPost($PostID); ?>
        <!-- END BLOG ENTRIES -->

        <!-- COMMENTS -->

        <div class="w3-card-4 w3-margin w3-white">
            <div class="w3-container">
                <h4><b>Comments</b></h4>
                <hr>
            </div>
            <form method="post" action="" class="w3-container">
                <div class="w3-row-padding">
                    <p class="w3-text-red"> <?php echo (isset($NameError)) ? $NameError : ""; ?></p>
                    <p class="w3-text-red"> <?php echo (isset($CommentError)) ? $CommentError : ""; ?></p>
                    <div class="w3-quarter">
                        <input name="Name" class="w3-input w3-border w3-round" type="text" placeholder="Your Name" required>
                    </div>
                    <div class="w3-rest">
                        <textarea name="Comment" style="resize: none;" rows="1" class="w3-input w3-border w3-round" type="text" placeholder="Your Comment" required></textarea>
                    </div>
                    <input name="PostId" value="<?php echo $PostID ?>" type="hidden">
                    <p>
                        <button name="AddComment" type="submit" class="w3-right w3-button w3-white w3-border"><b>Comment</b></button>
                    </p>
                </div>
            </form>

            <hr>
            
            <?php DisplayComments($PostID); ?>

        </div>

        <!-- END COMMENTS -->

    </div>

    <!-- Introduction menu -->
    <div class="w3-col l4">
        <!-- About Card -->
        <div class="w3-card w3-margin w3-margin-top">
            <?php DisplayOwner(); ?>
        </div>
        
        <hr>

        <!-- Posts -->
        <div class="w3-card w3-margin">
            <div class="w3-container w3-padding">
                <h4>Popular Posts</h4>
            </div>
            <ul class="w3-ul w3-hoverable w3-white">
                <?php PopularPosts(); ?>
            </ul>
        </div>
        <hr>

        <!-- Labels / tags -->
        <div class="w3-card w3-margin">
            <div class="w3-container w3-padding">
                <h4>Tags</h4>
            </div>
            <div class="w3-container w3-white">
                <p><?php Tags(); ?></p>
            </div>
        </div>

        <!-- END Introduction Menu -->
    </div>

    <!-- END GRID -->
</div>
<br>

<!-- END w3-content -->
</div>

<script>
//Feedback Notification
$(document).ready(function() {
    
    setTimeout(function() {
     $('.alert').addClass("bounceOutUp");
    }, 3000)
    
    setTimeout(function() {
     $('.alert').remove();
    }, 4000)
    
});   
</script>
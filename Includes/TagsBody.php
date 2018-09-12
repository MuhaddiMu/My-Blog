<?php 

if(isset($_GET['Tag'])){
    $TagID = $_GET['Tag'];    
} else {
    header("Location: index.php");
}

?>

<!-- Grid -->
<div class="w3-row">

    <!-- Blog entries -->
    <div class="w3-col l8 s12">

        <div class="w3-container w3-center">
            <h2><b>Tag: <?php TagByID($TagID); ?></b></h2>
        </div>

        <!-- Blog entry -->
        <?php DisplayPostsTag($TagID); ?>
        <!-- END BLOG ENTRIES -->
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
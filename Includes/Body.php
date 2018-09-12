<!-- Grid -->
<div class="w3-row">

    <!-- Blog entries -->
    <div class="w3-col l8 s12">
        <!-- Blog entry -->
        <?php DisplayPostsIndex(); ?>
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
                <li class="w3-padding-16">
                    <img src="https://www.w3schools.com/w3images/workshop.jpg" alt="Image" class="w3-left w3-margin-right" style="width:50px">
                    <span class="w3-large">Lorem</span>
                    <br>
                    <span>Sed mattis nunc</span>
                </li>
                <li class="w3-padding-16">
                    <img src="https://www.w3schools.com/w3images/gondol.jpg" alt="Image" class="w3-left w3-margin-right" style="width:50px">
                    <span class="w3-large">Ipsum</span>
                    <br>
                    <span>Praes tinci sed</span>
                </li>
                <li class="w3-padding-16">
                    <img src="https://www.w3schools.com/w3images/skies.jpg" alt="Image" class="w3-left w3-margin-right" style="width:50px">
                    <span class="w3-large">Dorum</span>
                    <br>
                    <span>Ultricies congue</span>
                </li>
                <li class="w3-padding-16 w3-hide-medium w3-hide-small">
                    <img src="https://www.w3schools.com/w3images/rock.jpg" alt="Image" class="w3-left w3-margin-right" style="width:50px">
                    <span class="w3-large">Mingsum</span>
                    <br>
                    <span>Lorem ipsum dipsum</span>
                </li>
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
<div class="w3-center">
    <div class="w3-bar w3-border w3-round">
      <b><a href="index.php" class="w3-bar-item w3-button">First</a></b>
      <b><a href="<?php if($PageNo <= 1){echo "#"; } else { echo "?Page=".($PageNo - 1);} ?>" class="<?php if($PageNo <= 1){echo "w3-disabled"; } ?> w3-bar-item w3-button">&laquo;</a></b>
      <b><a href="<?php if($PageNo >= $TotalPages){ echo "#"; } else { echo "?Page=".($PageNo + 1); } ?>" class="<?php if($PageNo >= $TotalPages){ echo "w3-disabled"; } ?> w3-button">&raquo;</a></b>
      <b><a href="?Page=<?php echo $TotalPages; ?>" class="w3-button">Last</a></b>
    </div>
</div>
<!-- END w3-content -->
</div>
<!-- Footer -->
    <?php Footer(); ?>
    <footer class="w3-container w3-dark-grey w3-padding-32 w3-margin-top">
        <button class="w3-button w3-black w3-disabled w3-padding-large w3-margin-bottom">Previous</button>
        <button class="w3-button w3-black w3-padding-large w3-margin-bottom">Next »</button>
        <p class="w3-center">Powered by <a href="<?php echo (isset($FootherLink)) ? $FootherLink : "#"; ?>" target="_blank"><?php echo (isset($FootherText)) ? $FootherText : "Admin"; ?></a></p>
    </footer>

</body>

</html>
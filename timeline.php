<?php include('header.php'); ?>

<?php

if(isset($_COOKIE['name'])||isset($_SESSION['name'])){?>


<?php include_once('includes/connection.php'); ?>







            <?php }else{
                header('Location: index.php');
            } ?>
<?php include('footer.php') ?>

            <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
            <script type="text/javascript" src="jquery.js"></script>
            <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>

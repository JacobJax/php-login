<!DOCTYPE html>
<html lang="en">
<?php include 'templates/header.php' ?>
    <header>
       <?php
            if(isset($_SESSION["username"])){
                echo "<h3>Hey there ".$_SESSION["username"]."</h3>";
            }
       ?>
        <h1>This is a Mock up</h1>
    </header>
</body>
</html>
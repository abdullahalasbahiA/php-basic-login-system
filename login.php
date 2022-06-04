<?php
    include_once "header.php";
?>
    <form action="includes/login.inc.php" method="post">
        <input type="text" name="uid" placeholder="Username/Email..." /><br>
        <input type="password" name="pwd" placeholder="Password" /><br>
        <button type="submit" name="submit">Log In</button>
    </form>
    
    <?php
        if(isset($_GET['error'])){
            if($_GET['error'] == "wronglogin"){
                echo "<p>wrong login information!</p>";
            }else if ($_GET['error'] == "emptyinput"){
                echo "<p>Fill in all fields!</p>";
            }
        }
    ?>

<?php
    include_once "footer.php";
?>
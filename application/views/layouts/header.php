<nav>
    <li><a href="register">Register</a></li>
    <?php if(isset($_SESSION['logged_in'])){
        echo "<li><a href='logout'>Logout</a></li>";
    } else {
        echo "<li><a href='login'>Login</a></li>";
    } ?>
    <!-- <li><a href="login">Login</a></li> -->
</nav>

<hr>
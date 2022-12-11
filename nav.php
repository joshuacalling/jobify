<nav id="nav" class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="home_success.php">Home <span class="sr-only"></span></a>
            </li>
            <?php
            if (basename($_SERVER['PHP_SELF']) == "home_success.php" || basename($_SERVER['PHP_SELF']) == "user_applications.php") {
            ?>
                <li class="nav-item">
                    <a class="nav-link" href="user_applications.php">My Applications</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="editUser.php">My Profile</a>
                </li>
            <?php
            }
            ?>
            <li class="nav-item">
                <a class="nav-link" href="about.php">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact.php">Contact</a>
            </li>
        </ul>
    </div>
    <form class="form-inline my-2 my-lg-0">
        <?php
        if (!isset($_SESSION['loggedin'])) {
        ?>
            <button class="button login" type="submit">Login</button>
        <?php
        } else {
        ?>
            <button class="button login" type="submit"><a href="logout.php">Logout</a></button>
        <?php
        }
        $pageName = basename($_SERVER['PHP_SELF']);
        if ($pageName == 'jobify.php') {
        ?>
            <button class="button register" type="submit"><a href="register.php?role=user">Register</a></button>
        <?php
        }
        ?>
    </form>
</nav>
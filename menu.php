<?php $activePage = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME); ?>
<nav>
    <div class="wrapper">
        <ul class="menu">
            <li <?php if ($activePage == "index") echo 'class="active"'; ?> ><a href="index.php">Home</a></li>
            <li <?php if ($activePage == "fietsen") echo 'class="active"'; ?>><a href="fietsen.php">Fietsen</a></li>
            <li <?php if ($activePage == "fietsverhuur") echo 'class="active"'; ?>><a href="fietsverhuur.php">Verhuur</a></li>
            <li <?php if ($activePage == "contact") echo 'class="active"'; ?>><a href="contact.php">Contact</a></li>
            <li <?php if ($activePage == "openingstijden") echo 'class="active"'; ?>><a href="openingstijden.php">Openingstijden</a></li>
            <li <?php if ($activePage == "overons") echo 'class="active"'; ?>><a href="overons.php">Over ons</a></li>
        </ul>
        <div class="hamburger" onclick="toggleMenu()">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</nav>
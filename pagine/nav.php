<div class="nav">
    <div class="centratonav">
        <ul class="navlinks">
            <?php
                if (basename($_SERVER['PHP_SELF']) == "index.php") {
                    echo "<li><a href='pagine/registrazione.php'>Registrati</a></li>";
                } elseif (basename($_SERVER['PHP_SELF']) == "registrazione.php") {
                    echo "<li><a href='../index.php'>Login</a></li>";
                } else {
                    if (basename($_SERVER['PHP_SELF']) == "home.php") {
                        echo "<li id='active'>Home</li>";
                    } else {
                        echo "<li><a href='home.php'>Home</a></li>";
                    }
                    if (basename($_SERVER['PHP_SELF']) == "dati_personali.php") {
                        echo "<li id='active'>Dati personali</li>";
                    } else {
                        echo "<li><a href='dati_personali.php'>Dati personali</a></li>";
                    }
                    if (basename($_SERVER['PHP_SELF']) == "ritira.php") {
                        echo "<li id='active'>Ritira</li>";
                    } else {
                        echo "<li><a href='ritira.php'>Ritira</a></li>";
                    }
                    if (basename($_SERVER['PHP_SELF']) == "riconsegna.php") {
                        echo "<li id='active'>Riconsegna</li>";
                    } else {
                        echo "<li><a href='riconsegna.php'>Riconsegna</a></li>";
                    }
                    if (basename($_SERVER['PHP_SELF']) == "logout.php") {
                        echo "<li id='active'>Logout</li>";
                    } else {
                        echo "<li><a href='logout.php'>Logout</a></li>";
                    }
                }
            ?>
        </ul>
    </div>
</div>
<?php
    session_start();
    if(isset($_SESSION['username'])){
        header('location: pagine/home.php');
    }
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Biblioteca-Login</title>
</head>
<body>
    <?php
        require("pagine/nav.php");
    ?>
    <div class="contenuto">
        <h1>Biblioteca Online</h1>
		<h2>Pagina di Login</h2>

        <form action="" method="post">
            <table class="tab_input">
                <tr>
                    <td><label for="username">Username: </label></td>
                    <td><input type="text" name="username" id="username" value = "" required></td>
                </tr>
                <tr>
                    <td><label for="password">Password: </label></td>
                    <td><input type="password" name="password" id="password" required></td>
                </tr>
            </table>
            <input type="submit" value="Accedi">
        </form>
        <?php
            // codice del login
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["username"]) && isset($_POST["password"])) {
                $username = $_POST["username"];
                $password = $_POST["password"];

                // connessione al DB
                require_once("data/connessione_db.php");

                // creazione della query
                $myquery = "SELECT username, password 
                            FROM utenti 
                            WHERE username = '$username' AND password = '$password'";
                
                // esecuzione della query
                $ris = $conn->query($myquery);

                // verifico il risultato cioè se è presente un utente con quelle credenziali
                if ($ris->num_rows > 0) {
                    // se è presente allora l'utente è autenticato
                    echo "<p>Login effettuato con successo!</p>"; // non lo vedrò mai

                    // carico lo username in sessione per poterlo usare nelle altre pagine
                    session_start();
                    $_SESSION["username"] = $username; // salvo lo username in sessione

                    // reindirizzo alla pagina principale
                    header("location: pagine/home.php");
                    $conn->close();
                    exit(); // interrompo l'esecuzione del codice
                } else {
                    // altrimenti le credenziali sono errate
                    echo "<p>Username o password errati. Riprova.</p>";
                }
                $conn->close();
            }
        ?>

        
        <?php
            require('pagine/footer.php');
        ?>
            
    </div>
</body>
</html>


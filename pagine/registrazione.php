<?php
    // carico tutti i valori dei campi del form, se esistono, altrimenti li inizializzo a stringa vuota
    // così oltre ad averli già comodamente per il codice di registrazione, 
    // li posso usare anche per reinserirli nel form in caso l'utente li abbia già inseriti ma ci sia stato un errore, 
    // così non deve riscrivere tutto da capo quando la pagina si ricarica
    if(isset($_POST["username"])) {$username = $_POST["username"];} else {$username = "";}
	if(isset($_POST["password"])) {$password = $_POST["password"];} else {$password = "";}
    if(isset($_POST["conferma"])) $conferma = $_POST["conferma"];  else $conferma = "";
    if(isset($_POST["nome"])) $nome = $_POST["nome"];  else $nome = "";
    if(isset($_POST["cognome"])) $cognome = $_POST["cognome"];  else $cognome = "";
    if(isset($_POST["email"])) $email = $_POST["email"];  else $email = "";
    if(isset($_POST["telefono"])) $telefono = $_POST["telefono"];  else $telefono = "";
    if(isset($_POST["comune"])) $comune = $_POST["comune"];  else $comune = "";
    if(isset($_POST["indirizzo"])) $indirizzo = $_POST["indirizzo"];  else $indirizzo = "";
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Biblioteca-Registrazione</title>
</head>
<body>
    <?php
        require("nav.php");
    ?>
    <div class="contenuto">
        <h1>Biblioteca-Registrazione</h1>
        <form action="" method="post">
            <!-- da far vedere come ho cambiato lo stile per gli input -->
            <table class="tab_input tab_registrazione">
                <tr>
                    <td><label for="username">Username: </label></td>
                    <td><input type="text" name="username" id="username" value="<?php echo $username ?>" required></td>
                </tr>
                <tr>
                    <td><label for="password">Password: </label></td>
                    <td><input type="password" name="password" id="password" required></td>
                </tr>
                <tr>
                    <td><label for="conferma">Conferma password: </label></td>
                    <td><input type="password" name="conferma" id="conferma" required></td>
                </tr>
                <tr>
                    <td><label for="nome">Nome: </label></td>
                    <td><input type="text" name="nome" id="nome" <?php echo "value = '$nome'" ?>></td>
                </tr>
                <tr>
                    <td><label for="cognome">Cognome: </label></td>
                    <td><input type="text" name="cognome" id="cognome" <?php echo "value = '$cognome'" ?>></td>
                </tr>
                <tr>
                    <td><label for="email">Email: </label></td>
                    <td><input type="text" name="email" id="email" <?php echo "value = '$email'" ?>></td>
                </tr>
                <tr>
                    <td><label for="telefono">Telefono: </label></td>
                    <td><input type="text" name="telefono" id="telefono" <?php echo "value = '$telefono'" ?>></td>
                </tr>
                <tr>
                    <td><label for="comune">Comune: </label></td>
                    <td><input type="text" name="comune" id="comune" <?php echo "value = '$comune'" ?>></td>
                </tr>
                <tr>
                    <td><label for="indirizzo">Indirizzo: </label></td>
                    <td><input type="text" name="indirizzo" id="indirizzo" <?php echo "value = '$indirizzo'" ?>></td>
                </tr>
            </table>
            <input type="submit" value="Invia">
        </form>

        <p>
            <?php
            if(isset($_POST["username"]) and isset($_POST["password"])) {
                if ($_POST["username"] == "" or $_POST["password"] == "") {
                    echo "username e password non possono essere vuoti!";
                } elseif ($_POST["password"] != $_POST["conferma"]){
                    echo "<p>Le password inserite non corrispondono</p>";
                } else {
                    require_once("../data/connessione_db.php");

                    $myquery = "SELECT username 
						        FROM utenti 
						        WHERE username='$username'";
                    //echo $myquery;

                    $ris = $conn->query($myquery) or die("<p>Query fallita!</p>");
                    if ($ris->num_rows > 0) {
                        echo "Questo username è già stato usato";
                    } else {

                        // query per inserire il nuovo utente nel DB, con i valori presi dal form
                        $myquery = "INSERT INTO utenti (username, password, nome, cognome, email, telefono, comune, indirizzo)
                                    VALUES ('$username', '$password', '$nome', '$cognome','$email','$telefono','$comune','$indirizzo')";

                        /*
                        // Versione con l'uso dell'hash
                        $password_hash = password_hash($password, PASSWORD_DEFAULT);

                        $myquery = "INSERT INTO utenti (username, password, nome, cognome, email, telefono, comune, indirizzo)
                                    VALUES ('$username', '$password_hash', '$nome', '$cognome','$email','$telefono','$comune','$indirizzo')";
                        */

                        if ($conn->query($myquery) === true) {
                            // se la registrazione è andata a buon fine, salvo lo username in sessione e reindirizzo alla home
                            // in pratica registro l'utente e lo loggo direttamente

                            session_start();
                            $_SESSION["username"]=$username;
                            
						    $conn->close();

                            echo "Registrazione effettuata con successo!<br>sarai ridirezionato alla home tra 5 secondi.";
                            header('Refresh: 5; URL=home.php');

                        } else {
                            echo "Non è stato possibile effettuare la registrazione per il seguente motivo: " . $conn->error;
                        }
                    }
                }
            }
            ?>
        </p>
        <?php 
            require('footer.php');
        ?>	
    </div>
</body>
</html>
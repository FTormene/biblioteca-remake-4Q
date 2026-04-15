<?php
    // faccio partire la sessione
	session_start();

    // se l'utente non è loggato, lo reindirizzo alla pagina di login
    if(!isset($_SESSION['username'])){ 
		header('location: ../index.php');
	}
    // memorizzo lo username dell'utente loggato in una variabile
    $username = $_SESSION["username"];

    // connessione al DB
    require_once("../data/connessione_db.php");

    // query per prendere il nome e cognome dell'utente loggato
    $myquery = "SELECT nome, cognome 
                FROM utenti 
                WHERE username = '$username'";
    $ris = $conn->query($myquery);
    if ($ris->num_rows > 0) {
        $riga = $ris->fetch_assoc();
        $nome = $riga["nome"];
        $cognome = $riga["cognome"];
    }

?>
    
<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<title>Biblioteca - Home Personale</title>
	<link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
	<?php require("nav.php");?>
	<div class="contenuto">
		<h1 style="text-align: center; margin-top: 0px">Pagina personale</h1>
		<p>Benvenuto, <?php echo $nome." ".$cognome; ?>!</p>

        <h2>Libri presi in prestito</h2>
        
        <div class="elenco_libri">
            <!-- qui devo mostrare l'elenco di tutti i libri presi in prestito, li metto come card contenente immagine, titolo autore e link alla scheda -->
            
            <?php
                // query per pescare i dati dei libri presi in prestito
				$sql = "SELECT libri.cod_libro, libri.titolo, libri.copertina, autori.nome, autori.cognome 
						FROM libri JOIN autori ON libri.cod_autore = autori.cod_autore  
						WHERE libri.username_utente='$username'";
				$ris = $conn->query($sql) or die("<p>Query fallita!</p>");

                // se non ci sono libri presi in prestito, mostro un messaggio e nessuna card
				if ($ris->num_rows == 0) {
					echo "<p style='text-align:center'>Non hai preso in prestito nessun libro";
				}

                else { // ho trovato dei libri
                    foreach($ris as $riga){ // in python sarebbe "for riga in ris"
                        $cod_libro = $riga['cod_libro']; // codlibro usato per aprire la scheda corrispondente
                        $titolo = $riga['titolo'];
                        $nome = $riga["nome"];
                        $cognome = $riga["cognome"];
                        $copertina = $riga["copertina"]; // nome del file dell'immagine della copertina, che si trova nella cartella ../immagini/


                        // con questo blocco crea la card, <<<EOD è una sintassi che permette di scrivere 
                        // un blocco di codice html su più righe, e $variabile
                        // viene interpretata come il suo valore

                        // nota che il link usa un parametro: cod_libro, che è l'identificativo del libro, 
                        // così quando l'utente clicca sul link, nella pagina scheda-libro.php posso prendere 
                        // questo parametro e usarlo per fare una query al DB e mostrare le informazioni del libro corrispondente
                        echo <<<EOD
                            <div class="card-libro">
                                <div class="card-libro__img">
                                    <img src="../immagini/$copertina" alt="$copertina">
                                </div>
                                <div class="card-libro__testo">
                                    <div class="card-libro__testo__centrato">
                                        <p>Titolo: $titolo</p>
                                        <p>Autore: $nome $cognome</p>
                                        <p class="link-scheda"><a href="scheda-libro.php?cod_libro=$cod_libro">Scheda del libro</a></p>
                                    </div>
                                </div>
                            </div>
                        EOD;
                        // echo "<li>$titolo - $nome $cognome</li>"; // 
                    }
                }
			?>
			
		</div>

	</div>
	<?php 
		require('footer.php');
	?>	
	
</body>
</html>
<?php
	session_start();
    if(!isset($_SESSION['username'])){ 
		header('location: ../index.php');
	}
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
            <?php
				$sql = "SELECT libri.cod_libro, libri.titolo, libri.copertina, autori.nome, autori.cognome 
						FROM libri JOIN autori ON libri.cod_autore = autori.cod_autore  
						WHERE libri.username_utente='$username'";
				$ris = $conn->query($sql) or die("<p>Query fallita!</p>");
				if ($ris->num_rows == 0) {
					echo "<p style='text-align:center'>Nessuno";
				}
                else {
                    foreach($ris as $riga){
                        $cod_libro = $riga['cod_libro'];
                        $titolo = $riga['titolo'];
                        $nome = $riga["nome"];
                        $cognome = $riga["cognome"];
                        $copertina = $riga["copertina"];
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
                        // echo "<li>$titolo - $nome $cognome</li>";
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
<?php
    // come sempre faccio partire il gestore della sessione
	session_start();
	//echo session_id();

    // connessione al db
	require_once('../data/connessione_db.php');
    
    // se l'utente non è loggato, lo reindirizzo alla pagina di login
	if(!isset($_SESSION['username'])){
        header('location: ../index.php');
	}
    // salvo per comodità lo username dell'utente loggato in una variabile
    $username = $_SESSION["username"];
    //echo $username;

    // questo serve quando l'utente mi manda dei libri da riconsegnare,
    // succede solo col post e non alla prima apertura normale della pagina.
    if (isset($_POST['cod_libri'])) {
        $libri = $_POST['cod_libri'];
        foreach($libri as $libro) {
            //echo $libro . '<br/>';
            $sql = "UPDATE libri
                    SET username_utente = NULL
                    WHERE cod_libro = '".$libro."'";
            $conn->query($sql) or die("<p>Query fallita!</p>");
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<title>Biblioteca - Riconsegna</title>
	<link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
	<?php require("nav.php");?>
	<div class="contenuto">
		<h1 style="text-align: center; margin-top: 0px">Pagina personale</h1>
        <?php
            // query per pescare i dati del libro per ogni singola card
            $sql = "SELECT libri.cod_libro, libri.titolo, libri.copertina, autori.nome, autori.cognome 
                    FROM libri JOIN autori ON libri.cod_autore = autori.cod_autore  
                    WHERE username_utente='$username'";
            $ris = $conn->query($sql) or die("<p>Query fallita!</p>");
            if ($ris->num_rows == 0) {
                echo "<p>Non ci sono libri da riconsegnare</p>";
            } else {
                echo "<form action='' method='post'>";
                echo "<div class='elenco_libri'>";
                foreach($ris as $riga){
                    $cod_libro = $riga["cod_libro"];
                    $titolo = $riga["titolo"];
                    $copertina = $riga["copertina"];
                    $nome = $riga["nome"];
                    $cognome = $riga["cognome"];

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
                                    <p><input type='checkbox' name='cod_libri[]' value='$cod_libro'/> Spunta per riconsegnare il libro</p>
                                </div>
                            </div>
                        </div>
                    EOD;
                }
                echo "<p style='text-align: center; padding-top: 10px'><input type='submit' value='Conferma'/></p>";
                echo "</div>"; // chiudo la div elenco libri
                echo "</form>"; // chiudo form
            }
        ?>
	</div>
	<?php 
		include('footer.php')
	?>	
</body>
</html>
<?php
	$conn->close();
?>
<?php
	session_start();
    if(!isset($_SESSION['username'])){ 
		header('location: ../index.php');
	}
    $username = $_SESSION["username"];

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
		

        <h2>Libri presi in prestito</h2>
        <div class="elenco_libri">
			
		</div>

	</div>
	<?php 
		require('footer.php');
	?>	
	
</body>
</html>
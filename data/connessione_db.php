<?php 
    // $db_servername = "localhost";
	// $db_name = "biblioteca";
	// $db_username = "root";
	// $db_password = "";
    // $conn = new mysqli($db_servername,$db_username,$db_password,$db_name);
    $conn = new mysqli("localhost", "root", "","biblioteca");
    if($conn->connect_error){
        die("<p>Connessione al server non riuscita: ".$conn->connect_error."</p>");
    }
?>
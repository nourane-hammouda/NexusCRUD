<?php
$host = '127.0.0.1';
$username = 'root';
$password = 'CHiheb2004';
$database = 'projet';

$conn = new mysqli(hostname: $host , username: $username , password: $password , database: $database );

if($conn->connect_error){
    die ("Erreur de connexion : " . $conn->connect_error);
}
echo "Connexion réussie à la base de données $database";

$conn->close();
?>
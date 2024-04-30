<?php

$server = "localhost";
$user = "root";
$password = "";
$database = "biblioteca";

// Conexão com o banco de dados
$conn = new mysqli($server, $user, $password, $database);

// Verificação da conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

?>

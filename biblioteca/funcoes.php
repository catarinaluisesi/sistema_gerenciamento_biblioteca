<?php
require_once 'config.php';

function getBooks() {
    global $db;
    $sql = "SELECT * FROM livros";
    $result = mysqli_query($db, $sql);
    $livros = [];

    if ($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $livros[] = $row;
        }
    }

    return $livros;
}

function addBook($titulo, $autor, $ISBN, $numeroDeCopiasDisponiveis) {
    global $db;
    $sql = "INSERT INTO livros (titulo, autor, ISBN, numero_de_copias_disponiveis) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $titulo, $autor, $ISBN, $numeroDeCopiasDisponiveis);
    return mysqli_stmt_execute($stmt);
}

function emprestarLivro($ISBN) {
    global $db;
    $sql = "UPDATE livros SET numero_de_copias_disponiveis = numero_de_copias_disponiveis - 1 WHERE ISBN = ? AND numero_de_copias_disponiveis > 0";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "s", $ISBN);
    return mysqli_stmt_execute($stmt);
}

function devolverLivro($ISBN) {
    global $db;
    $sql = "UPDATE livros SET numero_de_copias_disponiveis = numero_de_copias_disponiveis + 1 WHERE ISBN = ?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "s", $ISBN);
    return mysqli_stmt_execute($stmt);
}
?>

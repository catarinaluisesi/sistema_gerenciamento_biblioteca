<?php
// Conexão com o banco de dados (substitua com suas credenciais)
$conn = new mysqli('localhost', 'usuario', 'senha', 'biblioteca');

// Verifica se o formulário foi submetido
if (isset($_POST['submit'])) {
    // Verifica se um arquivo de imagem foi selecionado
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $livro_id = $_POST['livro_id'];
        $imagem_temp = $_FILES['imagem']['tmp_name'];
        $imagem_nome = $_FILES['imagem']['name'];

        // Diretório onde as imagens serão armazenadas
        $diretorio_destino = "./imagens/";

        // Gera um nome único para a imagem
        $imagem_nome_final = uniqid() . "_" . $imagem_nome;

        // Move o arquivo carregado para o diretório de destino
        if (move_uploaded_file($imagem_temp, $diretorio_destino . $imagem_nome_final)) {
            // URL completa da imagem
            $imagem_url = "http://seusite.com/imagens/" . $imagem_nome_final;

            // Atualiza o registro do livro com a URL da imagem no banco de dados
            $sql = "UPDATE livros SET imagem_url = '$imagem_url' WHERE id = $livro_id";
            if ($conn->query($sql) === TRUE) {
                echo "<p class='alert alert-success'>Imagem do livro atualizada com sucesso!</p>";
            } else {
                echo "<p class='alert alert-danger'>Erro ao atualizar a imagem do livro: " . $conn->error . "</p>";
            }
        } else {
            echo "<p class='alert alert-danger'>Erro ao fazer upload da imagem.</p>";
        }
    } else {
        echo "<p class='alert alert-danger'>Selecione uma imagem para enviar.</p>";
    }
}
?>

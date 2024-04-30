<?php
require_once("./config.php");
require_once("./Livro.php");

// Função para obter todos os livros do banco de dados
function getLivrosFromDB() {
    global $conn;
    $livros = [];

    $sql = "SELECT * FROM livros";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $livro = new Livro($row['id'], $row['titulo'], $row['autor'], $row['ISBN'], $row['numero_de_copias_disponiveis'], $row['imagem_url']);
            $livros[] = $livro;
        }
    }

    return $livros;
}

// Função para exibir informações dos livros na página
function displayLivros($livros) {
    if (empty($livros)) {
        echo "<p>Nenhum livro encontrado na biblioteca.</p>";
    } else {
        foreach ($livros as $livro) {
            echo "<div class='card mb-3'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>" . $livro->getTitulo() . "</h5>";
            echo "<p class='card-text'><b>Autor:</b> " . $livro->getAutor() . "</p>";
            echo "<p class='card-text'><b>ISBN:</b> " . $livro->getISBN() . "</p>";
            echo "<p class='card-text'><b>Número de cópias disponíveis:</b> " . $livro->verificarDisponibilidade() . "</p>";
            
            // Adicionando a imagem do livro
            echo "<img src='" . $livro->getImagemUrl() . "' class='card-img-top' alt='Capa do Livro'>";

            echo "<form method='post'>";
            echo "<input type='hidden' name='livro_id' value='" . $livro->getId() . "'>";
            echo "<button type='submit' class='btn btn-primary mr-2' name='emprestar'>Emprestar</button>";
            echo "<button type='submit' class='btn btn-success' name='devolver'>Devolver</button>";
            echo "</form>";
            echo "</div>";
            echo "</div>";
        }
    }
}

// Adicionar novo livro à biblioteca
if (isset($_POST['adicionar'])) {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $ISBN = $_POST['isbn'];
    $numCopias = $_POST['num_copias'];
    $imagemUrl = $_POST['imagem_url']; // Certifique-se de ter um campo 'imagem_url' no seu formulário

    // Verifica se o ISBN já existe no banco de dados
    $sql_check_isbn = "SELECT * FROM livros WHERE ISBN = '$ISBN'";
    $result_check_isbn = $conn->query($sql_check_isbn);

    if ($result_check_isbn->num_rows > 0) {
        echo "<p class='alert alert-danger'>Livro com o ISBN '$ISBN' já existe na biblioteca.</p>";
    } else {
        // ISBN é único, então insere o novo livro
        $sql_insert_livro = "INSERT INTO livros (titulo, autor, ISBN, numero_de_copias_disponiveis, imagem_url) VALUES ('$titulo', '$autor', '$ISBN', $numCopias, '$imagemUrl')";
        if ($conn->query($sql_insert_livro) === TRUE) {
            echo "<p class='alert alert-success'>Livro adicionado com sucesso!</p>";
        } else {
            echo "<p class='alert alert-danger'>Erro ao adicionar livro: " . $conn->error . "</p>";
        }
    }
}

// Verifica se foi clicado o botão de emprestar ou devolver
if (isset($_POST['emprestar']) || isset($_POST['devolver'])) {
    $livroId = $_POST['livro_id'];
    $livro = null;

    // Busca o livro correspondente ao ID
    $livros = getLivrosFromDB();
    foreach ($livros as $livroItem) {
        if ($livroItem->getId() == $livroId) {
            $livro = $livroItem;
            break;
        }
    }

    // Executa ação de emprestar ou devolver
    if ($livro) {
        if (isset($_POST['emprestar'])) {
            if ($livro->emprestar()) {
                $sql = "UPDATE livros SET numero_de_copias_disponiveis = numero_de_copias_disponiveis - 1 WHERE id = $livroId";
                $conn->query($sql);
                echo "<p class='alert alert-success'>Livro emprestado com sucesso!</p>";
            } else {
                echo "<p class='alert alert-danger'>Livro não disponível para empréstimo.</p>";
            }
        } elseif (isset($_POST['devolver'])) {
            $livro->devolver();
            $sql = "UPDATE livros SET numero_de_copias_disponiveis = numero_de_copias_disponiveis + 1 WHERE id = $livroId";
            $conn->query($sql);
            echo "<p class='alert alert-success'>Livro devolvido com sucesso!</p>";
        }
    } else {
        echo "<p class='alert alert-danger'>Livro não encontrado.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Seu estilo CSS aqui -->
    <style>
        /* Estilo para o corpo da página */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        /* Estilo para o container principal */
        .container {
            padding: 20px;
        }

        /* Estilo para os títulos */
        h1, h2 {
            color: #333;
            text-align: center;
        }

        /* Estilo para o formulário de adicionar livro */
        form {
            margin-bottom: 20px;
        }

        /* Estilo para os botões */
        .btn {
            cursor: pointer;
        }

        /* Estilo para a lista de livros */
        #livros {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        /* Estilo para os cards de livro */
        .card {
            background-color: #fff;
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Estilo para o corpo dos cards */
        .card-body {
            padding: 20px;
        }

        /* Estilo para o título do livro */
        .card-title {
            font-size: 1.5rem;
            margin-bottom: 10px;
            text-align: center;
        }

        /* Estilo para as informações do livro */
        .card-text {
            margin-bottom: 10px;
        }

        /* Estilo para a imagem do livro */
        .card-img-top {
            border-radius: 10px;
            width: 100%;
            height: auto;
        }

        /* Estilo para os botões de emprestar e devolver */
        .btn-primary, .btn-success {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5 mb-4">Biblioteca</h1>

        <h2>Adicionar Novo Livro</h2>
        <form method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título:</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="autor" class="form-label">Autor:</label>
                        <input type="text" class="form-control" id="autor" name="autor" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="isbn" class="form-label">ISBN:</label>
                        <input type="text" class="form-control" id="isbn" name="isbn" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="num_copias" class="form-label">Número de cópias disponíveis:</label>
                        <input type="number" class="form-control" id="num_copias" name="num_copias" min="1" required>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="imagem_url" class="form-label">URL da Imagem:</label>
                <input type="text" class="form-control" id="imagem_url" name="imagem_url" required>
            </div>
            <button type="submit" class="btn btn-primary" name="adicionar">Adicionar Livro</button>
        </form>

        <h2 class="mt-5">Livros</h2>
        <div id="livros">
            <?php
            $livros = getLivrosFromDB();
            displayLivros($livros);
            ?>
        </div>
    </div>

    <!-- Bootstrap JavaScript Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

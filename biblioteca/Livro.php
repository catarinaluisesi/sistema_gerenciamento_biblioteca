<?php

class Livro {
    private $id;
    private $titulo;
    private $autor;
    private $ISBN;
    private $numeroDeCopiasDisponiveis;
    private $imagemUrl; // Novo atributo para armazenar a URL da imagem do livro

    public function __construct($id, $titulo, $autor, $ISBN, $numeroDeCopiasDisponiveis, $imagemUrl) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->ISBN = $ISBN;
        $this->numeroDeCopiasDisponiveis = $numeroDeCopiasDisponiveis;
        $this->imagemUrl = $imagemUrl; // Atribui a URL da imagem ao novo atributo
    }

    public function getId() {
        return $this->id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getAutor() {
        return $this->autor;
    }

    public function getISBN() {
        return $this->ISBN;
    }

    public function getImagemUrl() {
        return $this->imagemUrl; // Getter para acessar a URL da imagem do livro
    }

    public function verificarDisponibilidade() {
        return $this->numeroDeCopiasDisponiveis;
    }

    public function emprestar() {
        if ($this->numeroDeCopiasDisponiveis > 0) {
            $this->numeroDeCopiasDisponiveis--;
            // Aqui você pode adicionar código para atualizar o banco de dados com a nova quantidade de cópias disponíveis
            return true;
        } else {
            return false;
        }
    }

    public function devolver() {
        $this->numeroDeCopiasDisponiveis++;
        // Aqui você pode adicionar código para atualizar o banco de dados com a nova quantidade de cópias disponíveis
    }
}

?>

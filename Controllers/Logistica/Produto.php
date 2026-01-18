<?php

 require 'Conexao.php';
 require '../Models/db.php';

 $connect = new Conexao($conexao);

class Produto {

    private $id;
    private $nome;
    private $preco;


    public function __construct($id, $nome, $preco){
        $this->id = $id;
        $this->nome = $nome;
        $this->preco= $preco;

    }

    public function getId(){
        return $this->id; 
    }

    public function setId($id){
        $this->id = $id;
    }
    public function getNome(){
        return $this->nome; 
    }

    public function setNome($nome){
        $this->nome = $nome;
    }
    public function getPreco(){
        return $this->preco; 
    }

    public function setPreco($preco){
        $this->preco = $preco;
    }

    public function criarProduto($dados){
        $stmt = $connect->prepare("INSERT INTO produtos (nome, estoque, preco) VALUES (?,0,?)");
            $stmt->execute([$dados['nome'], $dados['preco']]) ;
    }
}

?>

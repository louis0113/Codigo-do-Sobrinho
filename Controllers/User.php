<?php

class User {
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function findByEmail($email) {
        $stmt = $this->conexao->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
}

?>

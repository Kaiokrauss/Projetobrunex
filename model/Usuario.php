<?php
require_once __DIR__ . '/../config/Conexao.php';

class Usuario {
    public static function listarTodos() {
        $conn = Conexao::getConexao();
        $sql = "SELECT id, nome, email FROM usuarios";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function cadastrar($nome, $email, $senha) {
        $conn = Conexao::getConexao();
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);
        return $stmt->execute([$nome, $email, $senhaCriptografada]);
    }

    public static function autenticar($email, $senha) {
        $conn = Conexao::getConexao();
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;
        }
        return false;
    }
}
?>

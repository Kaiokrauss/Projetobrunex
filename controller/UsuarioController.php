<?php
require_once __DIR__ . '/../model/Usuario.php';

class UsuarioController {
    public function listar() {
        $usuarios = Usuario::listarTodos();
        include __DIR__ . '/../view/lista_usuarios.php';
    }

    public function cadastrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            Usuario::cadastrar($nome, $email, $senha);
            header('Location: index.php?rota=usuarios');
        } else {
            include __DIR__ . '/../view/cadastrar_usuario.php';
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            $usuario = Usuario::autenticar($email, $senha);
            if ($usuario) {
                session_start();
                $_SESSION['usuario'] = $usuario;
                header('Location: index.php');
            } else {
                echo "<p style='color:red'>Login inválido</p>";
            }
        }
        include __DIR__ . '/../view/login.php';
    }
}
?>

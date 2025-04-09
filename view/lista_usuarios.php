<h2>Lista de Usuários</h2>
<a href="index.php?rota=cadastrar-usuario">Cadastrar novo</a>
<ul>
<?php foreach ($usuarios as $usuario): ?>
    <li><?= htmlspecialchars($usuario['nome']) ?> - <?= htmlspecialchars($usuario['email']) ?></li>
<?php endforeach; ?>
</ul>

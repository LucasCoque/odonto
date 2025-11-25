<?php
/**
 * View: admin_login.php
 * @param string $error Mensagem de erro de login.
 */
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login do Estagiário</title>
    <!-- CSS referenciado no novo arquivo de estilo -->
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body>
<div class="card">
    <h1>Login</h1>
    <!-- A action agora aponta para a rota base /admin/login -->
    <form class="form" method="post" action="/admin/login">
        <?php if (!empty($error)): ?><div class="error"><?= htmlspecialchars($error, ENT_QUOTES) ?></div><?php endif; ?>
        <div><input name="username" placeholder="Usuário" required></div>
        <div><input type="password" name="password" placeholder="Senha" required></div>
        <button class="primary">Entrar</button>
        <div class="muted">usuário: <code>estagiario</code> • senha: <code>123456</code></div>
    </form>
</div>
</body>
</html>
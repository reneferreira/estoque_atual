<?php
require_once __DIR__ . '/autenticacao.php';
if (usuarioLogado()) {
    header('Location: index.php', true, 303);
    exit;
}
$erro = $_SESSION['erro_login'] ?? '';
unset($_SESSION['erro_login']);
$token = tokenCsrfLogin();
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Entrar | Estoque Fácil</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body class="pagina-login">
    <main class="cartao-login">
        <div class="login-marca">EF</div>
        <h1>Estoque Fácil</h1>
        <p>Acesse o sistema com seu e-mail e sua senha.</p>
        <?php if ($erro): ?>
            <p class="login-erro" role="alert"><?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        <form method="post" action="autenticar.php">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars($token, ENT_QUOTES, 'UTF-8') ?>">
            <label for="email">E-mail</label>
            <input id="email" name="email" type="email" maxlength="190" autocomplete="username" required>
            <label for="senha">Senha</label>
            <input id="senha" name="senha" type="password" autocomplete="current-password" required>
            <button type="submit" class="botao-primario">Entrar</button>
        </form>
        <small>Primeiro acesso: crie o administrador pelo terminal (consulte INSTRUCOES_LOGIN.md).</small>
    </main>
</body>
</html>

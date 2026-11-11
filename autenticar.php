<?php
require_once __DIR__ . '/autenticacao.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método não permitido.');
}
if (!verificarCsrfLogin($_POST['csrf'] ?? null)) {
    http_response_code(403);
    exit('Formulário inválido. Atualize a página de login.');
}
$email = trim((string) ($_POST['email'] ?? ''));
$senhaInformada = $_POST['senha'] ?? '';
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !is_string($senhaInformada) || $senhaInformada === '') {
    $_SESSION['erro_login'] = 'E-mail ou senha inválidos.';
    header('Location: login.php', true, 303);
    exit;
}
try {
    require __DIR__ . '/conexao.php';
    $consulta = $pdo->prepare('SELECT id, nome, email, senha_hash, perfil, ativo FROM usuarios WHERE email = :email LIMIT 1');
    $consulta->execute(['email' => $email]);
    $usuario = $consulta->fetch(PDO::FETCH_ASSOC);
    if (!$usuario || (int) $usuario['ativo'] !== 1 || !password_verify($senhaInformada, $usuario['senha_hash'])) {
        $_SESSION['erro_login'] = 'E-mail ou senha inválidos.';
        header('Location: login.php', true, 303);
        exit;
    }
    session_regenerate_id(true);
    $_SESSION['usuario_id'] = (int) $usuario['id'];
    $_SESSION['usuario_nome'] = $usuario['nome'];
    $_SESSION['usuario_perfil'] = $usuario['perfil'];
    unset($_SESSION['erro_login']);
    $pdo->prepare('UPDATE usuarios SET ultimo_login_em = NOW() WHERE id = :id')->execute(['id' => $usuario['id']]);
    header('Location: index.php', true, 303);
    exit;
} catch (PDOException $erro) {
    error_log('Falha de autenticação: ' . $erro->getMessage());
    http_response_code(503);
    exit('Não foi possível autenticar agora. Confira a conexão e a tabela usuarios.');
}

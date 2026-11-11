<?php
// Funções comuns: este arquivo NÃO bloqueia o login.php.
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
function usuarioLogado(): bool {
    return isset($_SESSION['usuario_id']) && is_int($_SESSION['usuario_id']);
}
function exigirLogin(): void {
    if (!usuarioLogado()) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            http_response_code(401);
            exit('Sessão expirada. Entre novamente e refaça a operação.');
        }
        header('Location: login.php', true, 303);
        exit;
    }
}
function usuarioAdministrador(): bool {
    return usuarioLogado() && ($_SESSION['usuario_perfil'] ?? '') === 'administrador';
}
function exigirAdministrador(): void {
    exigirLogin();
    if (!usuarioAdministrador()) {
        http_response_code(403);
        exit('Acesso negado. Apenas administradores podem executar esta operação.');
    }
}
function tokenCsrfLogin(): string {
    $_SESSION['csrf_login'] ??= bin2hex(random_bytes(32));
    return $_SESSION['csrf_login'];
}
function verificarCsrfLogin($token): bool {
    return is_string($token) && hash_equals(tokenCsrfLogin(), $token);
}

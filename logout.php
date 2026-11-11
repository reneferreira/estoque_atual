<?php
require_once __DIR__ . '/autenticacao.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verificarCsrfLogin($_POST['csrf'] ?? null)) {
    http_response_code(405);
    exit('Utilize o botão Encerrar sessão.');
}
$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
}
session_destroy();
header('Location: login.php', true, 303);
exit;

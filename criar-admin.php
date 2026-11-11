<?php
// Execute SOMENTE no terminal. Não há criação de administradores pelo navegador.
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
require __DIR__ . '/conexao.php';
function perguntar(string $texto): string {
    echo $texto;
    return trim((string) fgets(STDIN));
}
echo "=== CRIAR USUÁRIO (ambiente didático) ===\n";
$nome = perguntar('Nome: ');
$email = perguntar('E-mail: ');
$perfil = perguntar('Perfil [administrador/almoxarife]: ');
$senha = perguntar('Senha (min. 12 caracteres; será exibida enquanto digita): ');
if ($nome === '' || strlen($nome) > 120 || !filter_var($email, FILTER_VALIDATE_EMAIL)
    || !in_array($perfil, ['administrador', 'almoxarife'], true)
    || strlen($senha) < 12) {
    exit("Dados inválidos. Verifique os campos e tente novamente.\n");
}
$sql = 'INSERT INTO usuarios (nome, email, senha_hash, perfil, ativo)
        VALUES (:nome, :email, :senha_hash, :perfil, 1)';
try {
    $pdo->prepare($sql)->execute([
        'nome' => $nome,
        'email' => $email,
        'senha_hash' => password_hash($senha, PASSWORD_DEFAULT),
        'perfil' => $perfil
    ]);
    echo "Usuário criado com sucesso.\n";
} catch (PDOException $e) {
    echo "Não foi possível criar o usuário. Confira se a tabela existe e se o e-mail já está cadastrado.\n";
    exit(1);
}

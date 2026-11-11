# Aula 03/11/2026 — Autenticação do Estoque Fácil

## O que foi incluído
- `login.php`: formulário para informar e-mail e senha.
- `autenticar.php`: consulta o usuário com PDO, confere `password_verify()` e grava a sessão.
- `autenticacao.php`: funções `exigirLogin()`, `exigirAdministrador()`, `usuarioLogado()` e CSRF do login.
- `verificar-login.php`: arquivo incluído nas páginas protegidas.
- `logout.php`: encerra a sessão via formulário POST.
- `usuarios.sql`: cria a tabela `usuarios` com perfis `administrador` e `almoxarife`.
- `criar-admin.php`: cria usuários pelo terminal sem expor uma senha padrão no código ou no SQL.

## Primeira instalação
1. **Backup**: exporte o banco `estoque_ads` no phpMyAdmin antes de qualquer alteração.
2. Extraia o ZIP em `C:\xampp\htdocs\estoque` (ou em uma pasta de teste). Não sobrescreva o banco existente.
3. Inicie **Apache** e **MySQL** no XAMPP.
4. Abra o phpMyAdmin, selecione o banco `estoque_ads` e **importe somente `usuarios.sql`**. Não reimporte `estoque_ads.sql`: ele contém `DROP TABLE produtos`.
   
-----5. Abra o CMD e execute:------------------------

```cmd
cd C:\xampp\htdocs\estoque_atual
C:\xampp\php\php.exe criar-admin.php

se for wampp
cd /d C:\wamp64\www\estoque_atual
C:\wamp64\bin\php\php8.2.30\php.exe criar-admin.php
```

Se a pasta for diferente, ajuste o caminho. O terminal pedirá nome, e-mail, perfil e senha (mínimo de 12 caracteres). A senha aparece enquanto é digitada: faça o cadastro sem outras pessoas olhando a tela.
6. Acesse `http://localhost/estoque/login.php`, informe o e-mail e a senha cadastrados.
7. Teste abrir `http://localhost/estoque/produtos.php` sem login (deverá redirecionar).
8. Após login, teste cadastrar e editar. Excluir exige perfil `administrador` (inclusive em requisições diretas).
9. Clique em **Encerrar sessão**, e tente abrir novamente a página de produtos.

## Exercício para os alunos
Crie um segundo usuário com perfil `almoxarife` executando o comando novamente. Entre com ele e observe que pode cadastrar/editar, mas não excluir. Depois entre com o administrador e compare.

## Observações técnicas e limites
- O CRUD permanece no banco existente; o projeto protege `index.php`, `categorias.php`, `produto.php`, `produtos.php` e as operações `inserir.php`, `editar.php`, `deletar.php` pelo contexto comum.
- **Não existe conta padrão nem senha fixa.** É preciso criar o primeiro usuário pelo terminal.
- A autenticação utiliza `password_hash()`, `password_verify()`, `session_regenerate_id()`, consultas preparadas e um token CSRF específico para login/logout.
- Este é um **ambiente didático local**. Para produção: HTTPS, limitação de tentativas de login, gestão segura de credenciais, permissões de banco restritas, política de redefinição de senha, auditoria e validação periódica do estado da conta no banco.
- Os indicadores em `index.php` e as categorias seguem demonstrativos, como no projeto original.

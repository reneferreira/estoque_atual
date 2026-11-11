<?php $paginaAtual = basename($_SERVER["PHP_SELF"]); ?>

<aside class="menu-lateral">
    <a class="marca" href="index.php">
        <span class="marca-icone">EF</span>
        <span>Estoque Facil<small>Gestao integrada</small></span>
    </a>

    <nav>
        <a class="<?= $paginaAtual === "index.php" ? "ativo" : "" ?>" href="index.php">Visão geral</a>

        <span class="titulo-menu">Catálogo</span>
        <a class="<?= $paginaAtual === "produtos.php" ? "ativo" : "" ?>" href="produtos.php">Produtos</a>
        <a class="<?= $paginaAtual === "categorias.php" ? "ativo" : "" ?>" href="categorias.php">Categorias</a>

        <span class="titulo-menu">Operacoes</span>
        <a href="#">Nova entrada</a>
        <a href="#">Nova saida</a>
        <a href="#">Historico</a>
    </nav>

    <div class="area-sessao">
        <small>Olá, <?= htmlspecialchars($_SESSION['usuario_nome'] ?? 'Usuário', ENT_QUOTES, 'UTF-8') ?></small>
        <small>Perfil: <?= htmlspecialchars($_SESSION['usuario_perfil'] ?? '', ENT_QUOTES, 'UTF-8') ?></small>
        <form method="POST" action="logout.php">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(tokenCsrfLogin(), ENT_QUOTES, 'UTF-8') ?>">
            <button class="sair" type="submit">Encerrar sessão</button>
        </form>
    </div>
</aside>
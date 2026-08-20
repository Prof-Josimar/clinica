<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema Clinica Médica</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(to bottom, #add8e6, #000080);
            display: flex;
            flex-direction: column;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.15);
            /* leve transparência */
            border-radius: 15px;
            backdrop-filter: blur(10px);
            /* efeito vidro fosco */
            -webkit-backdrop-filter: blur(10px);
            /* compatibilidade Safari */
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
        }
    </style>


</head>




<body class="d-flex flex-column min-vh-100">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
        <div class="container-fluid">

            <!-- Marca -->
            <a class="navbar-brand" href="/index.php">Clinica Médica</a>

            <!-- Botão responsivo -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSistema">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Links -->
            <div class="collapse navbar-collapse" id="navbarSistema">
                <ul class="navbar-nav me-auto">

                    <!-- PESSOAS -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Medicos
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="/medico-create.php">Cadastrar</a>
                                <a class="dropdown-item" href="/medico-listar.php">Listar</a>
                                <a class="dropdown-item" href="/medico-pesquisar.php">Pesquisar</a>
                            </li>
                        </ul>
                    </li>

                    <!-- Especialidades -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Especialidades
                        </a>


                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/especialidade-create.php">Cadastrar</a></li>
                            <li><a class="dropdown-item" href="/especialidade-list.php">Listar</a></li>
                        </ul>

                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- Container principal -->
    <main class="flex-grow-1 container mt-4">
        <?php
        if (isset($content)) {
            echo $content;
        } else {
            echo "<h1>Sistema Clinica Médica!</h1>";
        }
        ?>
    </main>

    <!-- Rodapé -->
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <p>&copy; <?php echo date("Y"); ?> - Sistema Clinica Médica</p>
        <p id="relogio"></p>
    </footer>

    <script>
        function atualizarRelogio() {
            const agora = new Date();
            const opcoesData = { day: '2-digit', month: '2-digit', year: 'numeric' };
            const data = agora.toLocaleDateString('pt-BR', opcoesData);
            const hora = agora.toLocaleTimeString('pt-BR');
            document.getElementById('relogio').textContent = `${data} - ${hora}`;
        }

        // Atualiza a cada segundo
        setInterval(atualizarRelogio, 1000);
        atualizarRelogio();
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz de PHP</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <header>
            <h1>Quiz de PHP</h1>
            <p>Teste seus conhecimentos sobre PHP!</p>
        </header>

        <div id="quiz-container">
            <!-- O quiz será carregado aqui via JavaScript -->
            <div id="loading">Carregando quiz...</div>
            <div id="quiz-content" style="display: none;"></div>
        </div>

        <div id="results" style="display: none;">
            <h2>Resultado</h2>
            <div id="score"></div>
            <button onclick="reiniciarQuiz()">Fazer Quiz Novamente</button>
        </div>

        <footer>
            <p>Desenvolvido para testar conhecimentos em PHP</p>
        </footer>
    </div>

    <script src="script.js"></script>
</body>

</html>
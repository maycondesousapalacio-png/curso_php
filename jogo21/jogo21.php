<?php
session_start();

// Função para criar o baralho
function criarBaralho()
{
    $naipes = ['♠', '♥', '♦', '♣'];
    $valores = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];
    $baralho = [];
    foreach ($naipes as $naipe) {
        foreach ($valores as $valor) {
            $baralho[] = ['valor' => $valor, 'naipe' => $naipe];
        }
    }
    shuffle($baralho);
    return $baralho;
}

// Função para calcular o valor total das cartas
function calcularValor($cartas)
{
    $total = 0;
    $ases = 0;
    foreach ($cartas as $carta) {
        if ($carta['valor'] == 'A') {
            $total += 11;
            $ases++;
        } elseif (in_array($carta['valor'], ['J', 'Q', 'K'])) {
            $total += 10;
        } else {
            $total += intval($carta['valor']);
        }
    }

    // Ajusta Áses se passar de 21
    while ($total > 21 && $ases > 0) {
        $total -= 10;
        $ases--;
    }

    return $total;
}

// Inicializa o jogo
if (!isset($_SESSION['baralho'])) {
    $_SESSION['baralho'] = criarBaralho();
    $_SESSION['jogador'] = [array_pop($_SESSION['baralho']), array_pop($_SESSION['baralho'])];
    $_SESSION['dealer'] = [array_pop($_SESSION['baralho']), array_pop($_SESSION['baralho'])];
}

// Ações
if (isset($_GET['acao'])) {
    if ($_GET['acao'] == 'hit') {
        $_SESSION['jogador'][] = array_pop($_SESSION['baralho']);
    } elseif ($_GET['acao'] == 'stand') {
        // Dealer joga até 17 ou mais
        while (calcularValor($_SESSION['dealer']) < 17) {
            $_SESSION['dealer'][] = array_pop($_SESSION['baralho']);
        }
        $_SESSION['fim'] = true;
    } elseif ($_GET['acao'] == 'novo') {
        session_destroy();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Calcula valores
$jogadorValor = calcularValor($_SESSION['jogador']);
$dealerValor = calcularValor($_SESSION['dealer']);

// Checa fim de jogo automático
if ($jogadorValor > 21) {
    $_SESSION['fim'] = true;
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Jogo de 21 (Blackjack)</title>
    <style>
        body {
            font-family: Arial;
            text-align: center;
            background: #024;
            color: #fff;
        }

        button {
            margin: 10px;
            padding: 10px 20px;
            font-size: 16px;
        }

        .cartas {
            margin: 20px;
            font-size: 24px;
        }
    </style>
</head>

<body>
    <h1>🃏 Jogo de 21</h1>

    <div class="cartas">
        <h2>Suas Cartas (<?= $jogadorValor ?>)</h2>
        <?php foreach ($_SESSION['jogador'] as $c): ?>
            <?= "{$c['valor']}{$c['naipe']} " ?>
        <?php endforeach; ?>
    </div>

    <div class="cartas">
        <h2>Cartas do Dealer (<?= isset($_SESSION['fim']) ? $dealerValor : '?' ?>)</h2>
        <?php
        if (isset($_SESSION['fim'])) {
            foreach ($_SESSION['dealer'] as $c) echo "{$c['valor']}{$c['naipe']} ";
        } else {
            echo $_SESSION['dealer'][0]['valor'] . $_SESSION['dealer'][0]['naipe'] . " ?";
        }
        ?>
    </div>

    <?php if (isset($_SESSION['fim'])): ?>
        <h2>
            <?php
            if ($jogadorValor > 21) echo "💥 Você estourou! Dealer vence.";
            elseif ($dealerValor > 21) echo "🎉 Dealer estourou! Você vence!";
            elseif ($jogadorValor > $dealerValor) echo "🎉 Você venceu!";
            elseif ($jogadorValor < $dealerValor) echo "😢 Dealer venceu!";
            else echo "🤝 Empate!";
            ?>
        </h2>
        <a href="?acao=novo"><button>Novo Jogo</button></a>
    <?php else: ?>
        <a href="?acao=hit"><button>Pedir carta</button></a>
        <a href="?acao=stand"><button>Parar</button></a>
    <?php endif; ?>

</body>

</html>
<?php
session_start();

// ====== INICIALIZAÇÃO ======
if (!isset($_SESSION['jogo_ativo'])) {
    $_SESSION['jogo_ativo'] = false;
    $_SESSION['historico'] = [];
}

// ====== INÍCIO DO JOGO ======
if (isset($_POST['iniciar']) && !empty(trim($_POST['nickname'] ?? ''))) {
    $_SESSION['jogo_ativo'] = true;
    $_SESSION['nickname'] = trim($_POST['nickname']);
    $_SESSION['tempo_restante'] = 60;
    $_SESSION['score'] = 0;
    $_SESSION['nivel_dificuldade'] = 1;
    $_SESSION['respostas_corretas_seguidas'] = 0;
    $_SESSION['maior_sequencia'] = 0;
    gerarPergunta();
}

// ====== ZERAR HISTÓRICO ======
if (isset($_POST['zerar_historico'])) $_SESSION['historico'] = [];

// ====== RESPOSTA ======
if (isset($_POST['resposta']) && $_SESSION['jogo_ativo']) {
    $r = intval($_POST['resposta']);
    if ($r === $_SESSION['resposta_correta']) {
        $_SESSION['score']++;
        $_SESSION['respostas_corretas_seguidas']++;
        $_SESSION['tempo_restante'] += 4;
        if ($_SESSION['respostas_corretas_seguidas'] > $_SESSION['maior_sequencia'])
            $_SESSION['maior_sequencia'] = $_SESSION['respostas_corretas_seguidas'];
        if ($_SESSION['score'] % 3 === 0) $_SESSION['nivel_dificuldade']++;
        gerarPergunta();
    } else finalizar();
}

// ====== SAIR / REINICIAR ======
if (isset($_POST['reiniciar']) || isset($_POST['sair'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// ====== FUNÇÕES ======
function gerarPergunta()
{
    $n = $_SESSION['nivel_dificuldade'];
    $max = min(10 + ($n * 5), 100);
    $ops = ['+', '-', '×'];

    if ($n <= 2) {
        $a = rand(1, $max);
        $b = rand(1, $max);
        $op = $ops[array_rand($ops)];
        $_SESSION['pergunta'] = "$a $op $b";
        $_SESSION['resposta_correta'] = match ($op) {
            '+' => $a + $b,
            '-' => abs($a - $b),
            '×' => $a * $b
        };
    } elseif ($n <= 4) {
        $a = rand(1, $max);
        $b = rand(1, $max);
        $c = rand(1, $max);
        $op1 = $ops[array_rand($ops)];
        $op2 = $ops[array_rand($ops)];
        $_SESSION['pergunta'] = "$a $op1 $b $op2 $c";
        $expr = str_replace('×', '*', $_SESSION['pergunta']);
        $_SESSION['resposta_correta'] = eval("return $expr;");
    } else {
        $nums = [rand(1, $max), rand(1, $max), rand(1, $max), rand(1, $max)];
        $o1 = $ops[array_rand($ops)];
        $o2 = $ops[array_rand($ops)];
        $o3 = $ops[array_rand($ops)];
        $_SESSION['pergunta'] = "$nums[0] $o1 $nums[1] $o2 $nums[2] $o3 $nums[3]";
        $expr = str_replace('×', '*', $_SESSION['pergunta']);
        $_SESSION['resposta_correta'] = eval("return $expr;");
    }
}

function finalizar()
{
    $precisao = ($_SESSION['score'] > 0) ? round(($_SESSION['score'] / ($_SESSION['score'] + 1)) * 100, 1) : 0;
    $_SESSION['historico'][] = [
        'nickname' => $_SESSION['nickname'],
        'score' => $_SESSION['score'],
        'nivel' => $_SESSION['nivel_dificuldade'],
        'sequencia' => $_SESSION['maior_sequencia'],
        'precisao' => $precisao,
        'data' => date('d/m/Y H:i:s')
    ];
    if (count($_SESSION['historico']) > 10)
        $_SESSION['historico'] = array_slice($_SESSION['historico'], -10);
    $_SESSION['resultado'] = $_SESSION;
    $_SESSION['jogo_ativo'] = false;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>🧮 Desafio Matemático</title>
    <style>
        body {
            font-family: Arial;
            background: #f3f6fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            width: 420px;
            text-align: center
        }

        h1 {
            color: #2c3e50
        }

        input,
        button {
            padding: 10px;
            font-size: 1.1em;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin: 5px
        }

        button {
            background: #3498db;
            color: white;
            cursor: pointer
        }

        button:hover {
            background: #2980b9
        }

        .pergunta {
            font-size: 2em;
            margin: 20px 0;
            color: #2c3e50
        }

        .cronometro {
            font-size: 2em;
            font-weight: bold;
            margin: 15px 0
        }

        .tempo-normal {
            color: #27ae60
        }

        .tempo-alerta {
            color: #f39c12
        }

        .tempo-urgente {
            color: #e74c3c
        }

        .historico {
            margin-top: 25px;
            text-align: left
        }

        .historico-item {
            background: #ecf0f1;
            padding: 8px;
            border-left: 4px solid #3498db;
            margin-bottom: 6px;
            border-radius: 4px;
            font-size: 0.95em
        }

        .nickname-box {
            background: #eaf4ff;
            padding: 20px;
            border-radius: 10px
        }

        .nickname-box input {
            width: 80%;
            text-align: center
        }
    </style>
</head>

<body>
    <div class="container">
        <?php if (!$_SESSION['jogo_ativo'] && !isset($_SESSION['resultado'])): ?>
            <h1>🎯 Desafio Matemático</h1>
            <div class="nickname-box">
                <p>Digite seu nickname para começar:</p>
                <form method="POST">
                    <input type="text" name="nickname" placeholder="Seu nickname" maxlength="20" required>
                    <br><button name="iniciar">Começar 🚀</button>
                </form>
                <small>Você ganha <b>4 segundos</b> por acerto. A dificuldade aumenta a cada 3 acertos!</small>
            </div>
        <?php elseif ($_SESSION['jogo_ativo']): ?>
            <?php
            $t = $_SESSION['tempo_restante'];
            $classe = $t > 30 ? 'tempo-normal' : ($t > 10 ? 'tempo-alerta' : 'tempo-urgente');
            ?>
            <div class="cronometro <?php echo $classe; ?>" id="timer"><?php echo $t; ?></div>
            <div class="pergunta"><?php echo $_SESSION['pergunta']; ?> = ?</div>
            <form method="POST">
                <input type="number" name="resposta" required autofocus>
                <br><button>Enviar ✅</button>
                <button name="sair" style="background:#e74c3c;">Sair 🚪</button>
            </form>
            <script>
                let tempo = <?php echo $t; ?>;
                const timer = document.getElementById('timer');
                setInterval(() => {
                    if (tempo > 0) {
                        tempo--;
                        timer.textContent = tempo;
                    } else {
                        document.forms[0].submit();
                    }
                }, 1000);
            </script>
        <?php else: ?>
            <h1>🏁 Fim de Jogo!</h1>
            <?php $r = $_SESSION['resultado']; ?>
            <p><b>Jogador:</b> <?php echo htmlspecialchars($r['nickname']); ?></p>
            <p>🎯 Pontos: <?php echo $r['score']; ?></p>
            <p>🔥 Sequência Máxima: <?php echo $r['maior_sequencia']; ?></p>
            <p>🏆 Nível: <?php echo $r['nivel_dificuldade']; ?></p>
            <form method="POST">
                <button name="reiniciar">Jogar Novamente 🔄</button>
            </form>
        <?php endif; ?>

        <?php if (!empty($_SESSION['historico'])): ?>
            <div class="historico">
                <h3>📜 Histórico de Partidas</h3>
                <?php foreach (array_reverse($_SESSION['historico']) as $p): ?>
                    <div class="historico-item">
                        <?php echo $p['nickname']; ?> —
                        <?php echo $p['score']; ?> pts |
                        Nível <?php echo $p['nivel']; ?> |
                        Seq. <?php echo $p['sequencia']; ?> |
                        <?php echo $p['data']; ?>
                    </div>
                <?php endforeach; ?>
                <form method="POST"><button name="zerar_historico" style="background:#e67e22;">🗑️ Limpar Histórico</button></form>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>
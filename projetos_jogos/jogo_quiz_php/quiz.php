<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

// Configurações para debug (remover em produção)
error_reporting(E_ALL);
ini_set('display_errors', 1);

$perguntas = [
    [
        'Pergunta' => 'O que significa PHP?',
        'Opções' => ['Personal Home Page', 'Private Hosting Program', 'Public Hypertext Processor', 'Program Hypertext Page'],
        'Resposta' => 'Personal Home Page'
    ],
    [
        'Pergunta' => 'Qual é a extensão padrão dos arquivos PHP?',
        'Opções' => ['.html', '.ph', '.php', '.js'],
        'Resposta' => '.php'
    ],
    [
        'Pergunta' => 'Como se inicia um bloco de código PHP dentro de um arquivo HTML?',
        'Opções' => ['<php>', '<?php...?>', '<script>', '<php code>'],
        'Resposta' => '<?php...?>'
    ],
    [
        'Pergunta' => 'Qual é a função usada para exibir algo na tela?',
        'Opções' => ['print()', 'echo', 'write()', 'show()'],
        'Resposta' => 'echo'
    ],
    [
        'Pergunta' => 'Em PHP, como se declara uma variável?',
        'Opções' => ['var nome = "Filipe"', '$nome = "Filipe"', 'nome = "Filipe"', 'let nome = "Filipe"'],
        'Resposta' => '$nome = "Filipe"'
    ],
    [
        'Pergunta' => 'Qual destes é um comentário de uma linha em PHP?',
        'Opções' => ['<!-- comentário -->', '// comentário', '# comentário', 'Ambos b e c'],
        'Resposta' => 'Ambos b e c'
    ]
];

// Log para debug
file_put_contents('debug.log', date('Y-m-d H:i:s') . " - Action: " . ($_GET['action'] ?? 'none') . "\n", FILE_APPEND);

try {
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'carregar':
                carregarPerguntas();
                break;

            case 'corrigir':
                corrigirRespostas();
                break;

            default:
                throw new Exception('Ação inválida');
        }
    } else {
        throw new Exception('Nenhuma ação especificada');
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

function carregarPerguntas()
{
    global $perguntas;

    // Validar estrutura das perguntas
    foreach ($perguntas as &$pergunta) {
        if (!isset($pergunta['Opções']) || !is_array($pergunta['Opções'])) {
            $pergunta['Opções'] = [];
        }
    }

    echo json_encode([
        'success' => true,
        'perguntas' => $perguntas,
        'total' => count($perguntas)
    ]);
}

function corrigirRespostas()
{
    global $perguntas;

    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input || !isset($input['respostas'])) {
        throw new Exception('Dados de resposta inválidos');
    }

    $respostasUsuario = $input['respostas'];
    $acertos = 0;
    $resultados = [];

    foreach ($perguntas as $index => $pergunta) {
        $respostaUsuario = $respostasUsuario[$index] ?? '';
        $correta = ($respostaUsuario === $pergunta['Resposta']);

        if ($correta) {
            $acertos++;
        }

        $resultados[] = [
            'pergunta' => $pergunta['Pergunta'],
            'sua_resposta' => $respostaUsuario,
            'resposta_correta' => $pergunta['Resposta'],
            'correta' => $correta
        ];
    }

    $total = count($perguntas);
    $porcentagem = $total > 0 ? round(($acertos / $total) * 100) : 0;

    echo json_encode([
        'success' => true,
        'acertos' => $acertos,
        'total' => $total,
        'porcentagem' => $porcentagem,
        'resultados' => $resultados
    ]);
}

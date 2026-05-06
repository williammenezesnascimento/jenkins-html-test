<?php
// Configurações iniciais da página (Boas práticas: definir fuso horário)
date_default_timezone_set('America/Sao_Paulo');

// Exemplo de manipulação segura de dados dinâmicos
// Se o usuário passar um nome na URL (ex: ?nome=Will), ele usa, senão usa "Estudante"
$nomeUsuario = isset($_GET['nome']) ? htmlspecialchars($_GET['nome'], ENT_QUOTES, 'UTF-8') : 'Estudante da Alura';

// Uma função simples para demonstrar código limpo e reutilizável
function saudarUsuario($nome) {
    return "Olá, " . $nome . "! Seja bem-vindo ao seu projeto integrado.";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pipeline CI/CD com Sucesso</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            color: #333;
            margin: 0;
            padding: 40px;
            display: flex;
            justify-content: center;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            max-width: 600px;
            width: 100%;
        }
        h1 {
            color: #0056b3;
            margin-top: 0;
        }
        .status-badge {
            background-color: #28a745;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.9em;
            display: inline-block;
            margin-bottom: 20px;
        }
        .info-box {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 4px;
            margin-top: 20px;
            font-family: monospace;
        }
    </style>
</head>
<body>

    <div class="container">
        <span class="status-badge">Pipeline Integrado com Sucesso!</span>
        
        <h1><?php echo saudarUsuario($nomeUsuario); ?></h1>
        
        <p>Este arquivo PHP foi corrigido e estruturado seguindo os padrões de análise estática do SonarQube.</p>
        
        <p>Agora o pipeline executa o <strong>Checkout</strong>, valida a qualidade do código na etapa de <strong>Análise</strong>, gera a imagem Docker no <strong>Build</strong> e realiza o <strong>Deploy</strong> automatizado.</p>

        <div class="info-box">
            Mapeamento do Servidor:<br>
            Horário da análise: <?php echo date('d/m/Y H:i:s'); ?><br>
            Status do Quality Gate: PASSED 🟢
        </div>
    </div>

</body>
</html>
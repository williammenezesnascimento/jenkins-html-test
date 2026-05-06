<?php
// 1. VULNERABILIDADE DE SEGURANÇA (SQL Injection)
// Receber dados direto na query sem tratamento
$id_usuario = $_GET['id'];
$query = "SELECT * FROM usuarios WHERE id = " . $id_usuario; 

// 2. BUG (Erro de lógica/Digitação)
// Uma condição que sempre será verdadeira (código morto)
$status = true;
if ($status == true) {
    // bloco normal
} else if ($status == false) {
    echo "Isso nunca vai acontecer"; // Código inacessível
}

// 3. CODE SMELL (Má prática / Código Sujo)
// Uma variável declarada que nunca é usada no sistema
$variavelInutilQueNinguemUsa = "apenas ocupando espaço";

// O restante do seu código original continua aqui para baixo...
?>
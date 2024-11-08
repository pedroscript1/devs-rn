<?php
require 'config.php';

$associado_id = $_GET['associado_id'] ?? null;

if (!$associado_id) {
    die("ID do associado não fornecido.");
}

// Marcar anuidade como paga
if (isset($_GET['pay_anuidade_id'])) {
    $anuidade_id = $_GET['pay_anuidade_id'];
    $stmt = $pdo->prepare("INSERT INTO pagamentos (associado_id, anuidade_id, pago) VALUES (?, ?, 1)");
    $stmt->execute([$associado_id, $anuidade_id]);
    echo "<p>Anuidade marcada como paga com sucesso.</p>";
}

// Buscar nome do associado
$stmt = $pdo->prepare("SELECT nome FROM associados WHERE id = ?");
$stmt->execute([$associado_id]);
$associado = $stmt->fetch();

// Buscar anuidades devidas do associado
$stmt = $pdo->prepare("
    SELECT a.id, a.ano, a.valor, IFNULL(p.pago, 0) AS pago
    FROM anuidades a
    LEFT JOIN pagamentos p ON p.anuidade_id = a.id AND p.associado_id = ?
    WHERE a.ano >= YEAR((SELECT data_filiacao FROM associados WHERE id = ?))
");
$stmt->execute([$associado_id, $associado_id]);
$anuidades = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Checkout de Anuidades</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
            color: #333;
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #218838;
        }
        a {
            color: #007BFF;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .nav-links {
            margin: 20px 0;
        }
        .nav-links a{
            margin-right: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="nav-links">
    <a href="anuidades.php">Gerenciar Anuidades</a>
    <a href="status_pagamento.php">Status de Pagamento</a>
    
</div>
<h2>Checkout de Anuidades para <?php echo htmlspecialchars($associado['nome']); ?></h2>

<table>
    <tr>
        <th>Ano</th>
        <th>Valor</th>
        <th>Status</th>
        <th>Ação</th>
    </tr>
    <?php foreach ($anuidades as $anuidade): ?>
        <tr>
            <td><?php echo htmlspecialchars($anuidade['ano']); ?></td>
            <td>R$ <?php echo number_format($anuidade['valor'], 2, ',', '.'); ?></td>
            <td><?php echo $anuidade['pago'] ? 'Pago' : 'Em Aberto'; ?></td>
            <td>
                <?php if (!$anuidade['pago']): ?>
                    <a href="checkout.php?associado_id=<?php echo $associado_id; ?>&pay_anuidade_id=<?php echo $anuidade['id']; ?>" class="button">Pagar</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>

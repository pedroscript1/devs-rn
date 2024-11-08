<?php
require 'config.php';

// Buscar todos os associados
$stmt = $pdo->query("SELECT id, nome, data_filiacao FROM associados");
$associados = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Status de Pagamento dos Associados</title>
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
        .status-em-dia {
            color: #28a745;
            font-weight: bold;
        }
        .status-em-atraso {
            color: #dc3545;
            font-weight: bold;
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
        .nav-links a {
            margin-right: 15px;
            font-weight: bold;
        }

    </style>
</head>
<body>

<h2>Status de Pagamento dos Associados</h2>

<table>
    <tr>
        <th>Nome</th>
        <th>Status</th>
        <th>Ação</th>
    </tr>

    <?php foreach ($associados as $associado): ?>
        <?php
        // Obter o ano de filiação para calcular as anuidades devidas
        $associado_id = $associado['id'];
        $ano_filiacao = (int) date('Y', strtotime($associado['data_filiacao']));

        // Buscar as anuidades do associado
        $stmt = $pdo->prepare("
            SELECT a.id, a.ano, IFNULL(p.pago, 0) AS pago 
            FROM anuidades a
            LEFT JOIN pagamentos p ON p.anuidade_id = a.id AND p.associado_id = ?
            WHERE a.ano >= ?
        ");
        $stmt->execute([$associado_id, $ano_filiacao]);
        $anuidades = $stmt->fetchAll();

        // Verificar se o associado tem algum pagamento em atraso
        $em_dia = true;
        foreach ($anuidades as $anuidade) {
            if (!$anuidade['pago']) {
                $em_dia = false;
                break;
            }
        }

        // Definir classe de status para o associado
        $status_class = $em_dia ? "status-em-dia" : "status-em-atraso";
        $status_text = $em_dia ? "Em Dia" : "Em Atraso";
        ?>

        <tr>
            <td><?php echo htmlspecialchars($associado['nome']); ?></td>
            <td class="<?php echo $status_class; ?>"><?php echo $status_text; ?></td>
            <td>
                <!-- Link para a página de checkout -->
                <a href="checkout.php?associado_id=<?php echo $associado['id']; ?>">Checkout</a>
            </td>
        </tr>

    <?php endforeach; ?>

    <div class="nav-links">
    <a href="anuidades.php">Gerenciar Anuidades</a>
    <a href="status_pagamento.php">Status de Pagamento</a>
    
</div>
</table>

</body>
</html>





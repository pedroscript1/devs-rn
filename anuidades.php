<?php
require 'config.php';

// Verifica se o formulário de adicionar anuidade foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adicionar_anuidade'])) {
    // Sanitização e validação dos dados do formulário
    $ano = filter_input(INPUT_POST, 'ano', FILTER_SANITIZE_NUMBER_INT);
    $valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    if ($ano && $valor) {
        // Inserir a nova anuidade no banco de dados
        $stmt = $pdo->prepare("INSERT INTO anuidades (ano, valor) VALUES (?, ?)");
        $stmt->execute([$ano, $valor]);

        // Redirecionar para a página para evitar envio duplicado
        header('Location: anuidades.php');
        exit();
    } else {
        // Caso algum campo esteja vazio, exibe uma mensagem de erro
        $error_message = "Por favor, preencha todos os campos!";
    }
}

// Buscar todas as anuidades
$stmt = $pdo->query("SELECT * FROM anuidades ORDER BY ano ASC");
$anuidades = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Anuidades</title>
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
        form {
            margin: 20px 0;
        }
        input[type="number"], input[type="submit"] {
            padding: 10px;
            margin: 10px 0;
            width: 100%;
            max-width: 300px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>

<h2>Gerenciar Anuidades</h2>

<div class="nav-links">
    <a href="associados.php">Gerenciar Associados</a>
    <a href="status_pagamento.php">Status de Pagamento</a>
    
</div>

<!-- Formulário de Cadastro de Anuidade -->
<h3>Adicionar Nova Anuidade</h3>

<?php if (isset($error_message)): ?>
    <p class="error"><?php echo $error_message; ?></p>
<?php endif; ?>

<form method="POST" action="anuidades.php">
    <label for="ano">Ano:</label>
    <input type="number" id="ano" name="ano" required>

    <label for="valor">Valor (R$):</label>
    <input type="number" id="valor" name="valor" step="0.01" required>

    <input type="submit" name="adicionar_anuidade" value="Adicionar Anuidade">
</form>

<!-- Tabela de Anuidades -->
<h3>Lista de Anuidades</h3>
<table>
    <tr>
        <th>Ano</th>
        <th>Valor</th>
        <th>Ações</th>
    </tr>

    <?php foreach ($anuidades as $anuidade): ?>
        <tr>
            <td><?php echo htmlspecialchars($anuidade['ano']); ?></td>
            <td>R$ <?php echo number_format($anuidade['valor'], 2, ',', '.'); ?></td>
            <td>
                <a href="editar_anuidade.php?id=<?php echo $anuidade['id']; ?>">Editar</a> | 
                <a href="deletar_anuidade.php?id=<?php echo $anuidade['id']; ?>">Deletar</a> 
                
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>



<?php
require 'config.php';

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitização e validação dos dados do formulário
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);
    $data_filiacao = filter_input(INPUT_POST, 'data_filiacao', FILTER_SANITIZE_STRING);

    if ($nome && $email && $cpf && $data_filiacao) {
        // Inserir o novo associado no banco de dados
        $stmt = $pdo->prepare("INSERT INTO associados (nome, email, cpf, data_filiacao) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nome, $email, $cpf, $data_filiacao]);
        
        // Redirecionar para a página para evitar envio duplicado
        header('Location: associados.php');
        exit();
    } else {
        // Caso algum campo esteja vazio, exibe uma mensagem de erro
        $error_message = "Por favor, preencha todos os campos!";
    }
}

// Buscar todos os associados
$stmt = $pdo->query("SELECT id, nome, email, cpf, data_filiacao FROM associados");
$associados = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Associados</title>
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
            text-decoration: none;
            margin: 5px;
        }

        .btn-primary {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-danger {
            background-color: #f44336;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
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
        input[type="text"], input[type="email"], input[type="date"], input[type="submit"] {
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

<h2>Cadastro de Associados</h2>

<div class="nav-links">
    <a href="anuidades.php">Gerenciar Anuidades</a>
    <a href="status_pagamento.php">Status de Pagamento</a>
    
</div>

<!-- Formulário de Cadastro de Associado -->
<h3>Adicionar Novo Associado</h3>

<?php if (isset($error_message)): ?>
    <p class="error"><?php echo $error_message; ?></p>
<?php endif; ?>

<form method="POST" action="associados.php">
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" required>

    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" required>

    <label for="cpf">CPF:</label>
    <input type="text" id="cpf" name="cpf" required>
    <br>

    <label for="data_filiacao">Data de Filiação:</label>
    <input type="date" id="data_filiacao" name="data_filiacao" required>

    <input type="submit" value="Cadastrar Associado">
</form>

<!-- Tabela de Associados -->
<h3>Lista de Associados</h3>
<table>
    <tr>
        <th>Nome</th>
        <th>Email</th>
        <th>CPF</th>
        <th>Data de Filiação</th>
        <th>Ações</th>
    </tr>

    <?php foreach ($associados as $associado): ?>
        <tr>
            <td><?php echo htmlspecialchars($associado['nome']); ?></td>
            <td><?php echo htmlspecialchars($associado['email']); ?></td>
            <td><?php echo htmlspecialchars($associado['cpf']); ?></td>
            <td><?php echo date('d/m/Y', strtotime($associado['data_filiacao'])); ?></td>
            <td>
                <a href="editar_associado.php?associado_id=<?=$row['associado_id']?>" class="btn btn-primary">Editar</a> 
                <a href="excluir_associado.php?associado_id=<?=$row['associado_id']?>" class="btn btn-danger">Deletar</a>
            </td>

        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>



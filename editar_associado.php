<?php
require 'config.php';

if (isset($_GET['associado_id'])) {
    $associado_id = $_GET['associado_id'];

    // Carregar dados do associado
    $stmt = $pdo->prepare("SELECT * FROM associados WHERE associado_id = :associado_id");
    $stmt->bindParam(':associado_id', $associado_id, PDO::PARAM_INT);
    $stmt->execute();
    $associado = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$associado) {
        echo "Associado não encontrado.";
        echo '<br><a href="associados.php">Voltar para a lista de associados</a>';
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $cpf = $_POST['cpf'];
        $data_filiacao = $_POST['data_filiacao'];

        // Atualizar dados do associado
        $stmt = $pdo->prepare("UPDATE associados SET nome = :nome, email = :email, cpf = :cpf, data_filiacao = :data_filiacao WHERE associado_id = :associado_id");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':data_filiacao', $data_filiacao);
        $stmt->bindParam(':associado_id', $associado_id, PDO::PARAM_INT);
        $stmt->execute();

        echo "Associado atualizado com sucesso!";
        echo '<br><a href="associados.php">Voltar para a lista de associados</a>';
    }
} else {
    echo "ID do associado não fornecido.";
    echo '<br><a href="associados.php">Voltar para a lista de associados</a>';
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Associado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        h2 {
            color: #333;
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        input[type="text"], input[type="email"], input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            margin-top: 15px;
            padding: 10px 15px;
            border: none;
            background-color: #28a745;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            border-radius: 4px;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        a {
            display: inline-block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Editar Associado</h2>
        <form method="POST">
            <label>Nome:</label>
            <input type="text" name="nome" value="<?php echo htmlspecialchars($associado['nome']); ?>">

            <label>E-mail:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($associado['email']); ?>">

            <label>CPF:</label>
            <input type="text" name="cpf" value="<?php echo htmlspecialchars($associado['cpf']); ?>">

            <label>Data de Filiação:</label>
            <input type="date" name="data_filiacao" value="<?php echo htmlspecialchars($associado['data_filiacao']); ?>">

            <input type="submit" value="Salvar">
        </form>
        <a href="associados.php">Voltar para a lista de associados</a>
    </div>
</body>
</html>


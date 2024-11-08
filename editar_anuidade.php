<?php
require 'config.php';

if (isset($_GET['anuidade_id'])) {
    $anuidade_id = $_GET['anuidade_id'];

    // Carregar dados da anuidade
    $stmt = $pdo->prepare("SELECT * FROM anuidades WHERE anuidade_id = :anuidade_id");
    $stmt->bindParam(':anuidade_id', $anuidade_id, PDO::PARAM_INT);
    $stmt->execute();
    $anuidade = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$anuidade) {
        echo "Anuidade não encontrada.";
        echo '<br><a href="anuidades.php">Voltar para a lista de anuidades</a>';
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ano = $_POST['ano'];
        $valor = $_POST['valor'];

        // Atualizar dados da anuidade
        $stmt = $pdo->prepare("UPDATE anuidades SET ano = :ano, valor = :valor WHERE anuidade_id = :anuidade_id");
        $stmt->bindParam(':ano', $ano);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':anuidade_id', $anuidade_id, PDO::PARAM_INT);
        $stmt->execute();

        echo "Anuidade atualizada com sucesso!";
        echo '<br><a href="anuidades.php">Voltar para a lista de anuidades</a>';
    }
} else {
    echo "ID da anuidade não fornecido.";
    echo '<br><a href="anuidades.php">Voltar para a lista de anuidades</a>';
}
?>

<!-- Formulário de edição -->
<form method="POST">
    Ano: <input type="text" name="ano" value="<?php echo htmlspecialchars($anuidade['ano']); ?>"><br>
    Valor: <input type="text" name="valor" value="<?php echo htmlspecialchars($anuidade['valor']); ?>"><br>
    <input type="submit" value="Salvar">
</form>


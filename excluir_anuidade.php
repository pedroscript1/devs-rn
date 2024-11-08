<?php
require 'config.php';

if (isset($_GET['anuidade_id'])) {
    $anuidade_id = $_GET['anuidade_id'];

    // Excluir a anuidade pelo ID
    $stmt = $pdo->prepare("DELETE FROM anuidades WHERE anuidade_id = :anuidade_id");
    $stmt->bindParam(':anuidade_id', $anuidade_id, PDO::PARAM_INT);
    $stmt->execute();

    echo "Anuidade excluída com sucesso!";
    echo '<br><a href="anuidades.php">Voltar para a lista de anuidades</a>';
} else {
    echo "ID da anuidade não fornecido.";
    echo '<br><a href="anuidades.php">Voltar para a lista de anuidades</a>';
}


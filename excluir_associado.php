<?php
require 'config.php';

if (isset($_GET['associado_id'])) {
    $associado_id = $_GET['associado_id'];

    // Excluir o associado pelo ID
    $stmt = $pdo->prepare("DELETE FROM associados WHERE associado_id = :associado_id");
    $stmt->bindParam(':associado_id', $associado_id, PDO::PARAM_INT);
    $stmt->execute();

    echo "Associado excluído com sucesso!";
    echo '<br><a href="associados.php">Voltar para a lista de associados</a>';
} else {
    echo "ID do associado não fornecido.";
    echo '<br><a href="associados.php">Voltar para a lista de associados</a>';
}



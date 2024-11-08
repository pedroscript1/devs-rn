<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $associado_id = $_POST['associado_id'];
    $anuidade_id = $_POST['anuidade_id'];

    $stmt = $pdo->prepare("UPDATE pagamentos SET pago = TRUE WHERE associado_id = ? AND anuidade_id = ?");
    $stmt->execute([$associado_id, $anuidade_id]);
    echo "Anuidade marcada como paga!";
}

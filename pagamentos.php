<?php
require 'config.php';

$associado_id = $_GET['associado_id'] ?? null;

if ($associado_id) {
    // Exibir anuidades devidas e status de pagamento
    $query = "SELECT a.id as anuidade_id, a.ano, a.valor, IFNULL(p.pago, 0) AS pago 
              FROM anuidades a
              LEFT JOIN pagamentos p ON p.anuidade_id = a.id AND p.associado_id = :associado_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['associado_id' => $associado_id]);
    $pagamentos = $stmt->fetchAll();

    foreach ($pagamentos as $pagamento) {
        echo "Ano: " . $pagamento['ano'] . " - Valor: R$" . $pagamento['valor'];
        echo $pagamento['pago'] ? " - Pago" : " - Em Aberto";
        echo "<br>";
    }
}
?>

<!-- Formulário para marcar anuidade como paga -->
<form method="post" action="pagamento.php">
    <input type="hidden" name="associado_id" value="<?php echo $associado_id; ?>">
    <label>ID da Anuidade:</label>
    <input type="number" name="anuidade_id" required>
    <button type="submit">Marcar como Pago</button>
</form>

<?php
header('Content-Type: application/json; charset=utf-8');
require_once('conexao.php');

try
{
    $sql = "SELECT IDPERIODO, NOME FROM periodo ORDER BY NOME";
    $comando = $pdo->prepare($sql);
    $comando->execute();
    $periodos = $comando->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($periodos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}
catch (PDOException $erro)
{
    echo json_encode(
        [
            "erro" => true,
            "mensagem" => "Erro ao listar períodos.",
            "detalhes" => $erro->getMessage()
        ],
        JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
    );
}
?>
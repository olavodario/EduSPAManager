<?php
header('Content-Type: application/json; charset=utf-8');
require_once('conexao.php');

try
{
    $sql = "SELECT IDETAPA, NOME FROM etapa ORDER BY NOME";
    $comando = $pdo->prepare($sql);
    $comando->execute();
    $etapas = $comando->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($etapas, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}
catch (PDOException $erro)
{
    echo json_encode(
        [
            "erro" => true,
            "mensagem" => "Erro ao listar etapas.",
            "detalhes" => $erro->getMessage()
        ],
        JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
    );
}
?>
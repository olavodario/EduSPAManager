<?php
header('Content-Type: application/json; charset=utf-8');
require_once('conexao.php');

try
{
    $sql = "SELECT IDCURSO, NOME FROM curso ORDER BY NOME";
    $comando = $pdo->prepare($sql);
    $comando->execute();
    $cursos = $comando->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($cursos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}
catch (PDOException $erro)
{
    echo json_encode(
        [
            "erro" => true,
            "mensagem" => "Erro ao listar cursos.",
            "detalhes" => $erro->getMessage()
        ],
        JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
    );
}
?>
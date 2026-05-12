<?php
header ('Content-Type: application/json; charset=utf-8');
require_once('conexao.php');

try
{
    $nome = $_POST['nome'] ?? '';
    $nome = trim($nome);

    if ($nome === '')
    {
        echo json_encode(
            [
                "erro" => true,
                "mensagem" => "O nome do período deve ser informado."
            ],
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        );
        exit;
    }

    $sql = "INSERT INTO periodo (NOME) VALUES (:nome)";
    $comando = $pdo->prepare($sql);
    $comando->bindValue(':nome', $nome, PDO::PARAM_STR);
    $comando->execute();

    $idPeriodo = $pdo->lastInsertId();

    echo json_encode(
        [
            "erro" => false,
            "mensagem" => "Período inserido com sucesso.",
            "IDPERIODO" => $idPeriodo,
            "NOME" => $nome
        ],
        JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
    );
}
catch (PDOException $erro)
{
    echo json_encode(
        [
            "erro" => true,
            "mensagem" => "Erro ao inserir período.",
            "detalhes" => $erro->getMessage()
        ],
        JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
    );
}
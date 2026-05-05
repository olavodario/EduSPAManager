<?php
header('Content-Type: application/json; charset=utf-8');
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
                "mensagem" => "O nome do curso deve ser informado."
            ],
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        );
        exit;
    }

    $sql = "INSERT INTO curso (NOME) VALUES (:nome)";
    $comando = $pdo->prepare($sql);
    $comando->bindValue(':nome', $nome, PDO::PARAM_STR);
    $comando->execute();

    $idCurso = $pdo->lastInsertId();

    echo json_encode(
        [
            "erro" => false,
            "mensagem" => "Curso inserido com sucesso.",
            "IDCURSO" => $idCurso,
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
            "mensagem" => "Erro ao inserir curso.",
            "detalhes" => $erro->getMessage()
        ],
        JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
    );
}
?>
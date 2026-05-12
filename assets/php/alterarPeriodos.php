<?php
header('Content-Type: application/json; charset=utf-8');
require_once('conexao.php');

try{
    $idPeriodo = (isset($_POST['idPeriodo'])) ? $_POST['idPeriodo'] : '';
    $nome = (isset($_POST['nome'])) ? $_POST['nome'] : '';
    if ($idPeriodo === '') {
        echo json_encode(
            array(
                "erro" => true,
                "mensagem" => "O ID do período deve ser informado."
            )
        );
        exit;
    }
    if ($nome === '') {
        echo json_encode(
            array(
                "erro" => true,
                "mensagem" => "O nome do período deve ser informado."
            )
        );
        exit;
    }

    $sql = "UPDATE periodo SET NOME = :nome WHERE IDPERIODO = :idPeriodo";
    $comando = $pdo->prepare($sql);
    $comando->bindValue(':nome', $nome, PDO::PARAM_STR);
    $comando->bindValue(':idPeriodo', $idPeriodo, PDO::PARAM_INT);
    $comando->execute();

    echo json_encode(
        array(
            "erro" => false,
            "mensagem" => "Período alterado com sucesso.",
            "IDPERIODO" => $idPeriodo,
            "NOME" => $nome
        )
    );
} catch (PDOException $erro) {
    echo json_encode(
        array(
            "erro" => true,
            "mensagem" => "Erro ao alterar período.",
            "detalhes" => $erro->getMessage()
        )
    );
}
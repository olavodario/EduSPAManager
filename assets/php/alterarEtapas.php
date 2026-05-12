<?php
header('Content-Type: application/json; charset=utf-8');
require_once('conexao.php');

try {
    $idEtapa = (isset($_POST['idEtapa'])) ? $_POST['idEtapa'] : '';
    $nome = (isset($_POST['nome'])) ? $_POST['nome'] : '';
    if ($idEtapa === '') {
        echo json_encode(
            array(
                "erro" => true,
                "mensagem" => "O ID da etapa deve ser informado."
            )
        );
        exit;
    }
    if ($nome === '') {
        echo json_encode(
            array(
                "erro" => true,
                "mensagem" => "O nome da etapa deve ser informado."
            )
        );
        exit;
    }

    $sql = "UPDATE etapa SET NOME = :nome WHERE IDETAPA = :idEtapa";
    $comando = $pdo->prepare($sql);
    $comando->bindValue(':nome', $nome, PDO::PARAM_STR);
    $comando->bindValue(':idEtapa', $idEtapa, PDO::PARAM_INT);
    $comando->execute();

    echo json_encode(
        array(
            "erro" => false,
            "mensagem" => "Etapa alterada com sucesso.",
            "IDETAPA" => $idEtapa,
            "NOME" => $nome
        )
    );
} catch (PDOException $erro) {
    echo json_encode(
        array(
            "erro" => true,
            "mensagem" => "Erro ao alterar etapa.",
            "detalhes" => $erro->getMessage()
        )
    );
}
?>
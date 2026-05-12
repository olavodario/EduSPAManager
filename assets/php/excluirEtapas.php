<?php
header('Content-Type: application/json; charset=utf-8');
require_once('conexao.php');

try 
{
    $idEtapa = (isset($_POST['idEtapa'])) ? $_POST['idEtapa'] : '';
    $idEtapa = trim($idEtapa);

    if ($idEtapa === '') 
    {
        echo json_encode(
            array(
                "erro" => true,
                "mensagem" => "O ID da etapa deve ser informado."
            ),
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        );
        exit;
    }

    $sql = "DELETE FROM etapa WHERE IDETAPA = :idEtapa";
    $comando = $pdo->prepare($sql);
    $comando->bindValue(':idEtapa', $idEtapa, PDO::PARAM_INT);
    $comando->execute();

    if ($comando->rowCount() === 0) 
    {
        echo json_encode(
            array(
                "erro" => true,
                "mensagem" => "Nenhuma etapa foi encontrada para exclusão."
            ),
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        );
        exit;
    }

    echo json_encode(
        array(
            "erro" => false,
            "mensagem" => "Etapa excluída com sucesso."
        ),
        JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
    );
} 
catch (PDOException $erro) 
{
    $mensagem = "Erro ao excluir etapa.";

    if ($erro->getCode() == 23000) 
    {
        $mensagem = "Não é possível excluir esta etapa, pois existem alunos vinculados a ela.";
    }

    echo json_encode(
        array(
            "erro" => true,
            "mensagem" => $mensagem
        ),
        JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
    );
}
?>
<?php
header('Content-Type: application/json; charset=utf-8');
require_once('conexao.php');

try {
    $idPeriodo = (isset($_POST['idPeriodo'])) ? $_POST['idPeriodo'] : '';
    $idPeriodo = trim($idPeriodo);

    if ($idPeriodo === '') {
        echo json_encode(
            array(
                "erro" => true,
                "mensagem" => "O ID do período deve ser informado."
            ),
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        );
        exit;
    }

    $sql = "DELETE FROM periodo WHERE IDPERIODO = :idPeriodo";
    $comando = $pdo->prepare($sql);
    $comando->bindValue(':idPeriodo', $idPeriodo, PDO::PARAM_INT);
    $comando->execute();

    if ($comando->rowCount() === 0) {
        echo json_encode(
            array(
                "erro" => true,
                "mensagem" => "Nenhum período foi encontrado para exclusão."
            ),
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        );
        exit;
    }

    echo json_encode(
        array(
            "erro" => false,
            "mensagem" => "Período excluído com sucesso."
        ),
        JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
    );
} catch (PDOException $erro) {
    $messagem = "Erro ao excluir período.";

    if ($erro->getCode() == 23000) {
        $messagem = "Não é possível excluir este período, pois existem alunos vinculados a ele.";
    }

    echo json_encode(
        array(
            "erro" => true,
            "mensagem" => $messagem
        ),
        JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
    );
}
?>

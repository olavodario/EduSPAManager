<?php
header('Content-Type: application/json; charset=utf-8');
require_once('conexao.php');

try 
{
    $idCurso = (isset($_POST['idCurso'])) ? $_POST['idCurso'] : '';
    $idCurso = trim($idCurso);

    if ($idCurso === '') 
    {
        echo json_encode(
            array(
                "erro" => true,
                "mensagem" => "O ID do curso deve ser informado."
            ),
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        );
        exit;
    }

    $sql = "DELETE FROM curso WHERE IDCURSO = :idCurso";
    $comando = $pdo->prepare($sql);
    $comando->bindValue(':idCurso', $idCurso, PDO::PARAM_INT);
    $comando->execute();

    if ($comando->rowCount() === 0) 
    {
        echo json_encode(
            array(
                "erro" => true,
                "mensagem" => "Nenhum curso foi encontrado para exclusão."
            ),
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        );
        exit;
    }

    echo json_encode(
        array(
            "erro" => false,
            "mensagem" => "Curso excluído com sucesso."
        ),
        JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
    );
} 
catch (PDOException $erro) 
{
    echo json_encode(
        array(
            "erro" => true,
            "mensagem" => "Erro ao excluir curso.",
            "detalhes" => $erro->getMessage()
        ),
        JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
    );
}
?>
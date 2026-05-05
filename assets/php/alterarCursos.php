<?php
header('Content-Type: application/json; charset=utf-8');
require_once('conexao.php');

try 
{
    $idCurso = (isset($_POST['idCurso'])) ? $_POST['idCurso'] : '';
    $nome = (isset($_POST['nome'])) ? $_POST['nome'] : '';

    $idCurso = trim($idCurso);
    $nome = trim($nome);

    if ($idCurso === '') 
    {
        echo json_encode(
            array(
                "erro" => true,
                "mensagem" => "O ID do curso deve ser informado."
            )
        );
        exit;
    }

    if ($nome === '') 
    {
        echo json_encode(
            array(
                "erro" => true,
                "mensagem" => "O nome do curso deve ser informado."
            )
        );
        exit;
    }

    $sql = "UPDATE curso SET NOME = :nome WHERE IDCURSO = :idCurso";
    $comando = $pdo->prepare($sql);
    $comando->bindValue(':nome', $nome, PDO::PARAM_STR);
    $comando->bindValue(':idCurso', $idCurso, PDO::PARAM_INT);
    $comando->execute();

    echo json_encode(
        array(
            "erro" => false,
            "mensagem" => "Curso alterado com sucesso.",
            "IDCURSO" => $idCurso,
            "NOME" => $nome
        )
    );
} 
catch (PDOException $erro) 
{
    echo json_encode(
        array(
            "erro" => true,
            "mensagem" => "Erro ao alterar curso.",
            "detalhes" => $erro->getMessage()
        )
    );
}
?>

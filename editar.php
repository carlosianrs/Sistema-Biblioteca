<?php

include_once "conexao.php";

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (empty($dados['id'])) {
    $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Tente mais tarde!</div>"];
} elseif (empty($dados['curso'])) {
    $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo curso!</div>"];
} elseif (empty($dados['nomeAluno'])) {
    $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo nome do aluno!</div>"];
} elseif (empty($dados['dataEmprestimo'])) {
    $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo data de empréstimo!</div>"];
} elseif (empty($dados['tituloLivro'])) {
    $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo título do livro!</div>"];
} elseif (empty($dados['dataDevolucao'])) {
    $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo data de devolução!</div>"];
} else {
    $query_usuario = "UPDATE emprestimo SET curso=:curso, nomeAluno=:nomeAluno, dataEmprestimo=:dataEmprestimo, tituloLivro=:tituloLivro, dataDevolucao=:dataDevolucao WHERE id=:id";
    $edit_usuario = $conn->prepare($query_usuario);
    $edit_usuario->bindParam(':curso', $dados['curso']);
    $edit_usuario->bindParam(':nomeAluno', $dados['nomeAluno']);
    $edit_usuario->bindParam(':dataEmprestimo', $dados['dataEmprestimo']);
    $edit_usuario->bindParam(':tituloLivro', $dados['tituloLivro']);
    $edit_usuario->bindParam(':dataDevolucao', $dados['dataDevolucao']);
    $edit_usuario->bindParam(':id', $dados['id']);

    if($edit_usuario->execute()){
        $retorna = ['status' => true, 'msg' => "<div class='alert alert-success' role='alert'>Empréstimo editado com sucesso!</div>"];
    }else{
        $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Empréstimo não foi editado com sucesso!</div>"];
    }
}

echo json_encode($retorna);

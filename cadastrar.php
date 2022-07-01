<?php

include_once "conexao.php";

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (empty($dados['curso'])) {
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
    $query_usuario = "INSERT INTO emprestimo (curso, nomeAluno, dataEmprestimo, tituloLivro, dataDevolucao) VALUES (:curso, :nomeAluno, :dataEmprestimo, :tituloLivro, :dataDevolucao)";
    $cad_usuario =$conn->prepare($query_usuario);
    $cad_usuario->bindParam(':curso', $dados['curso']);
    $cad_usuario->bindParam(':nomeAluno', $dados['nomeAluno']);
    $cad_usuario->bindParam(':dataEmprestimo', $dados['dataEmprestimo']);
    $cad_usuario->bindParam(':tituloLivro', $dados['tituloLivro']);
    $cad_usuario->bindParam(':dataDevolucao', $dados['dataDevolucao']);
    $cad_usuario->execute();

    if($cad_usuario->rowCount()){
        $retorna = ['status' => true, 'msg' => "<div class='alert alert-success' role='alert'>Empréstimo cadastrado com sucesso!</div>"];
    }else{
        $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Empréstimo não cadastrado com sucesso!</div>"];
    }
}

echo json_encode($retorna);

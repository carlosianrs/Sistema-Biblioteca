<?php

// Incluir a conexao com o banco de dados
include_once './conexao.php';

//Receber os dados da requisão
$dados_requisicao = $_REQUEST;

// Lista de colunas da tabela
$colunas = [
    0 => 'id',
    1 => 'curso',
    2 => 'nomeAluno',
    3 => 'dataEmprestimo',
    4 => 'tituloLivro',
    5 => 'dataDevolucao'
];

// Obter a quantdataEmprestimo de registros no banco de dados
$query_qnt_usuarios = "SELECT COUNT(id) AS qnt_usuarios FROM emprestimo";

// Acessa o IF quando ha paramentros de pesquisa   
if(!empty($dados_requisicao['search']['value'])) {
    $query_qnt_usuarios .= " WHERE id LIKE :id ";
    $query_qnt_usuarios .= " OR curso LIKE :curso ";
    $query_qnt_usuarios .= " OR nomeAluno LIKE :nomeAluno ";
    $query_qnt_usuarios .= " OR dataEmprestimo LIKE :dataEmprestimo ";
    $query_qnt_usuarios .= " OR tituloLivro LIKE :tituloLivro ";
    $query_qnt_usuarios .= " OR dataDevolucao LIKE :dataDevolucao ";
}
// Preparar a QUERY
$result_qnt_usuarios = $conn->prepare($query_qnt_usuarios);
// Acessa o IF quando ha paramentros de pesquisa   
if(!empty($dados_requisicao['search']['value'])) {
    $valor_pesq = "%" . $dados_requisicao['search']['value'] . "%";
    $result_qnt_usuarios->bindParam(':id', $valor_pesq, PDO::PARAM_STR);
    $result_qnt_usuarios->bindParam(':curso', $valor_pesq, PDO::PARAM_STR);
    $result_qnt_usuarios->bindParam(':nomeAluno', $valor_pesq, PDO::PARAM_STR);
    $result_qnt_usuarios->bindParam(':dataEmprestimo', $valor_pesq, PDO::PARAM_STR);
    $result_qnt_usuarios->bindParam(':tituloLivro', $valor_pesq, PDO::PARAM_STR);
    $result_qnt_usuarios->bindParam(':dataDevolucao', $valor_pesq, PDO::PARAM_STR);
}
// Executar a QUERY responsável em retornar a quantdataEmprestimo de registros no banco de dados
$result_qnt_usuarios->execute();
$row_qnt_usuarios = $result_qnt_usuarios->fetch(PDO::FETCH_ASSOC);
//var_dump($row_qnt_usuarios);

// Recuperar os registros do banco de dados
$query_usuarios = "SELECT id, curso, nomeAluno, dataEmprestimo, tituloLivro, dataDevolucao, situacao 
                    FROM emprestimo ";

// Acessa o IF quando ha paramentros de pesquisa   
if(!empty($dados_requisicao['search']['value'])) {
    $query_usuarios .= " WHERE id LIKE :id ";
    $query_usuarios .= " OR curso LIKE :curso ";
    $query_usuarios .= " OR nomeAluno LIKE :nomeAluno ";
    $query_usuarios .= " OR dataEmprestimo LIKE :dataEmprestimo ";
    $query_usuarios .= " OR tituloLivro LIKE :tituloLivro ";
    $query_usuarios .= " OR dataDevolucao LIKE :dataDevolucao ";
    $query_usuarios .= " OR situacao LIKE :situacao ";
}

// Ordenar os registros
$query_usuarios .= " ORDER BY " . $colunas[$dados_requisicao['order'][0]['column']] . " " . $dados_requisicao['order'][0]['dir'] . " LIMIT :inicio , :quantdataEmprestimo";

// Preparar a QUERY
$result_usuarios = $conn->prepare($query_usuarios);
$result_usuarios->bindParam(':inicio', $dados_requisicao['start'], PDO::PARAM_INT);
$result_usuarios->bindParam(':quantdataEmprestimo', $dados_requisicao['length'], PDO::PARAM_INT);

// Acessa o IF quando ha paramentros de pesquisa   
if(!empty($dados_requisicao['search']['value'])) {
    $valor_pesq = "%" . $dados_requisicao['search']['value'] . "%";
    $result_usuarios->bindParam(':id', $valor_pesq, PDO::PARAM_STR);
    $result_usuarios->bindParam(':curso', $valor_pesq, PDO::PARAM_STR);
    $result_usuarios->bindParam(':nomeAluno', $valor_pesq, PDO::PARAM_STR);
    $result_usuarios->bindParam(':dataEmprestimo', $valor_pesq, PDO::PARAM_STR);
    $result_usuarios->bindParam(':tituloLivro', $valor_pesq, PDO::PARAM_STR);
    $result_usuarios->bindParam(':dataDevolucao', $valor_pesq, PDO::PARAM_STR);
    $result_usuarios->bindParam(':situacao', $valor_pesq, PDO::PARAM_STR);
}
// Executar a QUERY
$result_usuarios->execute();

// Ler os registros retornado do banco de dados e atribuir no array 
while ($row_usuario = $result_usuarios->fetch(PDO::FETCH_ASSOC)) {
    extract($row_usuario);
    $registro = [];
    $registro[] = $id;
    $registro[] = $curso;
    $registro[] = $nomeAluno;
    $registro[] = $dataEmprestimo;
    $registro[] = $tituloLivro;
    $registro[] = $dataDevolucao;
    $registro[] = $situacao;
    $registro[] = "<button type='button' id='$id' class='btn btn-outline-primary btn-sm' onclick='editUsuario($id)'>Editar</button> <button type='button' id='$id' class='btn btn-outline-warning btn-sm' onclick='baiUsuario($id)'>Dar Baixa</button>";
    $dados[] = $registro;
}

//Cria o array de informações a serem retornadas para o Javascript
$resultado = [
    "draw" => intval($dados_requisicao['draw']), // Para cada requisição é enviado um número como parâmetro
    "recordsTotal" => intval($row_qnt_usuarios['qnt_usuarios']), // QuantdataEmprestimo de registros que há no banco de dados
    "recordsFiltered" => intval($row_qnt_usuarios['qnt_usuarios']), // Total de registros quando houver pesquisa
    "data" => $dados // Array de dados com os registros retornados da tabela usuarios
];

// Retornar os dados em formato de objeto para o JavaScript
echo json_encode($resultado);

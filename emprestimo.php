<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">    
    <title>Cadastrar Empréstimo</title>

<style>

*{
    margin: 0%;
    padding: 0%;
}

body{
   
    width: 100vw;
    height: 100vh;
    background-size: cover;
    color: rgb(12, 3, 3);
    font-family: 'Ubuntu', sans-serif;
    text-align: center;   
}

.inputBox{
    position: relative;
}

#Enviar{
    background-image: linear-gradient(to right,rgb(0, 92, 197), rgb(90, 20, 220));
    width: 100%;
    border: none;
    padding: 15px;
    color: white;
    font-size: 15px;
    cursor: pointer;
    border-radius: 10px;
}
#Enviar:hover{
    background-image: linear-gradient(to right,rgb(0, 80, 172), rgb(80, 19, 195));
}
#campos{
    width: 300px;
}
#cadastrar{
    width: 100px;
    color: white;
    background-color: blue;
}

</style>

</head>
<body>

    <div class="d-flex">
            <a href="index.html" class="btn btn-danger me-5">Sair</a>
        </div>
 
<br>
    <div align="center">
    <form name="formEmprestimo" method="POST" action="emprestimo.php">
        <fieldset>
            <h3>Adicionar Emprestimo</h3>
        <label for="curso">Turma:</label>
            <select id="campos" class="form-select form-select-sm" name="curso" value="<?=$curso?>"required>
                <option name="1ºEnfermagem" value="1ºEnfermagem">1ºEnfermagem</option> 
                <option name="1ºHospedagem" value="1ºHospedagem">1ºHospedagem</option>
                <option name="1ºInformática" value="1ºInformática">1ºInformática</option>
                <option name="1ºModelagem" value="1ºModelagem">1ºModelagem</option>
                <option name="2ºEnfermagem" value="2ºEnfermagem">2ºEnfermagem</option>
                <option name="2ºHospedagem" value="2ºHospedagem">2ºHospedagem</option>
                <option name="2ºInformática" value="2ºInformática">2ºInformática</option>
                <option name="2ºModelagem" value="2ºModelagem">2ºModelagem</option>
                <option name="3ºEnfermagem" value="3ºEnfermagem">3ºEnfermagem</option>
                <option name="3ºHospedagem" value="3ºHospedagem">3ºHospedagem</option>
                <option name="3ºInformática" value="3ºInformática">3ºInformática</option>
                <option name="3ºModelagem" value="3ºModelagem">3ºModelagem</option>
            </select>
            <br>
            Nome: <input id="campos" class="form-control form-control-sm" type="text" name="nomeAluno" required>
            <br>
            Data de Empréstimo: <input id="campos" class="form-control form-control-sm" type="date" name="dataEmprestimo" required>
            <br>
            Título do Livro: <input id="campos" class="form-control form-control-sm" type="text" name="tituloLivro" required>
            <br>
            Data de Devolução: <input id="campos" class="form-control form-control-sm" type="date" name="dataDevolucao" required>
            <br>
        
        <button name="cadastrar" id="cadastrar" class="btn submit">Cadastrar</button>
    
        </fieldset>
    </form>
</div>
</body>
</html>


<?php 
    require_once('conexao.php');
        if(isset($_POST['cadastrar'])){
            $curso=$_POST['curso'];
            $nomeAluno=$_POST['nomeAluno'];
            $dataEmprestimo=$_POST['dataEmprestimo'];
            $tituloLivro=$_POST['tituloLivro'];
            $dataDevolucao=$_POST['dataDevolucao'];

        try{
            $stmte = $conn->prepare("INSERT INTO emprestimo(curso, nomeAluno, dataEmprestimo, tituloLivro, dataDevolucao) VALUES(?, ?, ?, ?, ?)");
            $stmte -> bindParam(1, $curso, PDO::PARAM_STR);
            $stmte -> bindParam(2, $nomeAluno, PDO::PARAM_STR);
            $stmte -> bindParam(3, $dataEmprestimo, PDO::PARAM_STR);
            $stmte -> bindParam(4, $tituloLivro, PDO::PARAM_STR);
            $stmte -> bindParam(5, $dataDevolucao, PDO::PARAM_STR);
            $executa = $stmte->execute();

            if($executa){
                echo 'Dados inseridos com sucesso';
                header('location: index.html');
            }else{
                echo "erro ao inserir dados";
            }

        
        
        
        }catch(PDOException $e){
            echo $e->GetMessage();
        }
        
        }
    

?>

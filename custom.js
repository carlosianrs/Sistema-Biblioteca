$(document).ready(function() {
    $('#listar-usuario').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "listar_usuarios.php",
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json"
        }
    });
});

const formNewUser = document.getElementById("form-cad-usuario");
const fecharModalCad = new bootstrap.Modal(document.getElementById("cadUsuarioModal"));
if (formNewUser) {
    formNewUser.addEventListener("submit", async(e) => {
        e.preventDefault();
        const dadosForm = new FormData(formNewUser);
        //console.log(dadosForm);

        const dados = await fetch("cadastrar.php", {
            method: "POST",
            body: dadosForm
        });
        const resposta = await dados.json();
        //console.log(resposta);

        if (resposta['status']) {
            document.getElementById("msgAlertErroCad").innerHTML = "";
            document.getElementById("msgAlerta").innerHTML = resposta['msg'];
            formNewUser.reset();
            fecharModalCad.hide();
            listarDataTables = $('#listar-usuario').DataTable();
            listarDataTables.draw();
        } else {
            document.getElementById("msgAlertErroCad").innerHTML = resposta['msg'];
        }
    });
}

async function visUsuario(id) {
    //console.log("Acessou: " + id);
    const dados = await fetch('visualizar.php?id=' + id);
    const resposta = await dados.json();
    //console.log(resposta);

    if (resposta['status']) {
        const visModal = new bootstrap.Modal(document.getElementById("visUsuarioModal"));
        visModal.show();

        document.getElementById("idUsuario").innerHTML = resposta['dados'].id;
        document.getElementById("cursoUsuario").innerHTML = resposta['dados'].curso;
        document.getElementById("nomeAlunoUsuario").innerHTML = resposta['dados'].salario;
        document.getElementById("dataEmprestimoUsuario").innerHTML = resposta['dados'].dataEmprestimo;
        document.getElementById("tituloLivroUsuario").innerHTML = resposta['dados'].tituloLivro;
        document.getElementById("dataDevolucaoUsuario").innerHTML = resposta['dados'].dataDevolucao;
        document.getElementById("situacao").innerHTML = resposta['situacao'].situacao;

        document.getElementById("msgAlerta").innerHTML = "";
    } else {
        document.getElementById("msgAlerta").innerHTML = resposta['msg'];
    }
}

const editModal = new bootstrap.Modal(document.getElementById("editUsuarioModal"));
async function editUsuario(id) {
    //console.log("Editar: " + id);

    const dados = await fetch('visualizar.php?id=' + id);
    const resposta = await dados.json();
    //console.log(resposta);

    if (resposta['status']) {
        document.getElementById("msgAlertErroEdit").innerHTML = "";

        document.getElementById("msgAlerta").innerHTML = "";
        editModal.show();

        document.getElementById("editid").value = resposta['dados'].id;
        document.getElementById("editcurso").value = resposta['dados'].curso;
        document.getElementById("editnomeAluno").value = resposta['dados'].nomeAluno;
        document.getElementById("editdataEmprestimo").value = resposta['dados'].dataEmprestimo;
        document.getElementById("edittituloLivro").value = resposta['dados'].tituloLivro;
        document.getElementById("editdataDevolucao").value = resposta['dados'].dataDevolucao;
    } else {
        document.getElementById("msgAlerta").innerHTML = resposta['msg'];
    }
}

const formEditUser = document.getElementById("form-edit-usuario");
if (formEditUser) {
    formEditUser.addEventListener("submit", async(e) => {
        e.preventDefault();
        const dadosForm = new FormData(formEditUser);

        const dados = await fetch("editar.php", {
            method: "POST",
            body: dadosForm
        });

        const resposta = await dados.json();

        if (resposta['status']) {
            
            document.getElementById("msgAlerta").innerHTML = resposta['msg'];
            document.getElementById("msgAlertErroEdit").innerHTML = "";
            
            formEditUser.reset();
            editModal.hide();

            listarDataTables = $('#listar-usuario').DataTable();
            listarDataTables.draw();
        } else {
            document.getElementById("msgAlertErroEdit").innerHTML = resposta['msg'];
        }
    });
}

const baiModal = new bootstrap.Modal(document.getElementById("baiUsuarioModal"));
async function baiUsuario(id) {
    //console.log("Editar: " + id);

    const dados = await fetch('visualizar.php?id=' + id);
    const resposta = await dados.json();
    //console.log(resposta);

    if (resposta['status']) {
        document.getElementById("msgAlertErroBai").innerHTML = "";

        document.getElementById("msgAlerta").innerHTML = "";
        editModal.show();

        document.getElementById("baiid").value = resposta['dados'].id;
        document.getElementById("baisituacao").value = resposta['dados'].situacao;
    } else {
        document.getElementById("msgAlerta").innerHTML = resposta['msg'];
    }
}

const formBaiUser = document.getElementById("form-bai-usuario");
if (formBaiUser) {
    formBaiUser.addEventListener("submit", async(e) => {
        e.preventDefault();
        const dadosForm = new FormData(formBaiUser);

        const dados = await fetch("darbaixa.php", {
            method: "POST",
            body: dadosForm
        });

        const resposta = await dados.json();

        if (resposta['status']) {
            
            document.getElementById("msgAlerta").innerHTML = resposta['msg'];
            document.getElementById("msgAlertErroBai").innerHTML = "";
            
            formBaiUser.reset();
            baiModal.hide();

            listarDataTables = $('#listar-usuario').DataTable();
            listarDataTables.draw();
        } else {
            document.getElementById("msgAlertErroBai").innerHTML = resposta['msg'];
        }
    });
}

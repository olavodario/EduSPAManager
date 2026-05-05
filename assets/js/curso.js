const corpoTabela = document.getElementById("corpoTabela");
const mensagem = document.getElementById("mensagem");
const btnNovo = document.getElementById("btnNovo");
const btnAtualizar = document.getElementById("btnAtualizar");
const modal = document.getElementById("modal");
const idCursoInput = document.getElementById("idCurso");
const nomeCursoInput = document.getElementById("nomeCurso");
const tituloModal = document.getElementById("tituloModal");
const formCurso = document.getElementById("formCurso");
const fecharModal = document.getElementById("fecharModal");
const btnCancelar = document.getElementById("btnCancelar");

// Event Listeners
btnAtualizar.addEventListener("click", listarCursos);
btnNovo.addEventListener("click", abrirModalNovo);
formCurso.addEventListener("submit", salvarCurso);
fecharModal.addEventListener("click", fecharJanelaModal);
btnCancelar.addEventListener("click", fecharJanelaModal);

// Listar cursos ao carregar a página
window.onload = listarCursos;

function listarCursos() {
    corpoTabela.innerHTML = "";
    mensagem.innerText = "Carregando cursos...";
    fetch("assets/php/listarCursos.php")
        .then(resposta => resposta.json())
        .then(cursos => {
            mensagem.innerText = "";
            if (cursos.erro) {
                mensagem.innerText = cursos.mensagem;
                return;
            }
            if (cursos.length === 0) {
                mensagem.innerText = "Nenhum curso cadastrado.";
                return;
            }
            cursos.forEach(curso => criarLinhaTabela(curso));
        })
        .catch(erro => {
            console.error(erro);
            mensagem.innerText = "Erro ao carregar cursos.";
        });
}

function criarLinhaTabela(curso) {
    const linha = document.createElement("tr");
    
    const colunaId = document.createElement("td");
    colunaId.innerText = curso.IDCURSO;
    
    const colunaNome = document.createElement("td");
    colunaNome.innerText = curso.NOME;

    const colunaAcoes = document.createElement("td");

    const btnAlterar = document.createElement("button");
    btnAlterar.innerText = "ALTERAR";
    btnAlterar.className = "btn-alterar";
    btnAlterar.onclick = () => abrirModalAlterar(curso);

    const btnExcluir = document.createElement("button");
    btnExcluir.innerText = "EXCLUIR";
    btnExcluir.className = "btn-excluir";
    btnExcluir.onclick = () => excluirCurso(curso);

    colunaAcoes.appendChild(btnAlterar);
    colunaAcoes.appendChild(btnExcluir);

    linha.appendChild(colunaId);
    linha.appendChild(colunaNome);
    linha.appendChild(colunaAcoes);

    corpoTabela.appendChild(linha);
}

function abrirModalNovo() {
    tituloModal.innerText = "Novo Curso";
    idCursoInput.value = "";
    nomeCursoInput.value = "";
    modal.style.display = "flex";
    nomeCursoInput.focus();
}

function abrirModalAlterar(curso) {
    tituloModal.innerText = "Alterar Curso";
    idCursoInput.value = curso.IDCURSO;
    nomeCursoInput.value = curso.NOME;
    modal.style.display = "flex";
    nomeCursoInput.focus();
}

function fecharJanelaModal() {
    modal.style.display = "none";
    formCurso.reset();
}

function salvarCurso(evento) {
    evento.preventDefault();
    const idCurso = idCursoInput.value;
    const nomeCurso = nomeCursoInput.value.trim();

    if (nomeCurso === "") {
        mensagem.innerText = "O nome do curso deve ser informado.";
        nomeCursoInput.focus();
        return;
    }

    const url = idCurso === "" ? "assets/php/inserirCursos.php" : "assets/php/alterarCursos.php";
    const corpo = new URLSearchParams({ idCurso: idCurso, nome: nomeCurso });

    mensagem.innerText = idCurso === "" ? "Inserindo curso..." : "Alterando curso...";

    fetch(url, {
        method: "POST",
        body: corpo
    })
    .then(resposta => resposta.json())
    .then(dados => {
        mensagem.innerText = dados.mensagem;
        if (!dados.erro) {
            fecharJanelaModal();
            listarCursos();
        }
    })
    .catch(erro => {
        console.error(erro);
        mensagem.innerText = "Erro ao processar a requisição.";
    });
}

function excluirCurso(curso) {
    if (confirm(`Deseja realmente excluir o curso "${curso.NOME}"?`)) {
        mensagem.innerText = "Excluindo curso...";
        fetch("assets/php/excluirCursos.php", {
            method: "POST",
            body: new URLSearchParams({ idCurso: curso.IDCURSO })
        })
        .then(resposta => resposta.json())
        .then(dados => {
            mensagem.innerText = dados.mensagem;
            if (!dados.erro) {
                listarCursos();
            }
        })
        .catch(erro => {
            console.error(erro);
            mensagem.innerText = "Erro ao excluir curso.";
        });
    }
}

const corpoTabela = document.getElementById("corpoTabela");
const mensagem = document.getElementById("mensagem");
const btnNovo = document.getElementById("btnNovo");
const btnAtualizar = document.getElementById("btnAtualizar");
const modal = document.getElementById("modal");
const idPeriodoInput = document.getElementById("idPeriodo");
const nomePeriodoInput = document.getElementById("nomePeriodo");
const tituloModal = document.getElementById("tituloModal");
const formPeriodo = document.getElementById("formPeriodo");
const fecharModal = document.getElementById("fecharModal");
const btnCancelar = document.getElementById("btnCancelar");

//event listeners
btnAtualizar.addEventListener("click", listarPeriodos);
btnNovo.addEventListener("click", abrirModalNovo);
formPeriodo.addEventListener("submit", salvarPeriodo);
fecharModal.addEventListener("click", fecharJanelaModal);
btnCancelar.addEventListener("click", fecharJanelaModal);

window.onLoad = listarPeriodos;

function listarPeriodos() {
    corpoTabela.innerHTML = "";
    mensagem.innerText = "Carregando períodos...";
    fetch("assets/php/listarPeriodos.php")
        .then(resposta => resposta.json())
        .then(periodos => {
            mensagem.innerText = "";
            if (periodos.erro) {
                mensagem.innerText = periodos.mensagem;
                return;
            }

            if (periodos.length === 0) {
                mensagem.innerText = "Nenhum período cadastrado.";
                return;
            }
            periodos.forEach(periodo => criarLinhaTabela(periodo));
        })
        .catch(erro => {
            console.error(erro);
            mensagem.innerText = "Erro ao carregar períodos.";
        });
}

function criarLinhaTabela(periodo) {
    const linha = document.createElement("tr");

    const colunaId = document.createElement("td");
    colunaId.innerText = periodo.IDPERIODO;

    const colunaNome = document.createElement("td");
    colunaNome.innerText = periodo.NOME;

    const colunaAcoes = document.createElement("td");
    const btnAlterar = document.createElement("button");
    btnAlterar.innerText = "ALTERAR";
    btnAlterar.className = "btn-alterar";
    btnAlterar.onclick = () => abrirModalAlterar(periodo);

    const btnExcluir = document.createElement("button");
    btnExcluir.innerText = "EXCLUIR";
    btnExcluir.className = "btn-excluir";
    btnExcluir.onclick = () => excluirPeriodo(periodo);

    colunaAcoes.appendChild(btnAlterar);
    colunaAcoes.appendChild(btnExcluir);

    linha.appendChild(colunaId);
    linha.appendChild(colunaNome);
    linha.appendChild(colunaAcoes);

    corpoTabela.appendChild(linha);
}


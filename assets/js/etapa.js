const corpoTabela = document.getElementById("corpoTabela");
const mensagem = document.getElementById("mensagem");
const btnNovo = document.getElementById("btnNovo");
const btnAtualizar = document.getElementById("btnAtualizar");
const modal = document.getElementById("modal");
const idEtapaInput = document.getElementById("idEtapa");
const nomeEtapaInput = document.getElementById("nomeEtapa");
const tituloModal = document.getElementById("tituloModal");
const formEtapa = document.getElementById("formEtapa");
const fecharModal = document.getElementById("fecharModal");
const btnCancelar = document.getElementById("btnCancelar");

// Event Listeners
btnAtualizar.addEventListener("click", listarEtapas);
btnNovo.addEventListener("click", abrirModalNovo);
formEtapa.addEventListener("submit", salvarEtapa);
fecharModal.addEventListener("click", fecharJanelaModal);
btnCancelar.addEventListener("click", fecharJanelaModal);

// Listar etapas ao carregar a página
window.onload = listarEtapas;

function listarEtapas() {
    corpoTabela.innerHTML = "";
    mensagem.innerText = "Carregando etapas...";
    fetch("assets/php/listarEtapas.php")
        .then(resposta => resposta.json())
        .then(etapas => {
            mensagem.innerText = "";
            if (etapas.erro) {
                mensagem.innerText = etapas.mensagem;
                return;
            }
            if (etapas.length === 0) {
                mensagem.innerText = "Nenhuma etapa cadastrada.";
                return;
            }
            etapas.forEach(etapa => criarLinhaTabela(etapa));
        })
        .catch(erro => {
            console.error(erro);
            mensagem.innerText = "Erro ao carregar etapas.";
        });
}

function criarLinhaTabela(etapa) {
    const linha = document.createElement("tr");
    
    const colunaId = document.createElement("td");
    colunaId.innerText = etapa.IDETAPA;
    
    const colunaNome = document.createElement("td");
    colunaNome.innerText = etapa.NOME;

    const colunaAcoes = document.createElement("td");

    const btnAlterar = document.createElement("button");
    btnAlterar.innerText = "ALTERAR";
    btnAlterar.className = "btn-alterar";
    btnAlterar.onclick = () => abrirModalAlterar(etapa);

    const btnExcluir = document.createElement("button");
    btnExcluir.innerText = "EXCLUIR";
    btnExcluir.className = "btn-excluir";
    btnExcluir.onclick = () => excluirEtapa(etapa);

    colunaAcoes.appendChild(btnAlterar);
    colunaAcoes.appendChild(btnExcluir);

    linha.appendChild(colunaId);
    linha.appendChild(colunaNome);
    linha.appendChild(colunaAcoes);

    corpoTabela.appendChild(linha);
}

function abrirModalNovo() {
    tituloModal.innerText = "Nova Etapa";
    idEtapaInput.value = "";
    nomeEtapaInput.value = "";
    modal.style.display = "flex";
    nomeEtapaInput.focus();
}

function abrirModalAlterar(etapa) {
    tituloModal.innerText = "Alterar Etapa";
    idEtapaInput.value = etapa.IDETAPA;
    nomeEtapaInput.value = etapa.NOME;
    modal.style.display = "flex";
    nomeEtapaInput.focus();
}

function fecharJanelaModal() {
    modal.style.display = "none";
    formEtapa.reset();
}

function salvarEtapa(evento) {
    evento.preventDefault();
    const idEtapa = idEtapaInput.value;
    const nomeEtapa = nomeEtapaInput.value.trim();

    if (nomeEtapa === "") {
        mensagem.innerText = "O nome da etapa deve ser informado.";
        nomeEtapaInput.focus();
        return;
    }

    const url = idEtapa === "" ? "assets/php/inserirEtapas.php" : "assets/php/alterarEtapas.php";
    const corpo = new URLSearchParams({ idEtapa: idEtapa, nome: nomeEtapa });

    mensagem.innerText = idEtapa === "" ? "Inserindo etapa..." : "Alterando etapa...";

    fetch(url, {
        method: "POST",
        body: corpo
    })
    .then(resposta => resposta.json())
    .then(dados => {
        mensagem.innerText = dados.mensagem;
        if (!dados.erro) {
            fecharJanelaModal();
            listarEtapas
            ();
        }
    })
    .catch(erro => {
        console.error(erro);
        mensagem.innerText = "Erro ao processar a requisição.";
    });
}

function excluirEtapa(etapa) {
    if (confirm(`Deseja realmente excluir a etapa "${etapa.NOME}"?`)) {
        mensagem.innerText = "Excluindo etapa...";
        fetch("assets/php/excluirEtapas.php", {
            method: "POST",
            body: new URLSearchParams({ idEtapa: etapa.IDETAPA })
        })
        .then(resposta => resposta.json())
        .then(dados => {
            mensagem.innerText = dados.mensagem;
            if (!dados.erro) {
                listarEtapas();
            }
        })
        .catch(erro => {
            console.error(erro);
            mensagem.innerText = "Erro ao excluir etapa.";
        });
    }
}

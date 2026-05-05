// Arquivo principal do aplicativo SPA para gerenciamento de cursos
// Responsável por controlar a abertura e fechamento do modal

// Selecionando elementos do DOM
const btnNovo = document.getElementById("btn-novo");
const fecharModal = document.getElementById("fecharModal");
const btnCancelar = document.getElementById("btnCancelar");

// Função para abrir o modal
function abrirModal() {
    modal.style.display = "flex";
}

// Função para fechar o modal
function fecharModalJanela() {
    modal.style.display = "none";
}

// Event listeners para os botões
btnNovo.addEventListener("click", abrirModal);
fecharModal.addEventListener("click", fecharModalJanela);

btnCancelar.addEventListener("click", fecharModalJanela);

// Fechar modal ao clicar fora dele
modal.addEventListener("click", function (evento) {
    if (evento.target === modal) {
        fecharModalJanela();
    }
});


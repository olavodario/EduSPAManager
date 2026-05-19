const corpoTabela = document.getElementById("corpoTabela");
const mensagem = document.getElementById("mensagem");
const btnNovo = document.getElementById("btnNovo");
const btnAtualizar = document.getElementById("btnAtualizar");
const modal = document.getElementById("modal");

const idAlunoInput = document.getElementById("idAluno");
const nomeAlunoInput = document.getElementById("nomeAluno");
const cpfAlunoInput = document.getElementById("cpfAluno");
const cpfAlunoInput = document.getElementById("cpfAluno");
const dtNascimentoInput = document.getElementById("dtNascimento");
const cursoAlunoInput = document.getElementById("cursoAluno");
const periodoAlunoInput = document.getElementById("periodoAluno");
const etapaAlunoInput = document.getElementById("etapaAluno");
const tituloModal = document.getElementById("tituloModal");

const formAluno = document.getElementById("formAluno");
const fecharModal = document.getElementById("fecharModal");
const btnCancelar = document.getElementById("btnCancelar");

// Event Listeners
btnAtualizar.addEventListener("click", listarAlunos);
btnNovo.addEventListener("click", abrirModalNovo);
formAluno.addEventListener("submit", salvarAluno);
fecharModal.addEventListener("click", fecharJanelaModal);
btnCancelar.addEventListener("click", fecharJanelaModal);

modal.addEventListener("click", function (evento) {
    if (evento.target === modal) {
        fecharJanelaModal();
    }
});
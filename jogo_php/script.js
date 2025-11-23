class QuizGame {
    constructor() {
        this.perguntas = [];
        this.respostas = {};
        this.perguntaAtual = 0;
        this.carregarQuiz();
    }

    async carregarQuiz() {
        try {
            const response = await fetch('quiz.php?action=carregar');
            const data = await response.json();

            if (data.success) {
                this.perguntas = data.perguntas;
                this.mostrarQuiz();
            } else {
                document.getElementById('loading').innerHTML = 'Erro ao carregar o quiz.';
            }
        } catch (error) {
            console.error('Erro:', error);
            document.getElementById('loading').innerHTML = 'Erro ao conectar com o servidor.';
        }
    }

    mostrarQuiz() {
        document.getElementById('loading').style.display = 'none';
        document.getElementById('quiz-content').style.display = 'block';

        this.atualizarProgresso();
        this.renderizarPergunta();
    }

    renderizarPergunta() {
        const quizContent = document.getElementById('quiz-content');
        const pergunta = this.perguntas[this.perguntaAtual];

        // Verificar se as opções existem
        if (!pergunta.Opções || !Array.isArray(pergunta.Opções)) {
            console.error('Opções não encontradas para a pergunta:', pergunta);
            quizContent.innerHTML = '<p>Erro ao carregar a pergunta.</p>';
            return;
        }

        quizContent.innerHTML = `
            <div class="contador-perguntas">
                Pergunta ${this.perguntaAtual + 1} de ${this.perguntas.length}
            </div>
            <div class="progresso">
                <div class="barra-progresso" style="width: ${((this.perguntaAtual + 1) / this.perguntas.length) * 100}%"></div>
            </div>
            
            <div class="pergunta">
                <h3>${pergunta.Pergunta}</h3>
                <div class="opcoes">
                    ${pergunta.Opções.map((opcao, index) => `
                        <div class="opcao">
                            <input type="radio" id="opcao${index}" name="resposta" value="${this.escapeHtml(opcao)}">
                            <label for="opcao${index}">${this.escapeHtml(opcao)}</label>
                        </div>
                    `).join('')}
                </div>
            </div>
            
            <button onclick="quiz.avancarPergunta()">
                ${this.perguntaAtual === this.perguntas.length - 1 ? 'Finalizar Quiz' : 'Próxima Pergunta'}
            </button>
        `;

        // Marcar resposta anterior se existir
        const respostaAnterior = this.respostas[this.perguntaAtual];
        if (respostaAnterior) {
            const radio = document.querySelector(`input[value="${this.escapeHtml(respostaAnterior)}"]`);
            if (radio) radio.checked = true;
        }
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    avancarPergunta() {
        const respostaSelecionada = document.querySelector('input[name="resposta"]:checked');

        if (!respostaSelecionada) {
            alert('Por favor, selecione uma resposta!');
            return;
        }

        this.respostas[this.perguntaAtual] = respostaSelecionada.value;

        if (this.perguntaAtual < this.perguntas.length - 1) {
            this.perguntaAtual++;
            this.renderizarPergunta();
        } else {
            this.finalizarQuiz();
        }
    }

    async finalizarQuiz() {
        try {
            const response = await fetch('quiz.php?action=corrigir', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    respostas: this.respostas
                })
            });

            const resultado = await response.json();
            this.mostrarResultado(resultado);
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao enviar respostas.');
        }
    }

    mostrarResultado(resultado) {
        document.getElementById('quiz-content').style.display = 'none';
        document.getElementById('results').style.display = 'block';

        const scoreElement = document.getElementById('score');
        scoreElement.innerHTML = `
            <h3>Você acertou ${resultado.acertos} de ${resultado.total} perguntas!</h3>
            <p>Porcentagem de acerto: <strong>${resultado.porcentagem}%</strong></p>
            ${resultado.porcentagem >= 70 ?
                '<p style="color: #27ae60; margin-top: 10px;">🎉 Parabéns! Excelente desempenho!</p>' :
                '<p style="color: #e74c3c; margin-top: 10px;">💪 Continue estudando, você vai melhorar!</p>'
            }
        `;
    }

    atualizarProgresso() {
        // Progresso é atualizado no renderizarPergunta
    }
}

// Instância global do quiz
const quiz = new QuizGame();

// Função global para reiniciar
function reiniciarQuiz() {
    document.getElementById('results').style.display = 'none';
    document.getElementById('quiz-content').style.display = 'none';
    document.getElementById('loading').style.display = 'block';

    quiz.perguntas = [];
    quiz.respostas = {};
    quiz.perguntaAtual = 0;

    quiz.carregarQuiz();
}
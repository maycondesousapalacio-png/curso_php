// Função para confirmar exclusões
function confirmarExclusao() {
    return confirm('Tem certeza que deseja excluir este registro?');
}

// Máscara para telefone
function mascaraTelefone(telefone) {
    telefone = telefone.replace(/\D/g, '');
    telefone = telefone.replace(/^(\d{2})(\d)/g, '($1) $2');
    telefone = telefone.replace(/(\d)(\d{4})$/, '$1-$2');
    return telefone;
}

// Formatação de preço
function formatarPreco(preco) {
    return 'R$ ' + parseFloat(preco).toFixed(2).replace('.', ',');
}

// Cálculo de totais
function calcularTotal() {
    let total = 0;
    document.querySelectorAll('.item-total').forEach(item => {
        total += parseFloat(item.textContent.replace('R$ ', '').replace(',', '.'));
    });
    document.getElementById('total-geral').textContent = formatarPreco(total);
}

// Controle de quantidade nos itens
function atualizarQuantidade(button, change) {
    const container = button.closest('.quantity-control');
    const input = container.querySelector('input');
    let quantidade = parseInt(input.value) + change;

    if (quantidade < 0) quantidade = 0;

    input.value = quantidade;
    atualizarSubtotal(container, quantidade);
}

function atualizarSubtotal(container, quantidade) {
    const precoUnitario = parseFloat(container.dataset.preco);
    const subtotal = precoUnitario * quantidade;
    const subtotalElement = container.closest('.sabor-card').querySelector('.subtotal');

    subtotalElement.textContent = formatarPreco(subtotal);
    calcularTotal();
}

// Validação de formulário
function validarFormulario(form) {
    const inputs = form.querySelectorAll('input[required], select[required]');
    let valido = true;

    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.style.borderColor = 'red';
            valido = false;
        } else {
            input.style.borderColor = '#ffe4e9';
        }
    });

    return valido;
}

// Aplicar máscaras e funcionalidades
document.addEventListener('DOMContentLoaded', function () {
    // Máscara para telefone
    const telefoneInputs = document.querySelectorAll('input[name="telefone"]');
    telefoneInputs.forEach(input => {
        input.addEventListener('input', function (e) {
            e.target.value = mascaraTelefone(e.target.value);
        });
    });

    // Formatação de preços
    const precoElements = document.querySelectorAll('.price');
    precoElements.forEach(element => {
        if (!element.textContent.includes('R$')) {
            element.textContent = formatarPreco(element.textContent);
        }
    });

    // Validação de data de entrega
    const dataEntregaInputs = document.querySelectorAll('input[name="data_entrega"]');
    dataEntregaInputs.forEach(input => {
        input.addEventListener('change', function (e) {
            const hoje = new Date().toISOString().split('T')[0];
            if (e.target.value < hoje) {
                alert('A data de entrega deve ser futura!');
                e.target.value = '';
            }
        });
    });
});

// Função para adicionar item ao pedido
function adicionarItemAoCarrinho(saborId, saborNome, preco, quantidade) {
    if (quantidade > 0) {
        // Implementar lógica do carrinho aqui
        console.log(`Adicionado: ${quantidade}x ${saborNome} - ${formatarPreco(preco * quantidade)}`);
    }
}

// Adicione estas funções ao arquivo script.js existente

// Funções específicas para encomendas
function validarDataEntrega(dataEntrega) {
    const hoje = new Date();
    const dataSelecionada = new Date(dataEntrega);
    return dataSelecionada >= hoje;
}

// Impedir datas passadas
document.addEventListener('DOMContentLoaded', function () {
    const dataEntregaInputs = document.querySelectorAll('input[name="data_entrega"]');
    dataEntregaInputs.forEach(input => {
        const hoje = new Date().toISOString().split('T')[0];
        input.min = hoje;

        input.addEventListener('change', function (e) {
            if (!validarDataEntrega(e.target.value)) {
                alert('A data de entrega deve ser hoje ou futura!');
                e.target.value = hoje;
            }
        });
    });
});

// Gerar comprovante (para futura implementação)
function gerarComprovante(encomendaId) {
    window.open(`comprovante.php?id=${encomendaId}`, '_blank');
}

// Notificação de status
function mostrarNotificacaoStatus(mensagem, tipo = 'success') {
    const notificacao = document.createElement('div');
    notificacao.className = `alert alert-${tipo}`;
    notificacao.textContent = mensagem;
    notificacao.style.position = 'fixed';
    notificacao.style.top = '20px';
    notificacao.style.right = '20px';
    notificacao.style.zIndex = '1000';

    document.body.appendChild(notificacao);

    setTimeout(() => {
        notificacao.remove();
    }, 3000);
}
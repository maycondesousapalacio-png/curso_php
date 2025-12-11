// Função para confirmar exclusões
function confirmarExclusao() {
    return confirm('Tem certeza que deseja excluir este registro?');
}

// Função para buscar endereço pelo CEP
function buscarCEP() {
    const cep = document.getElementById('cep').value.replace(/\D/g, '');

    if (cep.length !== 8) {
        return;
    }

    fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(response => response.json())
        .then(data => {
            if (!data.erro) {
                document.getElementById('endereco').value = data.logradouro;
                document.getElementById('bairro').value = data.bairro;
                document.getElementById('cidade').value = data.localidade;
                document.getElementById('estado').value = data.uf;
            }
        })
        .catch(error => console.error('Erro ao buscar CEP:', error));
}

// Validação de formulário
function validarFormulario(form) {
    const inputs = form.querySelectorAll('input[required]');
    let valido = true;

    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.style.borderColor = 'red';
            valido = false;
        } else {
            input.style.borderColor = '#ddd';
        }
    });

    return valido;
}

// Máscara para telefone
function mascaraTelefone(telefone) {
    telefone = telefone.replace(/\D/g, '');
    telefone = telefone.replace(/^(\d{2})(\d)/g, '($1) $2');
    telefone = telefone.replace(/(\d)(\d{4})$/, '$1-$2');
    return telefone;
}

// Aplicar máscaras nos campos
document.addEventListener('DOMContentLoaded', function () {
    const telefoneInputs = document.querySelectorAll('input[name="telefone"]');
    telefoneInputs.forEach(input => {
        input.addEventListener('input', function (e) {
            e.target.value = mascaraTelefone(e.target.value);
        });
    });

    const cepInputs = document.querySelectorAll('input[name="cep"]');
    cepInputs.forEach(input => {
        input.addEventListener('blur', buscarCEP);
    });
});

// Adicione estas funções ao arquivo script.js existente

// Formatação de data para o campo datetime-local
function formatarDataParaInput(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toISOString().slice(0, 16);
}

// Validação de data futura para consultas
function validarDataConsulta(dataConsulta) {
    const agora = new Date();
    const dataSelecionada = new Date(dataConsulta);
    return dataSelecionada > agora;
}

// Máscara para CEP
function mascaraCEP(cep) {
    cep = cep.replace(/\D/g, '');
    cep = cep.replace(/^(\d{5})(\d)/, '$1-$2');
    return cep;
}

// Aplicar máscaras adicionais
document.addEventListener('DOMContentLoaded', function () {
    // Máscara para CEP
    const cepInputs = document.querySelectorAll('input[name="cep"]');
    cepInputs.forEach(input => {
        input.addEventListener('input', function (e) {
            e.target.value = mascaraCEP(e.target.value);
        });
    });

    // Validação de data para consultas
    const dataConsultaInputs = document.querySelectorAll('input[name="data_consulta"]');
    dataConsultaInputs.forEach(input => {
        input.addEventListener('change', function (e) {
            if (!validarDataConsulta(e.target.value)) {
                alert('A data da consulta deve ser futura!');
                e.target.value = '';
            }
        });
    });
});
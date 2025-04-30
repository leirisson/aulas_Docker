/* 
 * Script para gerenciamento de registros
 * 
 */

/**
 * Dados da tabela atual de acordo com os filtros aplicados
 * @type json
 */
var tabelaRegistros;
var urlBaseListar = 'recessos/lista';
var urlBaseCadastrarEditar = 'recessos/cadastrar-editar-recesso';

/**
 * Função utilizada na tabela de registros para exibir uma determinada informacao
 * @param {type} value
 * @param {type} row
 * @returns {String}
 */
function formatarPeriodoRecesso(value, row){
    return formatarData(row.data_inicio,null) + " a " + formatarData(row.data_fim, null);
}

/**
 * Atualiza tabela de registros
 */
function listarRegistros() {
    tabelaRegistros.bootstrapTable('refresh', {
        url: urlBaseListar
    });
}

$(document).ready(function () {
    tabelaRegistros = $('#tabela');

    var botaoCadastrarNovoRegistro = $("#button-novo");
    
    /*
     * Chamada para a funcao de listagem de registros.
     */
    $.get(urlBaseListar, function (data) {
        tabelaRegistros.bootstrapTable({
            data: data
        });
    });

    tabelaRegistros.bootstrapTable({
        exportDataType: 'all',
        contextMenu: '#ul-menu-contexto-tabela',
        contextMenuTrigger: 'both',
        onContextMenuRow: function (row, $el) {
            tabelaRegistros.find('.info').removeClass('info');
            $el.addClass('info');
        },
        onContextMenuItem: function (row, $el) {
            var opcaoSelecionada = $el.data("item");
            var id = row.id;

            switch (opcaoSelecionada) {
                case "alterar":
                    window.location.href = urlBaseCadastrarEditar +"/" + id;
                    break;
            }
        }
    });

    botaoCadastrarNovoRegistro.click(function () {
        window.location.href = urlBaseCadastrarEditar;
    });

    $('#div-periodo').datepicker({
        format: "dd/mm/yyyy",
        language: "pt-BR"
    });

    $('#input-data-inicio').on('keydown', function (event) {

        event.preventDefault();
        alert('Por favor, utilize o calendário.');
    });
    $('#input-data-fim').on('keydown', function (event) {
        event.preventDefault();
        alert('Por favor, utilize o calendário.');
    });
});
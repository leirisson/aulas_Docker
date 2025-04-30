/* 
 * Script para gerenciamento de frequencias
 * 
 */

/**
 * Dados da tabela atual de acordo com os filtros aplicados
 * @type json
 */
var dadosTabela;
var tabelaRegistros;
var urlBaseListar = 'avaliar-frequencia/lista/';
var urlBaseVisualizarDez = 'avaliar-frequencia/visualizar-dez/';
var urlBaseVisualizarJan = 'avaliar-frequencia/visualizar-jan/';

/*
 *Esta função busca a lista de frequencias e a carrega (load)
 *na tabela de frequencias lista.blade.php 
 */
function listarRegistros(idRecesso) {
    idRecesso = typeof idRecesso !== 'undefined' ? idRecesso : null;
    tabelaRegistros.bootstrapTable('refresh', {
        url: urlBaseListar + idRecesso
    });
}

function formatarRegistroMaisRecente(value, row) {
    if (value !== null) {
        value.sort(function (a, b) {
            return Date.parse(a.updated_at) - Date.parse(b.updated_at);
        });

        var maxT = value[value.length - 1];
        if (formatarHoraRemoveSegundos(maxT.saida2) !== null) {
            return formatarData(maxT.dia_id, null) + " - Saída: " + formatarHoraRemoveSegundos(maxT.saida2);
        }
        if (formatarHoraRemoveSegundos(maxT.entrada2) !== null) {
            return formatarData(maxT.dia_id, null) + " - Entrada: " + formatarHoraRemoveSegundos(maxT.saida2);
        }
        if (formatarHoraRemoveSegundos(maxT.saida1) !== null) {
            return formatarData(maxT.dia_id, null) + " - Saída: " + formatarHoraRemoveSegundos(maxT.saida1);
        }
        if (formatarHoraRemoveSegundos(maxT.entrada1) !== null) {
            return formatarData(maxT.dia_id, null) + " - Entrada: " + formatarHoraRemoveSegundos(maxT.entrada1);
        }
        return formatarData(maxT.dia_id, null);
    } else {
        return "";
    }
}
function formatarEventosPagamento(value, row) {
    var textoFinal = "";
    jQuery.each(value, function (i, val) {
        if (!val.opcao) {
            textoFinal = textoFinal + formatarDataDia(val.dia_id, null) + "; ";
        }
    });
    return textoFinal;
}

function configurarMenuPedido(row, $el) {
    if (verificaEscaladoDez(row.frequencia)) {
        $('.frequencia-aberta-dez').show();
    } else {
        $('.frequencia-aberta-dez').hide();
    }
    
    if (verificaEscaladoJan(row.frequencia)) {
        $('.frequencia-aberta-jan').show();
    } else {
        $('.frequencia-aberta-jan').hide();
    }
}

$(document).ready(function () {
    tabelaRegistros = $('#tabela-avaliacoes');

    var selectRecessos = $('#select-recessos');
    selectRecessos.on('change', function () {
        listarRegistros($(this).val());
    });


    var modalConfirmarValidarFrequenciaDez = $("#modal-validar-frequencia-dez");
    var botaoConfirmarValidarFrequenciaDez = $('#button-confirma-validacao-dez');
    var urlBaseValidarFrequenciaDez = 'avaliar-frequencia/validar-dez/';

    var modalConfirmarValidarFrequenciaJan = $("#modal-validar-frequencia-jan");
    var botaoConfirmarValidarFrequenciaJan = $('#button-confirma-validacao-jan');
    var urlBaseValidarFrequenciaJan = 'avaliar-frequencia/validar-jan/';

    botaoConfirmarValidarFrequenciaDez.click(function () {
        var id = modalConfirmarValidarFrequenciaDez.data('frequenciaid');
        $.ajax({
            url: urlBaseValidarFrequenciaDez + id,
            success: function (resposta) {
                exibirAlertaBootstrap(resposta.mensagem, resposta.classe);
                listarRegistros();
            }
        });
        modalConfirmarValidarFrequenciaDez.modal('toggle');
    });

    botaoConfirmarValidarFrequenciaJan.click(function () {
        var id = modalConfirmarValidarFrequenciaJan.data('frequenciaid');
        $.ajax({
            url: urlBaseValidarFrequenciaJan + id,
            success: function (resposta) {
                exibirAlertaBootstrap(resposta.mensagem, resposta.classe);
                listarRegistros();
            }
        });
        modalConfirmarValidarFrequenciaJan.modal('toggle');
    });

    tabelaRegistros.bootstrapTable({
        exportDataType: 'all',
        contextMenu: '#ul-menu-contexto-tabela-frequencia',
        contextMenuTrigger: 'both',
        formatNoMatches: function (row, $el) {
            return "Nenhuma frequência para você validar no recesso selecionado";
        },
        onContextMenuRow: function (row, $el) {
            configurarMenuPedido(row, $el);
            tabelaRegistros.find('.info').removeClass('info');
            $el.addClass('info');
        },
        onContextMenuItem: function (row, $el) {
            var opcaoSelecionada = $el.data("item");
            var modalAguarde = $('#div-modal-msg-aguarde');
            var modalVisualizarDez = $('#modal-visualizar-frequencia-dez');
            var modalVisualizarJan = $('#modal-visualizar-frequencia-jan');
            var modalValidarFrequenciaDez = $("#modal-validar-frequencia-dez");
            var modalValidarFrequenciaJan = $("#modal-validar-frequencia-dez");
            var paragrafoMensagemDez = $('#p-mensagem-validar-dez');
            var paragrafoMensagemJan = $('#p-mensagem-validar-jan');
            var id = row.frequencia.id;

            switch (opcaoSelecionada) {
                case "visualizar-dez":
                    modalAguarde.modal();
                    modalVisualizarDez.data('frequenciaid', row.frequencia.id).data('nome_servidor', row.frequencia.servidor_escalado.nome).load((urlBaseVisualizarDez + id), function () {
                        modalAguarde.modal('hide');
                        modalVisualizarDez.modal();
                    });
                    break;
                case "visualizar-jan":
                    modalAguarde.modal();
                    modalVisualizarJan.data('frequenciaid', row.frequencia.id).data('nome_servidor', row.frequencia.servidor_escalado.nome).load((urlBaseVisualizarJan + id), function () {
                        modalAguarde.modal('hide');
                        modalVisualizarJan.modal();
                    });
                    break;
                case "validar-dez":
                    paragrafoMensagemDez.text('Tem certeza que deseja validar a frequencia do mês de Dezembro do servidor ' + row.frequencia.servidor_escalado.nome + '?');
                    //Passando dados para um modal
                    modalValidarFrequenciaDez.data('frequenciaid', row.frequencia.id).modal();
                    break;
                case "validar-jan":
                    paragrafoMensagemJan.text('Tem certeza que deseja validar a frequencia do mês de Janeiro do servidor ' + row.frequencia.servidor_escalado.nome + '?');
                    //Passando dados para um modal
                    modalValidarFrequenciaJan.data('frequenciaid', row.frequencia.id).modal();
                    break;
            }
        }
    });

    /*
     * Para que o tooltip bootstrap da frequencia funcione
     */
    tabelaRegistros.on('post-body.bs.table', function () {
        $('[data-toggle="tooltip"]').tooltip({
            container: 'body'
        });
    });
});
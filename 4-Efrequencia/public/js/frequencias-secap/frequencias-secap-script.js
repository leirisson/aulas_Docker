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
var urlBaseListar = 'frequencias/listar-frequencias/';
var urlBaseEditar = 'frequencias/editar-chefia/';
var urlBaseVisualizar = 'frequencias/visualizar/';

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

function formatarChefiaAvaliacaoDez(value, row) {
    var textoFinal = "";
    jQuery.each(value, function (i, val) {
        textoFinal = textoFinal + (val.servidor_dez?val.servidor_dez.nome:"") + " ";
    });
    return textoFinal;
}

function formatarChefiaAvaliacaoJan(value, row) {
    var textoFinal = "";
    jQuery.each(value, function (i, val) {
        textoFinal = textoFinal + (val.servidor_jan?val.servidor_jan.nome:"") + " ";
    });
    return textoFinal;
}

function formatarStatusDezembro(value, row) {
    var textoFinal = "NÃO ESCALADO";
    var escaladoDezembro = false;
    
    jQuery.each(row.eventos, function (i, val) {
        if (val.dia_id.includes("-12-")) {
            escaladoDezembro = true;
        }
    });

    if (escaladoDezembro) {
        textoFinal = value;
    }

    return textoFinal;
}

function formatarStatusJaneiro(value, row) {
    var textoFinal = "NÃO ESCALADO";
    var escaladoJaneiro = false;
    
    jQuery.each(row.eventos, function (i, val) {
        if (val.dia_id.includes("-01-")) {
            escaladoJaneiro = true;
        }
    });

    if (escaladoJaneiro) {
        textoFinal = value;
    }

    return textoFinal;
}

function configurarMenuFrequencia(row, $el) {
    if (verificaStatusFechado(row.status_id)) {
        $('.frequencia-aberta').hide();
    } else {
        $('.frequencia-aberta').show();
    }
    if (row.avaliacoes.length === 0) {
        $('.redefinir-chefia').hide();
    } else {
        if (verificaStatusFechado(row.status_id)) {
            $('.redefinir-chefia').hide();
        } else {
            $('.redefinir-chefia').show();
        }
    }
}
$(document).ready(function () {

    tabelaRegistros = $('#tabela-frequencias');

    var selectRecessos = $('#select-recessos');
    selectRecessos.on('change', function () {
        listarRegistros($(this).val());
    });

    var botaoAbrirModalNovo = $("#button-novo-frequencia");
    var modalNovoRegistro = $("#modal-novo-frequencia");


    var formNovoRegistro = $('#form-novo-frequencia');
    var botaoCadastrarRegistro = $('#button-novo-frequencia-enviar');
    var urlBaseAdicionar = 'registrar-frequencia/adicionar';

    var modalConfirmarExclusao = $("#modal-confirma-exclusao");
    var botaoConfirmarExclusao = $('#button-confirma-exclusao');
    var urlBaseDeletar = 'registrar-frequencia/deletar/';

    tabelaRegistros.bootstrapTable({
        exportDataType: 'all',
        contextMenu: '#ul-menu-contexto-tabela-frequencia',
        contextMenuTrigger: 'both',
        formatNoMatches: function (row, $el) {
            return "Por enquanto, nenhuma frequência";
        },
        onContextMenuRow: function (row, $el) {
            configurarMenuFrequencia(row, $el);
            tabelaRegistros.find('.info').removeClass('info');
            $el.addClass('info');
        },
        onContextMenuItem: function (row, $el) {
            var opcaoSelecionada = $el.data("item");
            var modalAguarde = $('#div-modal-msg-aguarde');
            var modalEditar = $('#modal-editar-evento');
            var modalEditarChefia = $("#modal-editar-chefia");
            var modalVisualizar = $('#modal-visualizar-frequencia');
            var id = row.id;

            /*
             * Configuração página para PDF
             */
            var urlBaseRelatorioDez = "frequencias/versao-pdf-dez/" + row.id;
            var urlBaseRelatorioJan = "frequencias/versao-pdf-jan/" + row.id;



            switch (opcaoSelecionada) {
                case "alterar":
                    modalAguarde.modal();
                    modalEditar.load((urlBaseEditar + id), function () {
                        modalAguarde.modal('hide');
                        modalEditar.modal();
                    });
                    break;
                case "visualizar":
                    modalAguarde.modal();
                    modalVisualizar.data('frequenciaid', row.id).data('nome_servidor', row.servidor_escalado.nome).load((urlBaseVisualizar + id), function () {
                        modalAguarde.modal('hide');
                        modalVisualizar.modal();
                    });
                    break;

                case "definir-chefia":
                    modalEditarChefia.data('frequenciaid', row.id).load((urlBaseEditar + id), function () {
                        modalAguarde.modal('hide');
                        modalEditarChefia.modal();
                    });
                    break;
                case "versao-pdf-dez":
                    dadosTabela = tabelaRegistros.bootstrapTable('getData');
                    window.open(urlBaseRelatorioDez);
                    break;
                case "versao-pdf-jan":
                    dadosTabela = tabelaRegistros.bootstrapTable('getData');
                    window.open(urlBaseRelatorioJan);
                    break;
            }
        }
    });

    botaoConfirmarExclusao.click(function () {
        var id = modalConfirmarExclusao.data('frequenciaid');
        $.ajax({
            url: urlBaseDeletar + id,
            success: function (resposta) {
                exibirAlertaBootstrap(resposta.mensagem, resposta.classe);
                listarRegistros();
            }
        });
        modalConfirmarExclusao.modal('toggle');
    });

    /*
     * Ao clicar no modal, exibir formulario de novo frequencia.
     */
    botaoAbrirModalNovo.click(function () {
        modalNovoRegistro.modal();
    });

    /*
     * Envia nova frequencia para persistência no banco de dados
     * Ao retornar, atualiza a lista de frequencias por meio do metodo
     * listarRegistros()
     */
    formNovoRegistro.submit(function (event) {
        event.preventDefault();
        //Evitar duplo click
        botaoCadastrarRegistro.prop('disabled', true);
        var form = $(this);
        var data = form.serialize();
        $.ajax({
            url: urlBaseAdicionar,
            data: data,
            method: 'POST',
            success: function (resposta) {
                exibirAlertaBootstrap(resposta.mensagem, resposta.classe);
                modalNovoRegistro.modal('toggle');
                botaoCadastrarRegistro.prop('disabled', false);
                $('#select-servidores').val('').trigger('change');
                listarRegistros();

            },
            error: function (resposta) {
                botaoCadastrarRegistro.prop('disabled', false);

            }
        });

    });

    /*
     * Configuração página para PDF
     */
    var botaoPaginaImpressao = $('#button');
    var urlBaseRelatorio = "registrar-frequencia/relatorio-eventos";
    botaoPaginaImpressao.click(function () {
        dadosTabela = tabelaRegistros.bootstrapTable('getData');
        window.open(urlBaseRelatorio);
    });

    /*
     * Configurando select-servidores para pesquisa
     */
    var selectServidores = $('#select-servidores');
    selectServidores.select2();
    selectServidores.on('change', function (event) {
        var idServidor = selectServidores.val();
        //Verificar se já não está cadastrado.
    });





});
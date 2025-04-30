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
var urlBaseListar = 'registrar-frequencia/lista/';
var urlBaseEditar = 'registrar-frequencia/editar/';

/*
 *Esta função busca a lista de frequencias e a carrega (load)
 *na tabela de frequencias lista.blade.php 
 */
function listarRegistros(idFrequencia) {
    idFrequencia = typeof idFrequencia !== 'undefined' ? idFrequencia : null;
    tabelaRegistros.bootstrapTable('refresh', {
        url: urlBaseListar + idFrequencia
    });
}

function formatarOpcao(value, row) {
    return value ? 'FOLGA' : 'PAGAMENTO';
}

function configurarMenuPedido(row, $el) {
    if (verificaStatusFechadoPorMes(row)) {
        $('.frequencia-aberta').hide();
    } else {
        $('.frequencia-aberta').show();
    }
}

$(document).ready(function () {
    tabelaRegistros = $('#tabela-eventos');

    var botaoAbrirModalNovo = $("#button-novo-frequencia");
    var modalNovoRegistro = $("#modal-novo-frequencia");


    var formNovoRegistro = $('#form-novo-frequencia');
    var botaoCadastrarRegistro = $('#button-novo-frequencia-enviar');
    var urlBaseAdicionar = 'registrar-frequencia/adicionar';

    var modalConfirmarExclusao = $("#modal-confirma-exclusao");
    var botaoConfirmarExclusao = $('#button-confirma-exclusao');
    var urlBaseDeletar = 'registrar-frequencia/deletar/';

    var botaoAbrirModalEnvioChefia = $("#button-abrir-modal-envio-chefia");
    var botaoAbrirModalEnvioChefiaDez = $("#button-abrir-modal-envio-chefia-dez");
    var botaoAbrirModalEnvioChefiaJan = $("#button-abrir-modal-envio-chefia-jan");

    var modalConfirmarEnvioChefia = $("#modal-confirma-envio-chefia");
    var modalConfirmarEnvioChefiaDez = $("#modal-confirma-envio-chefia-dez");
    var modalConfirmarEnvioChefiaJan = $("#modal-confirma-envio-chefia-jan");

    var botaoConfirmarEnvioChefia = $('#button-confirma-envio-chefia');
    var botaoConfirmarEnvioChefiaDez = $('#button-confirma-envio-chefia-dez');
    var botaoConfirmarEnvioChefiaJan = $('#button-confirma-envio-chefia-jan');

    var urlBaseEnvioChefia = 'registrar-frequencia/fechar-e-disponibilizar/';
    var urlBaseEnvioChefiaDez = 'registrar-frequencia/fechar-e-disponibilizar-dez/';
    var urlBaseEnvioChefiaJan = 'registrar-frequencia/fechar-e-disponibilizar-jan/';

    var botaoAbrirModalDesfazerEnvioChefia = $("#button-abrir-modal-desfazer-envio-chefia");
    var botaoAbrirModalDesfazerEnvioChefiaDez = $("#button-abrir-modal-desfazer-envio-chefia-dez");
    var botaoAbrirModalDesfazerEnvioChefiaJan = $("#button-abrir-modal-desfazer-envio-chefia-jan");

    var modalConfirmarDesfazerEnvioChefia = $("#modal-desfazer-envio-chefia");
    var modalConfirmarDesfazerEnvioChefiaDez = $("#modal-desfazer-envio-chefia-dez");
    var modalConfirmarDesfazerEnvioChefiaJan = $("#modal-desfazer-envio-chefia-jan");

    var botaoConfirmarDesfazerEnvioChefia = $('#button-confirma-desfazer-envio-chefia');
    var botaoConfirmarDesfazerEnvioChefiaDez = $('#button-confirma-desfazer-envio-chefia-dez');
    var botaoConfirmarDesfazerEnvioChefiaJan = $('#button-confirma-desfazer-envio-chefia-jan');

    var urlBaseDesfazerEnvioChefia = 'registrar-frequencia/reabrir-frequencia/';
    var urlBaseDesfazerEnvioChefiaDez = 'registrar-frequencia/reabrir-frequencia-dez/';
    var urlBaseDesfazerEnvioChefiaJan = 'registrar-frequencia/reabrir-frequencia-jan/';

    var selectFrequencias = $('#select-frequencia-registro');
    selectFrequencias.on('change', function () {
        $("#input-frequencia-id").val($(this).val());
        atualizaBotoesEnvio($(this).val());
        listarRegistros($(this).val());
    });
    var urlConsultaFrequencia = 'registrar-frequencia/consulta-frequencia/';

    function atualizaBotoesEnvio(id) {

        botaoAbrirModalEnvioChefiaDez.hide();
        botaoAbrirModalDesfazerEnvioChefiaDez.hide();

        botaoAbrirModalEnvioChefiaJan.hide();
        botaoAbrirModalDesfazerEnvioChefiaJan.hide();
        $.ajax({
            url: urlConsultaFrequencia + id,
            success: function (resposta) {

                //exibirAlertaBootstrap('Status_Dezembro:' + resposta.status_id_dez, 'alert alert-danger');
                if (resposta.tem_dezembro) {
                    if (resposta.frequencia.status_id_dez === 1) {
                        botaoAbrirModalEnvioChefiaDez.show();
                        botaoAbrirModalDesfazerEnvioChefiaDez.hide();
                    }
                    if (resposta.frequencia.status_id_dez === 2) {
                        botaoAbrirModalEnvioChefiaDez.hide();
                        botaoAbrirModalDesfazerEnvioChefiaDez.show();
                    }
                    if (resposta.frequencia.status_id_dez > 2) {
                        botaoAbrirModalEnvioChefiaDez.hide();
                        botaoAbrirModalDesfazerEnvioChefiaDez.hide();
                    }
                } else {
                    botaoAbrirModalEnvioChefiaDez.hide();
                    botaoAbrirModalDesfazerEnvioChefiaDez.hide();
                }
                if (resposta.tem_janeiro) {
                    if (resposta.frequencia.status_id_jan === 1) {
                        botaoAbrirModalEnvioChefiaJan.show();
                        botaoAbrirModalDesfazerEnvioChefiaJan.hide();
                    }
                    if (resposta.frequencia.status_id_jan === 2) {
                        botaoAbrirModalEnvioChefiaJan.hide();
                        botaoAbrirModalDesfazerEnvioChefiaJan.show();
                    }
                    if (resposta.frequencia.status_id_jan > 2) {
                        botaoAbrirModalEnvioChefiaJan.hide();
                        botaoAbrirModalDesfazerEnvioChefiaJan.hide();
                    }
                } else {
                    botaoAbrirModalEnvioChefiaJan.hide();
                    botaoAbrirModalDesfazerEnvioChefiaJan.hide();
                }




            }
        });
    }

    atualizaBotoesEnvio($("#input-frequencia-id").val());


    tabelaRegistros.bootstrapTable({
        exportDataType: 'all',
        contextMenu: '#ul-menu-contexto-tabela-frequencia',
        contextMenuTrigger: 'both',
        onContextMenuRow: function (row, $el) {
            configurarMenuPedido(row, $el);
            tabelaRegistros.find('.info').removeClass('info');
            $el.addClass('info');
        },
        onContextMenuItem: function (row, $el) {
            var opcaoSelecionada = $el.data("item");
            var modalAguarde = $('#div-modal-msg-aguarde');
            var modalEditar = $('#modal-editar-evento');
            var modalConfirmarExclusao = $("#modal-confirma-exclusao");
            var paragrafoMensagem = $('#p-mensagem-excluir');
            var id = row.id;

            switch (opcaoSelecionada) {
                case "alterar":
                    modalAguarde.modal();
                    modalEditar.load((urlBaseEditar + id), function () {
                        modalAguarde.modal('hide');
                        modalEditar.modal();
                    });
                    break;
                case "deletar":
                    paragrafoMensagem.text('Tem certeza que deseja apagar os registros das horas do dia ' + formatarData(row.dia_id) + '?');
                    //Passando dados para um modal
                    modalConfirmarExclusao.data('frequenciaid', row.id).modal();
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
                listarRegistros($('#input-frequencia-id').val());
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
    var urlBaseRelatorio = "registrar-frequencia/versao-pdf/";
    botaoPaginaImpressao.click(function () {
        dadosTabela = tabelaRegistros.bootstrapTable('getData');
        window.open(urlBaseRelatorio+$("#input-frequencia-id").val());
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

    botaoAbrirModalEnvioChefiaDez.click(function () {
        modalConfirmarEnvioChefiaDez.modal();
    });

    botaoConfirmarEnvioChefiaDez.click(function () {
        var id = $('#input-frequencia-id').val();
        $.ajax({
            url: urlBaseEnvioChefiaDez + id,
            success: function (resposta) {
                exibirAlertaBootstrap(resposta.mensagem, resposta.classe);
                listarRegistros($('#input-frequencia-id').val());
                atualizaBotoesEnvio($('#input-frequencia-id').val());
                //location.reload();
            }
        });
        modalConfirmarEnvioChefiaDez.modal('toggle');
    });

    botaoAbrirModalDesfazerEnvioChefiaDez.click(function () {
        modalConfirmarDesfazerEnvioChefiaDez.modal();
    });

    botaoConfirmarDesfazerEnvioChefiaDez.click(function () {
        var id = $('#input-frequencia-id').val();
        $.ajax({
            url: urlBaseDesfazerEnvioChefiaDez + id,
            success: function (resposta) {
                exibirAlertaBootstrap(resposta.mensagem, resposta.classe);
                listarRegistros($('#input-frequencia-id').val());
                atualizaBotoesEnvio($('#input-frequencia-id').val());
                //location.reload();
            }
        });
        modalConfirmarDesfazerEnvioChefiaDez.modal('toggle');
    });



    botaoAbrirModalEnvioChefiaJan.click(function () {
        modalConfirmarEnvioChefiaJan.modal();
    });

    botaoConfirmarEnvioChefiaJan.click(function () {
        var id = $('#input-frequencia-id').val();
        $.ajax({
            url: urlBaseEnvioChefiaJan + id,
            success: function (resposta) {
                exibirAlertaBootstrap(resposta.mensagem, resposta.classe);
                listarRegistros($('#input-frequencia-id').val());
                atualizaBotoesEnvio($('#input-frequencia-id').val());
                //location.reload();
            }
        });
        modalConfirmarEnvioChefiaJan.modal('toggle');
    });

    botaoAbrirModalDesfazerEnvioChefiaJan.click(function () {
        modalConfirmarDesfazerEnvioChefiaJan.modal();
    });

    botaoConfirmarDesfazerEnvioChefiaJan.click(function () {
        var id = $('#input-frequencia-id').val();
        $.ajax({
            url: urlBaseDesfazerEnvioChefiaJan + id,
            success: function (resposta) {
                exibirAlertaBootstrap(resposta.mensagem, resposta.classe);
                listarRegistros($('#input-frequencia-id').val());
                atualizaBotoesEnvio($('#input-frequencia-id').val());
                //location.reload();
            }
        });
        
        modalConfirmarDesfazerEnvioChefiaJan.modal('toggle');
    });
    /*
     * Para que o tooltip bootstrap da situacao da escalacao funcione
     */
    tabelaRegistros.on('post-body.bs.table', function () {
        $('[data-toggle="tooltip"]').tooltip({
            container: 'body'
        });
    });
});
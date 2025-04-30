/* 
 * Script para gerenciamento de servidores
 * 
 */

/**
 * Dados da tabela atual de acordo com os filtros aplicados
 * @type json
 */
var dadosTabela;
var tabelaRegistros;
var urlBaseListar = 'servidores/lista';
var urlBaseEditar = 'servidores/editar/';

/*
 *Esta função busca a lista de servidores e a carrega (load)
 *na tabela de servidores lista.blade.php 
 */
function listarRegistros() {
    tabelaRegistros.bootstrapTable('refresh', {
        url: urlBaseListar
    });
}

$(document).ready(function () {
    tabelaRegistros = $('#tabela-servidores');


    var botaoAbrirModalNovo = $("#button-novo-servidor");
    var modalNovoRegistro = $("#modal-novo-servidor");


    var formNovoRegistro = $('#form-novo-servidor');
    var botaoCadastrarRegistro = $('#button-novo-servidor-enviar');
    var urlBaseAdicionar = 'servidores/adicionar';

    var modalConfirmarExclusao = $("#modal-confirma-exclusao");
    var botaoConfirmarExclusao = $('#button-confirma-exclusao');
    var urlBaseDeletar = 'servidores/deletar/';


    /*
     * Chamada para a funcao de listagem de servidores.
     */
    $.get(urlBaseListar, function (data) {
        tabelaRegistros.bootstrapTable({
            data: data
        });
    });

    tabelaRegistros.bootstrapTable({
        exportDataType: 'all',
        contextMenu: '#ul-menu-contexto-tabela-servidor',
        contextMenuTrigger: 'both',
        onContextMenuRow: function (row, $el) {
            tabelaRegistros.find('.info').removeClass('info');
            $el.addClass('info');
        },
        onContextMenuItem: function (row, $el) {
            var opcaoSelecionada = $el.data("item");
            var modalAguarde = $('#div-modal-msg-aguarde');
            var modalEditar = $('#modal-editar-servidor');
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
                    paragrafoMensagem.text('Tem certeza que deseja excluir o cadastro do servidor ' + row.nome + '?');
                    //Passando dados para um modal
                    modalConfirmarExclusao.data('servidorid', row.id).modal();
                    break;
            }
        }
    });

    botaoConfirmarExclusao.click(function () {
        var id = modalConfirmarExclusao.data('servidorid');
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
     * Ao clicar no modal, exibir formulario de novo servidor.
     */
    botaoAbrirModalNovo.click(function () {
        modalNovoRegistro.modal();
    });

    /*
     * Envia nova servidor para persistência no banco de dados
     * Ao retornar, atualiza a lista de servidores por meio do metodo
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
    var urlBaseRelatorio = "servidores/relatorio-servidores";
    botaoPaginaImpressao.click(function () {
        dadosTabela = tabelaRegistros.bootstrapTable('getData');
        window.open(urlBaseRelatorio);
    });
});
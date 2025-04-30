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
var urlBaseListar = 'listar-frequencias';
var urlBaseEditar = 'editar-chefia/';
var urlBaseVisualizar = 'visualizar/';

/*
 *Esta função busca a lista de frequencias e a carrega (load)
 *na tabela de frequencias lista.blade.php 
 */
function listarRegistros() {
    tabelaRegistros.bootstrapTable('refresh', {
        url: urlBaseListar
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

function configurarMenuFrequencia(row, $el) {
    if (verificaStatusFechado(row.status_id_dez) && verificaStatusFechado(row.status_id_jan)) {
        $('.redefinir-chefia').hide();
    } else {
        $('.redefinir-chefia').show();
    }
}
$(document).ready(function () {
    tabelaRegistros = $('#tabela-frequencias');

    var botaoAbrirModalNovo = $("#button-novo-frequencia");
    var modalNovoRegistro = $("#modal-novo-frequencia");


    var formNovoRegistro = $('#form-novo-frequencia');
    var botaoCadastrarRegistro = $('#button-novo-frequencia-enviar');
    var urlBaseAdicionar = 'registrar-frequencia/adicionar';

    var modalConfirmarExclusao = $("#modal-confirma-exclusao");
    var botaoConfirmarExclusao = $('#button-confirma-exclusao');
    var urlBaseDeletar = 'registrar-frequencia/deletar/';

    /*
     * Chamada para a funcao de listagem de frequencias.
     */
    $.get(urlBaseListar, function (data) {
        tabelaRegistros.bootstrapTable({
            data: data
        });
    });

    tabelaRegistros.bootstrapTable({
        exportDataType: 'all',
        contextMenu: '#ul-menu-contexto-tabela-frequencia',
        contextMenuTrigger: 'both',
        formatNoMatches: function (row, $el) {
            return "Não há frequências cadastradas para sua matrícula";
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
            var urlBaseRelatorio = "versao-pdf/";

        

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

                case "redefinir-chefia":
                    modalAguarde.modal();
                    modalEditarChefia.data('frequenciaid', row.id).load((urlBaseEditar + id), function () {
                        modalAguarde.modal('hide');
                        modalEditarChefia.modal();
                    });
                    break;
                case "pagina-pdf":
                    window.open(urlBaseRelatorio+row.id);
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
    var urlBaseRelatorio = "registrar-frequencia/versao-pdf";
    botaoPaginaImpressao.click(function () {
        dadosTabela = tabelaRegistros.bootstrapTable('getData');
        window.open(urlBaseRelatorio);
    });

    /*
     * Para que o tooltip bootstrap da situacao da frequencia funcione
     */
    tabelaRegistros.on('post-body.bs.table', function () {
        $('[data-toggle="tooltip"]').tooltip({
            container: 'body'
        });
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
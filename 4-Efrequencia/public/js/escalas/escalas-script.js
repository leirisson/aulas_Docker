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
var urlBaseListar = 'escalas/lista/';
var urlBaseEditar = 'escalas/editar/';
var urlCarregaDiasRecesso = 'escalas/dias-recesso-selecionado/';

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


$(document).ready(function () {
    tabelaRegistros = $('#tabela-escalas');

    var opcoesDias = $('#div-listagem-dias');
    

    var selectRecessos = $('#select-recessos');
    selectRecessos.on('change', function () {
        $("#input-recesso-id").val($(this).val());
        listarRegistros($(this).val());
        modalAguarde.modal();
        divDiasRecessoSelecionado.load((urlCarregaDiasRecesso + $(this).val()), function () {
            modalAguarde.modal('hide');
        });
    });

    var botaoAlternarEscalaTodos = $("#button-marcar-escala-todos");
    var botaoAlternarFolgaTodos = $("#button-marcar-folga-todos");
    botaoAlternarEscalaTodos.on('click', function () {
        if ($(this).text() === "Marcar Todos") {
            $(this).text("Desmarcar Todos");
            $("input[name*='escalado-dia']").bootstrapToggle('on');
        } else {
            $(this).text("Marcar Todos");
            $("input[name*='escalado-dia']").bootstrapToggle('off');
        }

    });
    botaoAlternarFolgaTodos.on('click', function () {
        if ($(this).text() === "Pagamento Todos") {
            $(this).text("Folga Todos");
            $("input[name*='opcao-dia']").bootstrapToggle('off');
        } else {
            $(this).text("Pagamento Todos");
            $("input[name*='opcao-dia']").bootstrapToggle('on');
        }

    });
    var botaoAbrirModalNovo = $("#button-novo-frequencia");
    var modalNovoRegistro = $("#modal-novo-frequencia");


    var formNovoRegistro = $('#form-novo-frequencia');
    var botaoCadastrarRegistro = $('#button-novo-frequencia-enviar');
    var urlBaseAdicionar = 'escalas/adicionar';

    var modalConfirmarExclusao = $("#modal-confirma-exclusao");
    var botaoConfirmarExclusao = $('#button-confirma-exclusao');
    var urlBaseDeletar = 'escalas/deletar/';
    $("input[name*='escalado-dia']").change(function (event) {
        var dia = $(this).prop('name').split('|')[1];
        var nomeDivOpcaoRelacionada = "div-opcao-dia|" + dia;
        if ($(this).prop('checked')) {
            $("div[name='" + nomeDivOpcaoRelacionada + "']").show();
        } else {
            $("div[name='" + nomeDivOpcaoRelacionada + "']").hide();
        }

    });

    var modalAguarde = $('#div-modal-msg-aguarde');
    var divDiasRecessoSelecionado = $('#div-dias-recesso-selecionado');
    modalAguarde.modal();
    divDiasRecessoSelecionado.load((urlCarregaDiasRecesso + $("#input-recesso-id").val()), function () {
        modalAguarde.modal('hide');
    });

    tabelaRegistros.bootstrapTable({
        exportDataType: 'all',
        contextMenu: '#ul-menu-contexto-tabela-frequencia',
        contextMenuTrigger: 'both',
        formatNoMatches: function (row, $el) {
            return "Você não cadastrou nenhuma escala no recesso selecionado";
        },
        onContextMenuRow: function (row, $el) {
            tabelaRegistros.find('.info').removeClass('info');
            $el.addClass('info');
        },
        onContextMenuItem: function (row, $el) {
            var opcaoSelecionada = $el.data("item");

            var modalEditar = $('#modal-editar-frequencia');
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
                    paragrafoMensagem.text('Tem certeza que deseja excluir o cadastro do frequencia ' + row.servidor_escalado.nome + '?');
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
                listarRegistros();
            }
        });
        modalConfirmarExclusao.modal('toggle');
    });

    /*
     * Ao clicar no modal, exibir formulario de novo frequencia.
     */
    botaoAbrirModalNovo.click(function () {
        if (selectServidores.val() === "") {
            opcoesDias.hide();
        }
        $("#input-recesso-id").val(selectRecessos.val());
        modalNovoRegistro.modal();
    });

    /*
     * Envia nova frequencia para persistência no banco de dados
     * Ao retornar, atualiza a lista de frequencias por meio do metodo
     * listarRegistros()
     */
    formNovoRegistro.submit(function (event) {
        event.preventDefault();

        if ($("input[name*='escalado-dia']").is(function () {
            return this.checked;
        }) == false) {
            alert('Nenhum dia foi selecionado.')
            return false;
        }

        if (!confirm("Confirma a escalação do servidor? Certifique-se quanto à preferência por folga ou pagamento.")) {
            return false;
        }

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
    var urlBaseRelatorio = "escalas/relatorio-escalas";
    botaoPaginaImpressao.click(function () {
        dadosTabela = tabelaRegistros.bootstrapTable('getData');
        window.open(urlBaseRelatorio);
    });

    /*
     * Configurando select-servidores para pesquisa
     */
    var selectServidores = $('#select-servidores');
    var selectServidoresAutoriza = $('#select-servidores-autoriza');

    selectServidores.select2();
    selectServidoresAutoriza.select2();
    var dadosJaEscalado = $('#span-dados-ja-escalado');

    var html_barra_progresso = '<div class="progress">' +
            '<div class="progress-bar progress-bar-striped active" role="progressbar"' +
            'aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:100%">' +
            '</div>' +
            '</div>';
    selectServidoresAutoriza.on('change', function () {

        var idServidor = selectServidoresAutoriza.val();
        $("#select-servidores option[value='" + idServidor + "']").attr('disabled', 'disabled')
                .siblings().removeAttr('disabled');
        selectServidores.select2();
    });
    selectServidores.on('change', function (event) {
        var idServidor = selectServidores.val();
        $("#select-servidores-autoriza option[value='" + idServidor + "']").attr('disabled', 'disabled')
                .siblings().removeAttr('disabled');
        selectServidoresAutoriza.select2();
        var idRecesso = $('#select-recessos').val();
        opcoesDias.hide();
        dadosJaEscalado.html(html_barra_progresso);
        //Verificar se já não está cadastrado.
        //Alterado requisito. Servidor pode estar cadastrado sim visto que pode exercer diferentes tarefas
        //validadas por diferentes chefias
        if (idServidor !== "") {
            dadosJaEscalado.hide();
            opcoesDias.show();
            botaoCadastrarRegistro.prop('disabled', false);
//            $.getJSON("escalas/verifica-escala-por-servidor/" + idServidor + '/' + idRecesso, function (dadosFrequenciaJson) {
//
//                if (typeof dadosFrequenciaJson.servidor_escalado !== 'undefined') {
//                    var nomeEscalado = dadosFrequenciaJson.servidor_escalado.nome;
//                    var nomeQuemEscalou = dadosFrequenciaJson.servidor_responsavel.nome;
//                    var nomeQuemAutoriza = dadosFrequenciaJson.servidor_autoriza.nome;
//                    var momentoEscalacao = dadosFrequenciaJson.created_at;
//                    var statusAtual = dadosFrequenciaJson.status_escalacao.status_descricao;
//                    opcoesDias.hide();
//                    dadosJaEscalado.show()
//                    dadosJaEscalado.html("Escalação de " + nomeEscalado + " já foi efetuada por " + nomeQuemEscalou + " em " + formatarDataHora(momentoEscalacao) + ".<br>O status atual da escalação é " + statusAtual + ".<br>Responsável pela Autorização da Escalação: " + nomeQuemAutoriza);
//                    botaoCadastrarRegistro.prop('disabled', true);
//
//                } else {
//                    dadosJaEscalado.hide();
//                    opcoesDias.show();
//                    botaoCadastrarRegistro.prop('disabled', false);
//
//                }
//            });
        }
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
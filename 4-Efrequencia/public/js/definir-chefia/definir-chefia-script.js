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
var urlBaseEditar = 'registrar-frequencia/editar/';

$(document).ready(function () {

    var formEditarRegistro = $('#form-definir-chefia');
    var botaoAbrirModalConfirmacao = $('#button-definir-chefia-enviar');
    var botaoConfirmarAlteracao = $("#button-confirma");
    var urlAlterar = 'definir-chefia-primeira-vez';
    formEditarRegistro.submit(function (event) {
        event.preventDefault();
        
        botaoConfirmarAlteracao.prop('disabled', true);
        var form = $(this);
        var data = form.serialize();
//        alert(data);
//        return false;
        $.ajax({
            url: urlAlterar,
            data: data,
            method: 'POST',
            success: function (resposta) {
                exibirAlertaBootstrap(resposta.mensagem, resposta.classe);
                modalConfirmaAlteracao.modal('hide');
                botaoConfirmarAlteracao.prop('disabled', false);
                window.location.href = "../registrar-frequencia";
            },
            error: function (resposta) {
                exibirAlertaBootstrap(resposta.mensagem, resposta.classe);
                botaoConfirmarAlteracao.prop('disabled', false);
            }
        });

    });
    
    var modalConfirmaAlteracao = $("#modal-confirma");
    botaoAbrirModalConfirmacao.on('click', function () {
        modalConfirmaAlteracao.modal('show');
    });

    /*
     * Configurando select-servidores para pesquisa
     */
    var selectServidores = $('.select-servidores');
    selectServidores.select2();
    selectServidores.on('change', function (event) {
        var idServidor = selectServidores.val();
        //Verificar se já não está cadastrado.
    });
    var botaoAlternarFolgaTodos = $("#button-marcar-folga-todos");
    botaoAlternarFolgaTodos.on('click', function () {
        if ($(this).text() === "Marcar Todos Como Pagamento") {
            $(this).text("Marcar Todos Como Folga");
            $("input[name*='opcao-dia']").bootstrapToggle('off');
        } else {
            $(this).text("Marcar Todos Como Pagamento");
            $("input[name*='opcao-dia']").bootstrapToggle('on');
        }
    });
    // Instance the tour
    var tutorial2 = new Tour({
        name: 'tutorial_opcao_1',
        backdrop: true,
        backdropPading: 10,
        template: "<div class='popover tour'>" +
                "<div class='arrow'></div>" +
                "<h3 class='popover-title'></h3>" +
                "<div class='popover-content'></div>" +
                "<div class='popover-navigation text-center'>" +
                "<button class='btn btn-default' data-role='prev'>« Ant</button>" +
                "<span data-role='separator'>|</span>" +
                "<button class='btn btn-default' data-role='next'>Próx »</button>" +
                "</div>",
        steps: [
            {
                element: ".select2-selection__arrow",
                title: "Chefia Imediata",
                content: "Aqui você seleciona o nome da sua chefia imediata"
            },
            {
                element: ".toggle:first",
                title: "Opção pela Conversão",
                content: "Neste botão você faz a opção por folga ou pagamento (caso seja liberado crédito). Clique e observe."
            },
            {
                element: "#button-marcar-folga-todos",
                title: "Botão Marcar Todos",
                content: "Com esse botão você poder marcar todos os dias como pagamento rapidamente. E vice-versa.",
                onNext: function () {
                    tutorial2.end();
                }
            }
            ,
            {
                element: "#button-marcar-folga-todos",
                title: "Botão Marcar Todos",
                content: "Com esse botão você poder marcar todos os dias como pagamento rapidamente. E vice-versa.",
                onNext: function () {
                    tutorial2.end();
                }
            }


        ]});
    //Desabilitei o tour pois em testes verifiquei que pode confundir o servidor
    // Initialize the tour
    // tutorial2.init();

    // Start the tour
    //tutorial2.start();



});
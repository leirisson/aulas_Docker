/* 
 * Script para exportar para planilha no Excel e efetuar os calculos do pagamento
 * 
 */

/**
 * Dados da tabela atual de acordo com os filtros aplicados
 * @type json
 */
var tabelaRegistros;
var urlBaseListar = 'exportar-excel/gerar-json-exportar-excel/';

/*
 *Esta função busca a lista de frequencias e a carrega (load)
 *na tabela de frequencias lista.blade.php 
 */
function listarRegistros(idRecesso, mesNumero, opcaoConversaoCodigo) {
    idRecesso = typeof idRecesso !== 'undefined' ? idRecesso : null;
    mesNumero = typeof mesNumero !== 'undefined' ? mesNumero : 12;
    opcaoConversaoCodigo = typeof opcaoConversaoCodigo !== 'undefined' ? opcaoConversaoCodigo : -1;
    var query = "";
    query = query + (mesNumero?"&mes=" + mesNumero: "");
    query = query + (opcaoConversaoCodigo?"&opcao=" + opcaoConversaoCodigo: "");
    tabelaRegistros.bootstrapTable('refresh', {
        url: urlBaseListar + idRecesso + "?" + query
    });
}

$(document).ready(function () {

    tabelaRegistros = $('#tabela-frequencias');

    var selectRecessos = $('#select-recessos');
    var selectMesNumero = $('#select-mes-numero');
    var selectOpcaoConversaoCodigo = $('#select-opcao-conversao-codigo');
    
    selectRecessos.on('change', function () {
        listarRegistros($(this).val(), selectMesNumero.val(), selectOpcaoConversaoCodigo.val());
    });
    
    
    selectMesNumero.on('change', function () {
        listarRegistros(selectRecessos.val(), $(this).val(), selectOpcaoConversaoCodigo.val());
    });
    
    selectOpcaoConversaoCodigo.on('change', function () {
        listarRegistros(selectRecessos.val(), selectMesNumero.val(), $(this).val());
    });


    tabelaRegistros.bootstrapTable({
        exportDataType: 'all',
        formatNoMatches: function (row, $el) {
            return "Por enquanto, nenhuma frequência";
        },
    });


});

/**
 * Habilitar Tooltip para todas as paginas que utilizam util-nucre.js
 */
$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

function formatarStatusFrequenciaComDica(value, row) {
    var mensagem = "";
    switch (value.id) {
        case 1:
            mensagem = 'Frequência em aberto, ou seja, você ainda não terminou de preenchê-la.';
            break;
        case 2:
            mensagem = 'Sua chefia ainda não validou. Converse com ela para que acesse o sistema e valide sua frequência.';
            break;
        case 3:
            mensagem = 'Disponível para Secap e Sepag. Não é mais possível fazer alterações.';
            break;
    }
    return '<a href="#" data-toggle="tooltip" title="' + mensagem + '">' + value.status_descricao + '</a>';
}

function formatarStatusFrequenciaComDicaDez(value, row) {

    this.mes = '';
    this.escaladoDezembro = false;
    var self = this;
    $.each(row.eventos, function (key, valor) {
        self.mes = valor.dia_id.split('-')[1];
        if (self.mes === '12') {

            self.escaladoDezembro = true;
            return false;
        }
    });
    if (!this.escaladoDezembro) {
        return 'Não Escalado';
    }
    var mensagem = "";
    var dataStatus = "";
    switch (value.id) {
        case 1:
            mensagem = 'Frequência de Dezembro em aberto, ou seja, você ainda não terminou de preenchê-la.';
            break;
        case 2:
            mensagem = 'Sua chefia ainda não validou sua frequência, período Dezembro. Converse com ela para que acesse o sistema e valide sua frequência.';
            break;
        case 3:
            dataStatus = formatarDataHora(row.avaliacoes[0].data_avaliacao_dez, row);
            mensagem = 'Disponível para Secap e Sepag. Não é mais possível fazer alterações.';
            break;
    }
    return '<a href="#" data-toggle="tooltip" title="' + mensagem + '">' + value.status_descricao + ' ' + dataStatus + '</a>';
}

function formatarStatusFrequenciaComDicaJan(value, row) {

    this.mes = '';
    this.escaladoJaneiro = false;
    var self = this;
    $.each(row.eventos, function (key, valor) {
        self.mes = valor.dia_id.split('-')[1];
        if (self.mes === '01') {

            self.escaladoJaneiro = true;
            return false;
        }
    });
    if (!this.escaladoJaneiro) {
        return 'Não Escalado';
    }
    var mensagem = "";
    var dataStatus = "";
    switch (value.id) {
        case 1:
            mensagem = 'Frequência mês de Janeiro em aberto, ou seja, você ainda não terminou de preenchê-la.';
            break;
        case 2:
            mensagem = 'Sua chefia ainda não validou sua frequência, período Janeiro. Converse com ela para que acesse o sistema e valide sua frequência.';
            break;
        case 3:
            dataStatus = formatarDataHora(row.avaliacoes[0].data_avaliacao_jan, row);
            mensagem = 'Disponível para Secap e Sepag. Não é mais possível fazer alterações.';
            break;
    }
    return '<a href="#" data-toggle="tooltip" title="' + mensagem + '">' + value.status_descricao + ' ' + dataStatus + '</a>';
}

function formatarStatusFrequenciaComDicaPorDia(value, row) {
    var mensagem = "";
    var mes = row.dia_id.split('-')[1];
    if (mes == '12') {
        switch (row.frequencia.status_id_dez) {
            case 1:
                mensagem = 'Frequência em aberto, ou seja, você ainda não terminou de preenchê-la.';
                break;
            case 2:
                mensagem = 'Sua chefia ainda não validou. Converse com ela para que acesse o sistema e valide sua frequência.';
                break;
            case 3:
                mensagem = 'Disponível para Secap e Sepag. Não é mais possível fazer alterações.';
                break;
        }
        return '<a href="#" data-toggle="tooltip" title="' + mensagem + '">' + row.frequencia.status_dez.status_descricao + '</a>';
    }

    if (mes == '01') {
        switch (row.frequencia.status_id_jan) {
            case 1:
                mensagem = 'Frequência em aberto, ou seja, você ainda não terminou de preenchê-la.';
                break;
            case 2:
                mensagem = 'Sua chefia ainda não validou. Converse com ela para que acesse o sistema e valide sua frequência.';
                break;
            case 3:
                mensagem = 'Disponível para Secap e Sepag. Não é mais possível fazer alterações.';
                break;
        }
        return '<a href="#" data-toggle="tooltip" title="' + mensagem + '">' + row.frequencia.status_jan.status_descricao + '</a>';
    }

}

function formatarStatusFrequenciaComDicaParaChefiaDez(value, row) {
    this.mes = '';
    this.escaladoDezembro = false;
    var self = this;
    $.each(row.frequencia.eventos, function (key, valor) {
        self.mes = valor.dia_id.split('-')[1];
        if (self.mes === '12') {

            self.escaladoDezembro = true;
            return false;
        }
    });
    if (!this.escaladoDezembro) {
        return 'N/A';
    }

    var mensagem = "";
    var dataStatus = "";
    switch (row.frequencia.status_dez.id) {
        case 1:
            mensagem = 'Frequência em aberto, ou seja, o servidor ainda não enviou para sua validação.';
            break;
        case 2:
            mensagem = 'Aguardando sua validação. Clique para visualizar as opções.';
            break;
        case 3:
            dataStatus = formatarDataHora(row.data_avaliacao_dez, row);
            mensagem = 'Disponível para Secap e Sepag. Não é mais possível fazer alterações.';
            break;
    }
    return '<a href="#" data-toggle="tooltip" title="' + mensagem + '">' + row.frequencia.status_dez.status_descricao + ' ' + dataStatus + '</a>';

}

function formatarStatusFrequenciaComDicaParaChefiaJan(value, row) {
    this.mes = '';
    this.escaladoJaneiro = false;
    var self = this;
    $.each(row.frequencia.eventos, function (key, valor) {
        self.mes = valor.dia_id.split('-')[1];
        if (self.mes === '01') {

            self.escaladoJaneiro = true;
            return false;
        }
    });
    if (!this.escaladoJaneiro) {
        return 'N/A';
    }

    var mensagem = "";
    var dataStatus = "";
    switch (row.frequencia.status_jan.id) {
        case 1:
            mensagem = 'Frequência em aberto, ou seja, o servidor ainda não enviou para sua validação.';
            break;
        case 2:
            mensagem = 'Aguardando sua validação. Clique para visualizar as opções.';
            break;
        case 3:
            dataStatus = formatarDataHora(row.data_avaliacao_jan, row);
            mensagem = 'Disponível para Secap e Sepag. Não é mais possível fazer alterações.';
            break;
    }
    return '<a href="#" data-toggle="tooltip" title="' + mensagem + '">' + row.frequencia.status_jan.status_descricao + ' ' + dataStatus + '</a>';

}

function formatarData(value, row) {
    if (value !== null && typeof value !== 'undefined') {
        return value.split('-').reverse().join('/');
    }
    return 'Sem Data';
}

function formatarDataComDiaDaSemanaMin(value, row) {
    if (value !== null && typeof value !== 'undefined') {
        var data = value.split('-').reverse().join('/');
        var diaDaSemana = diaSemanaMin(value);
        if (verificaStatusFechadoPorMes(row)) {
            return data + '-' + diaDaSemana;
        }
        return "<a href='#'>" + data + '-' + diaDaSemana + "</a>";

    }
    return 'Sem Data';
}
//Data no Formato yyyy-mm-dd
function diaSemana(dataString) {
    var data = new Date(dataString.split('-')[0], parseInt(dataString.split('-')[1]) - 1, dataString.split('-')[2]);
    //Detalhe para getUTCDay
    var dia = data.getUTCDay();
    var semana = new Array(6);
    semana[0] = 'Domingo';
    semana[1] = 'Segunda-Feira';
    semana[2] = 'Terça-Feira';
    semana[3] = 'Quarta-Feia';
    semana[4] = 'Quinta-Feira';
    semana[5] = 'Sexta-Feira';
    semana[6] = 'Sábado';
    return(semana[dia]);
}
//Data no Formato yyyy-mm-dd
function diaSemanaMin(dataString) {
    var data = new Date(dataString.split('-')[0], parseInt(dataString.split('-')[1]) - 1, dataString.split('-')[2]);
    var dia = data.getUTCDay();
    var semana = new Array(6);
    semana[0] = 'Dom';
    semana[1] = 'Seg';
    semana[2] = 'Ter';
    semana[3] = 'Qua';
    semana[4] = 'Qui';
    semana[5] = 'Sex';
    semana[6] = 'Sáb';
    return(semana[dia]);
}

function formatarComoLink(value, row) {
    return '<a href="#">' + value + '</a><span class="link-ajuda-identificar-edicao"/>';
}
function formatarSimNao(value, row) {
    if (value !== null && typeof value !== 'undefined') {
        return value == '1' ? "Sim" : "Não";
    }
    return '';
}

function formatarHoraRemoveSegundos(value, row) {
    if (value !== null && typeof value !== 'undefined' && value !== '') {
        return value.substring(0, 5);
    }
    return value;
}

function formatarDataDia(value, row) {
    if (value !== null && typeof value !== 'undefined') {
        return value.split('-').reverse()[0] + "/" + value.split('-').reverse()[1] + "";
    }
    return 'Sem Data';
}
function formatarDataSomenteDia(value, row) {
    if (value !== null && typeof value !== 'undefined') {
        return value.split('-').reverse()[0];
    }
    return 'Sem Data';
}

function formatarDataFolha(value, row) {
    if (value !== null && typeof value !== 'undefined') {
        var arrayData = value.split('-');
        return arrayData[1] + '/' + arrayData[0] + '-' + arrayData[2];
    }
    return 'Sem Data';
}

function formatarMyyyySQL(data) {
    var arrayData = data.split('/');
    return arrayData[1] + '-' + arrayData[0] + '-01';
}

function formatarDataSQLFolha(data) {
    var meses = new Array("JAN", "FEV", "MAR", "ABR", "MAI", "JUN", "JUL", "AGO", "SET", "OUT", "NOV", "DEZ");
    if (data !== null && typeof data !== 'undefined') {
        var arrayData = data.split('-');
        return meses[arrayData[1] - 1] + "/" + arrayData[0];
    }
    return 'Sem Data';
}

function formatarDataParaSQL(value, row) {
    if (value !== null && typeof value !== 'undefined') {
        return value.split('/').reverse().join('-');
    }
    return 'Sem Data';
}
function formatarCasoNulo(value, row) {
    if (value == null || typeof value == 'undefined') {
        return "-";
    }
    return value;
}
function formatarDescricaoFuncao(value, row) {
    if (value !== null) {
        var arrayNomeFuncao = value.split('/');
        return arrayNomeFuncao[1] + '/' + arrayNomeFuncao[2] + ' - ' + row.funcao.funcao_codigo;
    }
    return value;
}

function formatarStatusSecap(value, row) {
    if (row.folha_pagamento !== null) {
        return value + ' - ' + formatarDataSQLFolha(row.folha_pagamento);
    }
    return (value);
}
/*
 * Formatar período para data-formatter da Bootstrap Table
 * @param {type} value
 * @param {type} row
 * @returns {String}
 */
function formatarPeriodo(value, row) {
    if (row.pedido_inicio !== row.pedido_fim) {
        return formatarData(row.pedido_inicio) + ' a ' + formatarData(row.pedido_fim);
    }
    return formatarData(value);
}

function formatarPeriodoComDatas(dataInicio, dataFim) {
    if (dataInicio !== dataFim) {
        return formatarData(dataInicio) + ' a ' + formatarData(dataFim);
    }
    return formatarData(dataInicio);
}
function formatarNomePrimeiroUltimo(value, row) {
    var arrayNome = value.split(' ');
    return arrayNome[0] + " " + arrayNome[arrayNome.length - 1];
}

function formatarDataHora(value, row) {
    if (value !== null) {
        var data = value.substr(0, value.indexOf(' ')).split('-').reverse().join('/');
        var hora = value.substr(value.indexOf(' ') + 1);
        return data + ' ' + hora;
    }
    return 'Sem Data';
}
/**
 * Exibe um alerta bootstrap dada uma mensagem e o nome da classe
 * A view principal deve conter uma div com o id 'main'
 * @param {String} mensagem
 * @param {String} classe
 * @returns {undefined}
 */
function exibirAlertaBootstrap(mensagem, classe) {
    //Remove a div de status caso já tenha exista
    $("#div-alert-status").remove();
    //Adiciona no início da div 'main' a div status para o alerta bootstrap
    $("#main").prepend("<div id='div-alert-status'></div>");
    //Adiciona a mensagem passada como parametro a div recem criada
    $('#div-alert-status').html(mensagem);
    //remove qualquer 
    $('#div-alert-status').removeClass();
    $('#div-alert-status').addClass(classe);
    $("<button type='button' class='close'>×</button>").appendTo('#div-alert-status');
    $('#div-alert-status').css({opacity: 1});
    $('#div-alert-status').show();

    window.setTimeout(function () {
        $("#div-alert-status").fadeTo(500, 0).slideUp(500, function () {
            $('#div-alert-status').hide();
        });
    }, 5000);
}


function formatarEventos(value, row) {
    var textoFinal = "";
    var proximoDia;
    var de;
    var ate;
    var diaAux;
    var checkDe = true;
    var checkAte = true;
    if (value != null) {
        jQuery.each(value, function (i, val) {
            diaAux = +formatarDataSomenteDia(val.dia_id, null);

            if (value.length > i + 1) {
                proximoDia = +formatarDataSomenteDia(value[i + 1].dia_id, null);
            } else {
                proximoDia = +formatarDataSomenteDia(value[i].dia_id, null);
            }
            if (proximoDia == diaAux + 1 && checkDe) {
                de = formatarDataDia(value[i].dia_id);
                checkDe = false;
            }
            if (proximoDia !== diaAux + 1) {
                ate = formatarDataDia(value[i].dia_id);
                checkAte = false;
            }
            if (checkDe == false && checkAte == false) {
                checkDe = true;
                checkAte = true;
                textoFinal = textoFinal + de + " a " + ate + "; ";
            }

            if (checkDe == true && checkAte == false) {
                checkDe = true;
                checkAte = true;
                textoFinal = textoFinal + formatarDataDia(value[i].dia_id) + "; ";
            }
        });
    }
    return textoFinal;
}

function formatarEventosFolga(value, row) {
    var textoFinal = "";
    var proximoDia;
    var de;
    var ate;
    var diaAux;
    var checkDe = true;
    var checkAte = true;
    jQuery.each(value, function (i, val) {
        if (val.opcao) {
            diaAux = +formatarDataSomenteDia(val.dia_id, null);

            if (value.length > i + 1 && value[i + 1].opcao) {
                proximoDia = +formatarDataSomenteDia(value[i + 1].dia_id, null);
            } else {
                proximoDia = +formatarDataSomenteDia(value[i].dia_id, null);
            }
            if (proximoDia == diaAux + 1 && checkDe) {
                de = formatarDataDia(value[i].dia_id);
                checkDe = false;
            }

            if (proximoDia !== diaAux + 1) {
                ate = formatarDataDia(value[i].dia_id);
                checkAte = false;
            }
            if (checkDe == false && checkAte == false) {
                checkDe = true;
                checkAte = true;
                textoFinal = textoFinal + de + " a " + ate + "; ";
            }

            if (checkDe == true && checkAte == false) {
                checkDe = true;
                checkAte = true;
                textoFinal = textoFinal + formatarDataDia(value[i].dia_id) + "; ";
            }
        }
    });
    return textoFinal;
}
function formatarEventosPagamento(value, row) {
    var textoFinal = "";
    var proximoDia;
    var de;
    var ate;
    var diaAux;
    var checkDe = true;
    var checkAte = true;
    jQuery.each(value, function (i, val) {
        if (!val.opcao) {
            diaAux = +formatarDataSomenteDia(val.dia_id, null);

            if (value.length > i + 1 && !value[i + 1].opcao) {
                proximoDia = +formatarDataSomenteDia(value[i + 1].dia_id, null);
            } else {
                proximoDia = +formatarDataSomenteDia(value[i].dia_id, null);
            }
            if (proximoDia == diaAux + 1 && checkDe) {
                de = formatarDataDia(value[i].dia_id);
                checkDe = false;
            }

            if (proximoDia !== diaAux + 1) {
                ate = formatarDataDia(value[i].dia_id);
                checkAte = false;
            }
            if (checkDe == false && checkAte == false) {
                checkDe = true;
                checkAte = true;
                textoFinal = textoFinal + de + " a " + ate + "; ";
            }

            if (checkDe == true && checkAte == false) {
                checkDe = true;
                checkAte = true;
                textoFinal = textoFinal + formatarDataDia(value[i].dia_id) + "; ";
            }
        }
    });
    return textoFinal;
}

function formatarOpcaoFolgaPagamento(value, row) {
    if (value !== null && typeof value !== 'undefined') {
        return value == '1' ? "FOLGA" : "PAGAMENTO";
    }
    return '';
}

function formatarEntradasSaidas(value, row) {
    if (value !== null && typeof value !== 'undefined') {
        return value;
    }
    return '';
}

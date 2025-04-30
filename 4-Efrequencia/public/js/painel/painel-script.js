/* 
 * Script para painel
 * 
 */

$(document).ready(function () {
    $('#button-enviar-emails-pendencias-escalacao').on('click', function () {
        var email = '';
        $(".emails-chefias-pendentes-escalacao").each(function () {
            if (email.indexOf($(this).val()) === -1) {
                if (email === '') {
                    email = $(this).val();
                } else {
                    email = email + "," + $(this).val();
                }
            }
        });
        $("#span-lista-emails-pendencias-escalacao").html(email);
//        var subject = 'Autorização de Escala para o Recesso Pendente';
//        var emailBody = 'Sr(s). Diretor(es), Está pendente sua a autorização para o recesso via sistema. Acesse o sistema e autorize a escalação dos servidores.';
//        window.location.href = 'mailto:' + email + '?subject=' + subject + '&body=' + emailBody;
    });
    
    $('#button-ver-lista-email-em-aberto-dez').on('click', function () {
        var email = '';
        $(".emails-servidores-em-aberto-dez").each(function () {
            if (email.indexOf($(this).val()) === -1) {
                if (email === '') {
                    email = $(this).val();
                } else {
                    email = email + "," + $(this).val();
                }
            }
        });
        $("#span-lista-emails-servidores-em-aberto-dez").html(email);
//        var subject = 'Autorização de Escala para o Recesso Pendente';
//        var emailBody = 'Sr(s). Diretor(es), Está pendente sua a autorização para o recesso via sistema. Acesse o sistema e autorize a escalação dos servidores.';
//        window.location.href = 'mailto:' + email + '?subject=' + subject + '&body=' + emailBody;
    });
    
    $('#button-ver-lista-email-em-aberto-jan').on('click', function () {
        var email = '';
        $(".emails-servidores-em-aberto-jan").each(function () {
            if (email.indexOf($(this).val()) === -1) {
                if (email === '') {
                    email = $(this).val();
                } else {
                    email = email + "," + $(this).val();
                }
            }
        });
        $("#span-lista-emails-servidores-em-aberto-jan").html(email);
//        var subject = 'Autorização de Escala para o Recesso Pendente';
//        var emailBody = 'Sr(s). Diretor(es), Está pendente sua a autorização para o recesso via sistema. Acesse o sistema e autorize a escalação dos servidores.';
//        window.location.href = 'mailto:' + email + '?subject=' + subject + '&body=' + emailBody;
    });

    var selectRecessos = $('#select-recessos');
    selectRecessos.on('change', function () {
        var url = window.location.pathname;
        if (url.substr(url.length - 6) == 'painel') {
            window.location = 'painel/' + $(this).val();
        } else {
            window.location = $(this).val();
        }

    });
    
    var botaoVerServidoresSemChefia = $('#button-abrir-modal-servidores-sem-chefia');
    var modalServidoresSemChefia = $('#modal-servidores-sem-chefia');
    botaoVerServidoresSemChefia.on('click', function () {
        modalServidoresSemChefia.modal('show');
    });

    var botaoVerServidoresEscalados = $('#button-abrir-modal-servidores-escalados');
    var modalServidoresEscalados = $('#modal-detalhes-servidores-escalados');
    botaoVerServidoresEscalados.on('click', function () {
        modalServidoresEscalados.modal('show');
    });

    var botaoVerServidoresEscaladosAprovados = $('#button-abrir-modal-servidores-escalados-aprovados');
    var modalServidoresEscaladosAprovados = $('#modal-detalhes-servidores-escalados-aprovados');
    botaoVerServidoresEscaladosAprovados.on('click', function () {
        modalServidoresEscaladosAprovados.modal('show');
    });

    var botaoVerServidoresEscaladosNaoAprovados = $('#button-abrir-modal-servidores-escalados-nao-aprovados');
    var modalServidoresEscaladosNaoAprovados = $('#modal-detalhes-servidores-escalados-nao-aprovados');
    botaoVerServidoresEscaladosNaoAprovados.on('click', function () {
        modalServidoresEscaladosNaoAprovados.modal('show');
    });

    var botaoVerFrequencias = $('#button-abrir-modal-frequencias');
    var modalFrequencias = $('#modal-detalhes-frequencias');
    botaoVerFrequencias.on('click', function () {
        modalFrequencias.modal('show');
    });

    var botaoVerFrequenciasAvaliadasDez = $('#button-abrir-modal-frequencias-avaliadas-dez');
    var modalFrequenciasAvaliadasDez = $('#modal-detalhes-frequencias-avaliadas-dez');
    botaoVerFrequenciasAvaliadasDez.on('click', function () {
        modalFrequenciasAvaliadasDez.modal('show');
    });

    var botaoVerFrequenciasNaoAvaliadasDez = $('#button-abrir-modal-frequencias-nao-avaliadas-dez');
    var modalFrequenciasNaoAvaliadasDez = $('#modal-detalhes-frequencias-nao-avaliadas-dez');
    botaoVerFrequenciasNaoAvaliadasDez.on('click', function () {
        modalFrequenciasNaoAvaliadasDez.modal('show');
    });
    
    var botaoVerFrequenciasNaoAvaliadasJan = $('#button-abrir-modal-frequencias-nao-avaliadas-jan');
    var modalFrequenciasNaoAvaliadasJan = $('#modal-detalhes-frequencias-nao-avaliadas-jan');
    botaoVerFrequenciasNaoAvaliadasJan.on('click', function () {
        modalFrequenciasNaoAvaliadasJan.modal('show');
    });
    
    var botaoVerFrequenciasAguardandoChefiaDez = $('#button-abrir-modal-frequencias-aguardando-chefia-dez');
    var modalFrequencaisAguardandoChefiaDez = $('#modal-frequencias-aguardando-chefia-dez');
    botaoVerFrequenciasAguardandoChefiaDez.on('click', function () {
        modalFrequencaisAguardandoChefiaDez.modal('show');
    });
    
    var botaoVerFrequenciasAvaliadasJan = $('#button-abrir-modal-frequencias-avaliadas-jan');
    var modalFrequenciasAvaliadasJan = $('#modal-detalhes-frequencias-avaliadas-jan');
    botaoVerFrequenciasAvaliadasJan.on('click', function () {
        modalFrequenciasAvaliadasJan.modal('show');
    });
    
    var botaoVerFrequenciasAguardandoChefiaJan = $('#button-abrir-modal-frequencias-aguardando-chefia-jan');
    var modalFrequencaisAguardandoChefiaJan = $('#modal-frequencias-aguardando-chefia-jan');
    botaoVerFrequenciasAguardandoChefiaJan.on('click', function () {
        modalFrequencaisAguardandoChefiaJan.modal('show');
    });
});
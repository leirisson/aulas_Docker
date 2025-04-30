<!-- Corpo de um modal Modal Editar Escala-->
<div class="modal-dialog">
    <!-- Modal Content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4>
                Registrar Frequência - {{FormatacaoDataHelper::inverteData($evento->dia_id)}} - {{FormatacaoDataHelper::diaSemana($evento->dia_id)}}

            </h4>
        </div>
        <div class="modal-body modal-body-escala">
            <form id="form-editar-evento" method="POST">
                <!-- metodo para proteção csrf nativo laravel-->
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="evento_id" value="{{ $evento->id }}">
                <input id="input-entrada1" name="entrada1" style="display:none"  type="text" value="{{$evento->entrada1}}" class="form-control input-small">
                <input id="input-saida1" name="saida1" style="display:none"  type="text" value="{{$evento->saida1}}" class="form-control input-small">
                <input id="input-entrada2" name="entrada2" style="display:none"  type="text"  value="{{$evento->entrada2?$evento->entrada2:""}}" class="form-control input-small">
                <input id="input-saida2" name="saida2"  style="display:none" type="text" value="{{$evento->saida2}}" class="form-control input-small">
                <div class="row">
                    <div class="col-sm-3 borda-direita">
                        <div class="bootstrap-timepicker-widget" >
                            <table >
                                <tbody>
                                    <tr>
                                        <td colspan="3"><label>Entrada 1<br/><br/></label></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;Hora&nbsp;&nbsp;</td>
                                        <td class="separator">&nbsp;</td>
                                        <td>Minuto</td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" class="adiciona_hora-entrada1"><span class="glyphicon glyphicon-chevron-up"></span></a></td>
                                        <td class="separator">&nbsp;</td>
                                        <td><a href="#" class="adiciona_minuto-entrada1"><span class="glyphicon glyphicon-chevron-up"></span></a></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input id="input-entrada1-hora" type="text" class="bootstrap-timepicker-hour" maxlength="2" readonly>
                                        </td> 
                                        <td class="separator">:</td>
                                        <td>
                                            <input id="input-entrada1-minuto" type="text" class="bootstrap-timepicker-minute" maxlength="2" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" class="subtrai_hora-entrada1"><span class="glyphicon glyphicon-chevron-down"></span></a></td>
                                        <td class="separator"></td>
                                        <td><a href="#" class="subtrai_minuto-entrada1"><span class="glyphicon glyphicon-chevron-down"></span></a></td>
                                    </tr></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-3 borda-direita">
                        <div class="bootstrap-timepicker-widget" >
                            <table >
                                <tbody>
                                    <tr>
                                        <td colspan="3"><label>Saída 1<br/><br/></label></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;Hora&nbsp;&nbsp;</td>
                                        <td class="separator">&nbsp;</td>
                                        <td>Minuto</td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" class="adiciona_hora-saida1"><span class="glyphicon glyphicon-chevron-up"></span></a></td>
                                        <td class="separator">&nbsp;</td>
                                        <td><a href="#" class="adiciona_minuto-saida1"><span class="glyphicon glyphicon-chevron-up"></span></a></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input id="input-saida1-hora" type="text" class="bootstrap-timepicker-hour" maxlength="2" readonly>
                                        </td> 
                                        <td class="separator">:</td>
                                        <td><input id="input-saida1-minuto" type="text" class="bootstrap-timepicker-minute" maxlength="2" readonly></td>
                                    </tr>
                                    <tr>
                                        <td><a href="#"  class="subtrai_hora-saida1">
                                                <span class="glyphicon glyphicon-chevron-down"></span></a></td>
                                        <td class="separator"></td>
                                        <td><a href="#" class="subtrai_minuto-saida1">
                                                <span class="glyphicon glyphicon-chevron-down"></span></a></td>
                                    </tr></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-3 borda-direita">
                        <div class="bootstrap-timepicker-widget" >
                            <table >
                                <tbody>
                                    <tr>
                                        <td colspan="3">
                                            <label>Entrada 2 (Opcional)</label>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;Hora&nbsp;&nbsp;</td>
                                        <td class="separator">&nbsp;</td>
                                        <td>Minuto</td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" class="adiciona_hora-entrada2"><span class="glyphicon glyphicon-chevron-up"></span></a></td>
                                        <td class="separator">&nbsp;</td>
                                        <td><a href="#" class="adiciona_minuto-entrada2"><span class="glyphicon glyphicon-chevron-up"></span></a></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input id="input-entrada2-hora" type="text" class="bootstrap-timepicker-hour" maxlength="2" readonly>
                                        </td> 
                                        <td class="separator">:</td>
                                        <td><input id="input-entrada2-minuto" type="text" class="bootstrap-timepicker-minute" maxlength="2" readonly></td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" class="subtrai_hora-entrada2"><span class="glyphicon glyphicon-chevron-down"></span></a></td>
                                        <td class="separator"></td>
                                        <td><a href="#" class="subtrai_minuto-entrada2"><span class="glyphicon glyphicon-chevron-down"></span></a></td>
                                    </tr></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="bootstrap-timepicker-widget" >
                            <table >
                                <tbody>
                                    <tr>
                                        <td colspan="3"><label>Saída 2 (Opcional)</label></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;Hora&nbsp;&nbsp;</td>
                                        <td class="separator">&nbsp;</td>
                                        <td>Minuto</td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" class="adiciona_hora-saida2"><span class="glyphicon glyphicon-chevron-up"></span></a></td>
                                        <td class="separator">&nbsp;</td>
                                        <td><a href="#" class="adiciona_minuto-saida2"><span class="glyphicon glyphicon-chevron-up"></span></a></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input id="input-saida2-hora" type="text" class="bootstrap-timepicker-hour" maxlength="2" readonly>
                                        </td> 
                                        <td class="separator">:</td>
                                        <td><input id="input-saida2-minuto" type="text" class="bootstrap-timepicker-minute" maxlength="2" readonly></td>
                                    </tr>
                                    <tr>
                                        <td><a href="#"  class="subtrai_hora-saida2">
                                                <span class="glyphicon glyphicon-chevron-down"></span></a></td>
                                        <td class="separator"></td>
                                        <td><a href="#" class="subtrai_minuto-saida2">
                                                <span class="glyphicon glyphicon-chevron-down"></span></a></td>
                                    </tr></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">

            <div class="form-group row">
                <div class="col-sm-6">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                        Cancelar
                    </button>
                </div>
                <div class="col-sm-6">
                    <button id='button-evento-editar-enviar' form='form-editar-evento' type="submit" class="btn btn-primary pull-right">Salvar Alterações</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    function adicionaHora(valorAtual) {
        var numero = parseInt(valorAtual);
        if (numero >= 23) {
            return "00";
        }
        numero++;
        if (numero < 10) {
            return "0" + numero;
        }
        return numero;
    }

    function adicionaMinuto(valorAtual) {
        var numero = parseInt(valorAtual);
        if (numero === 59) {
            return "00";
        }
        numero++;
        if (numero < 10) {
            return "0" + numero;
        }
        return numero;
    }

    function subtraiHora(valorAtual) {
        var numero = parseInt(valorAtual);
        if (numero === 0) {
            return "23";
        }
        numero--;
        if (numero < 10) {
            return "0" + numero;
        }
        return numero;
    }

    function subtraiMinuto(valorAtual) {
        var numero = parseInt(valorAtual);
        if (numero === 0) {
            return "59";
        }
        numero--;
        if (numero < 10) {
            return "0" + numero;
        }
        return numero;
    }

    function somarHoraNoInput(inputHoraMinuto, inputHora, inputMinuto) {
        if (inputHoraMinuto.val() === "") {
            setarHoraAtualNoInput(inputHoraMinuto);
        } else {
            inputHoraMinuto.val(adicionaHora(inputHora.val()) + ":" + inputMinuto.val());
        }
        atualizarHorarios();
    }
    
    function subtrairHoraNoInput(inputHoraMinuto, inputHora, inputMinuto) {
        if (inputHoraMinuto.val() === "") {
            setarHoraAtualNoInput(inputHoraMinuto);
        } else {
            inputHoraMinuto.val(subtraiHora(inputHora.val()) + ":" + inputMinuto.val());
        }
        atualizarHorarios();
    }
    
    function somarMinutoNoInput(inputHoraMinuto, inputHora, inputMinuto) {
        if (inputHoraMinuto.val() === "") {
            setarHoraAtualNoInput(inputHoraMinuto);
        } else {
            inputHoraMinuto.val(inputHora.val() + ":" + adicionaMinuto(inputMinuto.val()));
        }
        atualizarHorarios();
    }
    
    function subtrairMinutoNoInput(inputHoraMinuto, inputHora, inputMinuto) {
        if (inputHoraMinuto.val() === "") {
            setarHoraAtualNoInput(inputHoraMinuto);
        } else {
            inputHoraMinuto.val(inputHora.val() + ":" + subtraiMinuto(inputMinuto.val()));
        }
        atualizarHorarios();
    }

    function setarHoraAtualNoInput(inputHoraMinuto) {
        var d = new Date();
        var hora = d.getHours();
        var minuto = d.getMinutes();
        var horaTexto = "";
        var minutoTexto = "";

        if (hora < 10) {
            horaTexto = "0" + hora;
        } else {
            horaTexto = hora;
        }
        if (minuto < 10) {
            minutoTexto = "0" + minuto;
        } else {
            minutoTexto = minuto;
        }
        inputHoraMinuto.val(horaTexto + ":" + minutoTexto);
    }
    var inputEntrada1 = $("#input-entrada1")
    var inputEntrada1hora = $("#input-entrada1-hora");
    var inputEntrada1minuto = $("#input-entrada1-minuto");

    var inputSaida1 = $("#input-saida1")
    var inputSaida1hora = $("#input-saida1-hora");
    var inputSaida1minuto = $("#input-saida1-minuto");

    var inputEntrada2 = $("#input-entrada2")
    var inputEntrada2hora = $("#input-entrada2-hora");
    var inputEntrada2minuto = $("#input-entrada2-minuto");

    var inputSaida2 = $("#input-saida2")
    var inputSaida2hora = $("#input-saida2-hora");
    var inputSaida2minuto = $("#input-saida2-minuto");

    $("[class^=adiciona_hora]").on('click', function (event) {
        event.preventDefault();
        var tipoSelecionado = $(this).attr('class').split("-")[1];
        switch (tipoSelecionado) {
            case 'entrada1':
                somarHoraNoInput(inputEntrada1, inputEntrada1hora, inputEntrada1minuto);
                break;
            case 'saida1':
                somarHoraNoInput(inputSaida1, inputSaida1hora, inputSaida1minuto);
                break;
            case 'entrada2':
                somarHoraNoInput(inputEntrada2, inputEntrada2hora, inputSaida2minuto);
                break;
            case 'saida2':
                somarHoraNoInput(inputSaida2, inputSaida2hora, inputSaida2minuto);
                break;
            default:
        }
        impedirHoraMinutoEntradaMaiorHoraMinutoSaida('input-entrada1', 'input-saida1');
        impedirHoraMinutoEntradaMaiorHoraMinutoSaida('input-entrada2', 'input-saida2');
        atualizarHorarios();
    });

    $("[class^=adiciona_minuto]").on('click', function (event) {
        event.preventDefault();
        var tipoSelecionado = $(this).attr('class').split("-")[1];

        switch (tipoSelecionado) {
            case 'entrada1':
                somarMinutoNoInput(inputEntrada1, inputEntrada1hora, inputEntrada1minuto);
                break;
            case 'saida1':
                somarMinutoNoInput(inputSaida1, inputSaida1hora, inputSaida1minuto);
                break;
            case 'entrada2':
                somarMinutoNoInput(inputEntrada2, inputEntrada2hora, inputSaida2minuto);
                break;
            case 'saida2':
                somarMinutoNoInput(inputSaida2, inputSaida2hora, inputSaida2minuto);
                break;
            default:
        }
        calcularTotalHoras(inputEntrada1.val(), inputSaida1.val(), inputEntrada2.val(), inputSaida2.val());
        ;
        atualizarHorarios();
    });

    $("[class^=subtrai_hora]").on('click', function (event) {
        event.preventDefault();
        var tipoSelecionado = $(this).attr('class').split("-")[1];
        switch (tipoSelecionado) {
            case 'entrada1':
                subtrairHoraNoInput(inputEntrada1, inputEntrada1hora, inputEntrada1minuto);
                break;
            case 'saida1':
                subtrairHoraNoInput(inputSaida1, inputSaida1hora, inputSaida1minuto);
                break;
            case 'entrada2':
                subtrairHoraNoInput(inputEntrada2, inputEntrada2hora, inputSaida2minuto);
                break;
            case 'saida2':
                subtrairHoraNoInput(inputSaida2, inputSaida2hora, inputSaida2minuto);
                break;
            default:
        }
        impedirHoraMinutoEntradaMaiorHoraMinutoSaida('input-entrada1', 'input-saida1');
        impedirHoraMinutoEntradaMaiorHoraMinutoSaida('input-entrada2', 'input-saida2');
        atualizarHorarios();
    });

    $("[class^=subtrai_minuto]").on('click', function (event) {
        event.preventDefault();
        var tipoSelecionado = $(this).attr('class').split("-")[1];

        switch (tipoSelecionado) {
            case 'entrada1':
                subtrairMinutoNoInput(inputEntrada1, inputEntrada1hora, inputEntrada1minuto);
                break;
            case 'saida1':
                subtrairMinutoNoInput(inputSaida1, inputSaida1hora, inputSaida1minuto);
                break;
            case 'entrada2':
                subtrairMinutoNoInput(inputEntrada2, inputEntrada2hora, inputSaida2minuto);
                break;
            case 'saida2':
                subtrairMinutoNoInput(inputSaida2, inputSaida2hora, inputSaida2minuto);
                break;
            default:
        }
        impedirHoraMinutoEntradaMaiorHoraMinutoSaida('input-entrada1', 'input-saida1');
        impedirHoraMinutoEntradaMaiorHoraMinutoSaida('input-entrada2', 'input-saida2');
        atualizarHorarios();
    });

    function atualizarHorarios() {

        var horaEntrada1 = inputEntrada1.val().split(':')[0];
        var minutoEntrada1 = inputEntrada1.val().split(':')[1];
        $("#input-entrada1-hora").val(horaEntrada1);
        $("#input-entrada1-minuto").val(minutoEntrada1);

        var horaSaida1 = $("#input-saida1").val().split(':')[0];
        var minutoSaida1 = $("#input-saida1").val().split(':')[1];
        $("#input-saida1-hora").val(horaSaida1);
        $("#input-saida1-minuto").val(minutoSaida1);

        var horaEntrada2 = $("#input-entrada2").val().split(':')[0];
        var minutoEntrada2 = $("#input-entrada2").val().split(':')[1];
        $("#input-entrada2-hora").val(horaEntrada2);
        $("#input-entrada2-minuto").val(minutoEntrada2);

        var horaSaida2 = $("#input-saida2").val().split(':')[0];
        var minutoSaida2 = $("#input-saida2").val().split(':')[1];
        $("#input-saida2-hora").val(horaSaida2);
        $("#input-saida2-minuto").val(minutoSaida2);
    }

    atualizarHorarios();


    $('#input-entrada1-hora,#input-entrada1-minuto,#input-saida1-hora,#input-saida1-minuto,#input-entrada2-hora,#input-entrada2-minuto,#input-saida2-hora,#input-saida2-minuto').focus(function () {
        var inputTotalRelacionado = "#input-" + $(this).attr('id').split("-")[1];
        setarHorarioAtualSeInputAindaNaoPreenchido($(inputTotalRelacionado));
        impedirHoraMinutoEntradaMaiorHoraMinutoSaida('input-entrada1', 'input-saida1');
        impedirHoraMinutoEntradaMaiorHoraMinutoSaida('input-entrada2', 'input-saida2');
        atualizarHorarios();
    });
    /*
     * Envia dados frequencia para alteração no banco de dados
     * listarServidores()
     */
    var formEditarRegistro = $('#form-editar-evento');
    var modalEditarRegistro = $("#modal-editar-evento");
    var botaoConfirmarAlteracao = $('#button-evento-editar-enviar');
    var urlAlterar = 'registrar-frequencia/alterar';
    formEditarRegistro.submit(function (event) {
        event.preventDefault();
        botaoConfirmarAlteracao.prop('disabled', true);
        var form = $(this);
        var data = form.serialize();

        $.ajax({
            url: urlAlterar,
            data: data,
            method: 'post',
            success: function (resposta) {
                exibirAlertaBootstrap(resposta.mensagem, resposta.classe);
                modalEditarRegistro.modal('toggle');
                botaoConfirmarAlteracao.prop('disabled', false);
                listarRegistros($('#input-frequencia-id').val());
            },
            error: function (resposta) {
                botaoConfirmarAlteracao.prop('disabled', false);
            }
        });

    });

</script>
<!--Fim Editar Escala-->


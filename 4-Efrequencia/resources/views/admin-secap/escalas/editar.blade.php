<!-- Corpo de um modal Modal Editar Escala-->
<div class="modal-dialog modal-escala">
    <!-- Modal Content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4>Alterar Escala</h4>
        </div>
        <div class="modal-body modal-body-escala">
            <form id="form-editar-frequencia" method="POST">
                <!-- metodo para proteção csrf nativo laravel-->
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="frequencia_id" value="{{ $frequencia->id }}">
                <div class="form-group row">
                    <label class="col-sm-1">Nome:</label>
                    <div class="col-sm-6">
                        <span id="span-escalado-editar">{{$frequencia->servidorEscalado->nome}}</span>
                    </div>
                    <div class="col-sm-2">
                        <button id="button-marcar-escala-todos-editar" type="button" class="btn btn-default">Marcar Todos</button>
                    </div>
                    <div class="col-sm-2">
                        <button id="button-marcar-folga-todos-editar" type="button" class="btn btn-default">Pagamento Todos</button>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-1">Lotação ou Serviço:</label>
                    <div class="col-sm-4">
                        <input id="input-lotacao" type="text" name="lotacao" class="form-control" value="{{$frequencia->lotacao}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Dia</th>
                                    <th>Escalado</th>
                                    <th>Preferência Conversão</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($periodoAnoAtual as $dia)
                                <?php $encontrado = false; ?>
                                @forelse($frequencia->eventos as $evento)
                                @if($dia === $evento->dia_id )
                                <tr>
                            <input type="hidden" name="dia_id|{{$evento->dia_id}}" value="{{$evento->dia_id}}"/>
                            <td class="vert-align">
                                {{FormatacaoDataHelper::formatarDataSqlToddmmyyyy($evento->dia_id)}}
                            </td>
                            <td>
                                <input name="escalado-dia|{{$evento->dia_id}}" checked type="checkbox" data-toggle="toggle" data-on="<i class='fa fa-check'></i> Sim" data-off="<i class='fa fa-close'></i> Não" data-width="100" data-onstyle="success" data-offstyle="default">
                            </td>
                            <td>
                                <div name="div-opcao-dia|{{$evento->dia_id}}" >
                                    <input name="opcao-dia|{{$evento->dia_id}}" type="checkbox" data-toggle="toggle" {{($evento->opcao ? 'checked':'')}} data-on="<i class='fa fa-bed'></i> Folga" data-off="<i class='fa fa-dollar'></i> Pagamento" data-width="150" data-display="none"  data-onstyle="info" data-offstyle="warning">
                                </div>
                            </td>
                            </tr>
                            <?php $encontrado = true; ?>
                            @break


                            @endif
                            @empty
                            <option>Ops... Tente novamente mais tarde</option>
                            @endforelse
                            @if($encontrado == false)
                            <tr>
                            <input type="hidden" name="dia_id|{{$dia}}" value="{{$dia}}"/>
                            <td class="vert-align">
                                {{FormatacaoDataHelper::formatarDataSqlToddmmyyyy($dia)}}
                            </td>
                            <td>
                                <input name="escalado-dia|{{$dia}}" type="checkbox" data-toggle="toggle" data-on="<i class='fa fa-check'></i> Sim" data-off="<i class='fa fa-close'></i> Não" data-width="100" data-onstyle="success" data-offstyle="default">
                            </td>
                            <td>
                                <div name="div-opcao-dia|{{$dia}}" class="nao-exibir">
                                    <input name="opcao-dia|{{$dia}}" type="checkbox" checked data-toggle="toggle" data-on="<i class='fa fa-bed'></i> Folga" data-off="<i class='fa fa-dollar'></i> Pagamento" data-width="150" data-display="none"  data-onstyle="info" data-offstyle="warning">
                                </div>
                            </td>
                            </tr>
                            @endif
                            @empty
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Dia</th>
                                    <th>Escalado</th>
                                    <th>Preferência Conversão</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($periodoAnoProximo as $dia)
                                <?php $encontrado = false; ?>
                                @forelse($frequencia->eventos as $evento)
                                @if($dia === $evento->dia_id )
                                <tr>
                            <input type="hidden" name="dia_id|{{$evento->dia_id}}" value="{{$evento->dia_id}}"/>
                            <td class="vert-align">
                                {{FormatacaoDataHelper::formatarDataSqlToddmmyyyy($evento->dia_id)}}
                            </td>
                            <td>
                                <input name="escalado-dia|{{$evento->dia_id}}" checked type="checkbox" data-toggle="toggle" data-on="<i class='fa fa-check'></i> Sim" data-off="<i class='fa fa-close'></i> Não" data-width="100" data-onstyle="success" data-offstyle="default">
                            </td>
                            <td>
                                <div name="div-opcao-dia|{{$evento->dia_id}}" >
                                    <input name="opcao-dia|{{$evento->dia_id}}" type="checkbox" data-toggle="toggle" {{($evento->opcao ? 'checked':'')}} data-on="<i class='fa fa-bed'></i> Folga" data-off="<i class='fa fa-dollar'></i> Pagamento" data-width="150" data-display="none"  data-onstyle="info" data-offstyle="warning">
                                </div>
                            </td>
                            </tr>
                            <?php $encontrado = true; ?>
                            @break


                            @endif
                            @empty
                            <option>Ops... Tente novamente mais tarde</option>
                            @endforelse
                            @if($encontrado === false)
                            <tr>
                            <input type="hidden" name="dia_id|{{$dia}}" value="{{$dia}}"/>
                            <td class="vert-align">
                                {{FormatacaoDataHelper::formatarDataSqlToddmmyyyy($dia)}}
                            </td>
                            <td>
                                <input name="escalado-dia|{{$dia}}" type="checkbox" data-toggle="toggle" data-on="<i class='fa fa-check'></i> Sim" data-off="<i class='fa fa-close'></i> Não" data-width="100" data-onstyle="success" data-offstyle="default">
                            </td>
                            <td>
                                <div name="div-opcao-dia|{{$dia}}" class="nao-exibir">
                                    <input name="opcao-dia|{{$dia}}" type="checkbox" checked data-toggle="toggle" data-on="<i class='fa fa-bed'></i> Folga" data-off="<i class='fa fa-dollar'></i> Pagamento" data-width="150" data-display="none"  data-onstyle="info" data-offstyle="warning">
                                </div>
                            </td>
                            </tr>
                            @endif
                            @empty
                            @endforelse

                            </tbody>

                        </table>
                    </div>

                </div>
            </form>
        </div>
        <div class="modal-footer">

            <div class="form-group row">
                <div class="col-sm-6">
                    <button type="button" class="btn btn-danger btn-default pull-left" data-dismiss="modal">
                        Cancelar
                    </button>
                </div>
                <div class="col-sm-6">
                    <button id='button-frequencia-editar-enviar' form="form-editar-frequencia" type="submit" class="btn btn-primary pull-right">Salvar Alterações</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    /*Configurando os novos elementos
     * carregados nesta view
     */
    $("input[name*='escalado-dia']").bootstrapToggle();
    $("input[name*='opcao-dia']").bootstrapToggle();
    $("input[name*='escalado-dia']").change(function (event) {
        var dia = $(this).prop('name').split('|')[1];
        var nomeDivOpcaoRelacionada = "div-opcao-dia|" + dia;
        if ($(this).prop('checked')) {
            $("div[name='" + nomeDivOpcaoRelacionada + "']").show();
        } else {
            $("div[name='" + nomeDivOpcaoRelacionada + "']").hide();
        }

    });
    /*
     * Envia dados frequencia para alteração no banco de dados
     * Ao retornar, atualiza a lista de frequencias por meio do metodo
     * listarServidores()
     */
    var formEditarRegistro = $('#form-editar-frequencia');
    var modalEditarRegistro = $("#modal-editar-frequencia");
    var botaoConfirmarAlteracao = $('#button-frequencia-editar-enviar');
    var urlAlterar = 'escalas/alterar';
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
                listarRegistros();
            },
            error: function (resposta) {
                botaoConfirmarAlteracao.prop('disabled', false);
            }
        });

    });

    var botaoAlternarEscalaTodos = $("#button-marcar-escala-todos-editar");
    var botaoAlternarFolgaTodos = $("#button-marcar-folga-todos-editar");
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


</script>
<!--Fim Editar Escala-->


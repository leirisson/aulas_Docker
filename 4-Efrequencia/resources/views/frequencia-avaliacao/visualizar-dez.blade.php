<!-- Corpo de um modal Modal Editar Escala-->
<div class="modal-dialog modal-escala">
    <!-- Modal Content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4>Visualizar Frequência - {{$frequencia->recesso->descricao}} - Dezembro</h4>
        </div>
        <div class="modal-body modal-body-escala">
            <form id="form-avaliar-frequencia" method="POST">
                <!-- metodo para proteção csrf nativo laravel-->
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="frequencia_id" value="{{ $frequencia->id }}">
                <div class="form-group row">
                    <label class="col-sm-1">Nome:</label>
                    <div class="col-sm-6">
                        <span id="span-escalado-editar">{{$frequencia->servidorEscalado->nome}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Dia</th>
                                    <th>Entrada 1</th>
                                    <th>Saída 1</th>
                                    <th>Entrada 2</th>
                                    <th>Saída 2</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($eventos as $evento)
                                <tr>
                                    <td class="vert-align">
                                        {{FormatacaoDataHelper::formatarDataSqlToddmmyyyy($evento->dia_id)}}
                                    </td>
                                    <td>
                                        {{$evento->entrada1}}
                                    </td>
                                    <td>
                                        {{$evento->saida1}}
                                    </td>
                                    <td>
                                        {{$evento->entrada2}}
                                    </td>
                                    <td>
                                        {{$evento->saida2}}
                                    </td>
                                </tr>
                                @empty
                            <option>Ops... Tente novamente mais tarde</option>
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
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                        Fechar
                    </button>
                </div>
                @if($frequencia->status_id_dez==2)
                <div class="col-sm-6">
                    <button id='button-abrir-modal-avaliar-frequencia-dez' type="button" class="btn btn-primary pull-right">Validar Frequência de Dezembro</button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    var botaoAbrirModalDesfazerEnvioChefia = $("#button-abrir-modal-avaliar-frequencia-dez");
    var modalValidarFrequencia = $("#modal-validar-frequencia-dez");
    var modalVisualizarFrequencia = $("#modal-visualizar-frequencia-dez");
    var paragrafoMensagem = $('#p-mensagem-validar-dez');
    botaoAbrirModalDesfazerEnvioChefia.click(function () {
        //Passando dados para um modal
        modalVisualizarFrequencia.modal('hide');
        paragrafoMensagem.text('Tem certeza que deseja validar a frequencia de DEZEMBRO do servidor ' + modalVisualizarFrequencia.data('nome_servidor') + '?')
        modalValidarFrequencia.data('frequenciaid', modalVisualizarFrequencia.data('frequenciaid')).modal();
    });
</script>
<!--Fim Editar Escala-->


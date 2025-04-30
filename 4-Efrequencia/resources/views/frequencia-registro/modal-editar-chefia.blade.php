<!-- Corpo de um modal Modal Editar A Chefia Responsavel por Acompanhar e Validar uma Frequencia-->
<div class="modal-dialog">
    <!-- Modal Content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4>Redefinir Chefia</h4>
        </div>
        <div class="modal-body">
            @if(count($frequencia->avaliacoes))
            <form id="form-editar-chefia" method="POST">
                <!-- metodo para proteção csrf nativo laravel-->
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="frequencia_id" value="{{ $frequencia->id }}">
                <input type="hidden" name="avaliacao_id" value="{{ $frequencia->avaliacoes[0]->id }}">
                <div class="form-group row">
                    <label class="col-sm-2">Chefia Imediata:</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="select-servidores-editar" name="servidor_id" required style="width: 100%">
                            <option value="">Selecione o servidor</option>
                            @forelse($servidores as $servidor)
                            @if($servidor->matricula !== session('matricula_servidor_logado'))
                            <option value="{{$servidor->id}}"  {{$frequencia->avaliacoes[0]->servidorDisponivelPara->id == $servidor->id?"selected" : ''}}>{{$servidor->nome}}</option>
                            @endif
                            @empty
                            <option>Nenhum servidor carregado</option>
                            @endforelse
                        </select>
                    </div>
                </div>
            </form>
            @else
            <p>
                Ainda não é possível redefinir a chefia.
            </p>

            @endif
        </div>
        <div class="modal-footer">

            <div class="form-group row">
                <div class="col-sm-6">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                        Cancelar
                    </button>
                </div>
                @if(count($frequencia->avaliacoes))
                <div class="col-sm-6">
                    <button id='button-chefia-editar-enviar' type="submit" form="form-editar-chefia" class="btn btn-primary pull-right">
                        Ok, redefinir chefia
                    </button>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>
<script>
    /*
     * Envia dados servidor para alteração no banco de dados
     * Ao retornar, atualiza a lista de servidores por meio do metodo
     * listarServidores()
     */
    var formEditarRegistro = $('#form-editar-chefia');
    var modalEditarRegistro = $("#modal-editar-chefia");
    var botaoConfirmarAlteracao = $('#button-chefia-editar-enviar');
    var urlAlterar = 'alterar-chefia';
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
                exibirAlertaBootstrap(resposta.mensagem, resposta.classe);
                modalEditarRegistro.modal('toggle');
                botaoConfirmarAlteracao.prop('disabled', false);
                listarRegistros();
            }
        });

    });

    var selectServidores = $('#select-servidores-editar');
    selectServidores.select2();

</script>
<!--Fim Editar Situação-->


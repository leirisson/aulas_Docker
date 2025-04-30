<!-- Corpo de um modal Modal Editar Situação-->
<div class="modal-dialog">
    <!-- Modal Content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4>Alterar Servidor</h4>
        </div>
        <div class="modal-body">
            <form id="form-editar-servidor" method="POST">
                <!-- metodo para proteção csrf nativo laravel-->
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="servidor_id" value="{{ $servidor->id }}">
                <fieldset><legend>Dados do Servidor</legend>
                    <div class="form-group row">
                        <label class="col-sm-2">Matricula:</label>
                        <div class="col-sm-10">
                            <input type="text" class="input-sm form-control" required name="matricula_servidor" placeholder="Matricula Servidor" value="{{$servidor->matricula}}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2">Nome:</label>
                        <div class="col-sm-10">
                            <input type="text" class="input-sm form-control" required name="nome_servidor" placeholder="Nome do Servidor" value="{{$servidor->nome}}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2">E-mail:</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="exampleInputEmail1" name="email_servidor" placeholder="Email" value="{{$servidor->email}}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2">Permissões:</label>
                        <div class="col-sm-10">
                            <div class="checkbox">
                                <label><input type="checkbox" name="admin_sepag" {{ $servidor->admin_sepag?"checked":""}}>Administrador Sepag</label>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <button id='button-servidor-editar-enviar' type="submit" class="btn btn-primary pull-right">Salvar Alterações</button>
                    </div>
                </div>

            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-default pull-left" data-dismiss="modal">
                Cancelar
            </button>
        </div>
    </div>
</div>
<script>
    /*
     * Envia dados servidor para alteração no banco de dados
     * Ao retornar, atualiza a lista de servidores por meio do metodo
     * listarServidores()
     */
    var formEditarRegistro = $('#form-editar-servidor');
    var modalEditarRegistro = $("#modal-editar-servidor");
    var botaoConfirmarAlteracao = $('#button-servidor-editar-enviar');
    var urlAlterar = 'servidores/alterar';
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

</script>
<!--Fim Editar Situação-->


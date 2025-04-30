<div class="modal-dialog modal-escala">
    <!-- Modal Content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4>Visualizar Frequência - {{$frequencia->recesso->descricao}}</h4>
        </div>
        <div class="modal-body">

            <div class="row">
                <label class="col-sm-1">Nome:</label>
                <div class="col-sm-7">
                    <span id="span-escalado-editar">{{$frequencia->servidorEscalado->nome}}</span>

                </div>
            </div>
            <div class="row">
                <table class="table table-striped header-fixed">
                    <thead>
                        <tr>
                            <th>Dia</th>
                            <th>Entrada 1</th>
                            <th>Saída 1</th>
                            <th>Entrada 2</th>
                            <th>Saída 2</th>
                            <th>Preferência</th>
                            <th>Total Horas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($eventos as $evento)
                        <tr>
                            <td class="vert-align">
                                {{FormatacaoDataHelper::formatarDataSqlToddmmyyyy($evento->dia_id)}}
                            </td>
                            <td class="vert-align">
                                {{$evento->entrada1}}
                            </td>
                            <td class="vert-align">
                                {{$evento->saida1}}
                            </td>
                            <td class="vert-align">
                                {{$evento->entrada2}}
                            </td>
                            <td class="vert-align">
                                {{$evento->saida2}}
                            </td>
                            <td class="vert-align">
                                {{$evento->opcao?'FOLGA':'PAGAMENTO'}}
                            </td>
                            <td class="vert-align">
                                {{$evento->getTotalHoras()}}
                            </td>
                        </tr>
                        @empty
                        Ops... Tente novamente mais tarde
                        @endforelse

                    </tbody>
                </table>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                Fechar
            </button>
        </div>
    </div>
</div>



@extends('layouts.master_admin_secap')

@section('title', 'Escalações')
@section('pagescript')
<!-- vendor para exportacao da tabela -->

<script type="text/javascript" src="{{ URL::asset('vendors/bootstrap-table-contextmenu-1.11.0/extensions/export/bootstrap-table-export.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('vendors/bootstrap-table-contextmenu-1.11.0/extensions/export/tableExport.js') }}"></script>


<script type="text/javascript" src="{{ URL::asset('vendors/bootstrap-toggle/js/bootstrap-toggle.js')}}"></script>

<script src="{{ URL::asset('vendors/select2-4.0.3/dist/js/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/nucre-regras-negocio.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/util/util-nucre.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/escalas/escalas-script.js')}}"></script>
@stop
@section('pagecss')
<link rel="stylesheet" href="{{ URL::asset('vendors/bootstrap-toggle/css/bootstrap-toggle.css')}}">
<link rel="stylesheet" href="{{ URL::asset('vendors/select2-4.0.3/dist/css/select2.css') }}">

<link rel="stylesheet" href="{{ URL::asset('css/escalas/escalas-style.css')}}">
<style>
    .table tbody>tr>td.vert-align{
        vertical-align: middle;
    }
    .nao-exibir { display: none;}

    .exibir { display: "";}
    .modal-escala {
        /* new custom width */
        width: 70%;
        overflow-y: initial !important
    }
    .modal-body-escala{
        height: 600px;
        overflow-y: auto;
    }
</style>
@stop
@section('content')

<!--Alerta Modal Bootstrap 1-->
<div class="modal fade" id="div-modal-msg-aguarde" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Aguarde...</h4>
            </div>
            <div class="modal-body">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" role="progressbar"
                         aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:100%">                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Fim Alerta MOdal  Bootstrap 1-->


<!--Modal Novo Frequencia-->

<div class="modal fade" id="modal-novo-frequencia" role="dialog" style="overflow: hidden">
    <div class="modal-dialog modal-escala">
        <!-- Modal Content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Cadastrar Escala Servidor</h4>
            </div>
            <div class="modal-body modal-body-escala">
                <form id="form-novo-frequencia" method="POST">
                    <!-- metodo para proteção csrf nativo laravel-->
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input id="input-recesso-id" type="hidden" name="recesso_id_input" value="{{$recessos[0]->id}}">
                    <div class="form-group row">
                        <label class="col-sm-1">Servidor:</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="select-servidores" name="servidor_id" required style="width: 100%">
                                <option value="">Selecione o servidor</option>
                                @forelse($servidores as $servidor)
                                <option value="{{$servidor->id}}">{{$servidor->nome}}</option>
                                @empty
                                <option>Nenhum servidor carregado</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <button id="button-marcar-escala-todos" type="button" class="btn btn-default">Marcar Todos</button>
                        </div>
                        <div class="col-sm-2">
                            <button id="button-marcar-folga-todos" type="button" class="btn btn-default">Pagamento Todos</button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-1">Quem Autoriza:</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="select-servidores-autoriza" name="servidor_autoriza_id" required style="width: 100%">
                                <option value="">Selecione o servidor</option>
                                @forelse($servidores as $servidor)
                                <option value="{{$servidor->id}}">{{$servidor->nome}}</option>
                                @empty
                                <option>Nenhum servidor carregado</option>
                                @endforelse
                            </select>
                        </div>
                        <label class="col-sm-1">Lotação ou Serviço:</label>
                        <div class="col-sm-4">
                            <input id="input-lotacao" type="text" name="lotacao" class="form-control">
                        </div>
                    </div>
                    <span id="span-dados-ja-escalado"></span>
                    <div id="div-dias-recesso-selecionado">
                    <!-- dias carregado via ajax ao selecionar o recesso -->
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
                        <button id='button-novo-frequencia-enviar' form="form-novo-frequencia" type="submit" class="btn btn-primary pull-right">Cadastrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Fim Modal Novo Frequencias-->
<!--Area botao Novo Frequencia-->

<fieldset>
    <legend>Lista dos Servidores Escalados
        <button 
            type="button" 
            class="btn btn-xs btn-info" 
            style="border-radius: 50%" 
            data-toggle="tooltip" 
            data-placement="right" 
            title="Nesta página é possível escalar os servidores conforme listagem publicada em boletim de serviço">?
        </button> 
    </legend>
</fieldset>  
<div class="form-group row">
    <div class="col-sm-5">
        <select class="form-control" id="select-recessos" name="recesso_id" required style="width: 100%">
            @forelse($recessos as $recesso)
            <option value="{{$recesso->id}}" {{$recesso->id == $idRecesso?"selected":""}}>{{$recesso->descricao}}</option>
            @empty
            <option>Nenhum servidor carregado</option>
            @endforelse
        </select>
    </div>
</div>
<!--Fim Area botao Novo Frequencia-->
<!-- Tabela Frequencias -->
<div id="div-toolbar-tabela">
    <div class="form-inline" role="form">
        <div class="btn-toolbar">
            <!-- Botao novo Frequencias-->
            <button type="button" class="btn btn-success" id="button-novo-frequencia"><i class="glyphicon glyphicon-plus"></i>&nbsp;Nova Escala</button>
        </div>
    </div>
</div>
<table id="tabela-escalas" 
       class="table table-hover table-striped table-bordered" 
       data-url="{{route('retorna-lista-escalas-secap')}}"
       data-search="true" 
       data-toolbar="#div-toolbar-tabela"
       data-pagination="true"
       data-show-export="true"
       data-export-types="['excel']"
       data-sort-name="servidor_escalado.nome"
       data-id-field="id"> 

    <thead>
        <tr>
            <th data-field="servidor_escalado.matricula" data-sortable="true">Matrícula</th>
            <th data-field="servidor_escalado.nome" data-sortable="true">Nome</th> 
            <th data-field="recesso.descricao" data-sortable="true">Recesso</th>       
            <th data-field="eventos" data-sortable="true" data-formatter="formatarEventos">Período Escalado</th>
            <th data-field="eventos" data-sortable="true" data-formatter="formatarEventosFolga">Preferência pela Folga</th>
            <th data-field="eventos" data-sortable="true" data-formatter="formatarEventosPagamento">Preferência pelo Pagamento</th>
        </tr>
    </thead>
    <tbody id="tbody-tabela-escalas">

    </tbody>
</table>
<!-- Fim Tabela Frequencias -->
<!-- Opcoes Menu Contexto -->
<ul id="ul-menu-contexto-tabela-frequencia" class="dropdown-menu">
    <li data-item="alterar"><a><span class="glyphicon glyphicon-edit pull-left"></span>&nbsp;&nbsp;Alterar</a></li>
    <li class="divider"></li>
    <li data-item="deletar"><a><span class="glyphicon glyphicon-trash pull-left"></span>&nbsp;&nbsp;Excluir</a></li>
</ul>
<!-- Fim Opcoes Menu Contexto -->
<!--Modal Excluir Pedido-->
<div class="modal fade" id="modal-confirma-exclusao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Confirmar Exclusão</h4>
            </div>
            <div class="modal-body">
                <p id="p-mensagem-excluir">Tem certeza que deseja excluir este frequencia?</p>
                <p>Esta ação não poderá ser desfeita.</p>

                <p class="debug-url"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a id="button-confirma-exclusao" class="btn btn-danger btn-ok">Excluir</a>
            </div>
        </div>
    </div>
</div>
<!--Fim Modal Excluir Pedido-->
<!--Div para modal editar. Seu conteudo é carregado via ajax-->
<div class="modal fade" id="modal-editar-frequencia" role="dialog">
    <!--Corpo carregado de views/escalas/editar.blade.php-->
</div>
<!--Div para modal editar. Seu conteudo é carregado via ajax-->
@stop
@extends('layouts.master_admin_secap')

@section('title', 'Servidores - Gerenciar')
@section('pagescript')
<!-- vendor para exportacao da tabela -->

<script type="text/javascript" src="{{ URL::asset('vendors/bootstrap-table-contextmenu-1.11.0/extensions/export/bootstrap-table-export.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('vendors/bootstrap-table-contextmenu-1.11.0/extensions/export/tableExport.js') }}"></script>


<script type="text/javascript" src="{{ URL::asset('js/util/util-nucre.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/servidores/servidores-script.js') }}"></script>
@stop
@section('pagecss')
<link rel="stylesheet" href="{{ URL::asset('css/servidores/servidores-style.css')}}">
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


<!--Modal Novo Servidor-->

<div class="modal fade" id="modal-novo-servidor" role="dialog">
    <div class="modal-dialog">
        <!-- Modal Content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Cadastrar Novo Servidor</h4>
            </div>
            <div class="modal-body">
                <form id="form-novo-servidor" method="POST">
                    <!-- metodo para proteção csrf nativo laravel-->
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <fieldset><legend>Dados do Servidor</legend>
                        <div class="form-group row">
                            <label class="col-sm-2">Matricula:</label>
                            <div class="col-sm-10">
                                <input type="text" class="input-sm form-control" required name="matricula_servidor" placeholder="Matricula Servidor" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2">Nome:</label>
                            <div class="col-sm-10">
                                <input type="text" class="input-sm form-control" required name="nome_servidor" placeholder="Nome do Servidor" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2">E-mail:</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="exampleInputEmail1" name="email_servidor" placeholder="Email">
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button id='button-novo-servidor-enviar' type="submit" class="btn btn-primary pull-right">Cadastrar</button>
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
</div>

<!--Fim Modal Novo Servidores-->
<!--Area botao Novo Servidor-->

<fieldset>
    <legend>Lista de Servidores
        <button 
            type="button" 
            class="btn btn-xs btn-info" 
            style="border-radius: 50%" 
            data-toggle="tooltip" 
            data-placement="right" 
            title="Nesta página é possível gerenciar os servidores do órgão. Clique com o botão direito sobre um registro da tabela para dar permissões de administrador do sistema para o servidor">?
        </button> 
    </legend>
</fieldset>  
<!--Fim Area botao Novo Servidor-->
<!-- Tabela Servidores -->
<div id="div-toolbar-tabela">
    <div class="form-inline" role="form">
        <div class="btn-toolbar">
            <!-- Botao novo Servidores-->
            <button type="button" class="btn btn-success" id="button-novo-servidor"><i class="glyphicon glyphicon-plus"></i>&nbsp;Novo Servidor</button>
        </div>
    </div>
</div>
<table id="tabela-servidores" 
       class="table table-hover table-striped table-bordered" 
       data-url="servidores/lista"
       data-search="true" 
       data-toolbar="#div-toolbar-tabela"
       data-show-refresh="true"
       data-pagination="true"
       data-show-export="true"
       data-export-types="['excel']"
       data-show-columns="true" 
       data-id-field="id"> 
    <thead>
        <tr>
            <!--<th data-field="state" data-checkbox="true"></th>
            <th data-field="id" data-sortable="true">ID</th>  -->
            <th data-field="matricula" data-sortable="true">Matrícula</th>
            <th data-field="nome" data-sortable="true">Nome</th>         
            <th data-field="email" data-sortable="true">E-mail</th>
            <th data-field="created_at" data-sortable="true" data-formatter="formatarDataHora">Cadastrado em</th>      
        </tr>
    </thead>
    <tbody id="tbody-tabela-servidores">

    </tbody>
</table>
<!-- Fim Tabela Servidores -->
<!-- Opcoes Menu Contexto -->
<ul id="ul-menu-contexto-tabela-servidor" class="dropdown-menu">
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
                <p id="p-mensagem-excluir">Tem certeza que deseja excluir este servidor?</p>
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
<div class="modal fade" id="modal-editar-servidor" role="dialog">
    <!--Corpo carregado de views/servidores/editar.blade.php-->
</div>
<!--Div para modal editar. Seu conteudo é carregado via ajax-->
@stop
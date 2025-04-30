@extends('layouts.master')

@section('title', 'Validar Frequências')
@section('pagescript')
<!-- vendor para exportacao da tabela -->

<script type="text/javascript" src="{{ URL::asset('vendors/bootstrap-table-contextmenu-1.11.0/extensions/export/bootstrap-table-export.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('vendors/bootstrap-table-contextmenu-1.11.0/extensions/export/tableExport.js') }}"></script>


<script type="text/javascript" src="{{ URL::asset('vendors/bootstrap-toggle/js/bootstrap-toggle.js')}}"></script>

<script src="{{ URL::asset('vendors/select2-4.0.3/dist/js/select2.min.js') }}"></script>

<script type="text/javascript" src="{{ URL::asset('js/util/util-nucre.js?1') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/avaliar-frequencia/avaliar-frequencia-script.js?1')}}"></script>

<script type="text/javascript" src="{{ URL::asset('js/nucre-regras-negocio.js?1') }}"></script>
@stop
@section('pagecss')
<link rel="stylesheet" href="{{ URL::asset('vendors/bootstrap-toggle/css/bootstrap-toggle.css')}}">
<link rel="stylesheet" href="{{ URL::asset('vendors/select2-4.0.3/dist/css/select2.css') }}">

<style>
    .table tbody>tr>td.vert-align{
        vertical-align: middle;
    }
    .nao-exibir { display: none;}

    .exibir { display: "";}
    .modal-escala {
        /* new custom width */
        overflow-y: initial !important
    }
    .modal-body-escala{
        height: 400px;
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
<!--Area botao Novo -->

<fieldset>
    <legend>Validar Frequências
        <button 
            type="button" 
            class="btn btn-xs btn-info" 
            style="border-radius: 50%" 
            data-toggle="tooltip" 
            data-placement="right" 
            title="Aqui são exibidas as frequências pelas quais você é responsável. Clique sobre um registro da tabela para visualizar as opções">?
        </button>
    </legend>
</fieldset>
<!-- Tabela Frequencias -->
<div id="div-toolbar-tabela">
    <div class="form-inline" role="form">
        <div class="btn-toolbar">
            <select class="form-control" id="select-recessos" name="recesso_id" required style="width: 100%">
                @forelse($recessos as $recesso)
                <option value="{{$recesso->id}}" {{$recesso->id == $idRecesso?"selected":""}}>{{$recesso->descricao}}</option>
                @empty
                <option>Nenhum servidor carregado</option>
                @endforelse
            </select>
        </div>
    </div>
</div>
<table id="tabela-avaliacoes" 
       class="table table-hover table-striped table-bordered" 
       data-url="avaliar-frequencia/lista"
       data-toolbar="#div-toolbar-tabela"  
       data-pagination="true"
       data-sort-name="frequencia.servidor_escalado.nome"
       data-id-field="id"> 

    <thead>
        <tr>
            <th data-field="frequencia.servidor_escalado.matricula" data-sortable="true">Matrícula</th>
            <th data-field="frequencia.servidor_escalado.nome" data-sortable="true"  data-formatter="formatarComoLink">Nome</th> 
            <th data-field="frequencia.recesso.descricao" data-sortable="true">Ano</th>       
            <th data-field="frequencia.eventos" data-sortable="true" data-formatter="formatarEventos">Período Escalado</th>
            <th data-field="frequencia.eventos" data-sortable="true" data-formatter="formatarRegistroMaisRecente">Registro Mais Recente</th>
            <th data-field="frequencia" data-sortable="true" data-formatter="formatarStatusFrequenciaComDicaParaChefiaDez">Status Dezembro</th>
            <th data-field="frequencia" data-sortable="true" data-formatter="formatarStatusFrequenciaComDicaParaChefiaJan">Status Janeiro</th>
            
        </tr>
    </thead>
</table>
<!-- Fim Tabela Frequencias -->
<!-- Opcoes Menu Contexto -->
<ul id="ul-menu-contexto-tabela-frequencia" class="dropdown-menu">
    <li data-item="visualizar-dez" class="frequencia-aberta-dez"><a><span class="glyphicon glyphicon-eye-open pull-left"></span>&nbsp;&nbsp;Visualizar Frequência Dezembro</a></li>
    <li class="divider frequencia-aberta-jan"></li>
    <li data-item="visualizar-jan" class="frequencia-aberta-jan"><a><span class="glyphicon glyphicon-eye-open pull-left"></span>&nbsp;&nbsp;Visualizar Frequência Janeiro</a></li>
</ul>
<!-- Fim Opcoes Menu Contexto -->
<!--Modal Avaliar Frequencia DEZEMBRO-->
<div class="modal fade" id="modal-validar-frequencia-dez" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Validar Frequência de Dezembro</h4>
            </div>
            <div class="modal-body">
                <p id="p-mensagem-validar-dez">Tem certeza que deseja confirmar a frequência apresentada de Dezembro?</p>
                <p>Esta ação não poderá ser desfeita.</p>

                <p class="debug-url"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a id="button-confirma-validacao-dez" class="btn btn-danger btn-ok">Confirmar Validação</a>
            </div>
        </div>
    </div>
</div>

<!--Modal Avaliar Frequencia JANEIRO-->
<div class="modal fade" id="modal-validar-frequencia-jan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Validar Frequência de Janeiro</h4>
            </div>
            <div class="modal-body">
                <p id="p-mensagem-validar-jan">Tem certeza que deseja confirmar a frequência apresentada de Janeiro?</p>
                <p>Esta ação não poderá ser desfeita.</p>

                <p class="debug-url"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a id="button-confirma-validacao-jan" class="btn btn-danger btn-ok">Confirmar Validação</a>
            </div>
        </div>
    </div>
</div>

<!--Div para modal visualizar frequencia. Seu conteudo é carregado via ajax-->
<div class="modal fade" id="modal-visualizar-frequencia-dez" role="dialog">
    <!--Corpo carregado de views/frequencia-avaliacao/visualizar.blade.php-->
</div>
<!--Div para modal visualizar frequencia. Seu conteudo é carregado via ajax-->

<!--Div para modal visualizar frequencia. Seu conteudo é carregado via ajax-->
<div class="modal fade" id="modal-visualizar-frequencia-jan" role="dialog">
    <!--Corpo carregado de views/frequencia-avaliacao/visualizar.blade.php-->
</div>
<!--Div para modal visualizar frequencia. Seu conteudo é carregado via ajax-->
@stop
@extends('layouts.master')

@section('title', 'Registrar Frequência')
@section('pagescript')
<!-- vendor para exportacao da tabela -->

<script type="text/javascript" src="{{ URL::asset('vendors/bootstrap-table-contextmenu-1.11.0/extensions/export/bootstrap-table-export.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('vendors/bootstrap-table-contextmenu-1.11.0/extensions/export/tableExport.js') }}"></script>


<script type="text/javascript" src="{{ URL::asset('vendors/bootstrap-toggle/js/bootstrap-toggle.js')}}"></script>

<script type="text/javascript" src="{{ URL::asset('vendors/bootstrap-timepicker/js/bootstrap-timepicker.js')}}"></script>

<script src="{{ URL::asset('vendors/select2-4.0.3/dist/js/select2.min.js') }}"></script>

<script type="text/javascript" src="{{ URL::asset('js/util/util-nucre.js?1') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/nucre-regras-negocio.js?1') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/util/util-nucre-calculo-horas.js?1') }}"></script>

<script type="text/javascript" src="{{ URL::asset('js/eventos/eventos-script.js?2')}}"></script>

@stop
@section('pagecss')
<link rel="stylesheet" href="{{ URL::asset('vendors/bootstrap-toggle/css/bootstrap-toggle.css')}}">
<link rel="stylesheet" href="{{ URL::asset('vendors/select2-4.0.3/dist/css/select2.css') }}">

<link rel="stylesheet" href="{{ URL::asset('vendors/bootstrap-timepicker/css/bootstrap-timepicker.css')}}">

<link rel="stylesheet" href="{{ URL::asset('css/eventos/eventos-style.css')}}">
<style>
    .table tbody>tr>td.vert-align{
        vertical-align: middle;
    }
    .bootstrap-timepicker-widget table td{
        height: 20px !important;
    }
    .borda-direita{
        border-right: 1px solid #e5e5e5;
    }
    
    .tooltip {
        z-index: 2000 !important;
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

@if($frequencia == 'nao-escalado')
<fieldset><legend>Olá {{ucfirst(strtolower(strtok(session('nome_servidor_logado'), " ")))}}</legend>
</fieldset>
<p>
    Não há escalação para você no recesso atual ou sua escalação ainda não foi autorizada. 
</p>
<p>
    Converse com sua chefia imediata ou entre em contado com a Sepag.
</p>

@elseif($frequencia)
<!--Area botao Novo Frequencia-->

<fieldset>
    <legend>
        Minha Frequência - {{$frequencia->recesso->descricao}}
    </legend>
</fieldset>

<!--Fim Area botao Novo Frequencia-->
<!-- Tabela Frequencias -->
<div class="btn-toolbar form-group row">
    <div class="col-sm-1">        
        <label>Setor ou <br>Serviço:</label>
    </div>
    <div class="col-sm-3">
        <input type="hidden" id="input-frequencia-id" name="frequencia_id_input" value="{{$frequencia->id}}">
        <select class="form-control" id="select-frequencia-registro" name="frequencia_id_select">
            @forelse($frequencias as $freq)
            <option value="{{$freq->id}}">{{$freq->lotacao}}</option>
            @empty
            <option>Nenhuma lotação carregada</option>
            @endforelse
        </select>
    </div>

    <div class="col-sm-7">

        <button id='button-abrir-modal-envio-chefia-jan' class="btn btn-primary pull-right" style="display: none">Enviar para Chefia (JANEIRO)</button>

        <button id='button-abrir-modal-desfazer-envio-chefia-jan' class="btn btn-default pull-right"  style="display: none">Desfazer envio para chefia (JANEIRO)</button>

        <button id='button-abrir-modal-envio-chefia-dez' class="btn btn-primary pull-left" style="display: none">Enviar para Chefia (DEZEMBRO)</button>

        <button id='button-abrir-modal-desfazer-envio-chefia-dez' class="btn btn-default pull-left"  style="display: none">Desfazer envio para chefia (DEZEMBRO)</button>

    </div>
    
    <div class="col-sm-1">
        <!-- Botao para gerar relatório para PDF-->
        <button id="button" class="btn btn-default pull-left"><span class="fa fa-file-pdf-o"></span><span class="fa fa-print"></span></button>
    </div>
</div>
<table id="tabela-eventos" 
       class="table table-hover table-striped table-bordered" 
       data-url="{{route('retorna-lista-eventos-registrar')}}"
       data-id-field="id"> 

    <thead>
        <tr>
            <th data-field="dia_id" data-sortable="true" data-formatter="formatarDataComDiaDaSemanaMin">Dia</th>
            <th data-field="entrada1" data-sortable="true" data-formatter="formatarHoraRemoveSegundos">Entrada 1</th> 
            <th data-field="saida1" data-sortable="true" data-formatter="formatarHoraRemoveSegundos">Saída 1</th>       
            <th data-field="entrada2" data-sortable="true" data-formatter="formatarHoraRemoveSegundos">Entrada 2</th>
            <th data-field="saida2" data-sortable="true" data-formatter="formatarHoraRemoveSegundos">Saída 2</th>
            <th data-field="total" data-sortable="true" data-formatter="formatarTotalDia">Total de Horas</th>
            <th data-field="opcao" data-sortable="true" data-formatter="formatarOpcao">Opção Conversão</th>
            <th data-field="status" data-sortable="true"status.status_descricao data-formatter="formatarStatusFrequenciaComDicaPorDia">Status</th>

        </tr>
    </thead>
    <tbody id="tbody-tabela-eventos">

    </tbody>
</table>
<p name='total-horas'></p>
<!-- Fim Tabela Frequencias -->
<!-- Opcoes Menu Contexto -->
<ul id="ul-menu-contexto-tabela-frequencia" class="dropdown-menu frequencia-aberta">
    <li data-item="alterar" class="frequencia-aberta"><a><span class="glyphicon glyphicon-edit pull-left"></span>&nbsp;&nbsp;Registrar Frequência</a></li>
    <li class="divider frequencia-aberta"></li>
    <li data-item="deletar" class="frequencia-aberta"><a><span class="glyphicon glyphicon-trash pull-left"></span>&nbsp;&nbsp;Apagar Horários</a></li>
</ul>
<!-- Fim Opcoes Menu Contexto -->

<!--Modal Excluir Horário-->
<div class="modal fade" id="modal-confirma-exclusao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Confirmar Exclusão</h4>
            </div>
            <div class="modal-body">
                <p id="p-mensagem-excluir">Tem certeza que deseja apagar os horários registrados neste dia?</p>
                <p>Esta ação não poderá ser desfeita.</p>
                <p class="debug-url"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a id="button-confirma-exclusao" class="btn btn-danger btn-ok">Apagar</a>
            </div>
        </div>
    </div>
</div>
<!--Fim Modal Excluir Horário-->
<!--Modal Enviar para chefia DEZEMBRO-->
<div class="modal fade" id="modal-confirma-envio-chefia-dez" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Confirmar Envio para chefia do Período de <b>Dezembro</b></h4>
            </div>
            <div class="modal-body">
                <p>Atenção! Após enviar para chefia <b>não poderá mais fazer alterações na sua frequência</b>.</p>
                <p>Portanto, só envie para chefia caso tenha finalizado o preenchimento de <b>DEZEMBRO</b></p>
                <p class="debug-url"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a id="button-confirma-envio-chefia-dez" class="btn btn-danger btn-ok">Entendi, enviar para chefia (Dezembro).</a>
            </div>
        </div>
    </div>
</div>
<!--Fim Modal Envio Chefia-->

<!--Modal Desfazer Envio para chefia DEZEMBRO-->
<div class="modal fade" id="modal-desfazer-envio-chefia-dez" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Desfazer Envio para chefia do Período de Dezembro</h4>
            </div>
            <div class="modal-body">
                <p>Enquanto a Chefia não validou sua frequência, é possível desfazer o envio para realizar algum ajuste na frequência.</p>
                <p>Portanto, após a chefia avaliar sua frequência, este procedimento não será mais possível.</p>
                <p class="debug-url"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a id="button-confirma-desfazer-envio-chefia-dez" class="btn btn-danger btn-ok">Entendi, desfazer envio.</a>
            </div>
        </div>
    </div>
</div>
<!--Fim Modal Desfazer Envio Chefia-->

<!--Modal Enviar para chefia JANEIRO-->
<div class="modal fade" id="modal-confirma-envio-chefia-jan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Confirmar Envio para chefia do Período de <b>Janeiro</b></h4>
            </div>
            <div class="modal-body">
                <p>Atenção! Após enviar para chefia <b>não poderá mais fazer alterações na sua frequência</b>.</p>
                <p>Portanto, só envie para chefia caso tenha finalizado o preenchimento de <b>JANEIRO</b></p>
                <p class="debug-url"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a id="button-confirma-envio-chefia-jan" class="btn btn-danger btn-ok">Entendi, enviar para chefia (Janeiro).</a>
            </div>
        </div>
    </div>
</div>
<!--Fim Modal Envio Chefia JANEIRO-->

<!--Modal Desfazer Envio para chefia-->
<div class="modal fade" id="modal-desfazer-envio-chefia-jan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Desfazer Envio para chefia do Período de Janeiro</h4>
            </div>
            <div class="modal-body">
                <p>Enquanto a Chefia não validou sua frequência, é possível desfazer o envio para realizar algum ajuste na frequência.</p>
                <p>Portanto, após a chefia avaliar sua frequência, este procedimento não será mais possível.</p>
                <p class="debug-url"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a id="button-confirma-desfazer-envio-chefia-jan" class="btn btn-danger btn-ok">Entendi, desfazer envio.</a>
            </div>
        </div>
    </div>
</div>
<!--Fim Modal Desfazer Envio Chefia-->

<!--Div para modal editar. Seu conteudo é carregado via ajax-->
<div class="modal fade" id="modal-editar-evento" role="dialog" data-backdrop="static">
    <!--Corpo carregado de views/eventos/editar.blade.php-->
</div>
<!--Div para modal editar. Seu conteudo é carregado via ajax-->
@else
<fieldset><legend>Registrar Frequência - Recesso Judiciário</legend>
</fieldset>
<p>
    No momento não está aberto o período para registro de frequência do recesso.
</p>
<p>
    Para visualizar suas frequências, clique no menu superior <a href="{{route('frequencia-selecao')}}">"Minhas Frequências"</a>.
</p>
<p>
    Para validação de frequências, clique no menu superior <a href="{{route('avaliar-index')}}">"Validar Frequências"</a>.
</p>


@endif
@stop
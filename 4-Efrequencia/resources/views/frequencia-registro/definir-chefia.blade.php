@extends('layouts.master')

@section('title', 'Definir Chefia')
@section('pagescript')
<!-- vendor para exportacao da tabela -->
<script src="{{ URL::asset('vendors/select2-4.0.3/dist/js/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/util/util-nucre.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/definir-chefia/definir-chefia-script.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('vendors/bootstrap-toggle/js/bootstrap-toggle.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('vendors/bootstrap-tour-0.11.0/build/js/bootstrap-tour.min.js')}}"></script>

@stop
@section('pagecss')
<link rel="stylesheet" href="{{ URL::asset('vendors/select2-4.0.3/dist/css/select2.css') }}">
<link rel="stylesheet" href="{{ URL::asset('vendors/bootstrap-toggle/css/bootstrap-toggle.css')}}">
<link rel="stylesheet" href="{{ URL::asset('vendors/bootstrap-tour-0.11.0/build/css/bootstrap-tour.min.css') }}">
<style>
    .tour-backdrop{
        opacity: 0.3 !important;
    }
</style>
@stop
@section('content')
<fieldset><legend>{{$recesso->descricao}} - Definir Chefia</legend>
</fieldset>  
<!--Fim Area botao Novo Frequencia-->
<!-- Tabela Frequencias -->
<p>
    Selecione o nome da sua chefia imediata, responsável pela validação de sua frequência.
</p>

<p>
    A chefia imediata, neste contexto, é o servidor/magistrado que irá acessar o Sistema para validar sua frequência.
</p>

<p>
    Somente frequências validadas serão consideradas no cálculo de Banco de Horas ou Pagamento (caso haja recurso).
</p>

<form id="form-definir-chefia" method="GET">

    <!-- metodo para proteção csrf nativo laravel-->
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @forelse($frequencias as $frequencia)
    <div class="form-group row">
        <label class="col-md-4 control-label">Setor ou Serviço: {{$frequencia->lotacao}}</label>
        <label class="col-md-1 control-label">Chefia Imediata:</label>
        <div class="col-sm-5">

            <select class="form-control select-servidores" id="select-servidores" name="{{ $frequencia->id }}|servidor_id" required style="width: 100%">
                <option value="">Pesquisar o nome da chefia imediata</option>
                @forelse($servidores as $servidor)
                @if($servidor->matricula !== session('matricula_servidor_logado'))
                <option value="{{$servidor->id}}">{{$servidor->nome}}</option>
                @endif
                @empty
                <option>Nenhum servidor carregado</option>
                @endforelse
            </select>
        </div>


    </div>
    @empty
    <option>Nenhuma frequencia carregada</option>
    @endforelse

</form>


<div class="col-sm-12">

    <button id='button-definir-chefia-enviar' type="button" class="btn btn-primary pull-right">Concluir e Prosseguir</button>
</div>

<!--Modal Excluir Pedido-->
<div class="modal fade" id="modal-confirma" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Confirmar Chefia</h4>
            </div>
            <div class="modal-body">
                <p>Confirma a definição da chefia?</p>
                <p class="debug-url"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button id="button-confirma" class="btn btn-primary" type="submit" form="form-definir-chefia">Confirmar</button>
            </div>
        </div>
    </div>
</div>
@stop
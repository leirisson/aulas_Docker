@extends('layouts.master_admin_secap')

@section('title', 'Recesso - Gerenciar')
@section('pagescript')
<script type="text/javascript" src="{{ URL::asset('js/util/util-nucre.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/recessos/recessos-script.js') }}"></script>
@stop
@section('pagecss')
@stop
@section('content')
<a class="pull-left" href="{{route('recessos-index')}}">Voltar</a><br><br>

<fieldset>
    <legend>
        {{$tituloExibicao}} - @if(isset($recesso->id))
        Atualizar
        @else
        Cadastrar
        @endif
    </legend>
</fieldset>  
@if(isset($recesso->id))

<form id="form-recesso" method="POST" action="{{route('alterar-recesso',$recesso->id)}}">

    @else
    <form id="form-recesso" method="POST" action="{{route('adicionar-novo-recesso')}}">
        @endif
        <!-- metodo para proteção csrf nativo laravel-->
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="recesso_id" value="{{ $recesso->id }}">
        <fieldset><legend>Dados</legend></fieldset>

        <div class="form-group row">
            <label class="col-sm-2">Ano:</label>
            <div class="col-sm-10">
                <input type="number" class="input-sm form-control" required name="ano" value="{{ old('ano', $recesso->ano)}}" placeholder="Ano do Recesso" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2">Descrição:</label>
            <div class="col-sm-10">
                <input type="text" class="input-sm form-control" required name="descricao" value="{{ old('descricao', $recesso->descricao)}}" placeholder="Exemplo: Recesso 2015/2016" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2">Processo:</label>
            <div class="col-sm-10">
                <input type="text" class="input-sm form-control" required name="processo" value="{{ old('processo', $recesso->processo)}}" placeholder="Exemplo: 000800-11.2016.4.01.8000" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2">Frequência:</label>
            <div class="col-sm-10">
                <div class="checkbox">
                    <label><input type="checkbox" name="ativo" {{ old('ativo',($recesso->ativo?"checked":""))}}>Aberto para Registro de Frequência</label>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2">Período:</label>
            <div class="col-sm-10">
                <div class="input-daterange input-group" id="div-periodo">
                    <span class="input-group-addon"> De </span>
                    <input id="input-data-inicio" type="text" class="input-sm form-control"  required name="data_inicio" placeholder="Selecione a data de início" value="{{ old('data_inicio', date('d/m/Y',strtotime($recesso->data_inicio)))}}" />
                    <span class="input-group-addon"> até </span>
                    <input id="input-data-fim" type="text" class="input-sm form-control" required name="data_fim" placeholder="Selecione a data de fim" value="{{ old('data_fim', date('d/m/Y',strtotime($recesso->data_fim)))}}"/>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-6">
                <a class="btn btn-danger pull-left" href="{{route('recessos-index')}}">Cancelar</a>

            </div>

            <div class="col-sm-6">
                <button id='button-novo-registro' type="submit" class="btn btn-primary pull-right">
                    @if(isset($recesso->id))
                    Atualizar
                    @else
                    Cadastrar
                    @endif
                </button>
            </div>
        </div>

    </form>
    @stop
    @section('scripts')
    <script>
//Scripts para configuracoes adicionais
    </script>
    @stop
<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | This file is where you may define all of the routes that are handled
  | by your application. Just tell Laravel the URIs it should respond
  | to using a Closure or controller method. Build something great!
  |
 */

Route::get('/', [
    'uses' => 'HomeController@index',
    'as' => 'welcome'
]);


Route::get('login', [
    'uses' => 'AutenticacaoController@index',
    'as' => 'login-servidor'
]);
Route::get('login-admin', [
    'uses' => 'AutenticacaoController@adminIndex',
    'as' => 'login-admin'
]);

Route::post('/efetuarLogin', 'AutenticacaoController@efetuarLogin');
Route::get('/efetuarLogin', 'AutenticacaoController@index');
Route::post('/efetuarLoginAdmin', 'AutenticacaoController@efetuarLoginAdmin');

Route::get('/efetuarLogout', [
    'uses' => 'AutenticacaoController@efetuarLogout',
    'as' => 'efetuar-logout'
]);

Route::group(['prefix' => 'admin-secap/servidores', 'middleware' => 'checkLogadoAreaAdmin'], function() {
    Route::get('/', [
        'uses' => 'ServidorController@index',
        'as' => 'servidores-index'
    ]);

    Route::get('/lista', [
        'uses' => 'ServidorController@listarServidores',
        'as' => 'retorna-lista-servidores'
    ]);
    Route::post('/adicionar', [
        'uses' => 'ServidorController@adicionar',
        'as' => 'adicionar-novo-servidor'
    ]);

    Route::get('/deletar/{id}', [
        'uses' => 'ServidorController@deletar',
        'as' => 'deletar-servidor'
    ]);

    Route::get('/editar/{id}', [
        'uses' => 'ServidorController@mostrarEditar',
        'as' => 'mostrar-form-editar-servidor'
    ]);

    Route::post('/alterar', [
        'uses' => 'ServidorController@alterar',
        'as' => 'alterar-servidor'
    ]);
});

Route::group(['prefix' => 'admin-secap/painel', 'middleware' => 'checkLogadoAreaAdmin'], function() {
    Route::get('/{recesso_id}', [
        'uses' => 'PainelController@index',
        'as' => 'painel-index-com-id'
    ]);

    Route::get('/', [
        'uses' => 'PainelController@index',
        'as' => 'painel-index-sem-id'
    ]);
});

Route::group(['prefix' => 'admin-secap/frequencias', 'middleware' => 'checkLogadoAreaAdmin'], function() {
    Route::get('/', [
        'uses' => 'EscalaController@mostrarFrequenciasPorRecesso',
        'as' => 'frequencias-por-recesso-secap'
    ]);

    Route::get('/listar-frequencias/{idRecesso?}', [
        'uses' => 'EscalaController@listarFrequenciasRecessoSecap',
        'as' => 'listar-frequencia-recesso-secap'
    ]);    
    Route::get('/visualizar/{id}', [
        'uses' => 'AvaliacaoController@visualizarFrequenciaSecap',
        'as' => 'mostrar-form-visualizar-frequencia'
    ]);
    
    Route::get('/editar-chefia/{id}', [
        'uses' => 'EscalaController@mostrarEditarChefiaSecap',
        'as' => 'mostrar-form-editar-chefia-frequencia-secap'
    ]);
    
    Route::post('/alterar-chefia', [
        'uses' => 'EscalaController@alterarChefiaSecap',
        'as' => 'alterar-chefia-secap'
    ]);
    
    Route::get('/versao-pdf-dez/{idFrequencia?}', 'EventoController@frequenciaPDFSecapDez');
    Route::get('/versao-pdf-jan/{idFrequencia?}', 'EventoController@frequenciaPDFSecapJan');
});

Route::group(['prefix' => 'admin-secap/exportar-excel', 'middleware' => 'checkLogadoAreaAdmin'], function() {

    Route::get('/', [
        'uses' => 'EscalaController@mostrarFrequenciasPorRecessoParaExportarExcel',
        'as' => 'exportar-excel'
    ]);
    
    Route::get('/gerar-json-exportar-excel/{idRecesso?}', [
        'uses' => 'EscalaController@listarFrequenciasRecessoParaPlanilhaPagamento',
        'as' => 'gerar-json-exportar-excel'
    ]);
    
});

Route::group(['prefix' => 'admin-secap/recessos', 'middleware' => 'checkLogadoAreaAdmin'], function() {
    Route::get('/', [
        'uses' => 'RecessoController@index',
        'as' => 'recessos-index'
    ]);

    Route::get('/lista', [
        'uses' => 'RecessoController@listarRecessos',
        'as' => 'retorna-lista-recessos'
    ]);
    Route::post('/adicionar', [
        'uses' => 'RecessoController@adicionar',
        'as' => 'adicionar-novo-recesso'
    ]);

    Route::get('/deletar/{id}', [
        'uses' => 'RecessoController@deletar',
        'as' => 'deletar-recesso'
    ]);
    
    Route::get('/cadastrar-editar-recesso', [
        'uses' => 'RecessoController@mostrarEditar',
        'as' => 'mostrar-form-editar-recesso'
    ]);

    Route::get('/cadastrar-editar-recesso/{id}', [
        'uses' => 'RecessoController@mostrarEditar',
        'as' => 'mostrar-form-editar-recesso'
    ]);

    Route::post('/alterar', [
        'uses' => 'RecessoController@alterar',
        'as' => 'alterar-recesso'
    ]);
});

Route::group(['prefix' => 'admin-secap/escalas', 'middleware' => 'checkLogadoAreaAdmin'], function() {
    Route::get('/', [
        'uses' => 'EscalaController@index',
        'as' => 'escalas-index'
    ]);
    Route::get('/verifica-escala-por-servidor/{idServidor}/{idRecesso}', [
        'uses' => 'EscalaController@verificaEscalacaoServidor',
        'as' => 'verifica-escala-admin-secap'
    ]);
    
    Route::get('/lista/{id?}', [
        'uses' => 'EscalaController@listarEscalas',
        'as' => 'retorna-lista-escalas-secap'
    ]);
    Route::post('/adicionar', [
        'uses' => 'EscalaController@adicionar',
        'as' => 'adicionar-novo-escala'
    ]);

    Route::get('/deletar/{id}', [
        'uses' => 'EscalaController@deletar',
        'as' => 'deletar-escala'
    ]);

    Route::get('/editar/{id}', [
        'uses' => 'EscalaController@mostrarEditar',
        'as' => 'mostrar-form-editar-escala'
    ]);
    
    Route::get('/dias-recesso-selecionado/{id}', [
        'uses' => 'EscalaController@mostrarDiasRecessoSelecionado',
        'as' => 'mostrar-dias-recesso-selecionado'
    ]);

    Route::post('/alterar', [
        'uses' => 'EscalaController@secapAlterar',
        'as' => 'alterar-escala-menu-secap'
    ]);
    
    
});

Route::group(['prefix' => 'registrar-frequencia', 'middleware' => 'checkLogadoAreaComum'], function() {
    Route::get('/', [
        'uses' => 'EventoController@index',
        'as' => 'registrar-frequencia'
    ]);
    
    Route::get('/consulta-frequencia/{idFrequencia?}', [
        'uses' => 'EscalaController@consultarFrequencia',
        'as' => 'consulta-frequencia'
    ]);

    Route::get('/selecionar', [
        'uses' => 'EscalaController@mostrarFrequenciasPorServidor',
        'as' => 'frequencia-selecao'
    ]);

    Route::get('/definir-chefia', [
        'uses' => 'EscalaController@mostrarDefinirChefia',
        'as' => 'frequencia-definir-chefia'
    ]);

    Route::post('/definir-chefia-primeira-vez', [
        'uses' => 'EscalaController@definirChefia',
        'as' => 'frequencia-definir-chefia'
    ]);

    Route::get('/listar-frequencias', [
        'uses' => 'EscalaController@listarFrequenciasServidor',
        'as' => 'listar-frequencia-servidor'
    ]);

    Route::get('/versao-pdf/{idFrequencia?}', 'EventoController@frequenciaPDF');

    Route::get('/lista/{idFrequencia?}', [
        'uses' => 'EventoController@listarEventos',
        'as' => 'retorna-lista-eventos-registrar'
    ]);
    Route::post('/adicionar', [
        'uses' => 'EventoController@adicionar',
        'as' => 'adicionar-novo-evento'
    ]);

    Route::get('/deletar/{id}', [
        'uses' => 'EventoController@deletar',
        'as' => 'deletar-evento'
    ]);

    Route::get('/editar/{id}', [
        'uses' => 'EventoController@mostrarEditar',
        'as' => 'mostrar-form-editar-evento'
    ]);

    Route::get('/editar-chefia/{id}', [
        'uses' => 'EscalaController@mostrarEditarChefia',
        'as' => 'mostrar-form-editar-chefia-frequencia'
    ]);

    Route::get('/fechar-e-disponibilizar/{id}', [
        'uses' => 'EscalaController@fecharDisponibilizar',
        'as' => 'fechar-e-disponibilizar-frequencia'
    ]);
    
    Route::get('/fechar-e-disponibilizar-dez/{id}', [
        'uses' => 'EscalaController@fecharDisponibilizarDez',
        'as' => 'fechar-e-disponibilizar-frequencia-dez'
    ]);
    
    Route::get('/fechar-e-disponibilizar-jan/{id}', [
        'uses' => 'EscalaController@fecharDisponibilizarJan',
        'as' => 'fechar-e-disponibilizar-frequencia-jan'
    ]);

    Route::get('/reabrir-frequencia/{id}', [
        'uses' => 'EscalaController@reabrir',
        'as' => 'reabrir-frequencia'
    ]);
    
    Route::get('/reabrir-frequencia-dez/{id}', [
        'uses' => 'EscalaController@reabrirDez',
        'as' => 'reabrir-frequencia-dez'
    ]);
     Route::get('/reabrir-frequencia-jan/{id}', [
        'uses' => 'EscalaController@reabrirJan',
        'as' => 'reabrir-frequencia-jan'
    ]);

    Route::get('/visualizar/{id}', [
        'uses' => 'AvaliacaoController@visualizarFrequencia',
        'as' => 'mostrar-form-visualizar-frequencia'
    ]);

    Route::post('/alterar', [
        'uses' => 'EventoController@alterar',
        'as' => 'alterar-evento'
    ]);

    Route::post('/alterar-chefia', [
        'uses' => 'EscalaController@alterarChefia',
        'as' => 'alterar-chefia'
    ]);
});

Route::group(['prefix' => 'avaliar-frequencia', 'middleware' => 'checkLogadoAreaComum'], function() {
    Route::get('/', [
        'uses' => 'EventoController@avaliarIndex',
        'as' => 'avaliar-index'
    ]);

    Route::get('/definir-chefia', [
        'uses' => 'EscalaController@mostrarDefinirChefia',
        'as' => 'frequencia-definir-chefia'
    ]);

    Route::post('/definir-chefia-primeira-vez', [
        'uses' => 'EscalaController@definirChefia',
        'as' => 'frequencia-definir-chefia'
    ]);

    Route::get('/listar-frequencias', [
        'uses' => 'EscalaController@listarFrequenciasServidor',
        'as' => 'listar-frequencia-servidor'
    ]);

    Route::get('/relatorio-eventos', 'EventosController@relatorioEventos');

    Route::get('/lista/{idRecesso?}', [
        'uses' => 'AvaliacaoController@listarAvaliacoesPorAvaliador',
        'as' => 'retorna-lista-eventos'
    ]);
    Route::post('/adicionar', [
        'uses' => 'EventoController@adicionar',
        'as' => 'adicionar-novo-evento'
    ]);

    Route::get('/deletar/{id}', [
        'uses' => 'EventoController@deletar',
        'as' => 'deletar-evento'
    ]);

    Route::get('/editar/{id}', [
        'uses' => 'EventoController@mostrarEditar',
        'as' => 'mostrar-form-editar-evento'
    ]);

    Route::get('/visualizar/{id}', [
        'uses' => 'AvaliacaoController@visualizarFrequencia',
        'as' => 'mostrar-form-visualizar-frequencia'
    ]);
    
    Route::get('/visualizar-dez/{id}', [
        'uses' => 'AvaliacaoController@visualizarFrequenciaDez',
        'as' => 'mostrar-form-visualizar-frequencia-dez'
    ]);
    
    Route::get('/visualizar-jan/{id}', [
        'uses' => 'AvaliacaoController@visualizarFrequenciaJan',
        'as' => 'mostrar-form-visualizar-frequencia-jan'
    ]);

    Route::get('/validar/{id}', [
        'uses' => 'EscalaController@validarFrequencia',
        'as' => 'validar-frequencia'
    ]);
    
    Route::get('/validar-dez/{id}', [
        'uses' => 'EscalaController@validarFrequenciaDez',
        'as' => 'validar-frequencia-dez'
    ]);
    
    Route::get('/validar-jan/{id}', [
        'uses' => 'EscalaController@validarFrequenciaJan',
        'as' => 'validar-frequencia-jan'
    ]);

    Route::post('/alterar', [
        'uses' => 'EventoController@alterar',
        'as' => 'alterar-evento'
    ]);
});

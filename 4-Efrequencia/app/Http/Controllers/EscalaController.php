<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\Frequencia;
use App\Models\Servidor;
use App\Models\Recesso;
use App\Models\Avaliacao;
use App\Models\Evento;
use DateTime;
use DateInterval;
use DatePeriod;
use Carbon\Carbon;
use DB;

class EscalaController extends Controller {

    public function recessoAtivo() {
        $recesso = Recesso::where('ativo', 1)
                ->orderBy('ano', 'desc')
                ->first();
        return $recesso;
    }

    public function periodoRecessoAnoCorrente($recesso) {
        $dataInicioFormatoSQL = new DateTime($recesso->data_inicio);
        $dataFimFormatoSQL = new DateTime($recesso->data_inicio);
        $dataFimFormatoSQL->modify('first day of next month');
        $intervalo = DateInterval::createFromDateString('1 day');
        $periodoAnoAtual = new DatePeriod($dataInicioFormatoSQL, $intervalo, $dataFimFormatoSQL);
        return $periodoAnoAtual;
    }

    public function periodoRecessoAnoProximo($recesso) {
        $dataInicioFormatoSQL = new DateTime($recesso->data_fim);
        $dataFimFormatoSQL = new DateTime($recesso->data_fim);
        $dataInicioFormatoSQL->modify('first day of this month');
        $dataFimFormatoSQL->modify('+ 1 day');
        $intervalo = DateInterval::createFromDateString('1 day');
        $periodoAnoAtual = new DatePeriod($dataInicioFormatoSQL, $intervalo, $dataFimFormatoSQL);
        return $periodoAnoAtual;
    }

    public function periodoRecessoTotal($recesso) {
        $dataInicioFormatoSQL = new DateTime($recesso->data_inicio);
        $dataFimFormatoSQL = new DateTime($recesso->data_fim);
        $dataFimFormatoSQL->modify('+ 1 day');
        $intervalo = DateInterval::createFromDateString('1 day');
        $periodoAnoAtual = new DatePeriod($dataInicioFormatoSQL, $intervalo, $dataFimFormatoSQL);
        return $periodoAnoAtual;
    }

    public function DatePeriodToArray($periodo) {
        $dates = array();
        foreach ($periodo as $dt) {
            $dates[] = $dt->format('Y-m-d');
        }
        return $dates;
    }

    /*
     * Index para Secap.
     */

    public function index($idRecesso = null) {
        //Somente get() retorna uma collection. All retorna um array
        $recessos = Recesso::orderBy('ano', 'desc')->get()->all();
        $recesso = Recesso::find($idRecesso);
        if ($recesso == null) {
            $recesso = $recessos[0];
        }
        $idRecesso = $recesso->id;
        //Somente get() retorna uma collection. All retorna um array
        $frequencias = Frequencia::with('ServidorEscalado', 'Eventos', 'Recesso')
                ->where('recesso_id', '=', $idRecesso)
                ->get()
                ->all();

        //Todos os servidores
        $servidores = Servidor::get()->all();
        $periodoAnoAtual = $this->DatePeriodToArray($this->periodoRecessoAnoCorrente($recesso));
        $periodoAnoProximo = $this->DatePeriodToArray($this->periodoRecessoAnoProximo($recesso));
        return view('admin-secap.escalas.index')->with(['idRecesso' => $idRecesso, 'recessos' => $recessos, 'servidores' => $servidores, 'frequencias' => $frequencias, 'periodoAnoAtual' => $periodoAnoAtual, 'periodoAnoProximo' => $periodoAnoProximo]);
    }

    /*
     * Lista escalas para Secap.
     */
    public function listarEscalas($idRecesso = null) {
        //Somente get() retorna uma collection. All retorna um array
        $recessos = Recesso::orderBy('ano', 'desc')->get()->all();
        $recesso = Recesso::find($idRecesso);
        if ($recesso == null) {
            $recesso = $recessos[0];
        }
        $idRecesso = $recesso->id;
        $frequencias = Frequencia::with('ServidorEscalado', 'ServidorAutoriza', 'Recesso', 'Avaliacoes', 'Avaliacoes.ServidorDez', 'Avaliacoes.ServidorJan')
                ->with(array('Eventos' => function($query) {
                        $query->orderBy('dia_id', 'asc');
                    }))
                ->where('recesso_id', '=', $idRecesso)
                ->get()
                ->all();
        return response()->json($frequencias);
    }

    public function consultarFrequencia($idFrequencia = null) {
        //Somente get() retorna uma collection. All retorna um array

        $frequencia = Frequencia::where('id', '=', $idFrequencia)
                ->where('servidor_id', '=', session('id_servidor_logado'))
                ->first();
        $temDezembro = Evento::where('frequencia_id', '=', $idFrequencia)->where(DB::raw('MONTH(dia_id)'), '=', 12)->first();
        $temJaneiro = Evento::where('frequencia_id', '=', $idFrequencia)->where(DB::raw('MONTH(dia_id)'), '=', 1)->first();
        if ($temDezembro !== null) {
            $temDezembro = true;
        }
        if ($temJaneiro !== null) {
            $temJaneiro = true;
        }
        return response()->json(['frequencia' => $frequencia, 'tem_dezembro' => $temDezembro, 'tem_janeiro' => $temJaneiro]);
    }

    public function listarEscalasAreaComum() {
        $frequencias = Frequencia::with('ServidorEscalado', 'Recesso')->with(array('Eventos' => function($query) {
                                $query->orderBy('dia_id', 'asc');
                            }))->where('servidor_responsavel_id', '=', session('id_servidor_logado'))
                        ->get()->all();
        return response()->json($frequencias);
    }

    public function listarEscalasAreaComumAutoriza($idRecesso = null) {
        //Somente get() retorna uma collection. All retorna um array
        $recessos = Recesso::orderBy('ano', 'desc')->get()->all();
        $recesso = Recesso::find($idRecesso);
        if ($recesso == null) {
            $recesso = $recessos[0];
        }
        $idRecesso = $recesso->id;
        $frequencias = Frequencia::with('ServidorEscalado', 'Recesso')->with(array('Eventos' => function($query) {
                                $query->orderBy('dia_id', 'asc');
                            }))
                        ->where('servidor_autoriza_id', '=', session('id_servidor_logado'))
                        ->where('recesso_id', '=', $idRecesso)
                        ->get()->all();
        return response()->json($frequencias);
    }

    public function listarFrequenciasServidor() {
        $idServidor = session('id_servidor_logado');
        $frequencias = Frequencia::with('ServidorEscalado', 'Eventos', 'Recesso', 'Avaliacoes', 'Avaliacoes.servidorDez', 'Avaliacoes.servidorJan', 'StatusDez', 'StatusJan', 'ServidorAutoriza')
                ->where('servidor_id', $idServidor)
                ->get()
                ->all();

        return response()->json($frequencias);
    }

    public function listarFrequenciasRecessoSecap($idRecesso = null) {
        $recessos = Recesso::orderBy('ano', 'desc')->get()->all();
        $recesso = Recesso::find($idRecesso);
        if ($recesso == null) {
            $recesso = $recessos[0];
        }
        $idRecesso = $recesso->id;
        $frequencias = Frequencia::with('ServidorEscalado', 'Eventos', 'Recesso', 'Avaliacoes', 'Avaliacoes.servidorDez', 'Avaliacoes.servidorJan', 'StatusDez', 'StatusJan', 'ServidorAutoriza')
                ->where('recesso_id', $idRecesso)
                ->get()
                ->all();
        return response()->json($frequencias);
    }

    public function mostrarFrequenciasPorRecessoParaExportarExcel(Request $reques, $idRecesso = null) {
        //Somente get() retorna uma collection. All retorna um array
        $recessos = Recesso::orderBy('ano', 'desc')->get()->all();
        $recesso = Recesso::find($idRecesso);
        if ($recesso == null) {
            $recesso = $recessos[0];
        }
        $idRecesso = $recesso->id;
        return view('admin-secap.frequencias.exportar-excel')->with(['idRecesso' => $idRecesso, 'recessos' => $recessos]);
    }

    public function listarFrequenciasRecessoParaPlanilhaPagamento($idRecesso = null) {
        $mes = Input::get("mes");
        $opcao = Input::get("opcao");
        $recessos = Recesso::orderBy('ano', 'desc')->get()->all();
        $recesso = Recesso::find($idRecesso);
        
        if ($recesso == null) {
            $recesso = $recessos[0];
        }
        
        if ($mes == null) {
            $mes = 12;
        }
        
        if ($opcao == null) {
            $opcao = -1;
        }
        
        $idRecesso = $recesso->id;
        //-- Entradas e saidas dos servidores que escolheram pagamento por recesso independente do mes (meses de dez e jan)
        //-- JOIN para trazer a frequencia
        //-- JOIN para trazer os nomes dos servidores
        //-- Lefts JOINS para trazer o nome do servidor que valida a frequencia
        //-- Trocar aqui o mes do status tambem
        //aqui deve ser atualizado o valor do recesso_id. Ex. O recesso 2017-2018 o ID eh 4
        //tambem deve ser atualizado a opcao: 1 para folga ou 0 para pagamento
        
        $query = "
                SELECT servidores.matricula, servidores.nome, serv.nome AS 'nome_chefia', frequencias.lotacao, dia_id, entrada1, saida1, entrada2, saida2, opcao, status_descricao 
                    FROM nucre_frequencia_recesso.eventos 
                INNER JOIN frequencias ON eventos.frequencia_id =  frequencias.id 
                INNER JOIN servidores ON frequencias.servidor_id = servidores.id 
                LEFT JOIN avaliacoes ON frequencias.id = avaliacoes.frequencia_id";
        if($mes == 1){
            
            $query = $query . " LEFT JOIN servidores AS serv ON avaliacoes.servidor_id_jan = serv.id ";
            $query = $query . " INNER JOIN status ON frequencias.status_id_jan = status.id ";
        }
        if($mes == 12){
            $query = $query . " LEFT JOIN servidores AS serv ON avaliacoes.servidor_id_dez = serv.id ";
            $query = $query . " INNER JOIN status ON frequencias.status_id_dez = status.id ";
        }
        $query = $query . " WHERE frequencias.recesso_id = :recesso_id AND MONTH(dia_id) = :mes ";
        
            
        if($opcao != -1) {
            $query = $query . " AND opcao = :opcao ";            
            $frequencias = DB::select($query . "ORDER BY servidores.nome, eventos.dia_id", ["recesso_id" => $idRecesso, "mes" => $mes, "opcao" => $opcao]);
        } else {
            $frequencias = DB::select($query . " ORDER BY servidores.nome, eventos.dia_id", ["recesso_id" => $idRecesso, "mes" => $mes]);
        }
        
        return response()->json($frequencias);
    }

    public function adicionar(Request $request) {
        $frequencia = new Frequencia;
        $idServidorResponsavel = session('id_servidor_logado');
        $recesso = Recesso::find($request->recesso_id_input);
        $periodoTotal = $this->periodoRecessoTotal($recesso);
        $frequencia->servidor_id = $request->servidor_id;
        $frequencia->recesso_id = $recesso->id;
        $frequencia->servidor_responsavel_id = $idServidorResponsavel;
        $frequencia->servidor_autoriza_id = $request->servidor_autoriza_id;
        $frequencia->lotacao = $request->lotacao;

        $inputs = $request->all();
        //dd($inputs);
        $eventos = [];

        foreach ($periodoTotal as $dia) {
            $diaFormatado = $dia->format("Y-m-d");
            foreach ($inputs as $key => $value) {
                if (strpos($key, 'dia_id|' . $diaFormatado) !== false) {
                    if ($request->input("escalado-dia|" . $diaFormatado)) {
                        $eventos[] = ["dia_id" => $diaFormatado, "opcao" => ($request->input("opcao-dia|" . $diaFormatado) ? '1' : '0')];
                    }
                }
            }
        }


        try {
            if (array_filter($eventos)) {
                $frequencia->save();
                $frequencia->eventos()->createMany($eventos);
            }
            $mensagem = 'Escala cadastrada com sucesso!';
            $classe = 'alert alert-success';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        } catch (\PDOException $e) {
            $mensagem = 'Erro ao tentar cadastrar escala:' . $e->getMessage();
            $classe = 'alert alert-danger';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        }
    }

    public function mostrarEditar($id) {
        $frequencia = Frequencia::with('ServidorEscalado', 'Eventos', 'Recesso')->where('id', $id)->first();
        $recesso = $frequencia->recesso;
        $ano = $recesso->ano;
        $periodoAnoAtual = $this->DatePeriodToArray($this->periodoRecessoAnoCorrente($recesso));
        $periodoAnoProximo = $this->DatePeriodToArray($this->periodoRecessoAnoProximo($recesso));
        //dd($frequencia->eventos);
        return view('admin-secap.escalas.editar')->with(['frequencia' => $frequencia, 'ano' => $ano, 'periodoAnoAtual' => $periodoAnoAtual, 'periodoAnoProximo' => $periodoAnoProximo]);
    }

    public function mostrarDiasRecessoSelecionado($idRecesso) {
        $recesso = Recesso::find($idRecesso);
        $ano = $recesso->ano;
        $periodoAnoAtual = $this->DatePeriodToArray($this->periodoRecessoAnoCorrente($recesso));
        $periodoAnoProximo = $this->DatePeriodToArray($this->periodoRecessoAnoProximo($recesso));
        //dd($frequencia->eventos);
        return view('admin-secap.escalas.dias-novo')->with(['ano' => $ano, 'periodoAnoAtual' => $periodoAnoAtual, 'periodoAnoProximo' => $periodoAnoProximo]);
    }

    public function mostrarEditarAreaComum($id) {
        $servidores = Servidor::get()->all();
        $frequencia = Frequencia::with('ServidorEscalado', 'Eventos', 'Recesso')->where('id', $id)->first();
        $recesso = $frequencia->recesso;
        $ano = $recesso->ano;
        $periodoAnoAtual = $this->DatePeriodToArray($this->periodoRecessoAnoCorrente($recesso));
        $periodoAnoProximo = $this->DatePeriodToArray($this->periodoRecessoAnoProximo($recesso));
        //dd($frequencia->eventos);
        return view('escalas.editar')->with(['servidores' => $servidores, 'frequencia' => $frequencia, 'ano' => $ano, 'periodoAnoAtual' => $periodoAnoAtual, 'periodoAnoProximo' => $periodoAnoProximo]);
    }

    public function mostrarEditarChefia($id) {
        $frequencia = Frequencia::with('servidorResponsavel', 'Eventos', 'Recesso')->where('id', $id)->first();
        $servidores = Servidor::orderBy('nome', 'asc')->get()->all();
        //dd(count($frequencia->avaliacoes));
        //dd($frequencia->eventos);
        return view('frequencia-registro.modal-editar-chefia')->with(['frequencia' => $frequencia, 'servidores' => $servidores]);
    }

    public function mostrarEditarChefiaSecap($id) {
        $frequencia = Frequencia::with('servidorResponsavel', 'Eventos', 'Recesso', 'servidorEscalado')->where('id', $id)->first();
        $servidores = Servidor::orderBy('nome', 'asc')->get()->all();
        //dd($frequencia->avaliacoes);
        //dd($frequencia->avaliacoes[0]);
        return view('admin-secap.frequencias.modal-editar-chefia')->with(['frequencia' => $frequencia, 'servidores' => $servidores]);
    }

    public function alterarChefia(Request $request) {
        $avaliacao = Avaliacao::find($request->avaliacao_id);
        //dd($avaliacao->frequencia->servidor_id."   =   ".$request->servidor_id);
        if ($avaliacao->frequencia->servidor_id == $request->servidor_id) {
            $mensagem = 'Você mesmo não pode validar sua frequência. Selecione sua chefia imediata.';
            $classe = 'alert alert-danger';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        }
        if ($avaliacao->frequencia->isAvaliadaDez() && $avaliacao->frequencia->isAvaliadaJan()) {
            $mensagem = 'Frequência já foi validada e não pode mais sofrer alterações.';
            $classe = 'alert alert-danger';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        }
        
        $avaliacao->servidor_id_disponivel_para = $request->servidor_id;
        
        try {
            $avaliacao->save();
            $mensagem = 'Chefia alterada com Sucesso';
            $classe = 'alert alert-success';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        } catch (\PDOException $e) {
            $mensagem = 'Erro ao tentar redefinir chefia: ' . $e->getMessage();
            $classe = 'alert alert-danger';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        }
    }

    public function alterarChefiaSecap(Request $request) {
        $avaliacao = Avaliacao::find($request->avaliacao_id);
        //dd($avaliacao->frequencia->servidor_id."   =   ".$request->servidor_id);
        if ($avaliacao->frequencia->servidor_id == $request->servidor_id) {
            $mensagem = 'Você mesmo não pode validar sua frequência. Selecione sua chefia imediata.';
            $classe = 'alert alert-danger';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        }
        if ($avaliacao->frequencia->isAvaliadaDez() && $avaliacao->frequencia->isAvaliadaJan()) {
            $mensagem = 'Frequência já foi validada e não pode mais sofrer alterações.';
            $classe = 'alert alert-danger';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        }
        $avaliacao->servidor_id_disponivel_para = $request->servidor_id;
        try {
            $avaliacao->save();
            $mensagem = 'Chefia alterada com Sucesso';
            $classe = 'alert alert-success';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        } catch (\PDOException $e) {
            $mensagem = 'Erro ao tentar redefinir chefia: ' . $e->getMessage();
            $classe = 'alert alert-danger';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        }
    }

    public function secapAlterar(Request $request) {

        $frequencia = Frequencia::with('Recesso')->find($request->frequencia_id);

        if ($request->servidor_autoriza_id !== null) {
            $frequencia->servidor_autoriza_id = $request->servidor_autoriza_id;
        }
        $recesso = $frequencia->recesso;
        $periodoTotal = $this->periodoRecessoTotal($recesso);
        $frequencia->lotacao = $request->lotacao;

        $inputs = $request->all();
        try {
            foreach ($periodoTotal as $dia) {
                $diaFormatado = $dia->format("Y-m-d");
                $diaEncontrado = false;
                foreach ($inputs as $key => $value) {
                    if (strpos($key, 'escalado-dia|' . $diaFormatado) !== false) {
                        $evento = $frequencia->eventos()->where('dia_id', $diaFormatado);
                        if ($evento->first() !== null) {
                            $evento->update(['opcao' => ($request->input("opcao-dia|" . $diaFormatado) ? '1' : '0')]);
                        } else {
                            $frequencia->eventos()->create(["dia_id" => $diaFormatado, 'opcao' => ($request->input("opcao-dia|" . $diaFormatado) ? '1' : '0')]);
                        }

                        $diaEncontrado = true;
                    }
                }
                if (!$diaEncontrado) {
                    $frequencia->eventos()->where('dia_id', $diaFormatado)->delete();
                }
            }
            $frequencia->save();
            $mensagem = 'Escala alterada com sucesso!';
            $classe = 'alert alert-success';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        } catch (\PDOException $e) {
            $mensagem = 'Erro ao tentar alterar escala: ' . $e->getMessage();
            $classe = 'alert alert-danger';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        }
    }

    public function alterar(Request $request) {
        $frequencia = Frequencia::find($request->frequencia_id);
        if ($request->servidor_autoriza_id !== null) {
            $frequencia->servidor_autoriza_id = $request->servidor_autoriza_id;
        }
        $recesso = $frequencia->recesso;
        $periodoTotal = $this->periodoRecessoTotal($recesso);


        $inputs = $request->all();
        try {
            foreach ($periodoTotal as $dia) {
                $diaFormatado = $dia->format("Y-m-d");
                $diaEncontrado = false;
                foreach ($inputs as $key => $value) {
                    if (strpos($key, 'escalado-dia|' . $diaFormatado) !== false) {
                        $evento = $frequencia->eventos()->where('dia_id', $diaFormatado);
                        if ($evento->first() !== null) {
                            $evento->update(['opcao' => ($request->input("opcao-dia|" . $diaFormatado) ? '1' : '0')]);
                        } else {
                            $frequencia->eventos()->create(["dia_id" => $diaFormatado, 'opcao' => ($request->input("opcao-dia|" . $diaFormatado) ? '1' : '0')]);
                        }

                        $diaEncontrado = true;
                    }
                }
                if (!$diaEncontrado) {
                    $frequencia->eventos()->where('dia_id', $diaFormatado)->delete();
                }
            }
            $frequencia->save();
            $mensagem = 'Escala alterada com sucesso!';
            $classe = 'alert alert-success';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        } catch (\PDOException $e) {
            $mensagem = 'Erro ao tentar alterar escala: ' . $e->getMessage();
            $classe = 'alert alert-danger';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        }
    }

    public function deletar($id, Request $request) {
        $frequencia = Frequencia::find($id);
        if ($frequencia == null) {
            $mensagem = 'Frequência já excluída!';
            $classe = 'alert alert-success';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        }
        if ($frequencia->isAvaliadaDez() ||$frequencia->isAvaliadaJan() ) {
            $mensagem = 'Frequência ´finalizada e avaliada. Não é possível excluí-la!';
            $classe = 'alert alert-danger';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        }
        try {
            Frequencia::destroy($id);
            $mensagem = 'Escala excluída com sucesso!';
            $classe = 'alert alert-success';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        } catch (\PDOException $e) {
            $mensagem = 'Erro ao tentar excluir escala: ' . $e->getMessage();
            $classe = 'alert alert-danger';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        }
    }

    public function mostrarFrequenciasPorServidor(Request $request) {
        return view('frequencia-registro.selecao');
    }

    public function mostrarFrequenciasPorRecesso(Request $reques, $idRecesso = null) {
        //Somente get() retorna uma collection. All retorna um array
        $recessos = Recesso::orderBy('ano', 'desc')->get()->all();
        $recesso = Recesso::find($idRecesso);
        if ($recesso == null) {
            $recesso = $recessos[0];
        }
        $idRecesso = $recesso->id;
        return view('admin-secap.frequencias.index')->with(['idRecesso' => $idRecesso, 'recessos' => $recessos]);
    }

    public function mostrarDefinirChefia(Request $request) {
        $recesso = $this->recessoAtivo();
        if ($recesso !== null) {
            $recessoId = $recesso->id;
            //Somente get() retorna uma collection. All retorna um array
            $frequencias = Frequencia::with('ServidorEscalado', 'Eventos', 'Recesso')
                            ->where('recesso_id', '=', $recessoId)
                            ->where('servidor_id', '=', session('id_servidor_logado'))->get()->all();
        }
        $servidores = Servidor::orderBy('nome', 'asc')->get()->all();
        return view('frequencia-registro.definir-chefia')->with(['servidores' => $servidores, 'frequencias' => $frequencias, 'recesso' => $recesso]); //, 'parte1' => $parte1, 'parte2' => $parte2,'parte3'=>$parte3]);
    }

    public function definirChefia(Request $request) {
        $inputs = $request->all();
        //dd($inputs);
        foreach ($inputs as $key => $value) {
            $idFrequencia = explode("|", $key)[0];
            if (is_numeric($idFrequencia)) {
                $avaliacao = Avaliacao::firstOrNew(array('frequencia_id' => $idFrequencia));
                if ($avaliacao !== null) {
                    if ($avaliacao->frequencia->servidor_id !== $value) {
                        $avaliacao->servidor_id_disponivel_para = $value;
                    } else {
                        $mensagem = 'Você mesmo não pode validar sua frequência. Selecione sua chefia imediata.';
                        $classe = 'alert alert-danger';
                        return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
                    }
                    try {
                        $avaliacao->save();
                    } catch (\PDOException $e) {
                        $mensagem = 'Erro ao tentar definir chefia: ' . $e->getMessage();
                        $classe = 'alert alert-danger';
                        return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
                    }
                }
            }
        }


        $frequencia = Frequencia::find($request->frequencia_id);
        if ($request->servidor_autoriza_id !== null) {
            $frequencia->servidor_autoriza_id = $request->servidor_autoriza_id;
        }

        try {
            $mensagem = 'Chefia Cadastrada com Sucesso';
            $classe = 'alert alert-success';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        } catch (\PDOException $e) {
            $mensagem = 'Erro ao tentar definir chefia: ' . $e->getMessage();
            $classe = 'alert alert-danger';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        }
    }

    public function fecharDisponibilizarDez(Request $request, $id) {

        $avaliacao = Avaliacao::firstOrNew(array('frequencia_id' => $id));
        $frequencia = Frequencia::find($id);
        $frequencia->disponibilizarFecharDez();
        $avaliacao->data_disponibilizacao_dez = Carbon::now();

        try {
            $frequencia->save();
            $avaliacao->save();
            $mensagem = 'Frequência de Dezembro disponibilizada com Sucesso. Converse com sua chefia para avaliar assim que possível.';
            $classe = 'alert alert-success';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        } catch (\PDOException $e) {
            $mensagem = 'Erro ao tentar disponibilizar a frequência: ' . $e->getMessage();
            $classe = 'alert alert-danger';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        }
    }

    public function fecharDisponibilizarJan(Request $request, $id) {

        $avaliacao = Avaliacao::firstOrNew(array('frequencia_id' => $id));
        $frequencia = Frequencia::find($id);
        $frequencia->disponibilizarFecharJan();
        $avaliacao->data_disponibilizacao_jan = Carbon::now();

        try {
            $frequencia->save();
            $avaliacao->save();
            $mensagem = 'Frequência de Janeiro disponibilizada com Sucesso. Converse com sua chefia para avaliar assim que possível.';
            $classe = 'alert alert-success';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        } catch (\PDOException $e) {
            $mensagem = 'Erro ao tentar disponibilizar a frequência: ' . $e->getMessage();
            $classe = 'alert alert-danger';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        }
    }
    
    public function validarFrequenciaDez(Request $request, $id) {

        $avaliacao = Avaliacao::firstOrNew(array('frequencia_id' => $id));
        $frequencia = Frequencia::find($id);
        if ($frequencia->isDisponbilizadaDez()) {
            $frequencia->validarDez();
        } else {
            $mensagem = 'Frequência de Dezembro não pode ser Validada considerando seu status atual.';
            $classe = 'alert alert-danger';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        }
        $avaliacao->servidor_id_dez = session('id_servidor_logado');
        $avaliacao->data_avaliacao_dez = Carbon::now();


        try {
            $frequencia->save();
            $avaliacao->save();
            $mensagem = 'Frequência referente ao mês de Dezembro validada com Sucesso. Agora disponível para processamento pela Sepag e Secap';
            $classe = 'alert alert-success';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        } catch (\PDOException $e) {
            $mensagem = 'Erro ao tentar validar frequência: ' . $e->getMessage();
            $classe = 'alert alert-danger';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        }
    }

    public function validarFrequenciaJan(Request $request, $id) {

        $avaliacao = Avaliacao::firstOrNew(array('frequencia_id' => $id));
        $frequencia = Frequencia::find($id);
        if ($frequencia->isDisponbilizadaJan()) {
            $frequencia->validarJan();
        } else {
            $mensagem = 'Frequência de Janeiro não pode ser Validada considerando seu status atual.';
            $classe = 'alert alert-danger';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        }
        $avaliacao->servidor_id_jan = session('id_servidor_logado');
        $avaliacao->data_avaliacao_jan = Carbon::now();


        try {
            $frequencia->save();
            $avaliacao->save();
            $mensagem = 'Frequência referente ao mês de Janeiro validada com Sucesso. Agora disponível para processamento pela Sepag e Secap';
            $classe = 'alert alert-success';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        } catch (\PDOException $e) {
            $mensagem = 'Erro ao tentar validar frequência: ' . $e->getMessage();
            $classe = 'alert alert-danger';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        }
    }

    public function reabrirDez(Request $request, $id) {

        $avaliacao = Avaliacao::firstOrNew(array('frequencia_id' => $id));
        $frequencia = Frequencia::find($id);
        if ($frequencia->isAvaliadaDez() == false) {
            $frequencia->reabrirDez();
        } else {
            $mensagem = 'Não é possível reabrir a frequência de Dezembro. Ela já foi avaliada pela Chefia.';
            $classe = 'alert alert-danger';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        }
        $avaliacao->data_disponibilizacao_dez = null;

        try {
            $frequencia->save();
            $avaliacao->save();
            $mensagem = 'Frequência de Dezembro reaberta com Sucesso. Agora é possível realizar ajustes.';
            $classe = 'alert alert-success';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        } catch (\PDOException $e) {
            $mensagem = 'Erro ao tentar reabrir a frequencia: ' . $e->getMessage();
            $classe = 'alert alert-danger';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        }
    }

    public function reabrirJan(Request $request, $id) {

        $avaliacao = Avaliacao::firstOrNew(array('frequencia_id' => $id));
        $frequencia = Frequencia::find($id);
        if ($frequencia->isAvaliadaJan() == false) {
            $frequencia->reabrirJan();
        } else {
            $mensagem = 'Não é possível reabrir a frequência de Janeiro. Ela já foi avaliada pela Chefia.';
            $classe = 'alert alert-danger';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        }
        $avaliacao->data_disponibilizacao_jan = null;

        try {
            $frequencia->save();
            $avaliacao->save();
            $mensagem = 'Frequência de Janeiro reaberta com Sucesso. Agora é possível realizar ajustes.';
            $classe = 'alert alert-success';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        } catch (\PDOException $e) {
            $mensagem = 'Erro ao tentar reabrir a frequencia: ' . $e->getMessage();
            $classe = 'alert alert-danger';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        }
    }
    
    public function verificaEscalacaoServidor($idServidor = null, $idRecesso = null) {
        $frequencia = Frequencia::with('ServidorEscalado', 'ServidorResponsavel', 'ServidorAutoriza', 'Eventos', 'Recesso')
                ->where('servidor_id', $idServidor)
                ->where('recesso_id', $idRecesso)
                ->first();

        return response()->json($frequencia);
    }

}

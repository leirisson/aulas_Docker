<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Frequencia;
use App\Models\Evento;
use App\Models\Servidor;
use App\Models\Recesso;
use App\Models\Avaliacao;
use DateTime;
use DateInterval;
use DatePeriod;

class AvaliacaoController extends Controller {

    public function recessoAtivo() {
        $recesso = Recesso::where('ativo', 1)
                        ->orderBy('ano', 'desc')
                        ->take(1)
                        ->get()[0];
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

    public function index() {
        //Todos os servidores
        $servidores = Servidor::get()->all();
        //Somente get() retorna uma collection. All retorna um array
        $frequencias = Frequencia::with('ServidorEscalado', 'Eventos', 'Recesso')->get()->all();
        $recesso = $this->recessoAtivo();
        $ano = $recesso->ano;
        $periodoAnoAtual = $this->DatePeriodToArray($this->periodoRecessoAnoCorrente($recesso));
        $periodoAnoProximo = $this->DatePeriodToArray($this->periodoRecessoAnoProximo($recesso));
        return view('frequencia-registro.index')->with(['servidores' => $servidores, 'frequencias' => $frequencias, 'ano' => $ano, 'periodoAnoAtual' => $periodoAnoAtual, 'periodoAnoProximo' => $periodoAnoProximo]);
    }

    public function listarEventos() {
        $idFrequencia = 4;
        $eventos = Evento::where('frequencia_id', '=', $idFrequencia)->orderBy('dia_id', 'asc')->get()->all();
        return response()->json($eventos);
    }

    public function listarAvaliacoesPorAvaliador($idRecesso = null) {

        $servidorID = session('id_servidor_logado');
        //Somente get() retorna uma collection. All retorna um array
        $recessos = Recesso::orderBy('ano', 'desc')->get()->all();
        $recesso = Recesso::find($idRecesso);
        if ($recesso == null) {
            $recesso = $recessos[0];
        }
        $idRecesso = $recesso->id;
                
        $avaliacoes = Avaliacao::with('Frequencia.statusDez', 'Frequencia.statusJan', 'Frequencia.recesso', 'Frequencia.servidorEscalado', 'Frequencia.eventos', 'ServidorDez', 'ServidorJan')
                ->select('avaliacoes.*')
                ->where(function($query) use($servidorID) {
                    $query->where('avaliacoes.servidor_id_disponivel_para', '=', $servidorID)
                    ->orWhere('avaliacoes.servidor_id_dez', '=', $servidorID)
                    ->orWhere('avaliacoes.servidor_id_jan', '=', $servidorID);
                }
                )
                ->join('frequencias', 'frequencias.id', '=', 'avaliacoes.frequencia_id')
                ->where('frequencias.recesso_id', '=', $idRecesso)
                ->get()
                ->all();
                
        return response()->json($avaliacoes);
    }

    public function visualizarFrequencia($id) {
        $frequencia = Frequencia::with('ServidorEscalado', 'Eventos', 'Recesso')->where('id', $id)->where('servidor_id', session('id_servidor_logado'))->first();
        //dd($frequencia->eventos);
        return view('frequencia-registro.visualizar')->with(['frequencia' => $frequencia]);
    }

    public function visualizarFrequenciaDez($id) {
        $frequencia = Frequencia::with('ServidorEscalado', 'Eventos', 'Recesso')->where('id', $id)->first();
        $idFrequencia = $frequencia->id;
        $eventos = Evento::with('Frequencia')->whereMonth('dia_id', '=', 12)
                        ->where('frequencia_id', '=', $idFrequencia)->orderBy('dia_id', 'asc')->get()->all();
        return view('frequencia-avaliacao.visualizar-dez')->with(['frequencia' => $frequencia, 'eventos' => $eventos]);
    }

    public function visualizarFrequenciaJan($id) {
        $frequencia = Frequencia::with('ServidorEscalado', 'Eventos', 'Recesso')->where('id', $id)->first();
        $idFrequencia = $frequencia->id;
        $eventos = Evento::with('Frequencia')->whereMonth('dia_id', '=', 1)
                        ->where('frequencia_id', '=', $idFrequencia)->orderBy('dia_id', 'asc')->get()->all();
        return view('frequencia-avaliacao.visualizar-jan')->with(['frequencia' => $frequencia, 'eventos' => $eventos]);
    }

    public function visualizarFrequenciaSecap($id) {
        $frequencia = Frequencia::with('ServidorEscalado', 'Eventos', 'Recesso')->where('id', $id)->first();
        //dd($frequencia->eventos);
        $idFrequencia = $frequencia->id;
        $eventos = Evento::with('Frequencia')->where('frequencia_id', '=', $idFrequencia)->orderBy('dia_id', 'asc')->get()->all();
        return view('admin-secap.frequencias.visualizar')->with(['frequencia' => $frequencia, 'eventos' => $eventos]);
    }

    public function mostrarEditar($id) {
        $evento = Evento::find($id);
        //dd($frequencia->eventos);
        return view('frequencia-registro.editar')->with(['evento' => $evento]);
    }

    public function alterar(Request $request) {
        $evento = Evento::find($request->evento_id);
        $evento->entrada1 = $request->entrada1 == "" ? null : date("H:i:s", strtotime($request->entrada1));
        $evento->saida1 = $request->saida1 == "" ? null : date("H:i:s", strtotime($request->saida1));
        $evento->entrada2 = $request->entrada2 == "" ? null : date("H:i:s", strtotime($request->entrada2));
        $evento->saida2 = $request->saida2 == "" ? null : date("H:i:s", strtotime($request->saida2));

        try {
            $evento->save();
            $mensagem = 'Evento alterado com sucesso!';
            $classe = 'alert alert-success';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        } catch (\PDOException $e) {
            $mensagem = 'Erro ao tentar alterar evento: ' . $e->getMessage();
            $classe = 'alert alert-danger';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        }
    }

    public function deletar($id, Request $request) {
        try {
            $evento = Evento::find($id);
            $evento->entrada1 = null;
            $evento->saida1 = null;
            $evento->entrada2 = null;
            $evento->saida2 = null;
            $evento->save();
            $mensagem = 'Horários apagados com sucesso!';
            $classe = 'alert alert-success';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        } catch (\PDOException $e) {
            $mensagem = 'Erro ao tentar apagar horários: ' . $e->getMessage();
            $classe = 'alert alert-danger';
            return response()->json(['mensagem' => $mensagem, 'classe' => $classe]);
        }
    }

    public function relatorioEscalas() {
        return view('admin-secap.escalas.relatorio');
    }

}

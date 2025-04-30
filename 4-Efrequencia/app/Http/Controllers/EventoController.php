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
use DB;

class EventoController extends Controller {

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

    public function index(Request $request) {
        //Todos os servidores
        $servidores = Servidor::get()->all();
        $recesso = $this->recessoAtivo();
        $frequencia = false;
        if ($recesso !== null) {
            $recessoId = $recesso->id;
            //Somente get() retorna uma collection. All retorna um array
            $frequencias = Frequencia::with('ServidorEscalado', 'Eventos', 'Recesso')
                            ->where('recesso_id', '=', $recessoId)
                            ->where('servidor_id', '=', session('id_servidor_logado'))->get()->all();
            if ($frequencias == null) {
                $frequencia = "nao-escalado";
                return view('frequencia-registro.index')->with(['frequencia' => $frequencia]);
            }
            
            $chefiaDefinidaEmTodas = True;
            foreach ($frequencias as $frequencia) {
                $avaliacao = Avaliacao::where('frequencia_id', '=', $frequencia->id)->first();
                if ($avaliacao == null) {
                    $chefiaDefinidaEmTodas = false;
                }
            }

            if ($chefiaDefinidaEmTodas == true) {
                return view('frequencia-registro.index')->with(['servidores' => $servidores, 'frequencia' => $frequencias[0],'frequencias'=>$frequencias]);
            }

            $request->session()->put('frequencia_id', $frequencias[0]->id);
            return redirect()->intended('registrar-frequencia/definir-chefia');
        }
        return view('frequencia-registro.index')->with(['frequencia' => $frequencia]);
    }

    public function avaliarIndex($idRecesso = null) {
        //Somente get() retorna uma collection. All retorna um array
        $recessos = Recesso::orderBy('ano', 'desc')->get()->all();
        $recesso = Recesso::find($idRecesso);
        if ($recesso == null) {
            $recesso = $recessos[0];
        }
        $idRecesso = $recesso->id;
        //Todos os servidores
        $servidores = Servidor::get()->all();
        return view('frequencia-avaliacao.index')->with(['servidores' => $servidores, 'recessos' => $recessos, 'idRecesso' => $idRecesso]);
    }

    public function listarEventos($idFrequencia = null) {
        $recesso = $this->recessoAtivo();
        if ($idFrequencia == null) {
            $frequencias = Frequencia::with('ServidorEscalado', 'Eventos', 'Recesso')
                            ->where('recesso_id', '=', $recesso->id)
                            ->where('servidor_id', '=', session('id_servidor_logado'))->get()->all();
            $idFrequencia = $frequencias[0]->id;
        }
        $eventos = Evento::with('Frequencia','Frequencia.StatusDez','Frequencia.StatusJan')->where('frequencia_id', '=', $idFrequencia)->orderBy('dia_id', 'asc')->get()->all();
        return response()->json($eventos);
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
            $mensagem = 'Frequencia atualizada com sucesso!';
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

    public function frequenciaPDF($idFrequencia = null) {
        $frequencia = Frequencia::with('ServidorEscalado', 'Eventos', 'Recesso', 'Avaliacoes.ServidorDez','Avaliacoes.ServidorJan')
                ->where('id', $idFrequencia)
                ->where('servidor_id','=',session('id_servidor_logado'))->first();
        //dd($frequencia->eventos);
        return view('frequencia-registro.visualizar-versao-pdf')->with(['frequencia' => $frequencia]);
    }
    
    public function frequenciaPDFSecapDez($idFrequencia = null) {
        $frequencia = Frequencia::with('ServidorEscalado', 'Eventos', 'Recesso', 'Avaliacoes.ServidorDez')
                ->where('id', $idFrequencia)->first();
        //dd($frequencia->eventos);
        $idFrequencia = $frequencia->id;
        $eventos = Evento::with('Frequencia')->where('frequencia_id', '=', $idFrequencia)->whereMonth('dia_id','=',12)->orderBy('dia_id', 'asc')->get()->all();
        return view('admin-secap.frequencias.visualizar-versao-pdf-dez')->with(['frequencia' => $frequencia,'eventos'=>$eventos]);
    }
    
    public function frequenciaPDFSecapJan($idFrequencia = null) {
        $frequencia = Frequencia::with('ServidorEscalado', 'Eventos', 'Recesso', 'Avaliacoes.ServidorJan')
                ->where('id', $idFrequencia)->first();
        //dd($frequencia->eventos);
        $idFrequencia = $frequencia->id;
        $eventos = Evento::with('Frequencia')->where('frequencia_id', '=', $idFrequencia)->whereMonth('dia_id','=',1)->orderBy('dia_id', 'asc')->get()->all();
        return view('admin-secap.frequencias.visualizar-versao-pdf-jan')->with(['frequencia' => $frequencia,'eventos'=>$eventos]);
    }

}

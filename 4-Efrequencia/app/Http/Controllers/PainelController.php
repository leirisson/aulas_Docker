<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Recesso;
use App\Models\Frequencia;
use Illuminate\Support\Facades\DB;

class PainelController extends Controller {

    public function index($idRecesso = null) {
        //Somente get() retorna uma collection. All retorna um array
        $recessos = Recesso::orderBy('ano', 'desc')->get()->all();

        $recesso = Recesso::find($idRecesso);
        if ($recesso == null) {
            $recesso = $recessos[0];
        }
        $idRecesso = $recesso->id;

        $frequencias = DB::table('frequencias')
                ->where('recesso_id', '=', $idRecesso)
                ->join('servidores', 'servidores.id', '=', 'frequencias.servidor_id')
                ->orderBy('servidores.nome')
                ->get()
                ->all();
        $frequenciasEscalacaoAprovada = DB::table('frequencias')
                ->where('recesso_id', '=', $idRecesso)
                ->join('servidores', 'servidores.id', '=', 'frequencias.servidor_id')
                ->orderBy('servidores.nome')
                ->get()
                ->all();
        
        $frequenciasAvaliadasDez = DB::table('frequencias')
                ->where('recesso_id', '=', $idRecesso)
                ->join('servidores', 'servidores.id', '=', 'frequencias.servidor_id')
                ->where('status_id_dez', '=', 3)
                ->orderBy('servidores.nome')
                ->get()
                ->all();
        //Não avaliadas aqui significa em aberto. DEZEMBRO
        $frequenciasNaoAvaliadasDez = DB::table('frequencias')
                ->where('recesso_id', '=', $idRecesso)
                ->join('servidores as servidor_escalado', 'servidor_escalado.id', '=', 'frequencias.servidor_id')
                ->join('servidores as servidor_autoriza', 'servidor_autoriza.id', '=', 'frequencias.servidor_autoriza_id')
                ->join('avaliacoes as lita_avaliacoes', 'lita_avaliacoes.frequencia_id', '=', 'frequencias.id')
                ->join('servidores as servidor_valida', 'servidor_valida.id', '=', 'lita_avaliacoes.servidor_id_disponivel_para')
                ->join('eventos', 'frequencias.id', '=', 'eventos.frequencia_id')
                ->select('servidor_escalado.email','servidor_escalado.nome as servidor_escalado_nome', 'servidor_autoriza.nome as servidor_autoriza_nome','servidor_valida.nome as servidor_valida_nome')
                ->where('status_id_dez', '=', 1)
                ->whereMonth('eventos.dia_id', '=', 12)
                ->orderBy('servidor_escalado.nome')
                ->groupBy('servidor_escalado.nome','frequencias.id','lita_avaliacoes.id')
                ->get()
                ->all();
        $frequenciasAvaliadasJan = DB::table('frequencias')
                ->where('recesso_id', '=', $idRecesso)
                ->join('servidores', 'servidores.id', '=', 'frequencias.servidor_id')
                ->where('status_id_jan', '=', 3)
                ->orderBy('servidores.nome')
                ->get()
                ->all();
        $frequenciasNaoAvaliadasJan = DB::table('frequencias')
                ->where('recesso_id', '=', $idRecesso)
                ->join('servidores as servidor_escalado', 'servidor_escalado.id', '=', 'frequencias.servidor_id')
                ->join('servidores as servidor_autoriza', 'servidor_autoriza.id', '=', 'frequencias.servidor_autoriza_id')
                 ->join('avaliacoes as lita_avaliacoes', 'lita_avaliacoes.frequencia_id', '=', 'frequencias.id')
                ->join('servidores as servidor_valida', 'servidor_valida.id', '=', 'lita_avaliacoes.servidor_id_disponivel_para')
                ->join('eventos', 'frequencias.id', '=', 'eventos.frequencia_id')
                ->select('servidor_escalado.email','servidor_escalado.nome as servidor_escalado_nome', 'servidor_autoriza.nome as servidor_autoriza_nome','servidor_valida.nome as servidor_valida_nome')
                ->where('status_id_jan', '=', 1)
                ->orderBy('servidor_escalado.nome')
                ->whereMonth('eventos.dia_id', '=', 1)
                ->groupBy('servidor_escalado.nome','frequencias.id','lita_avaliacoes.id')
                ->get()
                ->all();

        $servidoresQueNaoDefiniramChefia = DB::table('frequencias AS t1')
                ->where('recesso_id', '=', $idRecesso)                
                ->leftJoin('avaliacoes AS t2', 't2.frequencia_id', '=', 't1.id')
                ->join('servidores as servidor_escalado', 'servidor_escalado.id', '=', 't1.servidor_id')
                ->select('*', 'servidor_escalado.nome as servidor_escalado_nome','servidor_escalado.email as servidor_escalado_email')                
                ->whereNull('t2.frequencia_id')
                ->orderBy('servidor_escalado_nome')
                ->get()->all();
        
        $frequenciasAguardandoValidacaoChefiaDez = DB::table('frequencias')
                ->where('recesso_id', '=', $idRecesso)
                ->join('servidores as servidor_escalado', 'servidor_escalado.id', '=', 'frequencias.servidor_id')
                ->join('servidores as servidor_autoriza', 'servidor_autoriza.id', '=', 'frequencias.servidor_autoriza_id')
                ->join('avaliacoes as lita_avaliacoes', 'lita_avaliacoes.frequencia_id', '=', 'frequencias.id')
                ->join('servidores as servidor_valida', 'servidor_valida.id', '=', 'lita_avaliacoes.servidor_id_disponivel_para')
                ->join('eventos', 'frequencias.id', '=', 'eventos.frequencia_id')
                ->select('servidor_escalado.nome as servidor_escalado_nome', 'servidor_autoriza.nome as servidor_autoriza_nome','servidor_valida.nome as servidor_valida_nome','servidor_valida.email as email')
                ->where('status_id_dez', '=', 2)
                ->orderBy('servidor_escalado.nome')
                ->whereMonth('eventos.dia_id', '=', 12)
                ->groupBy('servidor_escalado.nome','frequencias.id','lita_avaliacoes.id')
                ->get()
                ->all();
        
         $frequenciasAguardandoValidacaoChefiaJan = DB::table('frequencias')
                ->where('recesso_id', '=', $idRecesso)
                ->join('servidores as servidor_escalado', 'servidor_escalado.id', '=', 'frequencias.servidor_id')
                ->join('servidores as servidor_autoriza', 'servidor_autoriza.id', '=', 'frequencias.servidor_autoriza_id')
                ->join('avaliacoes as lita_avaliacoes', 'lita_avaliacoes.frequencia_id', '=', 'frequencias.id')
                ->join('servidores as servidor_valida', 'servidor_valida.id', '=', 'lita_avaliacoes.servidor_id_disponivel_para')
                ->join('eventos', 'frequencias.id', '=', 'eventos.frequencia_id')
                ->select('servidor_escalado.nome as servidor_escalado_nome', 'servidor_autoriza.nome as servidor_autoriza_nome','servidor_valida.nome as servidor_valida_nome','servidor_valida.email as email')
                ->where('status_id_jan', '=', 2)
                ->orderBy('servidor_escalado.nome')
                ->whereMonth('eventos.dia_id', '=', 1)
                ->groupBy('servidor_escalado.nome','frequencias.id','lita_avaliacoes.id')
                ->get()
                ->all();
        //dd($servidoresQueNaoDefiniramChefia);
        //dd($frequencias);
        //$frequencias
        //dd($frequencias);
        return view('admin-secap.painel.index')->with(
                        ['recessos' => $recessos,
                            'frequencias' => $frequencias,
                            'frequenciasEscalacaoAprovada' => $frequenciasEscalacaoAprovada,
                            'frequenciasAvaliadasDez' => $frequenciasAvaliadasDez,
                            'frequenciasNaoAvaliadasDez' => $frequenciasNaoAvaliadasDez,
                            'frequenciasAvaliadasJan' => $frequenciasAvaliadasJan,
                            'frequenciasNaoAvaliadasJan' => $frequenciasNaoAvaliadasJan,
                            'servidoresQueNaoDefiniramChefia' => $servidoresQueNaoDefiniramChefia,
                            'frequenciasAguardandoValidacaoChefiaDez'=>$frequenciasAguardandoValidacaoChefiaDez,
                            'frequenciasAguardandoValidacaoChefiaJan'=>$frequenciasAguardandoValidacaoChefiaJan,
                            "idRecesso" => $idRecesso
        ]);
    }

}

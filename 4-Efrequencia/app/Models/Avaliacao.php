<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    protected $table = 'avaliacoes';
    protected $fillable = ['servidor_id_dez', 'servidor_id_jan','frequencia_id'];
    
    public function frequencia() {
        return $this->belongsTo('App\Models\Frequencia', 'frequencia_id', 'id');
    }
    
    public function servidorDisponivelPara() {
        return $this->belongsTo('App\Models\Servidor', 'servidor_id_disponivel_para', 'id');
    }
    
    public function servidorDez() {
        return $this->belongsTo('App\Models\Servidor', 'servidor_id_dez', 'id');
    }
    
    public function servidorJan() {
        return $this->belongsTo('App\Models\Servidor', 'servidor_id_jan', 'id');
    }
}

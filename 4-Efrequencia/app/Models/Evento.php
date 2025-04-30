<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model {

    protected $table = 'eventos';
    protected $fillable = ['dia_id', 'opcao'];

    public function frequencia() {
        return $this->belongsTo('App\Models\Frequencia', 'frequencia_id', 'id');
    }

    public function getTotalHoras() {
        if($this->attributes['entrada1'] != null && $this->attributes['saida1'] == null && $this->attributes['entrada2'] == null && $this->attributes['saida2'] != null){
            return \CalculoHorasHelper::diferencaDoisHorarios($this->attributes['entrada1'], $this->attributes['saida2']);
        }
        return \CalculoHorasHelper::somarDoisHorarios(\CalculoHorasHelper::diferencaDoisHorarios($this->attributes['entrada1'], $this->attributes['saida1']), \CalculoHorasHelper::diferencaDoisHorarios($this->attributes['entrada2'], $this->attributes['saida2']));
    }
    
    public function getTotalHorasDobro() {
        $totalSimples = $this->getTotalHoras();
        return \CalculoHorasHelper::somarDoisHorarios($totalSimples,$totalSimples);
    }

    public function getSobra() {
        return (\CalculoHorasHelper::diferencaDoisHorariosMaior24h( $this->attributes['horas_folga'], \CalculoHorasHelper::diferencaDoisHorariosMaior24h($this->attributes['horas_pagamento'],$this->getTotalHorasDobro())));
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//Situação refere-se ao periodo em que uma determinada funcao possui um titular e substituto.

class Frequencia extends Model {

    protected $table = 'frequencias';

    public function servidorEscalado() {
        return $this->belongsTo('App\Models\Servidor', 'servidor_id', 'id');
    }

    public function servidorResponsavel() {
        return $this->belongsTo('App\Models\Servidor', 'servidor_responsavel_id', 'id');
    }

    public function servidorAutoriza() {
        return $this->belongsTo('App\Models\Servidor', 'servidor_autoriza_id', 'id');
    }

    /**
     * Get the comments for the blog post.
     */
    public function eventos() {
        return $this->hasMany('App\Models\Evento');
    }

    public function avaliacoes() {
        return $this->hasMany('App\Models\Avaliacao');
    }

    public function recesso() {
        return $this->belongsTo('App\Models\Recesso', 'recesso_id', 'id');
    }

    public function statusDez() {
        return $this->belongsTo('App\Models\Status', 'status_id_dez', 'id');
    }
    public function statusJan() {
        return $this->belongsTo('App\Models\Status', 'status_id_jan', 'id');
    }
    
    public function disponibilizarFecharDez() {
        $this->attributes['status_id_dez'] = 2;
    }
    
    public function disponibilizarFecharJan() {
        $this->attributes['status_id_jan'] = 2;
    }
    
    public function reabrirDez() {
        $this->attributes['status_id_dez'] = 1;
    }
    
    public function reabrirJan() {
        $this->attributes['status_id_jan'] = 1;
    }
    
    public function validarDez() {
        $this->attributes['status_id_dez'] = 3;
    }
    
    public function validarJan() {
        $this->attributes['status_id_jan'] = 3;
    }
    
    public function isAvaliadaDez() {
        return $this->attributes['status_id_dez'] == 3;
    }
    
     public function isAvaliadaJan() {
        return $this->attributes['status_id_jan'] == 3;
    }

    public function isEmAbertoDez() {
        return $this->attributes['status_id_dez'] == 1;
    }
    
    public function isEmAbertoJan() {
        return $this->attributes['status_id_jan'] == 1;
    }
    
    public function isDisponbilizadaDez() {
        return $this->attributes['status_id_dez'] == 2;
    }
    
    public function isDisponbilizadaJan() {
        return $this->attributes['status_id_jan'] == 2;
    }

    public function inverteData($data) {
        if (count(explode("/", $data)) > 1) {
            return implode("-", array_reverse(explode("/", $data)));
        } elseif (count(explode("-", $data)) > 1) {
            return implode("/", array_reverse(explode("-", $data)));
        }
    }

    public function getTotalHoras() {
        $totalHoras = "00:00";
        foreach ($this->eventos as $evento) {
            $totalHoras = \CalculoHorasHelper::somarDoisHorarios($totalHoras, $evento->getTotalHoras());
        }
        return $totalHoras;
    }

    public function getTotalHorasFolga() {
        $totalHoras = "00:00";
        foreach ($this->eventos as $evento) {
            if ($evento->opcao) {
                $totalHoras = \CalculoHorasHelper::somarDoisHorarios($totalHoras, $evento->getTotalHoras());
            }
        }
        return $totalHoras;
    }

    public function getTotalHorasDobro() {
        $totalHoras = "00:00";
        foreach ($this->eventos as $evento) {
            $totalHoras = \CalculoHorasHelper::somarDoisHorarios($totalHoras, $evento->getTotalHoras());
        }
        return \CalculoHorasHelper::somarDoisHorarios($totalHoras, $totalHoras);
    }

    public function getTotalHorasFolgaDobro() {
        $totalHoras = "00:00";
        foreach ($this->eventos as $evento) {
            if ($evento->opcao) {
                $totalHoras = \CalculoHorasHelper::somarDoisHorarios($totalHoras, $evento->getTotalHoras());
            }
        }
        return \CalculoHorasHelper::somarDoisHorarios($totalHoras, $totalHoras);
    }

    public function getTotalSobra() {
        $totalHoras = "00:00";
        foreach ($this->eventos as $evento) {
            $totalHoras = \CalculoHorasHelper::somarDoisHorarios($totalHoras, $evento->getSobra());
        }
        return $totalHoras;
    }

}

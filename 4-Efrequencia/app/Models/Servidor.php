<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servidor extends Model {

    protected $table = 'servidores';

    public function setMatriculaAttribute($matricula) {
        $this->attributes['matricula'] = mb_convert_case($matricula,MB_CASE_UPPER,'UTF-8');
    }
    
    public function setNomeAttribute($nome) {
        $this->attributes['nome'] = mb_convert_case($nome,MB_CASE_UPPER,'UTF-8');
    }
    
    public function setEmailAttribute($email) {
        $this->attributes['email'] = $email;
    }
    
    public function setAdminSecap($adminSecap) {
        
        $this->attributes['admin_secap'] = $adminSecap=='on'?1:0;;
    }
    
    public function setAdminSepag($adminSepag) {
        $this->attributes['admin_sepag'] = $adminSepag=='on'?1:0;;
    }

}

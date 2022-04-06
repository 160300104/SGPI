<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Labs extends Model
{
    use HasFactory;


    //Relacion uno a muchos 
    public function materials(){
        return $this->hasMany(Materials::class, 'id');
    }

}

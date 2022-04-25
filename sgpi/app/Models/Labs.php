<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Labs extends Model
{
    use HasFactory;

    protected $fillable=["id","name","id_user"];

    //Relacion uno a muchos 
    public function materials(){
        return $this->hasMany(Materials::class, 'id');
    }

     //Relacion uno a muchos 
     public function loans(){
        return $this->hasMany(Loan::class, 'id');
    }

    //Relacion uno a muchos (inversa)

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }

}

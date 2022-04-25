<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    use HasFactory;

    protected $fillable=["quantity","id_material","id_loan"];

    //Relacion muchos a muchos
    // public function loans(){
    //     return $this->belongsToMany('App\Models\Loan');
    // }

    public function loan(){
        return $this->belongsTo(Loan::class, 'id_loan');
    }

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }

    public function material(){
        return $this->belongsTo(Materials::class, 'id_material');
    }
}

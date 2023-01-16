<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;
    protected $fillable=["loan_date","delivery_date","observations","id_lab","id_user","id_status"];

    // //Relacion muchos a muchos
    // public function tickets(){
    //     return $this->belongsToMany('App\Models\Tickets');
    // }

    //Relacion uno a muchos 
    public function tickets(){
        return $this->hasMany(Tickets::class, 'id');
    }

    //Relacion uno a muchos (inversa)

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }

    public function lab(){
        return $this->belongsTo(Labs::class, 'id_lab');
    }

    public function status(){
        return $this->belongsTo(Status::class, 'id_status');
    }
}

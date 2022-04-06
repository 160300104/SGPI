<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materials extends Model
{
    use HasFactory;

    protected $fillable=["name","image","quantity","register_date","id_lab","id_category"];

    //Relacion uno a muchos (inversa)

    public function lab(){
        return $this->belongsTo(Labs::class, 'id_lab');
    }

    public function category(){
        return $this->belongsTo(Categories::class, 'id_category');
    }

}

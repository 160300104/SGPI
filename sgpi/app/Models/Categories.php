<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $fillable=["name"];

    //Relacion uno a muchos 
    public function materials(){
        return $this->hasMany(Materials::class, 'id');
    }
}

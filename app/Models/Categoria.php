<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    use HasFactory;

    //Relacion 1 a muchos
    //Una categoria tiene muchos posts (hasMany)
    public function posts(){
        return $this->hasMany('App\Models\Post');
    }
    
}

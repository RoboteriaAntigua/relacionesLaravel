<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    //Relacion 1 a muchos, users tiene muchos posts
    //los post pertenece a un usuario (belongsTo)
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    //Relacion 1 a muchos,  Categoria tiene muchos posts
    //los posts pertenecen a una categoria (belongsTo)
    public function categoria(){
        return $this->belongsTo('App\Models\Categoria');
    }
}

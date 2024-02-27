<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    //Un profile pertenece a un user (belongsTo)
    //Entidad fuerte user
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}

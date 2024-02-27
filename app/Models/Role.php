<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    //Un rol tiene muchos usuarios
    public function users(){
        return $this->BelongsToMany('App\Models\User');
    }
}

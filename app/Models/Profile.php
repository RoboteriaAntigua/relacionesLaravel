<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    public function user(){
        // return User::find($this->user_id); o mas eficiente
        return $this->belongsTo('App\Models\User');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Word extends Model
{
    public $fillable = ['label', 'definition'];

    public function user(){
        return $this->hasOne('App\User','id', 'user_id');
    }

}
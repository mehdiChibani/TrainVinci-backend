<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conventions extends Model
{
    //
    protected $fillable = [
        'id', 'stage_concene',
        'cheminConv','valide'
    ];
}

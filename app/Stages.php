<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stages extends Model
{
    //
    protected $fillable = [
        'id', 'entreprise_concernee',
        'idEncadrent','periode',
        'sujet','date_debut'
    ];
}

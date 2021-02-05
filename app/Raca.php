<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Raca extends Model
{
    use softDeletes;
    protected $fillable = ['nome', 'descricao'];
}

